<?php
requireLogin();

$pageTitle = 'Dashboard';
include __DIR__ . '/includes/header.php';

$companyId = $_SESSION['company_id'];

// Statistics
try {
    $db->query("SELECT COUNT(*) as total FROM internships WHERE company_id = :cid");
    $db->bind(':cid', $companyId);
    $totalInternships = $db->single()['total'];

    $db->query("SELECT COUNT(*) as active FROM internships WHERE company_id = :cid AND status = 'Active'");
    $db->bind(':cid', $companyId);
    $activeInternships = $db->single()['active'];

    $db->query("SELECT COUNT(*) as expiring FROM internships WHERE company_id = :cid AND status = 'Active' AND last_date_to_apply BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)");
    $db->bind(':cid', $companyId);
    $expiringSoon = $db->single()['expiring'];

    // Get all internships for this company
    $db->query("SELECT * FROM internships WHERE company_id = :cid ORDER BY created_at DESC");
    $db->bind(':cid', $companyId);
    $internships = $db->resultSet();
} catch (PDOException $e) {
    echo "<div class='alert alert-error'>Error loading data.</div>";
    $internships = [];
    $totalInternships = $activeInternships = $expiringSoon = 0;
}
?>

<div class="page-header">
    <h2>Company Dashboard</h2>
    <a href="add_internship.php" class="btn btn-success">+ Post New Internship</a>
</div>

<?php echo getFlash(); ?>

<div class="stats">
    <div class="stat-card">
        <h4>Total Internships</h4>
        <div class="stat-value"><?php echo $totalInternships; ?></div>
    </div>
    <div class="stat-card success">
        <h4>Active Listings</h4>
        <div class="stat-value"><?php echo $activeInternships; ?></div>
    </div>
    <div class="stat-card warning">
        <h4>Expiring in 7 Days</h4>
        <div class="stat-value"><?php echo $expiringSoon; ?></div>
    </div>
</div>

<div class="table-container">
    <h3>Your Internship Opportunities</h3>

    <?php if (empty($internships)): ?>
        <div class="empty-state">
            <h3>No internships posted yet</h3>
            <p>Start by posting your first internship opportunity to reach talented candidates.</p>
            <br>
            <a href="add_internship.php" class="btn btn-success">+ Post Your First Internship</a>
        </div>
    <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Location</th>
                    <th>Duration</th>
                    <th>Stipend</th>
                    <th>Last Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($internships as $int):
                    $isExpired = strtotime($int['last_date_to_apply']) < time();
                    $statusClass = ($int['status'] === 'Active' && !$isExpired) ? 'badge-active' : 'badge-inactive';
                    $statusText = $isExpired ? 'Expired' : htmlspecialchars($int['status']);
                ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($int['title']); ?></strong></td>
                    <td><?php echo htmlspecialchars($int['location']); ?></td>
                    <td><?php echo htmlspecialchars($int['duration']); ?></td>
                    <td><?php echo formatCurrency($int['stipend']); ?></td>
                    <td><?php echo formatDate($int['last_date_to_apply']); ?></td>
                    <td><span class="badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span></td>
                    <td>
                        <div class="action-buttons">
                            <a href="view_internship.php?id=<?php echo $int['id']; ?>" class="btn btn-outline" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">View</a>
                            <a href="edit_internship.php?id=<?php echo $int['id']; ?>" class="btn btn-warning" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Edit</a>
                            <a href="delete_internship.php?id=<?php echo $int['id']; ?>" class="btn btn-danger confirm-delete" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>

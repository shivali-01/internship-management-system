<?php
requireLogin();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    setFlash('Invalid internship ID.', 'error');
    redirect('dashboard.php');
}

$internshipId = sanitize($_GET['id']);
$companyId = $_SESSION['company_id'];

try {
    $db->query("SELECT i.*, c.company_name, c.email, c.phone, c.website FROM internships i
                JOIN companies c ON i.company_id = c.id
                WHERE i.id = :id AND i.company_id = :cid");
    $db->bind(':id', $internshipId);
    $db->bind(':cid', $companyId);
    $internship = $db->single();
} catch (PDOException $e) {
    $internship = false;
}

if (!$internship) {
    setFlash('Internship not found or access denied.', 'error');
    redirect('dashboard.php');
}

$pageTitle = 'View Internship - ' . htmlspecialchars($internship['title']);
include __DIR__ . '/includes/header.php';

$isExpired = strtotime($internship['last_date_to_apply']) < time();
?>

<div class="page-header">
    <h2>Internship Details</h2>
    <div class="action-buttons">
        <a href="dashboard.php" class="btn btn-outline">&larr; Back to Dashboard</a>
        <a href="edit_internship.php?id=<?php echo $internship['id']; ?>" class="btn btn-warning">Edit</a>
        <a href="delete_internship.php?id=<?php echo $internship['id']; ?>" class="btn btn-danger confirm-delete">Delete</a>
    </div>
</div>

<?php echo getFlash(); ?>

<div class="internship-card">
    <h2><?php echo htmlspecialchars($internship['title']); ?></h2>
    <p style="color: #667eea; font-weight: 600; margin-bottom: 0.3rem;">
        <?php echo htmlspecialchars($internship['company_name']); ?>
    </p>
    <div>
        <span class="badge <?php echo ($internship['status'] === 'Active' && !$isExpired) ? 'badge-active' : 'badge-inactive'; ?>">
            <?php echo $isExpired ? 'Expired' : htmlspecialchars($internship['status']); ?>
        </span>
    </div>

    <div class="internship-meta">
        <div class="meta-item">
            <label>Location</label>
            <span><?php echo htmlspecialchars($internship['location']); ?></span>
        </div>
        <div class="meta-item">
            <label>Duration</label>
            <span><?php echo htmlspecialchars($internship['duration']); ?></span>
        </div>
        <div class="meta-item">
            <label>Stipend</label>
            <span><?php echo formatCurrency($internship['stipend']); ?></span>
        </div>
        <div class="meta-item">
            <label>Internship Type</label>
            <span><?php echo htmlspecialchars($internship['internship_type']); ?></span>
        </div>
        <div class="meta-item">
            <label>Vacancies</label>
            <span><?php echo htmlspecialchars($internship['vacancies']); ?> Position(s)</span>
        </div>
        <div class="meta-item">
            <label>Last Date to Apply</label>
            <span><?php echo formatDate($internship['last_date_to_apply']); ?></span>
        </div>
    </div>

    <?php if (!empty($internship['description'])): ?>
        <div class="internship-section">
            <h4>About the Internship</h4>
            <p><?php echo nl2br(htmlspecialchars($internship['description'])); ?></p>
        </div>
    <?php endif; ?>

    <?php if (!empty($internship['requirements'])): ?>
        <div class="internship-section">
            <h4>Eligibility & Requirements</h4>
            <p><?php echo nl2br(htmlspecialchars($internship['requirements'])); ?></p>
        </div>
    <?php endif; ?>

    <?php if (!empty($internship['skills_required'])): ?>
        <div class="internship-section">
            <h4>Skills Required</h4>
            <?php
            $skills = array_map('trim', explode(',', $internship['skills_required']));
            echo '<div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">';
            foreach ($skills as $skill) {
                if (!empty($skill)) {
                    echo '<span class="badge badge-active">' . htmlspecialchars($skill) . '</span>';
                }
            }
            echo '</div>';
            ?>
        </div>
    <?php endif; ?>

    <div style="border-top: 1px solid #e5e7eb; padding-top: 1.2rem; margin-top: 1rem;">
        <h4 style="color: #667eea; margin-bottom: 0.8rem;">Company Contact</h4>
        <div style="color: #374151;">
            <?php if (!empty($internship['website'])): ?>
                <p><strong>Website:</strong> <a href="<?php echo htmlspecialchars($internship['website']); ?>" target="_blank" style="color: #667eea;"><?php echo htmlspecialchars($internship['website']); ?></a></p>
            <?php endif; ?>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($internship['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($internship['phone']); ?></p>
        </div>
    </div>

    <div style="margin-top: 1.5rem; color: #6b7280; font-size: 0.85rem; border-top: 1px solid #e5e7eb; padding-top: 1rem;">
        <p>Posted on: <?php echo formatDate($internship['created_at']); ?></p>
        <p>Last updated: <?php echo formatDate($internship['updated_at']); ?></p>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>

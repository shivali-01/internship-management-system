<?php
requireLogin();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    setFlash('Invalid internship ID.', 'error');
    redirect('dashboard.php');
}

$internshipId = sanitize($_GET['id']);
$companyId = $_SESSION['company_id'];

try {
    $db->query("SELECT id FROM internships WHERE id = :id AND company_id = :cid");
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

try {
    $db->query("DELETE FROM internships WHERE id = :id AND company_id = :cid");
    $db->bind(':id', $internshipId);
    $db->bind(':cid', $companyId);

    if ($db->execute()) {
        setFlash('Internship deleted successfully.', 'success');
    } else {
        setFlash('Failed to delete internship.', 'error');
    }
} catch (PDOException $e) {
    setFlash('Error deleting internship: ' . $e->getMessage(), 'error');
}

redirect('dashboard.php');
?>

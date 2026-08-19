<?php
$pageTitle = 'Home';
include __DIR__ . '/includes/header.php';
?>

<section class="hero">
    <h1>Find & Post Internship Opportunities</h1>
    <p>Connect companies with talented students. Post internships, manage applications, and grow your team.</p>
    <div class="hero-buttons">
        <?php if (!isLoggedIn()): ?>
            <a href="register.php" class="btn btn-white btn-lg">Register Your Company</a>
            <a href="login.php" class="btn btn-outline btn-lg" style="background: rgba(255,255,255,0.15); color: white; border-color: white;">Company Login</a>
        <?php else: ?>
            <a href="dashboard.php" class="btn btn-white btn-lg">Go to Dashboard</a>
        <?php endif; ?>
    </div>
</section>

<section class="cards">
    <div class="card">
        <h3>Post Internships</h3>
        <p>Create detailed internship listings with title, location, duration, stipend, and more in just a few clicks.</p>
    </div>
    <div class="card">
        <h3>Manage Listings</h3>
        <p>View, edit, and update all your posted internship opportunities from a simple dashboard.</p>
    </div>
    <div class="card">
        <h3>Reach Talent</h3>
        <p>Your internships are visible to students actively looking for valuable industry experience.</p>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>

<?php
$pageTitle = 'Company Login';
include __DIR__ . '/includes/header.php';

// If already logged in, redirect to dashboard
if (isLoggedIn()) {
    redirect('dashboard.php');
}

$errors = [];
$formData = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData['email'] = sanitize($_POST['email'] ?? '');
    $formData['password'] = $_POST['password'] ?? '';

    // Validation
    if (empty($formData['email'])) {
        $errors['email'] = 'Email is required';
    } elseif (!validateEmail($formData['email'])) {
        $errors['email'] = 'Please enter a valid email';
    }

    if (empty($formData['password'])) {
        $errors['password'] = 'Password is required';
    }

    if (empty($errors)) {
        try {
            $db->query("SELECT * FROM companies WHERE email = :email");
            $db->bind(':email', $formData['email']);
            $company = $db->single();

            if ($company && verifyPassword($formData['password'], $company['password'])) {
                // Set session variables
                $_SESSION['company_id'] = $company['id'];
                $_SESSION['company_name'] = $company['company_name'];
                $_SESSION['company_email'] = $company['email'];

                setFlash('Welcome back, ' . htmlspecialchars($company['company_name']) . '!', 'success');
                redirect('dashboard.php');
            } else {
                $errors['general'] = 'Invalid email or password';
            }
        } catch (PDOException $e) {
            $errors['general'] = 'Login failed. Please try again.';
        }
    }
}
?>

<div class="form-container" style="max-width: 480px;">
    <h2 class="form-title">Company Login</h2>
    <p class="form-subtitle">Access your dashboard to manage internships</p>

    <?php
    echo getFlash();
    if (isset($errors['general'])) {
        echo "<div class='alert alert-error'>" . htmlspecialchars($errors['general']) . "</div>";
    }
    ?>

    <form method="POST" action="login.php" novalidate>
        <div class="form-group">
            <label>Email Address <span class="required">*</span></label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>"
                   class="<?php echo isset($errors['email']) ? 'input-error' : ''; ?>"
                   placeholder="company@example.com">
            <?php if (isset($errors['email'])): ?>
                <span class="error-text"><?php echo htmlspecialchars($errors['email']); ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Password <span class="required">*</span></label>
            <input type="password" name="password"
                   class="<?php echo isset($errors['password']) ? 'input-error' : ''; ?>"
                   placeholder="Enter your password">
            <?php if (isset($errors['password'])): ?>
                <span class="error-text"><?php echo htmlspecialchars($errors['password']); ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-lg" style="width: 100%;">Login</button>
        </div>

        <div class="form-footer">
            Don't have an account? <a href="register.php">Register here</a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>

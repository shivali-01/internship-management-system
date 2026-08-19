<?php
$pageTitle = 'Company Registration';
include __DIR__ . '/includes/header.php';

$errors = [];
$formData = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize all inputs
    $formData['company_name'] = sanitize($_POST['company_name'] ?? '');
    $formData['email'] = sanitize($_POST['email'] ?? '');
    $formData['password'] = $_POST['password'] ?? '';
    $formData['confirm_password'] = $_POST['confirm_password'] ?? '';
    $formData['phone'] = sanitize($_POST['phone'] ?? '');
    $formData['address'] = sanitize($_POST['address'] ?? '');
    $formData['industry'] = sanitize($_POST['industry'] ?? '');
    $formData['description'] = sanitize($_POST['description'] ?? '');
    $formData['website'] = sanitize($_POST['website'] ?? '');

    // Validate Company Name
    if (empty($formData['company_name'])) {
        $errors['company_name'] = 'Company name is required';
    } elseif (strlen($formData['company_name']) < 2) {
        $errors['company_name'] = 'Company name must be at least 2 characters';
    }

    // Validate Email
    if (empty($formData['email'])) {
        $errors['email'] = 'Email is required';
    } elseif (!validateEmail($formData['email'])) {
        $errors['email'] = 'Please enter a valid email address';
    }

    // Validate Password
    if (empty($formData['password'])) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($formData['password']) < 6) {
        $errors['password'] = 'Password must be at least 6 characters';
    }

    // Validate Confirm Password
    if (empty($formData['confirm_password'])) {
        $errors['confirm_password'] = 'Please confirm your password';
    } elseif ($formData['password'] !== $formData['confirm_password']) {
        $errors['confirm_password'] = 'Passwords do not match';
    }

    // Validate Phone
    if (empty($formData['phone'])) {
        $errors['phone'] = 'Phone number is required';
    } elseif (!validatePhone($formData['phone'])) {
        $errors['phone'] = 'Phone must be 10 digits (numbers only)';
    }

    // Validate Address
    if (empty($formData['address'])) {
        $errors['address'] = 'Address is required';
    } elseif (strlen($formData['address']) < 10) {
        $errors['address'] = 'Please enter a complete address';
    }

    // Validate Industry
    if (empty($formData['industry'])) {
        $errors['industry'] = 'Industry is required';
    }

    // If no validation errors, check for duplicate email and insert
    if (empty($errors)) {
        try {
            // Check if email already exists
            $db->query("SELECT id FROM companies WHERE email = :email");
            $db->bind(':email', $formData['email']);
            $existing = $db->single();

            if ($existing) {
                $errors['email'] = 'This email is already registered';
            } else {
                // Hash password
                $hashedPassword = hashPassword($formData['password']);

                // Insert company
                $db->query("INSERT INTO companies (company_name, email, password, phone, address, industry, description, website)
                            VALUES (:company_name, :email, :password, :phone, :address, :industry, :description, :website)");
                $db->bind(':company_name', $formData['company_name']);
                $db->bind(':email', $formData['email']);
                $db->bind(':password', $hashedPassword);
                $db->bind(':phone', $formData['phone']);
                $db->bind(':address', $formData['address']);
                $db->bind(':industry', $formData['industry']);
                $db->bind(':description', $formData['description']);
                $db->bind(':website', $formData['website']);

                if ($db->execute()) {
                    setFlash('Registration successful! Please login to continue.', 'success');
                    redirect('login.php');
                } else {
                    $errors['general'] = 'Registration failed. Please try again.';
                }
            }
        } catch (PDOException $e) {
            $errors['general'] = 'Database error: ' . $e->getMessage();
        }
    }
}
?>

<div class="form-container">
    <h2 class="form-title">Company Registration</h2>
    <p class="form-subtitle">Create your company account to post internship opportunities</p>

    <?php
    if (isset($errors['general'])) {
        echo "<div class='alert alert-error'>" . htmlspecialchars($errors['general']) . "</div>";
    }
    echo getFlash();
    ?>

    <form method="POST" action="register.php" novalidate>
        <div class="form-group">
            <label>Company Name <span class="required">*</span></label>
            <input type="text" name="company_name" value="<?php echo htmlspecialchars($formData['company_name'] ?? ''); ?>"
                   class="<?php echo isset($errors['company_name']) ? 'input-error' : ''; ?>"
                   placeholder="Enter your company name">
            <?php if (isset($errors['company_name'])): ?>
                <span class="error-text"><?php echo htmlspecialchars($errors['company_name']); ?></span>
            <?php endif; ?>
        </div>

        <div class="form-row">
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
                <label>Phone Number <span class="required">*</span></label>
                <input type="tel" name="phone" value="<?php echo htmlspecialchars($formData['phone'] ?? ''); ?>"
                       class="<?php echo isset($errors['phone']) ? 'input-error' : ''; ?>"
                       placeholder="10 digit mobile number" maxlength="10">
                <?php if (isset($errors['phone'])): ?>
                    <span class="error-text"><?php echo htmlspecialchars($errors['phone']); ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Password <span class="required">*</span></label>
                <input type="password" name="password" id="password"
                       class="<?php echo isset($errors['password']) ? 'input-error' : ''; ?>"
                       placeholder="At least 6 characters">
                <?php if (isset($errors['password'])): ?>
                    <span class="error-text"><?php echo htmlspecialchars($errors['password']); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Confirm Password <span class="required">*</span></label>
                <input type="password" name="confirm_password" id="confirm_password"
                       class="<?php echo isset($errors['confirm_password']) ? 'input-error' : ''; ?>"
                       placeholder="Re-enter your password">
                <?php if (isset($errors['confirm_password'])): ?>
                    <span class="error-text"><?php echo htmlspecialchars($errors['confirm_password']); ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Industry <span class="required">*</span></label>
                <select name="industry" class="<?php echo isset($errors['industry']) ? 'input-error' : ''; ?>">
                    <option value="">Select industry</option>
                    <?php
                    $industries = ['IT & Software', 'Marketing', 'Finance', 'HR', 'Design', 'Engineering', 'Operations', 'Sales', 'Content Writing', 'Other'];
                    foreach ($industries as $ind) {
                        $selected = ($formData['industry'] ?? '') === $ind ? 'selected' : '';
                        echo "<option value='{$ind}' {$selected}>{$ind}</option>";
                    }
                    ?>
                </select>
                <?php if (isset($errors['industry'])): ?>
                    <span class="error-text"><?php echo htmlspecialchars($errors['industry']); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Website (Optional)</label>
                <input type="url" name="website" value="<?php echo htmlspecialchars($formData['website'] ?? ''); ?>"
                       placeholder="https://www.yourcompany.com">
            </div>
        </div>

        <div class="form-group">
            <label>Office Address <span class="required">*</span></label>
            <textarea name="address" rows="2"
                      class="<?php echo isset($errors['address']) ? 'input-error' : ''; ?>"
                      placeholder="Complete office address"><?php echo htmlspecialchars($formData['address'] ?? ''); ?></textarea>
            <?php if (isset($errors['address'])): ?>
                <span class="error-text"><?php echo htmlspecialchars($errors['address']); ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Company Description (Optional)</label>
            <textarea name="description" rows="3"
                      placeholder="Briefly describe your company, mission, and work culture"><?php echo htmlspecialchars($formData['description'] ?? ''); ?></textarea>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-lg" style="width: 100%;">Register Company</button>
        </div>

        <div class="form-footer">
            Already registered? <a href="login.php">Login here</a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>

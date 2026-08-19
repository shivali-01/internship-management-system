<?php
requireLogin();

$pageTitle = 'Add Internship';
include __DIR__ . '/includes/header.php';

$errors = [];
$formData = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData['title'] = sanitize($_POST['title'] ?? '');
    $formData['location'] = sanitize($_POST['location'] ?? '');
    $formData['duration'] = sanitize($_POST['duration'] ?? '');
    $formData['stipend'] = sanitize($_POST['stipend'] ?? '');
    $formData['last_date_to_apply'] = sanitize($_POST['last_date_to_apply'] ?? '');
    $formData['description'] = sanitize($_POST['description'] ?? '');
    $formData['requirements'] = sanitize($_POST['requirements'] ?? '');
    $formData['skills_required'] = sanitize($_POST['skills_required'] ?? '');
    $formData['vacancies'] = sanitize($_POST['vacancies'] ?? '1');
    $formData['internship_type'] = sanitize($_POST['internship_type'] ?? 'Full-time');
    $formData['status'] = sanitize($_POST['status'] ?? 'Active');

    // Validation
    if (empty($formData['title'])) {
        $errors['title'] = 'Internship title is required';
    } elseif (strlen($formData['title']) < 5) {
        $errors['title'] = 'Title must be at least 5 characters';
    }

    if (empty($formData['location'])) {
        $errors['location'] = 'Location is required';
    } elseif (strlen($formData['location']) < 3) {
        $errors['location'] = 'Please enter a valid location';
    }

    if (empty($formData['duration'])) {
        $errors['duration'] = 'Duration is required';
    }

    if (empty($formData['stipend'])) {
        $errors['stipend'] = 'Stipend amount is required';
    } elseif (!is_numeric($formData['stipend']) || $formData['stipend'] < 0) {
        $errors['stipend'] = 'Enter a valid stipend amount';
    }

    if (empty($formData['last_date_to_apply'])) {
        $errors['last_date_to_apply'] = 'Last date to apply is required';
    } else {
        $today = date('Y-m-d');
        if ($formData['last_date_to_apply'] < $today) {
            $errors['last_date_to_apply'] = 'Last date cannot be in the past';
        }
    }

    if (empty($formData['description'])) {
        $errors['description'] = 'Internship description is required';
    } elseif (strlen($formData['description']) < 20) {
        $errors['description'] = 'Description must be at least 20 characters';
    }

    if (!empty($formData['vacancies']) && (!is_numeric($formData['vacancies']) || $formData['vacancies'] < 1)) {
        $errors['vacancies'] = 'Vacancies must be at least 1';
    }

    if (empty($errors)) {
        try {
            $db->query("INSERT INTO internships (company_id, title, location, duration, stipend, last_date_to_apply, description, requirements, skills_required, vacancies, internship_type, status)
                        VALUES (:company_id, :title, :location, :duration, :stipend, :last_date_to_apply, :description, :requirements, :skills_required, :vacancies, :internship_type, :status)");
            $db->bind(':company_id', $_SESSION['company_id']);
            $db->bind(':title', $formData['title']);
            $db->bind(':location', $formData['location']);
            $db->bind(':duration', $formData['duration']);
            $db->bind(':stipend', $formData['stipend']);
            $db->bind(':last_date_to_apply', $formData['last_date_to_apply']);
            $db->bind(':description', $formData['description']);
            $db->bind(':requirements', $formData['requirements']);
            $db->bind(':skills_required', $formData['skills_required']);
            $db->bind(':vacancies', $formData['vacancies']);
            $db->bind(':internship_type', $formData['internship_type']);
            $db->bind(':status', $formData['status']);

            if ($db->execute()) {
                setFlash('Internship posted successfully!', 'success');
                redirect('dashboard.php');
            } else {
                $errors['general'] = 'Failed to post internship. Please try again.';
            }
        } catch (PDOException $e) {
            $errors['general'] = 'Error: ' . $e->getMessage();
        }
    }
}

$today = date('Y-m-d');
$minDate = $today;
?>

<div class="form-container" style="max-width: 850px;">
    <h2 class="form-title">Post New Internship</h2>
    <p class="form-subtitle">Fill in the details below to create a new internship listing</p>

    <?php
    if (isset($errors['general'])) {
        echo "<div class='alert alert-error'>" . htmlspecialchars($errors['general']) . "</div>";
    }
    echo getFlash();
    ?>

    <form method="POST" action="add_internship.php" novalidate>
        <div class="form-group">
            <label>Internship Title <span class="required">*</span></label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($formData['title'] ?? ''); ?>"
                   class="<?php echo isset($errors['title']) ? 'input-error' : ''; ?>"
                   placeholder="e.g., Web Development Intern, Marketing Intern">
            <?php if (isset($errors['title'])): ?>
                <span class="error-text"><?php echo htmlspecialchars($errors['title']); ?></span>
            <?php endif; ?>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Location <span class="required">*</span></label>
                <input type="text" name="location" value="<?php echo htmlspecialchars($formData['location'] ?? ''); ?>"
                       class="<?php echo isset($errors['location']) ? 'input-error' : ''; ?>"
                       placeholder="e.g., New Delhi, Mumbai, Work from Home">
                <?php if (isset($errors['location'])): ?>
                    <span class="error-text"><?php echo htmlspecialchars($errors['location']); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Duration <span class="required">*</span></label>
                <select name="duration" class="<?php echo isset($errors['duration']) ? 'input-error' : ''; ?>">
                    <option value="">Select duration</option>
                    <?php
                    $durations = ['1 Month', '2 Months', '3 Months', '4 Months', '5 Months', '6 Months', '9 Months', '12 Months'];
                    foreach ($durations as $d) {
                        $selected = ($formData['duration'] ?? '') === $d ? 'selected' : '';
                        echo "<option value='{$d}' {$selected}>{$d}</option>";
                    }
                    ?>
                </select>
                <?php if (isset($errors['duration'])): ?>
                    <span class="error-text"><?php echo htmlspecialchars($errors['duration']); ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Stipend (Rs.) <span class="required">*</span></label>
                <input type="text" name="stipend" id="stipend" value="<?php echo htmlspecialchars($formData['stipend'] ?? ''); ?>"
                       class="<?php echo isset($errors['stipend']) ? 'input-error' : ''; ?>"
                       placeholder="e.g., 5000, 10000, 0 for unpaid">
                <?php if (isset($errors['stipend'])): ?>
                    <span class="error-text"><?php echo htmlspecialchars($errors['stipend']); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Last Date to Apply <span class="required">*</span></label>
                <input type="date" name="last_date_to_apply" min="<?php echo $minDate; ?>"
                       value="<?php echo htmlspecialchars($formData['last_date_to_apply'] ?? ''); ?>"
                       class="<?php echo isset($errors['last_date_to_apply']) ? 'input-error' : ''; ?>">
                <?php if (isset($errors['last_date_to_apply'])): ?>
                    <span class="error-text"><?php echo htmlspecialchars($errors['last_date_to_apply']); ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Internship Type</label>
                <select name="internship_type">
                    <?php
                    $types = ['Full-time', 'Part-time', 'Work from Home', 'Hybrid'];
                    foreach ($types as $t) {
                        $selected = ($formData['internship_type'] ?? 'Full-time') === $t ? 'selected' : '';
                        echo "<option value='{$t}' {$selected}>{$t}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Number of Vacancies</label>
                <input type="number" name="vacancies" id="vacancies" min="1"
                       value="<?php echo htmlspecialchars($formData['vacancies'] ?? '1'); ?>">
                <?php if (isset($errors['vacancies'])): ?>
                    <span class="error-text"><?php echo htmlspecialchars($errors['vacancies']); ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status">
                <?php
                $statuses = ['Active', 'Inactive'];
                foreach ($statuses as $s) {
                    $selected = ($formData['status'] ?? 'Active') === $s ? 'selected' : '';
                    echo "<option value='{$s}' {$selected}>{$s}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label>Internship Description <span class="required">*</span></label>
            <textarea name="description" rows="5"
                      class="<?php echo isset($errors['description']) ? 'input-error' : ''; ?>"
                      placeholder="Describe the internship role, responsibilities, and what the intern will learn..."><?php echo htmlspecialchars($formData['description'] ?? ''); ?></textarea>
            <?php if (isset($errors['description'])): ?>
                <span class="error-text"><?php echo htmlspecialchars($errors['description']); ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Eligibility / Requirements</label>
            <textarea name="requirements" rows="3"
                      placeholder="Education qualification, year of study, eligibility criteria..."><?php echo htmlspecialchars($formData['requirements'] ?? ''); ?></textarea>
        </div>

        <div class="form-group">
            <label>Skills Required (comma separated)</label>
            <textarea name="skills_required" rows="2"
                      placeholder="e.g., PHP, MySQL, HTML, CSS, JavaScript"><?php echo htmlspecialchars($formData['skills_required'] ?? ''); ?></textarea>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success btn-lg" style="width: 100%;">Post Internship</button>
        </div>

        <div class="form-footer">
            <a href="dashboard.php">&larr; Back to Dashboard</a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>

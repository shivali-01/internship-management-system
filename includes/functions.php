<?php
// Helper Functions

// Sanitize input data
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Redirect to a page
function redirect($url) {
    header("Location: " . $url);
    exit();
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['company_id']) && !empty($_SESSION['company_id']);
}

// Require login for protected pages
function requireLogin() {
    if (!isLoggedIn()) {
        $_SESSION['error'] = "Please login to access this page.";
        redirect('login.php');
    }
}

// Set flash message
function setFlash($message, $type = 'success') {
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type;
}

// Get and clear flash message
function getFlash() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        $type = $_SESSION['flash_type'];
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
        return "<div class='alert alert-{$type}'>{$message}</div>";
    }
    return '';
}

// Validate email format
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Validate phone number (10 digits)
function validatePhone($phone) {
    return preg_match('/^[0-9]{10}$/', $phone);
}

// Format date for display
function formatDate($dateStr) {
    return date('F j, Y', strtotime($dateStr));
}

// Format currency
function formatCurrency($amount) {
    return 'Rs. ' . number_format($amount, 2);
}

// Hash password
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Verify password
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}
?>

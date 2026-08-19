<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'internship_portal');

// Site Configuration
define('SITE_NAME', 'Internship Portal');
define('BASE_URL', 'http://localhost/internship-portal');

// Start Session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

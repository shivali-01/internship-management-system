<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';

// Destroy session and redirect to login
session_unset();
session_destroy();

setFlash('You have been logged out successfully.', 'success');
redirect('login.php');
?>

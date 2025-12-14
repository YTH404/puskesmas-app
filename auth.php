<?php
session_start();

// Calculate base path for flexible redirects (e.g. to login.php)
$current_file = $_SERVER['PHP_SELF'];
$parts = explode('/', trim($current_file, '/'));
$depth = count($parts) - 1;
$base_path = str_repeat('../', max(0, $depth - 1));

// If we're in root directory (index.php or login.php), no need for ../
if ($depth <= 1) {
    $base_path = '';
}

// Redirect otomatis sesuai role
function redirectByRole() {
    global $base_path;
    switch ($_SESSION['level']) {
        case 'superadmin':
            header("Location: " . $base_path . "admin/admin_tampil.php");
            exit;
        case 'admin':
        case 'pendaftaran':
        case 'pemeriksaan':
        case 'apoteker':
            header("Location: " . $base_path . "index.php");
            exit;
        default:
            header("Location: " . $base_path . "login.php");
            exit;
    }
}

function checkRole($allowed_role) {

    global $base_path;

    if (!isset($_SESSION['login'])) {
        header('Location: ' . $base_path . 'login.php');
        exit;
    }

    // Support passing either a single role (string) or an array of allowed roles
    $userLevel = isset($_SESSION['level']) ? $_SESSION['level'] : null;

    if (is_array($allowed_role)) {
        if ($userLevel === null || !in_array($userLevel, $allowed_role, true)) {
            redirectByRole();
        }
    } else {
        if ($userLevel === null || $userLevel !== $allowed_role) {
            redirectByRole();
        }
    }
}

/**
 * Check whether the current user's level is within allowed roles.
 * Accepts a string (single role) or an array of roles.
 * Returns true when the user is logged in and has one of the allowed roles.
 */
function canView($allowed_roles) {
    // Ensure session is started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $userLevel = isset($_SESSION['level']) ? $_SESSION['level'] : null;

    if (is_array($allowed_roles)) {
        return $userLevel !== null && in_array($userLevel, $allowed_roles, true);
    }

    return $userLevel !== null && $userLevel === $allowed_roles;
}
function setFlash($message, $type = 'success') {
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type;
}

function consumeFlash() {
    if (!isset($_SESSION['flash_message'])) {
        return null;
    }

    $flash = [
        'message' => $_SESSION['flash_message'],
        'type' => $_SESSION['flash_type'] ?? 'info',
    ];

    unset($_SESSION['flash_message'], $_SESSION['flash_type']);

    return $flash;
}

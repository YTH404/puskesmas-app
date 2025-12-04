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
            header("Location: " . $base_path . "dokter/dokter_tampil.php");
            exit;
        case 'pendaftaran':
            header("Location: " . $base_path . "pendaftaran/pendaftaran_tampil.php");
            exit;
        case 'pemeriksaan':
            header("Location: " . $base_path . "pendaftaran/pendaftaran_tampil.php");
            exit;
        case 'apoteker':
            header("Location: " . $base_path . "pemeriksaan/pemeriksaan_tampil.php");
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
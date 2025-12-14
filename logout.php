<?php
include 'auth.php';
checkRole(["admin", "pendaftaran", "pemeriksaan", "apoteker", "superadmin"]);

// Destroy current session
$_SESSION = array();
session_destroy();

// Start new session for flash message
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
setFlash('Anda telah berhasil logout', 'info');

header('Location: login.php');
exit();
?>
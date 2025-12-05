<?php
include 'auth.php';
checkRole(["admin", "pendaftaran", "pemeriksaan", "apoteker", "superadmin"]);
$_SESSION = array();
session_destroy();
header('Location: login.php');
exit();
?>
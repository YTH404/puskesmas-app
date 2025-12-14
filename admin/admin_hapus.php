<?php
include '../config/koneksi.php';
include '../auth.php';
checkRole('superadmin');

// Ambil id dari URL
$id = $_GET['id_admin'];

// Query hapus data
$sql = "DELETE FROM admin WHERE id_admin = $id";

if (mysqli_query($conn, $sql)) {
    setFlash('Data admin berhasil dihapus!', 'success');
    header('Location: admin_tampil.php');
    exit;
} else {
    echo "Error: " . mysqli_error($conn);
}
?>

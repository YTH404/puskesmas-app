<?php
include '../config/koneksi.php';
include '../auth.php';
checkRole('admin');

// Ambil id dari URL
$id = $_GET['id_dokter'];

// Query hapus data
$sql = "DELETE FROM dokter WHERE id_dokter = $id";

if (mysqli_query($conn, $sql)) {
    setFlash('Data dokter berhasil dihapus!', 'success');
    header('Location: dokter_tampil.php');
    exit;
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
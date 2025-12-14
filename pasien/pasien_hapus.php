<?php
include '../config/koneksi.php';
include '../auth.php';
checkRole('pendaftaran');

// Ambil id dari URL
$id = $_GET['id_pasien'];

// Query hapus data
$sql = "DELETE FROM pasien WHERE id_pasien = $id";

if (mysqli_query($conn, $sql)) {
    setFlash('Data pasien berhasil dihapus!', 'success');
    header('Location: pasien_tampil.php');
    exit;
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
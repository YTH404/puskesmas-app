<?php
include '../config/koneksi.php';
include '../auth.php';
checkRole('pendaftaran');

// Ambil id dari URL
$id = $_GET['id_pendaftaran'];

// Query hapus data
$sql = "DELETE FROM pendaftaran WHERE id_pendaftaran = $id";

if (mysqli_query($conn, $sql)) {
    setFlash('Data pendaftaran berhasil dihapus!', 'success');
    header('Location: pendaftaran_tampil.php');
    exit;
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
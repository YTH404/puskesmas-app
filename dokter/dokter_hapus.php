<?php
include '../config/koneksi.php';
include '../auth.php';
checkRole('admin');

// Ambil id dari URL
$id = $_GET['id_dokter'];

// Query hapus data
$sql = "DELETE FROM dokter WHERE id_dokter = $id";

if (mysqli_query($conn, $sql)) {
    echo "<script>
            alert('Data berhasil dihapus!');
            window.location='dokter_tampil.php';
          </script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
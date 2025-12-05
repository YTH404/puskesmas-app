<?php
include '../config/koneksi.php';
include '../auth.php';
checkRole('pendaftaran');

// Ambil id dari URL
$id = $_GET['id_pendaftaran'];

// Query hapus data
$sql = "DELETE FROM pendaftaran WHERE id_pendaftaran = $id";

if (mysqli_query($conn, $sql)) {
    echo "<script>
            alert('Data berhasil dihapus!');
            window.location='pendaftaran_tampil.php';
          </script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
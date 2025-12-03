<?php
include '../config/koneksi.php';

// Ambil id dari URL
$id = $_GET['id_pasien'];

// Query hapus data
$sql = "DELETE FROM pasien WHERE id_pasien = $id";

if (mysqli_query($conn, $sql)) {
    echo "<script>
            alert('Data berhasil dihapus!');
            window.location='pasien_tampil.php';
          </script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
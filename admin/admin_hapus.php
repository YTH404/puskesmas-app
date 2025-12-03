<?php
include '../config/koneksi.php';

// Ambil id dari URL
$id = $_GET['id_admin'];

// Query hapus data
$sql = "DELETE FROM admin WHERE id_admin = $id";

if (mysqli_query($conn, $sql)) {
    echo "<script>
            alert('Data berhasil dihapus!');
            window.location='admin_tampil.php';
          </script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>

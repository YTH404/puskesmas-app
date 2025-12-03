<?php
// Konfigurasi database
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "puskesmas";
// Membuat koneksi
$conn = mysqli_connect($servername, $username, $password, $database);
// Mengecek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
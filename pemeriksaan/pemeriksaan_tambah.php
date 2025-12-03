<?php
include '../config/koneksi.php'; // koneksi database

$id =  $_GET['id_pendaftaran'];

$sql = "SELECT pendaftaran.*, pasien.nama_pasien 
        FROM pendaftaran
        JOIN pasien ON pendaftaran.id_pasien = pasien.id_pasien
        WHERE pendaftaran.id_pendaftaran = $id";

$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

// Jika tombol submit ditekan
if (isset($_POST['submit'])) {
    $id         = $_POST['id_pendaftaran'];
    $id_dokter  = $_POST['id_dokter'];
    $waktu      = $_POST['waktu_periksa'];
    $obat       = $_POST['obat'];

    $sql1 = "INSERT INTO pemeriksaan (id_pendaftaran, id_dokter, waktu_periksa, obat)
             VALUES ('$id', '$id_dokter', '$waktu', '$obat')";
    $sql2 = "UPDATE pendaftaran SET status='Diperiksa' WHERE id_pendaftaran='$id'";

    if (mysqli_query($conn, $sql1)) {
        mysqli_query($conn, $sql2); // Update status pendaftaran
        echo "<script>
        alert('Data berhasil disimpan!');
        window.location='pemeriksaan_tampil.php';
        </script>";
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Pemeriksaan</title>
</head>
<body>
    <h2 align="center">📝 Tambah Data Pemeriksaan</h2>

    <form action="" method="POST">
        <input type="hidden" name="id_pendaftaran" value="<?php echo $data['id_pendaftaran']; ?>">
        Nama Pasien:
        <input type="text" value="<?php echo $data['nama_pasien']; ?>" readonly><br><br>
        Keluhan:
        <input type="text" name="keluhan" value="<?php echo $data['keluhan']; ?>" readonly><br><br>
        Dokter:
        <select name="id_dokter" required>
            <option value="">-- Pilih Dokter --</option>
            <?php
            $dokter_sql = "SELECT id_dokter, nama_dokter FROM dokter ORDER BY nama_dokter ASC";
            $dokter_result = mysqli_query($conn, $dokter_sql);
            while ($dokter = mysqli_fetch_assoc($dokter_result)) { ?>
                <option value="<?php echo $dokter['id_dokter']; ?>">
                    <?php echo $dokter['nama_dokter']; ?>
                </option>
            <?php } ?>
        </select><br><br>
        Waktu Periksa:
        <input type="datetime-local" name="waktu_periksa" required><br><br>
        <input type="hidden" name="obat">
        <input type="submit" name="submit" value="Simpan">
    </form>
</body>
</html>

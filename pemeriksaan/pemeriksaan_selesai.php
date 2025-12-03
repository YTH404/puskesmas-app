<?php
include '../config/koneksi.php';

// Jika form disubmit → proses update
if (isset($_POST['submit'])) {
    $id      = $_POST['id_pemeriksaan'];
    $waktu     = $_POST['waktu_periksa'];
    $obat     = $_POST['obat'];

    $sql1 = "UPDATE pemeriksaan SET 
                waktu_periksa='$waktu',
                obat='$obat'
            WHERE id_pemeriksaan=$id";

    $sql2 = "UPDATE pendaftaran 
             JOIN pemeriksaan ON pendaftaran.id_pendaftaran = pemeriksaan.id_pendaftaran
             SET pendaftaran.status='Selesai'
             WHERE pemeriksaan.id_pemeriksaan=$id";

    if (mysqli_query($conn, $sql1)) {
        mysqli_query($conn, $sql2); // Update status pendaftaran
        echo "<script>
                alert('Data berhasil diperbarui!');
                window.location='pemeriksaan_tampil.php';
              </script>";
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Jika belum submit → tampilkan form edit
$id = $_GET['id_pemeriksaan'];
$sql = "SELECT pemeriksaan.*, pasien.nama_pasien, pendaftaran.keluhan, dokter.nama_dokter
FROM pemeriksaan
JOIN pendaftaran ON pemeriksaan.id_pendaftaran = pendaftaran.id_pendaftaran
JOIN pasien ON pendaftaran.id_pasien = pasien.id_pasien
JOIN dokter ON pemeriksaan.id_dokter = dokter.id_dokter
WHERE id_pemeriksaan = $id";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pemeriksaan Selesai</title>
</head>
<body>
    <h2 align="center">Pemeriksaan Selesai</h2>

    <form action="" method="POST">
        <input type="hidden" name="id_pemeriksaan" value="<?php echo $data['id_pemeriksaan']; ?>">
        Nama Pasien:
        <input type="text" value="<?php echo $data['nama_pasien'];?>" readonly><br><br>
        Keluhan:
        <input type="text" value="<?php echo $data['keluhan'];?>" readonly><br><br>
        Dokter:
        <input type="text" value="<?php echo $data['nama_dokter'];?>" readonly><br><br>
        Waktu Periksa:
        <input type="datetime-local" name="waktu_periksa" value="<?php echo $data['waktu_periksa']; ?>" readonly><br><br>
        Obat:
        <input type="text" name="obat" value="<?php echo $data['obat']; ?>" required><br><br>
        <input type="submit" name="submit" value="Selesai">
    </form>
</body>
</html>

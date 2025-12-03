<?php
include '../config/koneksi.php';

// Jika form disubmit → proses update
if (isset($_POST['submit'])) {
    $id      = $_POST['id_pemeriksaan'];
    $id_dokter    = $_POST['id_dokter'];
    $waktu     = $_POST['waktu_periksa'];

    $sql = "UPDATE pemeriksaan SET 
                id_dokter='$id_dokter',
                waktu_periksa='$waktu'
            WHERE id_pemeriksaan=$id";

    if (mysqli_query($conn, $sql)) {
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
$sql = "SELECT pemeriksaan.*, pasien.nama_pasien, pendaftaran.keluhan
FROM pemeriksaan
JOIN pendaftaran ON pemeriksaan.id_pendaftaran = pendaftaran.id_pendaftaran
JOIN pasien ON pendaftaran.id_pasien = pasien.id_pasien
WHERE id_pemeriksaan = $id";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Pemeriksaan</title>
</head>
<body>
    <h2 align="center">✏️ Edit Data Pemeriksaan</h2>

    <form action="" method="POST">
        <input type="hidden" name="id_pemeriksaan" value="<?php echo $data['id_pemeriksaan']; ?>">
        Nama Pasien:
        <input type="text" value="<?php echo $data['nama_pasien'];?>" readonly><br><br>
        Keluhan:
        <input type="text" value="<?php echo $data['keluhan'];?>" readonly><br><br>
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
        <input type="datetime-local" name="waktu_periksa" value="<?php echo $data['waktu_periksa']; ?>" required><br><br>
        <input type="submit" name="submit" value="Update Data">
    </form>
</body>
</html>

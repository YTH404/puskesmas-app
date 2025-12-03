<?php
include '../config/koneksi.php'; // koneksi database

$sql = "SELECT id_pasien, nama_pasien FROM pasien ORDER BY nama_pasien ASC";
$result = mysqli_query($conn, $sql);

// Jika tombol submit ditekan
if (isset($_POST['submit'])) {
    $id_pasien    = $_POST['id_pasien'];
    $keluhan     = $_POST['keluhan'];

    $sql = "INSERT INTO pendaftaran (id_pasien, keluhan, status)
            VALUES ('$id_pasien', '$keluhan', 'Menunggu')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Data berhasil disimpan!');
                window.location='pendaftaran_tampil.php';
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
    <title>Tambah Data Pendaftaran</title>
</head>
<body>
    <h2 align="center">📝 Tambah Data Pendaftaran</h2>

    <form action="" method="POST">
        Nama Pasien:
        <select name="id_pasien" required>
            <option value="">-- Pilih Pasien --</option>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <option value="<?php echo $row['id_pasien']; ?>">
                    <?php echo $row['nama_pasien']; ?>
                </option>
            <?php } ?>
        </select><br><br>
        Keluhan:
        <input type="text" name="keluhan" required><br><br>
        <input type="submit" name="submit" value="Simpan">
    </form>
</body>
</html>

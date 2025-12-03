<?php
include '../config/koneksi.php';

// Jika form disubmit → proses update
if (isset($_POST['submit'])) {
    $id      = $_POST['id_pendaftaran'];
    $keluhan = $_POST['keluhan'];

    $sql = "UPDATE pendaftaran SET 
                keluhan='$keluhan'
            WHERE id_pendaftaran=$id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Data berhasil diperbarui!');
                window.location='pendaftaran_tampil.php';
              </script>";
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Jika belum submit → tampilkan form edit
$id = $_GET['id_pendaftaran'];
$sql = "SELECT pendaftaran.*, pasien.nama_pasien 
        FROM pendaftaran
        JOIN pasien ON pendaftaran.id_pasien = pasien.id_pasien
        WHERE pendaftaran.id_pendaftaran = $id";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Pendaftaran</title>
</head>
<body>
    <h2 align="center">✏️ Edit Data Pendaftaran</h2>

    <form action="" method="POST">
        <input type="hidden" name="id_pendaftaran" value="<?php echo $data['id_pendaftaran']; ?>">
        Nama:
        <input type="text" value="<?php echo $data['nama_pasien']; ?>" readonly><br><br>
        Keluhan:
        <input type="text" name="keluhan" value="<?php echo $data['keluhan']; ?>" required><br><br>
        <input type="submit" name="submit" value="Update Data">
    </form>
</body>
</html>

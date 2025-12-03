<?php
include '../config/koneksi.php';

$page_title = "Edit Data Pasien - Puskesmas Management System";
$base_path = '../';

// Jika form disubmit → proses update
if (isset($_POST['submit'])) {
    $id      = $_POST['id_pasien'];
    $nama    = $_POST['nama_pasien'];
    $nama_ibu     = $_POST['nama_ibu'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $golongan_darah = $_POST['golongan_darah'];
    $tgl_lahir = $_POST['tgl_lahir'];

    $sql = "UPDATE pasien SET 
                nama_pasien='$nama',
                nama_ibu='$nama_ibu',
                jenis_kelamin='$jenis_kelamin',
                golongan_darah='$golongan_darah',
                tgl_lahir='$tgl_lahir'
            WHERE id_pasien=$id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Data berhasil diperbarui!');
                window.location='pasien_tampil.php';
              </script>";
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}

// Jika belum submit → tampilkan form edit
$id = $_GET['id_pasien'];
$sql = "SELECT * FROM pasien WHERE id_pasien = $id";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);
?>

<?php include '../templates/sidebar.php'; ?>
<?php include '../templates/header.php'; ?>

<div class="form-container">
    <form action="" method="POST" id="editForm">
        <input type="hidden" name="id_pasien" value="<?php echo htmlspecialchars($data['id_pasien']); ?>">
        
        <div class="form-group">
            <label for="nama_pasien">Nama Pasien</label>
            <input type="text" id="nama_pasien" name="nama_pasien" value="<?php echo htmlspecialchars($data['nama_pasien']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="nama_ibu">Nama Ibu</label>
            <input type="text" id="nama_ibu" name="nama_ibu" value="<?php echo htmlspecialchars($data['nama_ibu']); ?>" required>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="Laki-laki" <?php if ($data['jenis_kelamin'] == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                    <option value="Perempuan" <?php if ($data['jenis_kelamin'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="golongan_darah">Golongan Darah</label>
                <select id="golongan_darah" name="golongan_darah" required>
                    <option value="A" <?php if ($data['golongan_darah'] == 'A') echo 'selected'; ?>>A</option>
                    <option value="B" <?php if ($data['golongan_darah'] == 'B') echo 'selected'; ?>>B</option>
                    <option value="AB" <?php if ($data['golongan_darah'] == 'AB') echo 'selected'; ?>>AB</option>
                    <option value="O" <?php if ($data['golongan_darah'] == 'O') echo 'selected'; ?>>O</option>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label for="tgl_lahir">Tanggal Lahir</label>
            <input type="date" id="tgl_lahir" name="tgl_lahir" value="<?php echo htmlspecialchars($data['tgl_lahir']); ?>" required>
        </div>
        
        <div class="btn-group" style="margin-top: 2rem;">
            <input type="submit" name="submit" value="Update Data" class="btn btn-primary">
            <a href="pasien_tampil.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?php include '../templates/footer.php'; ?>

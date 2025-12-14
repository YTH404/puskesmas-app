<?php
include '../config/koneksi.php';
include '../auth.php';
checkRole('pendaftaran');

$page_title = "Tambah Data Pasien - Puskesmas Management System";
$base_path = '../';

// Jika tombol submit ditekan
if (isset($_POST['submit'])) {
    $nama    = $_POST['nama'];
    $nama_ibu     = $_POST['nama_ibu'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $golongan_darah = $_POST['golongan_darah'];
    $tgl_lahir = $_POST['tgl_lahir'];

    $sql = "INSERT INTO pasien (nama_pasien, nama_ibu, jenis_kelamin, golongan_darah, tgl_lahir)
            VALUES ('$nama', '$nama_ibu', '$jenis_kelamin', '$golongan_darah', '$tgl_lahir')";

    if (mysqli_query($conn, $sql)) {
        setFlash('Data pasien berhasil disimpan!', 'success');
        header('Location: pasien_tampil.php');
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<?php include '../templates/sidebar.php'; ?>
<?php include '../templates/header.php'; ?>

<div class="form-container">
    <form action="" method="POST" id="addForm">
        <div class="form-group">
            <label for="nama">Nama Pasien</label>
            <input type="text" id="nama" name="nama" required>
        </div>
        
        <div class="form-group">
            <label for="nama_ibu">Nama Ibu</label>
            <input type="text" id="nama_ibu" name="nama_ibu" required>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="">-- Pilih --</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="golongan_darah">Golongan Darah</label>
                <select id="golongan_darah" name="golongan_darah" required>
                    <option value="">-- Pilih --</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="AB">AB</option>
                    <option value="O">O</option>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label for="tgl_lahir">Tanggal Lahir</label>
            <input type="date" id="tgl_lahir" name="tgl_lahir" required>
        </div>
        
        <div class="btn-group" style="margin-top: 2rem;">
            <input type="submit" name="submit" value="Simpan" class="btn btn-success">
            <a href="pasien_tampil.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>


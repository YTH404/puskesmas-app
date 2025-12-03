<?php
include '../config/koneksi.php';

$page_title = "Tambah Data Dokter - Puskesmas Management System";
$base_path = '../';

// Jika tombol submit ditekan
if (isset($_POST['submit'])) {
    $nama       = $_POST['nama'];
    $spesialis  = $_POST['spesialis'];
    $no_hp      = $_POST['no_hp_dokter'];
    $start_time = $_POST['start_time_dokter'];
    $end_time       = $_POST['end_time_dokter'];
    $alamat       = $_POST['alamat_dokter'];

    $sql = "INSERT INTO dokter (nama_dokter, spesialis, no_hp_dokter, start_time_dokter, end_time_dokter, alamat_dokter)
            VALUES ('$nama', '$spesialis', '$no_hp', '$start_time', '$end_time', '$alamat')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Data berhasil disimpan!');
                window.location='dokter_tampil.php';
              </script>";
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
            <label for="nama">Nama Dokter</label>
            <input type="text" id="nama" name="nama" required>
        </div>
        
        <div class="form-group">
            <label for="spesialis">Spesialis</label>
            <input type="text" id="spesialis" name="spesialis" placeholder="Contoh: Umum, Gigi, Anak" required>
        </div>
        
        <div class="form-group">
            <label for="no_hp_dokter">No HP</label>
            <input type="text" id="no_hp_dokter" name="no_hp_dokter" required>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="start_time_dokter">Jadwal Mulai</label>
                <input type="time" id="start_time_dokter" name="start_time_dokter" required>
            </div>
            <div class="form-group">
                <label for="end_time_dokter">Jadwal Selesai</label>
                <input type="time" id="end_time_dokter" name="end_time_dokter" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="alamat_dokter">Alamat</label>
            <input type="text" id="alamat_dokter" name="alamat_dokter" required>
        </div>
        
        <div class="btn-group" style="margin-top: 2rem;">
            <input type="submit" name="submit" value="Simpan" class="btn btn-success">
            <a href="dokter_tampil.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?php include '../templates/footer.php'; ?>

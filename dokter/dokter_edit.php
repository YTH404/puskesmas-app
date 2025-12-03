<?php
include '../config/koneksi.php';

$page_title = "Edit Data Dokter - Puskesmas Management System";
$base_path = '../';

// Jika form disubmit → proses update
if (isset($_POST['submit'])) {
    $id         = $_POST['id_dokter'];
    $nama       = $_POST['nama_dokter'];
    $spesialis  = $_POST['spesialis'];
    $no_hp      = $_POST['no_hp_dokter'];
    $start_time = $_POST['start_time_dokter'];
    $end_time   = $_POST['end_time_dokter'];
    $alamat     = $_POST['alamat_dokter'];
    

    $sql = "UPDATE dokter SET 
                nama_dokter='$nama', 
                spesialis='$spesialis',
                no_hp_dokter='$no_hp',
                start_time_dokter='$start_time',
                end_time_dokter='$end_time',
                alamat_dokter='$alamat'
            WHERE id_dokter=$id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Data berhasil diperbarui!');
                window.location='dokter_tampil.php';
              </script>";
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}

// Jika belum submit → tampilkan form edit
$id = $_GET['id_dokter'];
$sql = "SELECT * FROM dokter WHERE id_dokter = $id";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);
?>

<?php include '../templates/sidebar.php'; ?>
<?php include '../templates/header.php'; ?>

<div class="form-container">
    <form action="" method="POST" id="editForm">
        <input type="hidden" name="id_dokter" value="<?php echo htmlspecialchars($data['id_dokter']); ?>">
        
        <div class="form-group">
            <label for="nama_dokter">Nama Dokter</label>
            <input type="text" id="nama_dokter" name="nama_dokter" value="<?php echo htmlspecialchars($data['nama_dokter']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="spesialis">Spesialis</label>
            <input type="text" id="spesialis" name="spesialis" value="<?php echo htmlspecialchars($data['spesialis']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="no_hp_dokter">No HP</label>
            <input type="text" id="no_hp_dokter" name="no_hp_dokter" value="<?php echo htmlspecialchars($data['no_hp_dokter']); ?>" required>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="start_time_dokter">Jadwal Mulai</label>
                <input type="time" id="start_time_dokter" name="start_time_dokter" value="<?php echo htmlspecialchars($data['start_time_dokter']); ?>" required>
            </div>
            <div class="form-group">
                <label for="end_time_dokter">Jadwal Selesai</label>
                <input type="time" id="end_time_dokter" name="end_time_dokter" value="<?php echo htmlspecialchars($data['end_time_dokter']); ?>" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="alamat_dokter">Alamat</label>
            <input type="text" id="alamat_dokter" name="alamat_dokter" value="<?php echo htmlspecialchars($data['alamat_dokter']); ?>" required>
        </div>
        
        <div class="btn-group" style="margin-top: 2rem;">
            <input type="submit" name="submit" value="Update Data" class="btn btn-primary">
            <a href="dokter_tampil.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?php include '../templates/footer.php'; ?>

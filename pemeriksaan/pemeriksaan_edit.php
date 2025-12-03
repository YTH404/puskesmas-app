<?php
include '../config/koneksi.php';

$page_title = "Edit Data Pemeriksaan - Puskesmas Management System";
$base_path = '../';

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
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
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

<?php include '../templates/sidebar.php'; ?>
<?php include '../templates/header.php'; ?>

<div class="form-container">
    <form action="" method="POST" id="editForm">
        <input type="hidden" name="id_pemeriksaan" value="<?php echo htmlspecialchars($data['id_pemeriksaan']); ?>">
        
        <div class="form-group">
            <label for="nama_pasien">Nama Pasien</label>
            <input type="text" id="nama_pasien" value="<?php echo htmlspecialchars($data['nama_pasien']); ?>" readonly>
        </div>
        
        <div class="form-group">
            <label for="keluhan">Keluhan</label>
            <input type="text" id="keluhan" value="<?php echo htmlspecialchars($data['keluhan']); ?>" readonly>
        </div>
        
        <div class="form-group">
            <label for="id_dokter">Dokter</label>
            <select id="id_dokter" name="id_dokter" required>
                <option value="">-- Pilih Dokter --</option>
                <?php
                $dokter_sql = "SELECT id_dokter, nama_dokter FROM dokter ORDER BY nama_dokter ASC";
                $dokter_result = mysqli_query($conn, $dokter_sql);
                while ($dokter = mysqli_fetch_assoc($dokter_result)) { ?>
                    <option value="<?php echo htmlspecialchars($dokter['id_dokter']); ?>">
                        <?php echo htmlspecialchars($dokter['nama_dokter']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="waktu_periksa">Waktu Periksa</label>
            <input type="datetime-local" id="waktu_periksa" name="waktu_periksa" value="<?php echo htmlspecialchars($data['waktu_periksa']); ?>" required>
        </div>
        
        <div class="btn-group" style="margin-top: 2rem;">
            <input type="submit" name="submit" value="Update Data" class="btn btn-primary">
            <a href="pemeriksaan_tampil.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?php include '../templates/footer.php'; ?>

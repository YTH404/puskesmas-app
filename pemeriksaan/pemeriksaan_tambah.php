<?php
include '../config/koneksi.php';

$page_title = "Tambah Data Pemeriksaan - Puskesmas Management System";
$base_path = '../';

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
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<?php include '../templates/sidebar.php'; ?>
<?php include '../templates/header.php'; ?>

<div class="form-container">
    <form action="" method="POST" id="addForm">
        <input type="hidden" name="id_pendaftaran" value="<?php echo htmlspecialchars($data['id_pendaftaran']); ?>">
        
        <div class="form-group">
            <label for="nama_pasien">Nama Pasien</label>
            <input type="text" id="nama_pasien" value="<?php echo htmlspecialchars($data['nama_pasien']); ?>" readonly>
        </div>
        
        <div class="form-group">
            <label for="keluhan">Keluhan</label>
            <input type="text" id="keluhan" name="keluhan" value="<?php echo htmlspecialchars($data['keluhan']); ?>" readonly>
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
            <input type="datetime-local" id="waktu_periksa" name="waktu_periksa" required>
        </div>
        
        <input type="hidden" name="obat">
        
        <div class="btn-group" style="margin-top: 2rem;">
            <input type="submit" name="submit" value="Simpan" class="btn btn-success">
            <a href="pemeriksaan_tampil.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?php include '../templates/footer.php'; ?>

<?php
include '../config/koneksi.php';
include '../auth.php';
checkRole('apoteker');

$page_title = "Pemeriksaan Selesai - Puskesmas Management System";
$base_path = '../';

// Jika form disubmit → proses update
if (isset($_POST['submit'])) {
    $id = htmlspecialchars($_POST['id_pemeriksaan']);
    $waktu = htmlspecialchars($_POST['waktu_periksa']);
    $obat = htmlspecialchars($_POST['obat']);

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
$id = htmlspecialchars($_GET['id_pemeriksaan']);
$sql = "SELECT pemeriksaan.*, pasien.nama_pasien, pendaftaran.keluhan, dokter.nama_dokter
FROM pemeriksaan
JOIN pendaftaran ON pemeriksaan.id_pendaftaran = pendaftaran.id_pendaftaran
JOIN pasien ON pendaftaran.id_pasien = pasien.id_pasien
LEFT JOIN dokter ON pemeriksaan.id_dokter = dokter.id_dokter
WHERE id_pemeriksaan = $id";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);
?>

<?php include '../templates/sidebar.php'; ?>
<?php include '../templates/header.php'; ?>

<div class="form-container">
    <div class="page-header">
        <h1 class="page-title">Pemeriksaan Selesai</h1>
    </div>

    <form action="" method="POST" id="formSelesai">
        <input type="hidden" name="id_pemeriksaan" value="<?php echo htmlspecialchars($data['id_pemeriksaan']); ?>">
        
        <div class="form-row">
            <div class="form-group">
                <label for="nama_pasien">Nama Pasien</label>
                <input type="text" id="nama_pasien" value="<?php echo htmlspecialchars($data['nama_pasien']); ?>" readonly class="form-control" style="background-color: #f0f0f0; cursor: not-allowed;">
            </div>
            <div class="form-group">
                <label for="nama_dokter">Dokter</label>
                <input type="text" id="nama_dokter" value="<?php echo htmlspecialchars($data['nama_dokter'] ?? '-'); ?>" readonly class="form-control" style="background-color: #f0f0f0; cursor: not-allowed;">
            </div>
        </div>

        <div class="form-group">
            <label for="keluhan">Keluhan</label>
            <textarea id="keluhan" readonly class="form-control" rows="3" style="background-color: #f0f0f0; cursor: not-allowed;"><?php echo htmlspecialchars($data['keluhan']); ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="waktu_periksa">Waktu Periksa</label>
                <input type="datetime-local" id="waktu_periksa" value="<?php echo htmlspecialchars($data['waktu_periksa']); ?>" readonly class="form-control" style="background-color: #f0f0f0; cursor: not-allowed;">
            </div>
            <div class="form-group">
                <label for="obat">Obat <span style="color: #dc3545;">*</span></label>
                <input type="text" name="obat" id="obat" value="<?php echo htmlspecialchars($data['obat']); ?>" required class="form-control" placeholder="Masukkan nama obat...">
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" name="submit" class="btn btn-primary">Selesaikan Pemeriksaan</button>
            <a href="pemeriksaan_tampil.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
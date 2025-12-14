<?php
include '../config/koneksi.php';
include '../auth.php';
checkRole('pendaftaran');

$page_title = "Edit Data Pendaftaran - Puskesmas Management System";
$base_path = '../';

// Jika form disubmit → proses update
if (isset($_POST['submit'])) {
    $id = htmlspecialchars($_POST['id_pendaftaran']);
    $keluhan = htmlspecialchars($_POST['keluhan']);

    $sql = "UPDATE pendaftaran SET 
                keluhan='$keluhan'
            WHERE id_pendaftaran=$id";

    if (mysqli_query($conn, $sql)) {
        setFlash('Data pendaftaran berhasil diperbarui!', 'success');
        header('Location: pendaftaran_tampil.php');
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Jika belum submit → tampilkan form edit
$id = htmlspecialchars($_GET['id_pendaftaran']);
$sql = "SELECT pendaftaran.*, pasien.nama_pasien 
        FROM pendaftaran
        JOIN pasien ON pendaftaran.id_pasien = pasien.id_pasien
        WHERE pendaftaran.id_pendaftaran = $id";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);
?>

<?php include '../templates/sidebar.php'; ?>
<?php include '../templates/header.php'; ?>

<div class="form-container">
    <div class="page-header">
        <h1 class="page-title">Edit Data Pendaftaran</h1>
    </div>

    <form action="" method="POST" id="formEdit">
        <input type="hidden" name="id_pendaftaran" value="<?php echo htmlspecialchars($data['id_pendaftaran']); ?>">
        
        <div class="form-group">
            <label for="nama_pasien">Nama Pasien</label>
            <input type="text" id="nama_pasien" value="<?php echo htmlspecialchars($data['nama_pasien']); ?>" readonly class="form-control" style="background-color: #f0f0f0; cursor: not-allowed;">
        </div>

        <div class="form-group">
            <label for="keluhan">Keluhan <span style="color: #dc3545;">*</span></label>
            <textarea name="keluhan" id="keluhan" required class="form-control" rows="4" placeholder="Masukkan keluhan pasien..."><?php echo htmlspecialchars($data['keluhan']); ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" name="submit" class="btn btn-primary">Update Data</button>
            <a href="pendaftaran_tampil.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

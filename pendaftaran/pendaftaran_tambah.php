<?php
include '../config/koneksi.php';

$page_title = "Tambah Data Pendaftaran - Puskesmas Management System";
$base_path = '../';

$sql = "SELECT id_pasien, nama_pasien FROM pasien ORDER BY nama_pasien ASC";
$result = mysqli_query($conn, $sql);

// Jika tombol submit ditekan
if (isset($_POST['submit'])) {
    $id_pasien = htmlspecialchars($_POST['id_pasien']);
    $keluhan = htmlspecialchars($_POST['keluhan']);

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

<?php include '../templates/sidebar.php'; ?>
<?php include '../templates/header.php'; ?>

<div class="form-container">
    <div class="page-header">
        <h1 class="page-title">Tambah Data Pendaftaran</h1>
    </div>

    <form action="" method="POST" id="formPendaftaran">
        <div class="form-group">
            <label for="id_pasien">Nama Pasien <span style="color: #dc3545;">*</span></label>
            <select name="id_pasien" id="id_pasien" required class="form-control">
                <option value="">-- Pilih Pasien --</option>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <option value="<?php echo htmlspecialchars($row['id_pasien']); ?>">
                        <?php echo htmlspecialchars($row['nama_pasien']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="keluhan">Keluhan <span style="color: #dc3545;">*</span></label>
            <textarea name="keluhan" id="keluhan" required class="form-control" rows="4" placeholder="Masukkan keluhan pasien..."></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" name="submit" class="btn btn-primary">Simpan Data</button>
            <a href="pendaftaran_tampil.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?php include '../templates/footer.php'; ?>

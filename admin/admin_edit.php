<?php
include '../config/koneksi.php';
include '../auth.php';
checkRole('superadmin');

$page_title = "Edit Data Admin - Puskesmas Management System";
$base_path = '../';

// Jika form disubmit → proses update
if (isset($_POST['submit'])) {
    $id         = $_POST['id_admin'];
    $nama       = $_POST['nama_admin'];
    $password   = $_POST['password'];
    $start      = $_POST['start_time_admin'];
    $end        = $_POST['end_time_admin'];
    $level      = $_POST['level'];

    $sql = "UPDATE admin SET 
                nama_admin='$nama', 
                password='$password',
                start_time_admin='$start',
                end_time_admin='$end',
                level='$level'
            WHERE id_admin=$id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Data berhasil diperbarui!');
                window.location='admin_tampil.php';
              </script>";
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}

// Jika belum submit → tampilkan form edit
$id = $_GET['id_admin'];
$sql = "SELECT * FROM admin WHERE id_admin = $id";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);
?>

<?php include '../templates/sidebar.php'; ?>
<?php include '../templates/header.php'; ?>

<div class="form-container">
    <form action="" method="POST" id="editForm">
        <input type="hidden" name="id_admin" value="<?php echo htmlspecialchars($data['id_admin']); ?>">
        
        <div class="form-group">
            <label for="nama_admin">Nama Admin</label>
            <input type="text" id="nama_admin" name="nama_admin" value="<?php echo htmlspecialchars($data['nama_admin']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($data['password']); ?>" required>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="start_time_admin">Jam Kerja Mulai</label>
                <input type="time" id="start_time_admin" name="start_time_admin" value="<?php echo htmlspecialchars($data['start_time_admin']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="end_time_admin">Jam Kerja Selesai</label>
                <input type="time" id="end_time_admin" name="end_time_admin" value="<?php echo htmlspecialchars($data['end_time_admin']); ?>" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="level">Bagian</label>
            <select id="level" name="level" required>
                <option value="pendaftaran" <?php if ($data['level'] == 'pendaftaran') echo 'selected'; ?>>Pendaftaran</option>
                <option value="pemeriksaan" <?php if ($data['level'] == 'pemeriksaan') echo 'selected'; ?>>Pemeriksaan</option>
                <option value="apoteker" <?php if ($data['level'] == 'apoteker') echo 'selected'; ?>>Apoteker</option>
            </select>
        </div>
        
        <div class="btn-group" style="margin-top: 2rem;">
            <input type="submit" name="submit" value="Update Data" class="btn btn-primary">
            <a href="admin_tampil.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
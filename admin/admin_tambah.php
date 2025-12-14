<?php
include '../config/koneksi.php';
include '../auth.php';
checkRole('superadmin');

$page_title = "Tambah Data Admin - Puskesmas Management System";
$base_path = '../';

// Jika tombol submit ditekan
if (isset($_POST['submit'])) {
    $nama    = $_POST['nama_admin'];
    $password     = $_POST['password'];
    $start = $_POST['start_time_admin'];
    $end = $_POST['end_time_admin'];
    $level = $_POST['level'];

    // Hash password with bcrypt
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO admin (nama_admin, password, start_time_admin, end_time_admin, level)
            VALUES ('$nama', '$hashed_password', '$start', '$end', '$level')";

    if (mysqli_query($conn, $sql)) {
        setFlash('Data admin berhasil disimpan!', 'success');
        header('Location: admin_tampil.php');
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
            <label for="nama_admin">Nama Admin</label>
            <input type="text" id="nama_admin" name="nama_admin" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="start_time_admin">Jam Kerja Mulai</label>
                <input type="time" id="start_time_admin" name="start_time_admin" required>
            </div>
            
            <div class="form-group">
                <label for="end_time_admin">Jam Kerja Selesai</label>
                <input type="time" id="end_time_admin" name="end_time_admin" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="level">Bagian</label>
            <select id="level" name="level" required>
                <option value="">-- Pilih Bagian --</option>
                <option value="admin">Admin</option>
                <option value="pendaftaran">Pendaftaran</option>
                <option value="pemeriksaan">Pemeriksaan</option>
                <option value="apoteker">Apoteker</option>
            </select>
        </div>
        
        <div class="btn-group" style="margin-top: 2rem;">
            <input type="submit" name="submit" value="Simpan" class="btn btn-success">
            <a href="admin_tampil.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

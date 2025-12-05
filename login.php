<?php
session_start();
include 'config/koneksi.php';

$error = '';
$success = '';

// Jika form login disubmit
if (isset($_POST['login'])) {
    $nama_admin = htmlspecialchars($_POST['nama_admin']);
    $password = htmlspecialchars($_POST['password']);

    // Query untuk mencari user
    $sql = "SELECT * FROM admin WHERE nama_admin='$nama_admin' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);

    if ($data) {
        $_SESSION['login'] = true;
        $_SESSION['level'] = $data['level'];
        $_SESSION['nama_admin'] = $data['nama_admin'];
        $success = 'Login berhasil! Mengalihkan...';
        echo "<script>
                setTimeout(function() {
                    window.location='index.php';
                }, 1500);
              </script>";
    } else {
        $error = 'Nama Admin atau Password salah!';
    }
}

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['login'])) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Puskesmas Management System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-container">
    <div class="login-box">
        <div class="login-header">
            <div class="login-logo">🏥</div>
            <h1 class="login-title">Puskesmas</h1>
            <p class="login-subtitle">Management System</p>
        </div>

        <?php if ($error): ?>
            <div class="login-alert error">
                <strong>Error!</strong> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="login-alert success">
                <strong>Sukses!</strong> <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" class="login-form">
            <div class="form-group">
                <label for="nama_admin">nama_admin</label>
                <input type="text" id="nama_admin" name="nama_admin" placeholder="Masukkan Nama Admin" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
            </div>

            <button type="submit" name="login">Login</button>
        </form>

        <div class="login-footer">
            <p>&copy; 2025 Puskesmas Management System</p>
            <p style="margin-top: 0.5rem; font-size: 0.85rem;">Sistem Manajemen Puskesmas</p>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>

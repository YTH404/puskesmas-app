<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config/koneksi.php';
include 'auth.php';

$error = '';
$success = '';

// Jika form login disubmit
if (isset($_POST['login'])) {
    $nama_admin = htmlspecialchars($_POST['nama_admin']);
    $password = htmlspecialchars($_POST['password']);

    // Query untuk mencari user by username only
    $sql = "SELECT * FROM admin WHERE nama_admin='$nama_admin'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);

    // Verify password using password_verify for hashed passwords
    if ($data && password_verify($password, $data['password'])) {
        $_SESSION['login'] = true;
        $_SESSION['level'] = $data['level'];
        $_SESSION['nama_admin'] = $data['nama_admin'];
        setFlash('Login berhasil! Selamat datang, ' . $data['nama_admin'], 'success');
        header('Location: index.php');
        exit;
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
    <script>
        window.tailwind = window.tailwind || {};
        window.tailwind.config = { corePlugins: { preflight: false } };
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="login-container">
    <?php $flash = function_exists('consumeFlash') ? consumeFlash() : null; ?>
    <script>
        window.appFlash = <?php echo json_encode($flash); ?>;
    </script>
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
                <label for="nama_admin">Nama Admin</label>
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

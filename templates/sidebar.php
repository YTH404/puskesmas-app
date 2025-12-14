<?php

// Calculate base path for flexible navigation
$current_file = $_SERVER['PHP_SELF'];
$parts = explode('/', trim($current_file, '/'));
$depth = count($parts) - 1;
$base_path = str_repeat('../', max(0, $depth - 1));

// If we're in root directory (index.php or login.php), no need for ../
if ($depth <= 1) {
    $base_path = '';
}

// Use canView() from auth.php for role-based visibility. Include auth.php if helper isn't available.
if (!function_exists('canView')) {
    // auth.php handles session start and provides canView()/checkRole()
    require_once __DIR__ . '/../auth.php';
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Puskesmas App'; ?></title>
    <?php $css_path = __DIR__ . '/../assets/css/style.css'; ?>
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/style.css?v=<?php echo file_exists($css_path) ? filemtime($css_path) : time(); ?>">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-brand">
                <span>🏥</span>
                <span>Puskesmas</span>
            </div>
            <button class="sidebar-toggle" id="sidebarToggle">☰</button>
        </div>
        
        <nav class="sidebar-nav">
            <ul class="navbar">
                <?php if (canView(['pendaftaran', 'pemeriksaan', 'apoteker', 'admin'])): ?>
                    <li class="sidebar-header">Menu Utama</li>
                    <li class="sidebar-item">
                        <a class="sidebar-link <?php echo (strpos($_SERVER['PHP_SELF'], 'index.php') !== false) ? 'active' : ''; ?>" aria-current="page" href="<?php echo $base_path; ?>index.php" data-nav="dashboard">
                            <i class="icon">📊</i>
                            <span class="sidebar-text">Dashboard</span>
                        </a>
                    </li>
                <?php endif; ?>
                
                <?php if (canView(['pendaftaran', 'dokter'])): ?>
                    <li class="sidebar-header">Data Master</li>
                <?php endif; ?>

                <?php if (canView(['pendaftaran'])): ?>
                    <li class="sidebar-item">
                        <a class="sidebar-link <?php echo (strpos($_SERVER['PHP_SELF'], 'pasien') !== false) ? 'active' : ''; ?>" aria-current="page" href="<?php echo $base_path; ?>pasien/pasien_tampil.php" data-nav="pasien">
                            <i class="icon">👥</i>
                            <span class="sidebar-text">Data Pasien</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (canView(['admin'])): ?>
                    <li class="sidebar-item">
                        <a class="sidebar-link <?php echo (strpos($_SERVER['PHP_SELF'], 'dokter') !== false) ? 'active' : ''; ?>" aria-current="page" href="<?php echo $base_path; ?>dokter/dokter_tampil.php" data-nav="dokter">
                            <i class="icon">👨‍⚕️</i>
                            <span class="sidebar-text">Data Dokter</span>
                        </a>
                    </li>
                <?php endif; ?>
                
                <?php if (canView(['pendaftaran', 'pemeriksaan', 'apoteker'])): ?>
                    <li class="sidebar-header">Layanan</li>
                <?php endif; ?>

                <?php if (canView(['pendaftaran', 'pemeriksaan'])): ?>
                    <li class="sidebar-item">
                        <a class="sidebar-link <?php echo (strpos($_SERVER['PHP_SELF'], 'pendaftaran') !== false) ? 'active' : ''; ?>" aria-current="page" href="<?php echo $base_path; ?>pendaftaran/pendaftaran_tampil.php" data-nav="pendaftaran">
                            <i class="icon">📋</i>
                            <span class="sidebar-text">Pendaftaran</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (canView(['pemeriksaan', 'apoteker'])): ?>
                    <li class="sidebar-item">
                        <a class="sidebar-link <?php echo (strpos($_SERVER['PHP_SELF'], 'pemeriksaan') !== false) ? 'active' : ''; ?>" aria-current="page" href="<?php echo $base_path; ?>pemeriksaan/pemeriksaan_tampil.php" data-nav="pemeriksaan">
                            <i class="icon">🩺</i>
                            <span class="sidebar-text">Pemeriksaan</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (canView(['pendaftaran', 'pemeriksaan', 'apoteker', 'admin'])): ?>
                    <li class="sidebar-item">
                        <a class="sidebar-link <?php echo (strpos($_SERVER['PHP_SELF'], 'histori') !== false) ? 'active' : ''; ?>" aria-current="page" href="<?php echo $base_path; ?>histori/histori_tampil.php" data-nav="histori">
                            <i class="icon">📜</i>
                            <span class="sidebar-text">Histori Pemeriksaan</span>
                        </a>
                    </li>
                <?php endif; ?>
                
                <?php if (canView(['superadmin'])): ?>
                    <li class="sidebar-header">Sistem</li>
                    <li class="sidebar-item">
                        <a class="sidebar-link <?php echo (strpos($_SERVER['PHP_SELF'], 'admin') !== false) ? 'active' : ''; ?>" aria-current="page" href="<?php echo $base_path; ?>admin/admin_tampil.php" data-nav="admin">
                            <i class="icon">⚙️</i>
                            <span class="sidebar-text">Kelola Admin</span>
                        </a>
                    </li>
                <?php endif; ?>
                
                <li class="sidebar-header">Akun</li>
                <li class="sidebar-item">
                    <form action="<?php echo $base_path; ?>logout.php" method="POST" class="logout-form">
                        <button type="submit" class="sidebar-link logout-item" id="logout">
                            <i class="icon">🚪</i>
                            <span class="sidebar-text">Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
            <div class="sidebar-footer">
                <span>&copy; <?php echo date('Y'); ?> Puskesmas Management System</span>
            </div>
    </aside>

    <!-- Main Content -->
    <div class="main-wrapper">
        

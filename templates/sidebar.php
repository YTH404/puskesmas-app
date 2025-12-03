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
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Puskesmas App'; ?></title>
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/style.css">
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
            <a href="<?php echo $base_path; ?>index.php" class="nav-item" data-nav="dashboard">
                <span class="nav-icon">📊</span>
                <span class="nav-text">Dashboard</span>
            </a>
            <div class="nav-section">
                <div class="nav-section-title">Data Utama</div>
                <a href="<?php echo $base_path; ?>pasien/pasien_tampil.php" class="nav-item" data-nav="pasien">
                    <span class="nav-icon">👥</span>
                    <span class="nav-text">Pasien</span>
                </a>
                <a href="<?php echo $base_path; ?>dokter/dokter_tampil.php" class="nav-item" data-nav="dokter">
                    <span class="nav-icon">👨‍⚕️</span>
                    <span class="nav-text">Dokter</span>
                </a>
            </div>
            
            <div class="nav-section">
                <div class="nav-section-title">Layanan</div>
                <a href="<?php echo $base_path; ?>pendaftaran/pendaftaran_tampil.php" class="nav-item" data-nav="pendaftaran">
                    <span class="nav-icon">📋</span>
                    <span class="nav-text">Pendaftaran</span>
                </a>
                <a href="<?php echo $base_path; ?>pemeriksaan/pemeriksaan_tampil.php" class="nav-item" data-nav="pemeriksaan">
                    <span class="nav-icon">🩺</span>
                    <span class="nav-text">Pemeriksaan</span>
                </a>
                <a href="<?php echo $base_path; ?>histori/histori_tampil.php" class="nav-item" data-nav="histori">
                    <span class="nav-icon">📜</span>
                    <span class="nav-text">Histori</span>
                </a>
            </div>
            
            <div class="nav-section">
                <div class="nav-section-title">Sistem</div>
                <a href="<?php echo $base_path; ?>admin/admin_tampil.php" class="nav-item" data-nav="admin">
                    <span class="nav-icon">⚙️</span>
                    <span class="nav-text">Admin</span>
                </a>
            </div>

            <div class="nav-section" style="margin-top: auto; border-top: 1px solid rgba(255, 255, 255, 0.1); padding-top: 1rem;">
                <a href="<?php echo $base_path; ?>logout.php" class="nav-item logout-item" data-nav="logout">
                    <span class="nav-icon">🚪</span>
                    <span class="nav-text">Logout</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <nav class="topbar">
            <div class="topbar-content">
                <div class="topbar-left">
                    <button class="menu-toggle" id="menuToggle">☰</button>
                    <h1 class="page-title-bar"><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Puskesmas Management System'; ?></h1>
                </div>
                <div class="topbar-right">
                    <span class="user-info">👤 Admin</span>
                </div>
            </div>
        </nav>
        
        <!-- Page Content -->
        <div class="container">

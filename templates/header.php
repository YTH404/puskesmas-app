<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Puskesmas App'; ?></title>
    <link rel="stylesheet" href="<?php echo isset($css_path) ? htmlspecialchars($css_path) : '../../assets/css/style.css'; ?>">
</head>
<body>
    <nav>
        <div class="navbar-container">
            <div class="navbar-brand">
                <span>🏥</span>
                <span>Puskesmas Management System</span>
            </div>
            <ul class="nav-menu">
                <li><a href="../../index.php">Dashboard</a></li>
                <li><a href="../../pendaftaran/pendaftaran_tampil.php">Pendaftaran</a></li>
                <li><a href="../../pemeriksaan/pemeriksaan_tampil.php">Pemeriksaan</a></li>
                <li><a href="../../histori/histori_tampil.php">Histori</a></li>
                <li><a href="../../pasien/pasien_tampil.php">Pasien</a></li>
                <li><a href="../../dokter/dokter_tampil.php">Dokter</a></li>
                <li><a href="../../admin/admin_tampil.php">Admin</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">

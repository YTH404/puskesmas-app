<?php
include 'config/koneksi.php';
include 'auth.php';
checkRole(["admin", "pendaftaran", "pemeriksaan", "apoteker"]);

$page_title = "Dashboard - Puskesmas Management System";
$base_path = '';

// Get statistics
$totalPasien = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM pasien"))['count'];
$totalDokter = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM dokter"))['count'];
$totalPendaftaran = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM pendaftaran WHERE status IN ('Menunggu', 'Diperiksa')"))['count'];
$totalPemeriksaan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM pendaftaran WHERE status IN ('Diperiksa')"))['count'];

// Get recent data
$recentPendaftaran = mysqli_query($conn, "SELECT p.id_pendaftaran, p.keluhan, pa.nama_pasien, p.status 
                                          FROM pendaftaran p 
                                          JOIN pasien pa ON p.id_pasien = pa.id_pasien
                                          WHERE p.status IN ('Menunggu', 'Diperiksa') 
                                          ORDER BY p.id_pendaftaran DESC LIMIT 5");

$recentPemeriksaan = mysqli_query($conn, "SELECT pm.id_pemeriksaan, p.status, pa.nama_pasien, d.nama_dokter, pm.waktu_periksa 
                                          FROM pemeriksaan pm 
                                          JOIN pendaftaran p ON pm.id_pendaftaran = p.id_pendaftaran
                                          JOIN pasien pa ON p.id_pasien = pa.id_pasien
                                          LEFT JOIN dokter d ON pm.id_dokter = d.id_dokter
                                          WHERE p.status IN ('Diperiksa')
                                          ORDER BY pm.id_pemeriksaan DESC LIMIT 5");
?>

<?php include 'templates/sidebar.php'; ?>
<?php include 'templates/header.php'; ?>

<!-- Statistics Grid -->
<div class="dashboard-grid">
    <div class="stat-card">
        <h3>Total Pasien</h3>
        <div class="stat-value"><?php echo $totalPasien; ?></div>
    </div>
    <div class="stat-card" style="border-left-color: #28a745;">
        <h3>Total Dokter</h3>
        <div class="stat-value"><?php echo $totalDokter; ?></div>
    </div>
    <div class="stat-card" style="border-left-color: #17a2b8;">
        <h3>Total Pendaftaran</h3>
        <div class="stat-value"><?php echo $totalPendaftaran; ?></div>
    </div>
    <div class="stat-card" style="border-left-color: #ffc107;">
        <h3>Total Pemeriksaan</h3>
        <div class="stat-value"><?php echo $totalPemeriksaan; ?></div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin: 2rem 0;">
    <!-- Recent Pendaftaran -->
    <div class="table-container">
        <h2>📋 Pendaftaran Terbaru</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pasien</th>
                    <th>Keluhan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (mysqli_num_rows($recentPendaftaran) > 0) {
                    while ($row = mysqli_fetch_assoc($recentPendaftaran)) {
                        $status_class = $row['status'] === 'Selesai' ? 'style="color: #28a745;"' : ($row['status'] === 'Menunggu' ? 'style="color: #ffc107;"' : 'style="color: #17a2b8;"');
                        echo "<tr>
                                <td>" . htmlspecialchars($row['id_pendaftaran']) . "</td>
                                <td>" . htmlspecialchars($row['nama_pasien']) . "</td>
                                <td>" . htmlspecialchars($row['keluhan']) . "</td>
                                <td $status_class><strong>" . htmlspecialchars($row['status']) . "</strong></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>Tidak ada data</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <div style="margin-top: 1rem; text-align: center;">
            <a href="pendaftaran/pendaftaran_tampil.php" class="btn btn-primary">Lihat Semua</a>
        </div>
    </div>

    <!-- Recent Pemeriksaan -->
    <div class="table-container">
        <h2>🩺 Pemeriksaan Terbaru</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pasien</th>
                    <th>Dokter</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (mysqli_num_rows($recentPemeriksaan) > 0) {
                    while ($row = mysqli_fetch_assoc($recentPemeriksaan)) {
                        $dokter_nama = !empty($row['nama_dokter']) ? htmlspecialchars($row['nama_dokter']) : '-';
                        echo "<tr>
                                <td>" . htmlspecialchars($row['id_pemeriksaan']) . "</td>
                                <td>" . htmlspecialchars($row['nama_pasien']) . "</td>
                                <td>" . $dokter_nama . "</td>
                                <td>" . htmlspecialchars($row['waktu_periksa']) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>Tidak ada data</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <div style="margin-top: 1rem; text-align: center;">
            <a href="pemeriksaan/pemeriksaan_tampil.php" class="btn btn-primary">Lihat Semua</a>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card" style="margin-top: 2rem;">
    <div class="card-header">⚡ Aksi Cepat</div>
    <div class="card-body">
        <div class="btn-group" style="gap: 1rem;">
            <a href="pasien/pasien_tambah.php" class="btn btn-primary">+ Tambah Pasien</a>
            <a href="pendaftaran/pendaftaran_tambah.php" class="btn btn-primary">+ Daftar Pasien</a>
            <a href="pemeriksaan/pemeriksaan_tambah.php" class="btn btn-info">+ Tambah Pemeriksaan</a>
            <a href="dokter/dokter_tampil.php" class="btn btn-secondary">Kelola Dokter</a>
            <a href="admin/admin_tampil.php" class="btn btn-secondary">Kelola Admin</a>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>

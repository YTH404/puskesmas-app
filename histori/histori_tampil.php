<?php
include '../config/koneksi.php';
include '../auth.php';
checkRole(["pendaftaran", "pemeriksaan", "apoteker", "admin"]);

$page_title = "Histori Pemeriksaan - Puskesmas Management System";
$base_path = '../';

// Query untuk mengambil data histori (hanya yang status = 'Selesai')
$sql = "SELECT pemeriksaan.*, pasien.nama_pasien, pendaftaran.keluhan, pendaftaran.status, dokter.nama_dokter
        FROM pemeriksaan
        LEFT JOIN dokter ON pemeriksaan.id_dokter = dokter.id_dokter
        JOIN pendaftaran ON pemeriksaan.id_pendaftaran = pendaftaran.id_pendaftaran
        JOIN pasien ON pendaftaran.id_pasien = pasien.id_pasien
        WHERE pendaftaran.status = 'Selesai'";

$result = mysqli_query($conn, $sql);
if (!$result) {
    echo "SQL Error: " . mysqli_error($conn);
    exit;
}
?>

<?php include '../templates/sidebar.php'; ?>
<?php include '../templates/header.php'; ?>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pasien</th>
                <th>Nama Dokter</th>
                <th>Waktu Periksa</th>
                <th>Keluhan</th>
                <th>Obat</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $dokter_nama = !empty($row['nama_dokter']) ? htmlspecialchars($row['nama_dokter']) : '-';
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id_pemeriksaan']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_pasien']) . "</td>";
                    echo "<td>" . $dokter_nama . "</td>";
                    echo "<td>" . htmlspecialchars($row['waktu_periksa']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['keluhan']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['obat']) . "</td>";
                    echo "<td><span style='color: #28a745;'><strong>" . htmlspecialchars($row['status']) . "</strong></span></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>Data belum ada</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
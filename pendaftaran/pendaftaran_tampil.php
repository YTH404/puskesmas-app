<?php
include '../config/koneksi.php';

$page_title = "Data Pendaftaran - Puskesmas Management System";
$css_path = "../assets/css/style.css";
$js_path = "../assets/js/script.js";

// Query untuk mengambil data
$sql = "SELECT pendaftaran.*, pasien.nama_pasien 
        FROM pendaftaran
        JOIN pasien ON pendaftaran.id_pasien = pasien.id_pasien
        WHERE status IN ('Menunggu', 'Diperiksa')";
$result = mysqli_query($conn, $sql);
?>

<?php include '../templates/header.php'; ?>

<div class="page-header">
    <h1 class="page-title">📝 Data Pendaftaran</h1>
    <a href="pendaftaran_tambah.php" class="btn btn-success" style="float: right; margin-top: -2.5rem;">+ Pendaftaran Baru</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Keluhan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $status_class = $row['status'] === 'Menunggu' ? 'style="color: #ffc107;"' : 'style="color: #17a2b8;"';
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id_pendaftaran']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_pasien']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['keluhan']) . "</td>";
                    echo "<td $status_class><strong>" . htmlspecialchars($row['status']) . "</strong></td>";
                    echo "<td class='action-links'>";
                    echo "<a href='pendaftaran_edit.php?id_pendaftaran=" . $row['id_pendaftaran'] . "' class='edit'>Edit</a>";
                    if ($row['status'] == 'Menunggu') {
                        echo " <a href='pendaftaran_hapus.php?id_pendaftaran=" . $row['id_pendaftaran'] . "' class='delete' onclick=\"return confirmDelete('Yakin ingin menghapus data ini?')\">Hapus</a>";
                        echo " <a href='../pemeriksaan/pemeriksaan_tambah.php?id_pendaftaran=" . $row['id_pendaftaran'] . "' class='view'>Periksa</a>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>Data belum ada</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include '../templates/footer.php'; ?>
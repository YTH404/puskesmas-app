<?php
include '../config/koneksi.php';

$page_title = "Data Pemeriksaan - Puskesmas Management System";
$base_path = '../';

// Query untuk mengambil data
$sql = "SELECT pemeriksaan.*, pasien.nama_pasien, pendaftaran.keluhan, pendaftaran.status, dokter.nama_dokter
        FROM pemeriksaan
        LEFT JOIN dokter ON pemeriksaan.id_dokter = dokter.id_dokter
        JOIN pendaftaran ON pemeriksaan.id_pendaftaran = pendaftaran.id_pendaftaran
        JOIN pasien ON pendaftaran.id_pasien = pasien.id_pasien
        WHERE pendaftaran.status = 'Diperiksa'";
$result = mysqli_query($conn, $sql);
?>

<?php include '../templates/sidebar.php'; ?>
<?php include '../templates/header.php'; ?>

<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <a href="pemeriksaan_tambah.php" class="btn btn-success">+ Tambah Pemeriksaan</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pasien</th>
                <th>Nama Dokter</th>
                <th>Waktu Periksa</th>
                <th>Keluhan</th>
                <th>Aksi</th>
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
                    echo "<td class='action-links'>
                            <a href='pemeriksaan_edit.php?id_pemeriksaan=" . $row['id_pemeriksaan'] . "' class='edit'>Edit</a>
                            <a href='pemeriksaan_selesai.php?id_pemeriksaan=" . $row['id_pemeriksaan'] . "' class='view'>Selesai</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>Data belum ada</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include '../templates/footer.php'; ?>
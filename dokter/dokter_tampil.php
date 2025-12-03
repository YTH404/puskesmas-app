<?php
include '../config/koneksi.php';

$page_title = "Data Dokter - Puskesmas Management System";
$css_path = "../assets/css/style.css";
$js_path = "../assets/js/script.js";

// Query untuk mengambil data
$sql = "SELECT * FROM dokter";
$result = mysqli_query($conn, $sql);
?>

<?php include '../templates/header.php'; ?>

<div class="page-header">
    <h1 class="page-title">👨‍⚕️ Data Dokter</h1>
    <a href="dokter_tambah.php" class="btn btn-success" style="float: right; margin-top: -2.5rem;">+ Tambah Dokter</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Spesialis</th>
                <th>No HP</th>
                <th>Jadwal Kerja</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id_dokter']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_dokter']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['spesialis']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['no_hp_dokter']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['start_time_dokter']) . " - " . htmlspecialchars($row['end_time_dokter']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['alamat_dokter']) . "</td>";
                    echo "<td class='action-links'>
                            <a href='dokter_edit.php?id_dokter=" . $row['id_dokter'] . "' class='edit'>Edit</a>
                            <a href='dokter_hapus.php?id_dokter=" . $row['id_dokter'] . "' class='delete' onclick=\"return confirmDelete('Yakin ingin menghapus data ini?')\">Hapus</a>
                        </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>Data belum ada</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include '../templates/footer.php'; ?>
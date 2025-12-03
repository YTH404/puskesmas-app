<?php
include '../config/koneksi.php';

$page_title = "Data Admin - Puskesmas Management System";
$css_path = "../assets/css/style.css";
$js_path = "../assets/js/script.js";

// Query untuk mengambil data
$sql = "SELECT * FROM admin
        WHERE level IN ('pendaftaran', 'pemeriksaan', 'apoteker')";
$result = mysqli_query($conn, $sql);
?>

<?php include '../templates/header.php'; ?>

<div class="page-header">
    <h1 class="page-title">📋 Data Admin</h1>
    <a href="admin_tambah.php" class="btn btn-success" style="float: right; margin-top: -2.5rem;">+ Tambah Admin</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jam Kerja</th>
                <th>Bagian</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id_admin']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_admin']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['start_time_admin']) . ' - '. htmlspecialchars($row['end_time_admin']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['level']) . "</td>";
                    echo "<td class='action-links'>
                            <a href='admin_edit.php?id_admin=" . $row['id_admin'] . "' class='edit'>Edit</a>
                            <a href='admin_hapus.php?id_admin=" . $row['id_admin'] . "' class='delete' onclick=\"return confirmDelete('Yakin ingin menghapus data ini?')\">Hapus</a>
                          </td>";
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
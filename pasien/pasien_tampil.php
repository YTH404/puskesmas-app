<?php
include '../config/koneksi.php';
include '../auth.php';
checkRole('pendaftaran');

$page_title = "Data Pasien - Puskesmas Management System";
$base_path = '../';

// Query untuk mengambil data
$sql = "SELECT * FROM pasien";
$result = mysqli_query($conn, $sql);
?>

<?php include '../templates/sidebar.php'; ?>
<?php include '../templates/header.php'; ?>

<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <a href="pasien_tambah.php" class="btn btn-success">+ Tambah Pasien</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Nama Ibu</th>
                <th>Jenis Kelamin</th>
                <th>Golongan Darah</th>
                <th>Tanggal Lahir</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id_pasien']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_pasien']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_ibu']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['jenis_kelamin']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['golongan_darah']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tgl_lahir']) . "</td>";
                    echo "<td class='action-links'>";
                            echo "<a href='pasien_edit.php?id_pasien=" . $row['id_pasien'] . "' class='edit'>Edit</a>";
                            $check_pemeriksaan = mysqli_query($conn, "SELECT id_pasien FROM pendaftaran WHERE id_pasien = '" . $row['id_pasien'] . "' LIMIT 1");
                            if (mysqli_num_rows($check_pemeriksaan) == 0) {
                                echo "<a href='pasien_hapus.php?id_pasien=" . $row['id_pasien'] . "' class='delete'>Hapus</a>";
                            } else {
                                echo "<span class='delete disabled' title='Pasien ini memiliki data pemeriksaan dan tidak dapat dihapus' style='display: inline-block; min-width: 63px;'>Hapus</span>";
                        }
                        "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>Data belum ada</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
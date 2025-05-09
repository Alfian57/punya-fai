<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once '../config/db.php';
require_once '../classes/Bayi.php';

$bayi = new Bayi($conn);
$result = $conn->query("SELECT * FROM databayi ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Data Balita</h2>
    <a href="tambah_bayi.php" class="btn btn-success mb-3">+ Tambah Data</a>
    <a href="../proses/proses_logout.php" class="btn btn-danger mb-3">Logout</a>

    <table class="table table-striped align-middle">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tinggi</th>
                <th>Berat</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Riwayat</th>
                <th>Catatan</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= $row['tinggi'] ?> cm</td>
                    <td><?= $row['berat'] ?> kg</td>
                    <td><?= $row['jenisKelamin'] ?></td>
                    <td><?= $row['tanggalLahir'] ?></td>
                    <td><?= $row['riwayat'] ?></td>
                    <td><?= $row['catatan'] ?></td>
                    <td>
                        <a href="edit_bayi.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="../proses/proses_hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                        
                           onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>

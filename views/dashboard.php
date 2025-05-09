<?php
require_once '../config/Database.php';
require_once '../controllers/BayiController.php';
require_once '../controllers/Controller.php';

// Cek login dan ambil data bayi
$controller = new Controller();
$controller->requireLogin();

$bayiController = new BayiController();
$dataBayi = $bayiController->bayiModel->getAllBayi();

// Ambil pesan flash jika ada
$flashMessage = $controller->getFlashMessage();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <?php if (isset($flashMessage)): ?>
            <div class="alert alert-<?= $flashMessage['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show"
                role="alert">
                <?= $flashMessage['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <h2 class="mb-4">Data Balita</h2>
        <a href="tambah_bayi.php" class="btn btn-success mb-3">+ Tambah Data</a>
        <a href="../proses/proses_logout.php" class="btn btn-danger mb-3">Logout</a>

        <div class="mb-3">
            <form action="../controllers/BayiController.php?action=search" method="GET" class="d-flex">
                <input type="hidden" name="action" value="search">
                <input type="text" name="keyword" class="form-control me-2" placeholder="Cari nama bayi..."
                    value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
        </div>

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
                <?php $no = 1;
                foreach ($dataBayi as $bayi): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($bayi['nama']) ?></td>
                        <td><?= $bayi['tinggi'] ?> cm</td>
                        <td><?= $bayi['berat'] ?> kg</td>
                        <td><?= $bayi['jenisKelamin'] ?></td>
                        <td><?= $bayi['tanggalLahir'] ?></td>
                        <td><?= $bayi['riwayat'] ?></td>
                        <td><?= $bayi['catatan'] ?></td>
                        <td>
                            <a href="edit_bayi.php?id=<?= $bayi['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="../proses/proses_hapus.php?id=<?= $bayi['id'] ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($dataBayi)): ?>
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
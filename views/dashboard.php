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
        <a href="index.php?controller=bayi&action=tambahForm" class="btn btn-success mb-3">+ Tambah Data</a>
        <a href="index.php?controller=user&action=logout" class="btn btn-danger mb-3">Logout</a>

        <div class="mb-3">
            <form action="index.php" method="GET" class="d-flex">
                <input type="hidden" name="controller" value="bayi">
                <input type="hidden" name="action" value="search">
                <input type="text" name="keyword" class="form-control me-2" placeholder="Cari nama bayi..."
                    value="<?= isset($keyword) ? $keyword : '' ?>">
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
                        <td><?= htmlspecialchars($bayi['riwayat']) ?></td>
                        <td><?= htmlspecialchars($bayi['catatan']) ?></td>
                        <td>
                            <a href="index.php?controller=bayi&action=editForm&id=<?= $bayi['id'] ?>"
                                class="btn btn-warning btn-sm">Edit</a>
                            <a href="index.php?controller=bayi&action=hapus&id=<?= $bayi['id'] ?>"
                                class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
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
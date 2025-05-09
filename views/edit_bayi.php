<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once '../config/db.php';

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM databayi WHERE id = $id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Balita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container my-5">
        <h2>Edit Data Balita</h2>
        <br>

        <form action="../proses/proses_edit.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>"> 
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Nama</label>
                <div class="col-sm-6">
                    <input type="text" name="nama" class="form-control" placeholder="Masukkan nama..." value="<?php echo $data['nama']; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-6">
                    <select name="jenis" class="form-control">
                        <option value="Laki-Laki" <?php echo ($data['jenisKelamin'] == 'Laki-Laki') ? 'selected' : ''; ?>>Laki-Laki</option>
                        <option value="Perempuan" <?php echo ($data['jenisKelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                        
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Tinggi Badan (cm)</label>
                <div class="col-sm-6">
                    <input type="number" name="tinggi" class="form-control" placeholder="Tinggi badan..." step="0.01" value="<?php echo $data['tinggi']; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Berat Badan (kg)</label>
                <div class="col-sm-6">
                    <input type="number" name="berat" class="form-control" placeholder="Berat badan..." step="0.01" value="<?php echo $data['berat']; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                <div class="col-sm-6">
                    <input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d', strtotime($data['tanggalLahir'])); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Riwayat Penyakit</label>
                <div class="col-sm-6">
                    <input type="text" name="riwayat" class="form-control" placeholder="Riwayat penyakit..." value="<?php echo $data['riwayat']; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Catatan</label>
                <div class="col-sm-6">
                    <input type="text" name="catatan" class="form-control" placeholder="Catatan..." value="<?php echo $data['catatan']; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <button type="submit" name="edit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
                <div class="col-sm-6">
                    <a href="dashboard.php" class="btn btn-outline-primary">Kembali</a>
                </div>
            </div>
        </form>
    </div>

</body>

</html>
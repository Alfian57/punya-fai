<?php
require_once '../config/db.php';
require_once '../classes/Bayi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bayi = new Bayi($conn);

    $bayi->setNama($_POST['nama']);
    $bayi->setTinggi($_POST['tinggi']);
    $bayi->setBerat($_POST['berat']);
    $bayi->setJenisKelamin($_POST['jenisKelamin']);
    $bayi->setTanggalLahir($_POST['tanggalLahir']);
    $bayi->setRiwayat($_POST['riwayat']);
    $bayi->setCatatan($_POST['catatan']);

    if ($bayi->tambah()) {
        header("Location: ../views/dashboard.php?pesan=berhasil");
    } else {
        header("Location: ../views/dashboard.php?pesan=gagal");
    }
    exit;
}
?>

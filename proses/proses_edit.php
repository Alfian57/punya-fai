<?php
require_once '../config/Database.php';
require_once '../controllers/Controller.php';
require_once '../controllers/BayiController.php';

// Mulai session jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../views/auth/login.php');
    exit;
}

// Handle POST request untuk edit data bayi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    // Jika id valid
    if ($id > 0) {
        $bayiController = new BayiController();

        // Set data dari form
        $bayiController->bayiModel->setNama($_POST['nama']);
        $bayiController->bayiModel->setTinggi($_POST['tinggi']);
        $bayiController->bayiModel->setBerat($_POST['berat']);
        $bayiController->bayiModel->setJenisKelamin($_POST['jenisKelamin']);
        $bayiController->bayiModel->setTanggalLahir($_POST['tanggalLahir']);
        $bayiController->bayiModel->setRiwayat($_POST['riwayat']);
        $bayiController->bayiModel->setCatatan($_POST['catatan']);

        // Proses update data
        if ($bayiController->bayiModel->update($id)) {
            // Set flash message sukses
            $controller = new Controller();
            $controller->setFlashMessage('success', 'Data bayi berhasil diperbarui');
        } else {
            // Set flash message error
            $controller = new Controller();
            $controller->setFlashMessage('error', 'Gagal memperbarui data bayi');
        }
    }
}

// Redirect ke halaman dashboard
header('Location: ../index.php?controller=bayi&action=index');
exit;
?>
<?php
require_once '../config/Database.php';
require_once '../controllers/BayiController.php';

// Buat instance dari BayiController
$bayiController = new BayiController();

// Ambil ID dari parameter GET
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Handle proses hapus
$bayiController->hapus($id);
?>
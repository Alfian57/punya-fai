<?php
require_once '../config/Database.php';
require_once '../controllers/BayiController.php';

// Buat instance dari BayiController
$bayiController = new BayiController();

// Handle proses edit
$bayiController->edit();
?>
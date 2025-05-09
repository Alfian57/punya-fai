<?php
require_once '../config/Database.php';
require_once '../controllers/UserController.php';

// Buat instance dari UserController
$userController = new UserController();

// Handle proses login
$userController->login();
?>
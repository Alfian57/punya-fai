<?php
require_once 'config/Database.php';
require_once 'controllers/Controller.php';

// Mulai session
session_start();

$controller = new Controller();

// Jika sudah login, arahkan ke dashboard
if ($controller->isLoggedIn()) {
    $controller->redirect('views/dashboard.php');
} else {
    // Jika belum login, arahkan ke halaman login
    $controller->redirect('views/login.php');
}
?>
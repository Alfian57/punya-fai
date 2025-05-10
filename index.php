<?php
require_once 'config/Database.php';
require_once 'controllers/Controller.php';
require_once 'controllers/UserController.php';
require_once 'controllers/BayiController.php';

// Mulai session
session_start();

// Logika routing sederhana
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'user';
$action = isset($_GET['action']) ? $_GET['action'] : 'loginForm';
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

// Inisialisasi controller yang sesuai
switch ($controller) {
    case 'bayi':
        $currentController = new BayiController();
        break;
    case 'user':
        $currentController = new UserController();
        break;
    default:
        // Controller tidak valid, arahkan ke UserController
        $currentController = new UserController();
        $action = 'loginForm'; // Set action default
        break;
}

// Memanggil method yang sesuai dengan action yang diminta
if (method_exists($currentController, $action)) {
    // Jika method memerlukan parameter ID
    if ($id !== null && in_array($action, ['editForm', 'hapus'])) {
        $currentController->$action($id);
    } else {
        $currentController->$action();
    }
} else {
    // Action tidak valid, arahkan ke halaman login
    $userController = new UserController();
    $userController->loginForm();
}
?>
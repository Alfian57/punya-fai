<?php
require_once '../config/db.php';
require_once '../classes/User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $user = new User($conn);
    if ($user->login($username, $password)) {
        header("Location: ../views/dashboard.php");
        exit;
    } else {
        header("Location: ../views/login.php?error=Login gagal");
        exit;
    }
}
?>

<?php
session_start();

// Jika sudah login, arahkan ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: views/dashboard.php");
    exit;
} else {
    // Jika belum login, arahkan ke halaman login
    header("Location: views/login.php");
    exit;
}
?>

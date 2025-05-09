<?php
require_once '../config/db.php';
require_once '../classes/User.php';

$user = new User($conn);
$user->logout();

header("Location: ../views/login.php");
exit;

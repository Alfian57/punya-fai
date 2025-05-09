<?php
$host = "1270.0.1";
$user = "root";
$pass = "root";
$dbname = "db_databayi";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
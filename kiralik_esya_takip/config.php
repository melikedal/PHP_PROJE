<?php
$conn = new mysqli("localhost", "root", "", "kiralik360");
if ($conn->connect_error) {
    die("Veritabanı bağlantı hatası: " . $conn->connect_error);
}
?>

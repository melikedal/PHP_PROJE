<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kiralik360";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS urunler (
    id INT AUTO_INCREMENT PRIMARY KEY,
    isim VARCHAR(100) NOT NULL,
    aciklama TEXT,
    fiyat DECIMAL(10,2),
    resim VARCHAR(255),
    durum ENUM('kiralanabilir', 'kirada') DEFAULT 'kiralanabilir'
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";

if ($conn->query($sql) === TRUE) {
    echo "Tablo 'urunler' başarıyla oluşturuldu.";
} else {
    echo "Hata oluştu: " . $conn->error;
}

$conn->close();
?>

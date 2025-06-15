<?php
$servername = "localhost";         
$username = "root";                
$password = "";                    
$database = "kiralik360";          

$baglanti = new mysqli($servername, $username, $password, $database);

if ($baglanti->connect_error) {
    die("Bağlantı hatası: " . $baglanti->connect_error);
}
?>

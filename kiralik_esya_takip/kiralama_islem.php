<?php
session_start();

$baglanti = new mysqli("localhost", "root", "", "kiralik360");
if ($baglanti->connect_error) {
    die("Bağlantı hatası: " . $baglanti->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $urun_id = (int)$_POST['urun_id'];
    $urun_adi = $baglanti->real_escape_string($_POST['urun_adi']);
    $adsoyad = $baglanti->real_escape_string($_POST['adsoyad']);
    $telefon = $baglanti->real_escape_string($_POST['telefon']);
    $adres = $baglanti->real_escape_string($_POST['adres']);
    $gun_sayisi = (int)$_POST['gun_sayisi'];
    $toplam_fiyat = (float)$_POST['toplam_fiyat'];

    $stmt = $baglanti->prepare("INSERT INTO kiralama_kayitlari (urun_id, urun_adi, adsoyad, telefon, adres, gun_sayisi, toplam_fiyat) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssid", $urun_id, $urun_adi, $adsoyad, $telefon, $adres, $gun_sayisi, $toplam_fiyat);

    if ($stmt->execute()) {
        header("Location: tesekkur.php");
        exit;
    } else {
        echo "Hata: " . $baglanti->error;
    }
    $stmt->close();
}

$baglanti->close();
?>



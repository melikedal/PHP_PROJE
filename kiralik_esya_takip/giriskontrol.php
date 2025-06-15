<?php
session_start();
include 'veritabani.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kullanici_adi = $_POST['kullanici_adi'];
    $sifre = $_POST['sifre'];

    $stmt = $baglanti->prepare("SELECT sifre FROM kullanicilar WHERE kullanici_adi = ?");
    $stmt->bind_param("s", $kullanici_adi);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($hashli_sifre);
        $stmt->fetch();

        
        if (password_verify($sifre, $hashli_sifre)) {
            
            $_SESSION['kullanici_adi'] = $kullanici_adi;

            
            header("Location: index.php");
            exit();
        } else {
            echo "Şifre yanlış.";
        }
    } else {
        echo "Kullanıcı bulunamadı.";
    }
} else {
    header("Location: login.php");
    exit();
}


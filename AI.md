Proje Yapısı (Örnek Olarak Hobi Kulübü Seçersek)
Aşağıdaki gibi bir yapı olacak:

🔐 Kullanıcı İşlemleri
Kayıt (kullanici_kayit.php)

Giriş/Çıkış (giris.php / cikis.php)

Şifre hash kullanımı (password_hash, password_verify)

Session ile oturum yönetimi





/ (root)
├── index.php
├── kullanici_kayit.php
├── giris.php
├── cikis.php
├── etkinlik_ekle.php
├── etkinlikler.php
├── etkinlik_duzenle.php
├── etkinlik_sil.php
├── /includes/
│   └── db.php
│   └── auth.php
├── /assets/
│   └── css/
│   └── js/
├── README.md
├── AI.md




Konu önerir misin



Bootstrap kullanılarak:

Responsive giriş/kayıt formu

Sidebar menü (giriş yaptıktan sonra)

Tablo stilleriyle listeleme

Grafik gösterimi için opsiyonel Chart.js (isteğe bağlı JS kütüphanesi)





<?php

 session_start(); 

// veritabani.php'yi dahil edelim (bağlantıyı buraya yazabilirsin)
$baglanti = new mysqli("localhost", "root", "", "kiralik360");
if ($baglanti->connect_error) {
    die("Bağlantı hatası: " . $baglanti->connect_error);
}

$arama = "";
if (isset($_GET['arama'])) {
    $arama = $baglanti->real_escape_string($_GET['arama']);
    $sorgu = "SELECT * FROM urunler WHERE durum = 'kiralanabilir' AND isim LIKE '%$arama%'";
} else {
    $sorgu = "SELECT * FROM urunler WHERE durum = 'kiralanabilir'";
}

$sonuc = $baglanti->query($sorgu);

// Ürünleri getir
//$sorgu = "SELECT * FROM urunler WHERE durum = 'kiralanabilir'";

//$sonuc = $baglanti->query($sorgu);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kiralık Ürünler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>



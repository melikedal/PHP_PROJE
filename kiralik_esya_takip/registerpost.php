<?php
session_start();

$baglanti = new mysqli("localhost", "root", "", "kiralik360");
if ($baglanti->connect_error) {
    die("Bağlantı hatası: " . $baglanti->connect_error);
}

$kullanici_adi = trim($_POST['kullanici_adi']);
$telefon_no = trim($_POST['telefon_no']);
$email = trim($_POST['email']);
$sifre = $_POST['sifre'];
$sifre_tekrar = $_POST['sifre_tekrar'];

if (empty($kullanici_adi) || empty($telefon_no) || empty($email) || empty($sifre) || empty($sifre_tekrar)) {
    $_SESSION['hata'] = "Lütfen tüm alanları doldurun.";
    header("Location: register.php");
    exit();
}

if ($sifre !== $sifre_tekrar) {
    $_SESSION['hata'] = "Şifreler eşleşmiyor.";
    header("Location: register.php");
    exit();
}

$stmt = $baglanti->prepare("SELECT id FROM kullanicilar WHERE kullanici_adi = ?");
$stmt->bind_param("s", $kullanici_adi);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $_SESSION['hata'] = "Bu kullanıcı adı zaten alınmış.";
    $stmt->close();
    header("Location: register.php");
    exit();
}
$stmt->close();

$stmt = $baglanti->prepare("SELECT id FROM kullanicilar WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $_SESSION['hata'] = "Bu e-posta zaten kullanılıyor.";
    $stmt->close();
    header("Location: register.php");
    exit();
}
$stmt->close();

$sifre_hashli = password_hash($sifre, PASSWORD_DEFAULT);

$stmt = $baglanti->prepare("INSERT INTO kullanicilar (kullanici_adi, sifre, telefon_no, email) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $kullanici_adi, $sifre_hashli, $telefon_no, $email);

if ($stmt->execute()) {
    $_SESSION['basarili'] = "Kayıt başarılı! Giriş yapabilirsiniz.";
    header("Location: login.php");
    exit();
} else {
    $_SESSION['hata'] = "Kayıt sırasında bir hata oluştu: " . $stmt->error;
    header("Location: register.php");
    exit();
}

$stmt->close();
$baglanti->close();
?>



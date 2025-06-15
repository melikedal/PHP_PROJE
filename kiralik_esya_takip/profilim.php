<?php
session_start();

if (!isset($_SESSION['kullanici_adi'])) {
    header("Location: login.php");
    exit;
}

$baglanti = new mysqli("localhost", "root", "", "kiralik360");
if ($baglanti->connect_error) {
    die("Bağlantı hatası: " . $baglanti->connect_error);
}

$kullanici_adi = $_SESSION['kullanici_adi'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kullanici_adi_guncel = $baglanti->real_escape_string($_POST['kullanici_adi']);
    $email = $baglanti->real_escape_string($_POST['email']);
    $telefon_no = $baglanti->real_escape_string($_POST['telefon_no']);

    $guncelle = $baglanti->query("UPDATE kullanicilar SET kullanici_adi='$kullanici_adi_guncel', email='$email', telefon_no='$telefon_no' WHERE kullanici_adi='$kullanici_adi'");

    if ($guncelle) {
        $_SESSION['kullanici_adi'] = $kullanici_adi_guncel; // Oturumdaki kullanıcı adını da güncelle
        $mesaj = "Profiliniz başarıyla güncellendi.";
    } else {
        $mesaj = "Güncelleme sırasında hata oluştu: " . $baglanti->error;
    }
}

$result = $baglanti->query("SELECT kullanici_adi, email, telefon_no FROM kullanicilar WHERE kullanici_adi='$kullanici_adi'");
$kullanici = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Profilim</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Profilim</h2>

    <?php if (isset($mesaj)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($mesaj) ?></div>
    <?php endif; ?>

    <form method="POST" action="profilim.php">
        <div class="mb-3">
            <label for="kullanici_adi" class="form-label">Kullanıcı Adı</label>
            <input type="text" class="form-control" id="kullanici_adi" name="kullanici_adi" required value="<?= htmlspecialchars($kullanici['kullanici_adi']) ?>">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-posta</label>
            <input type="email" class="form-control" id="email" name="email" required value="<?= htmlspecialchars($kullanici['email']) ?>">
        </div>

        <div class="mb-3">
            <label for="telefon_no" class="form-label">Telefon Numarası</label>
            <input type="text" class="form-control" id="telefon_no" name="telefon_no" required value="<?= htmlspecialchars($kullanici['telefon_no']) ?>">
        </div>

        <button type="submit" class="btn btn-primary">Güncelle</button>
    </form>
    <a href="hesabim.php" class="btn btn-secondary mt-3">Geri</a>
</div>
</body>
</html>


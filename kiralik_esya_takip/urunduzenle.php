<?php
session_start();

if (!isset($_SESSION['kullanici_adi'])) {
    header("Location: login.php");
    exit();
}

$baglanti = new mysqli("localhost", "root", "", "kiralik360");
if ($baglanti->connect_error) {
    die("Bağlantı hatası: " . $baglanti->connect_error);
}

$kullanici = $_SESSION['kullanici_adi'];

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Geçersiz ürün ID.");
}
$urun_id = (int)$_GET['id'];

$sql = "SELECT * FROM urunler WHERE id = ? AND ekleyen = ?";
$stmt = $baglanti->prepare($sql);
$stmt->bind_param("is", $urun_id, $kullanici);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Bu ürünü düzenleme yetkiniz yok veya ürün bulunamadı.");
}

$urun = $result->fetch_assoc();
$stmt->close();

$hata = "";
$basarili = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $isim = trim($_POST['isim']);
    $aciklama = trim($_POST['aciklama']);
    $fiyat = trim($_POST['fiyat']);
    $durum = trim($_POST['durum']);

    if ($isim === "" || $fiyat === "" || $durum === "") {
        $hata = "Lütfen zorunlu alanları doldurun (İsim, Fiyat, Durum).";
    } elseif (!is_numeric($fiyat) || $fiyat < 0) {
        $hata = "Fiyat pozitif bir sayı olmalıdır.";
    } else {
        
        $guncelle = $baglanti->prepare("UPDATE urunler SET isim = ?, aciklama = ?, fiyat = ?, durum = ? WHERE id = ? AND ekleyen = ?");
        $guncelle->bind_param("ssdiss", $isim, $aciklama, $fiyat, $durum, $urun_id, $kullanici);

        if ($guncelle->execute()) {
            $basarili = "Ürün başarıyla güncellendi.";
            $urun['isim'] = $isim;
            $urun['aciklama'] = $aciklama;
            $urun['fiyat'] = $fiyat;
            $urun['durum'] = $durum;
        } else {
            $hata = "Güncelleme sırasında bir hata oluştu.";
        }
        $guncelle->close();
    }
}

$baglanti->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ürün Düzenle - Kiralık360</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="profilim.php">Kiralık360</a>
        <div class="ms-auto">
            <a href="hesabim.php" class="btn btn-light">Geri Dön</a>
        </div>
    </div>
</nav>

<div class="container mt-5" style="max-width: 600px;">
    <h2 class="mb-4">Ürün Düzenle</h2>

    <?php if ($hata): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($hata) ?></div>
    <?php endif; ?>

    <?php if ($basarili): ?>
        <div class="alert alert-success"><?= htmlspecialchars($basarili) ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="isim" class="form-label">Ürün İsmi *</label>
            <input type="text" id="isim" name="isim" class="form-control" required value="<?= htmlspecialchars($urun['isim']) ?>">
        </div>

        <div class="mb-3">
            <label for="aciklama" class="form-label">Açıklama</label>
            <textarea id="aciklama" name="aciklama" class="form-control" rows="4"><?= htmlspecialchars($urun['aciklama']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="fiyat" class="form-label">Fiyat (₺) *</label>
            <input type="number" step="0.01" id="fiyat" name="fiyat" class="form-control" required value="<?= htmlspecialchars($urun['fiyat']) ?>">
        </div>

        <div class="mb-3">
            <label for="durum" class="form-label">Durum *</label>
            <select id="durum" name="durum" class="form-select" required>
                <option value="Temiz" <?= $urun['durum'] === 'Temiz' ? 'selected' : '' ?>>Temiz</option>
                <option value="Kullanılmış" <?= $urun['durum'] === 'Kullanılmış' ? 'selected' : '' ?>>Kullanılmış</option>
                <option value="Hasarlı" <?= $urun['durum'] === 'Hasarlı' ? 'selected' : '' ?>>Hasarlı</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Güncelle</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

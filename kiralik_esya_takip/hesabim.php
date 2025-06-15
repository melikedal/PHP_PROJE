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

$sql = "SELECT * FROM urunler WHERE ekleyen = ?";
$stmt = $baglanti->prepare($sql);
$stmt->bind_param("s", $kullanici);
$stmt->execute();
$sonuc = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Hesabım - Kiralık360</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Kiralık360</a>
        <div class="ms-auto d-flex align-items-center">
            <span class="text-white me-3">👋 Hoşgeldin, <?= htmlspecialchars($kullanici) ?></span>
            <a href="ekle.php" class="btn btn-success me-2">➕ Ürün Ekle</a>
            <a href="profilim.php" class="btn btn-light me-2">👤 Profilim</a>
            <a href="logout.php" class="btn btn-danger">Çıkış Yap</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="mb-4">Paylaştığın Kiralık Ürünler</h2>

    <?php if ($sonuc->num_rows > 0): ?>
        <div class="row g-4">
            <?php while ($urun = $sonuc->fetch_assoc()): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <?php if (!empty($urun['resim'])): ?>
                            <img src="resimler/<?= htmlspecialchars($urun['resim']) ?>" class="card-img-top" alt="<?= htmlspecialchars($urun['isim']) ?>">
                        <?php else: ?>
                            <img src="resimler/placeholder.png" class="card-img-top" alt="Ürün Resmi">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($urun['isim']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($urun['aciklama']) ?></p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Fiyat:</strong> ₺<?= number_format($urun['fiyat'], 2) ?><br>
                                <strong>Durum:</strong> <?= htmlspecialchars($urun['durum']) ?>
                            </div>
                            <div>
                                <a href="urunduzenle.php?id=<?= $urun['id'] ?>" class="btn btn-sm btn-primary me-2">Düzenle</a>
                                <a href="urunsil.php?id=<?= $urun['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bu ürünü silmek istediğinize emin misiniz?');">Sil</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Henüz hiç ürün paylaşmadınız.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$baglanti->close();
?>






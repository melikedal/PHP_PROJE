<?php
session_start();
$baglanti = new mysqli("localhost", "root", "", "kiralik360");
if ($baglanti->connect_error) die("Bağlantı hatası: " . $baglanti->connect_error);

if (!isset($_GET['urun_id'])) {
    echo "Ürün ID belirtilmedi.";
    exit;
}

$urun_id = (int)$_GET['urun_id'];

$sorgu = $baglanti->query("
SELECT 
    urunler.*, 
    COALESCE(kullanicilar.kullanici_adi, urunler.ekleyen) AS ekleyen,
    COALESCE(kullanicilar.telefon_no, urunler.ekleyen_telefon) AS ekleyen_telefon,
    COALESCE(kullanicilar.email, urunler.ekleyen_mail) AS ekleyen_email,
    COALESCE(kullanicilar.kullanici_adi, urunler.ekleyen) AS ekleyen_kullanici
FROM urunler
LEFT JOIN kullanicilar ON urunler.ekleyen = kullanicilar.kullanici_adi
WHERE urunler.id = $urun_id
");

if ($sorgu->num_rows === 0) {
    echo "Ürün bulunamadı.";
    exit;
}

$urun = $sorgu->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($urun['isim']) ?> - Kirala</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function fiyatHesapla() {
            const fiyat = <?= $urun['fiyat'] ?>;
            const gun = document.getElementById('gun').value;
            const toplam = fiyat * gun;
            document.getElementById('toplamFiyat').innerText = "Toplam Fiyat: ₺" + toplam.toFixed(2);
        }
    </script>
</head>
<body class="container mt-5">

    <h2><?= htmlspecialchars($urun['isim']) ?> Kiralama Bilgileri</h2>
    <p><strong>Açıklama:</strong> <?= htmlspecialchars($urun['aciklama']) ?></p>
    <p><strong>Günlük Fiyat:</strong> ₺<?= number_format($urun['fiyat'], 2) ?></p>

    <hr>

    <h4>İlan Sahibi Bilgileri</h4>
    <ul>
       
        <li><strong>Kullanıcı Adı:</strong> <?= htmlspecialchars($urun['ekleyen_kullanici']) ?></li>
        <li><strong>Telefon:</strong> <?= htmlspecialchars($urun['ekleyen_telefon']) ?></li>
        <li><strong>Email:</strong> <?= htmlspecialchars($urun['ekleyen_email']) ?></li>
    </ul>

    <hr>

    <h4>Kirala</h4>
    <form action="kiralama_islem.php" method="POST" class="mb-4">
        <input type="hidden" name="urun_id" value="<?= $urun_id ?>">

        <div class="mb-3">
            <label for="gun" class="form-label">Kaç Gün Kiralayacaksınız?</label>
            <input type="number" name="gun" id="gun" class="form-control" value="1" min="1" onchange="fiyatHesapla()" required>
        </div>

        <div class="mb-3">
            <label for="adsoyad" class="form-label">Ad Soyad</label>
            <input type="text" name="adsoyad" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="telefon" class="form-label">Telefon</label>
            <input type="text" name="telefon" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="adres" class="form-label">Adres</label>
            <textarea name="adres" class="form-control" rows="3" required></textarea>
        </div>

        <p id="toplamFiyat">Toplam Fiyat: ₺<?= number_format($urun['fiyat'], 2) ?></p>

        <button type="submit" class="btn btn-primary">Kirala</button>
    </form>

    <hr>

    </form>

</body>
</html>









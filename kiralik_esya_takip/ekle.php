<?php
session_start();

$baglanti = new mysqli("localhost", "root", "", "kiralik360");
if ($baglanti->connect_error) {
    die("Bağlantı hatası: " . $baglanti->connect_error);
}

$mesaj = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isim = $baglanti->real_escape_string($_POST['isim']);
    $aciklama = $baglanti->real_escape_string($_POST['aciklama']);
    $fiyat = (float)$_POST['fiyat'];
    $ekleyen = $baglanti->real_escape_string($_SESSION['kullanici_adi']);

    $resim_adi = "";
    if (isset($_FILES['resim']) && $_FILES['resim']['error'] === UPLOAD_ERR_OK) {
        $hedef_klasor = "uploads/";
        if (!file_exists($hedef_klasor)) {
            mkdir($hedef_klasor, 0777, true);
        }

        $uzanti = pathinfo($_FILES['resim']['name'], PATHINFO_EXTENSION);
        $resim_adi = uniqid("urun_") . "." . $uzanti;
        $yukleme_yolu = $hedef_klasor . $resim_adi;

        move_uploaded_file($_FILES['resim']['tmp_name'], $yukleme_yolu);
    }

    $sql = "INSERT INTO urunler (isim, aciklama, fiyat, durum, ekleyen, resim)
            VALUES ('$isim', '$aciklama', $fiyat, 'kiralanabilir', '$ekleyen', '$resim_adi')";

    if ($baglanti->query($sql) === TRUE) {
        $mesaj = '<div class="alert alert-success">✅ Eşya başarıyla eklendi.</div>';
    } else {
        $mesaj = '<div class="alert alert-danger">❌ Hata: ' . $baglanti->error . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ürün Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Yeni Ürün Ekle</h2>

    <?= $mesaj ?>

    <form method="POST" action="ekle.php" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
        <div class="mb-3">
            <label for="isim" class="form-label">Ürün İsmi</label>
            <input type="text" class="form-control" id="isim" name="isim" required>
        </div>

        <div class="mb-3">
            <label for="aciklama" class="form-label">Açıklama</label>
            <textarea class="form-control" id="aciklama" name="aciklama" required></textarea>
        </div>

        <div class="mb-3">
            <label for="fiyat" class="form-label">Günlük Fiyat (₺)</label>
            <input type="number" step="0.01" name="fiyat" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="resim" class="form-label">Ürün Fotoğrafı</label>
            <input type="file" class="form-control" id="resim" name="resim" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Kaydet</button>
        <a href="hesabim.php" class="btn btn-secondary">Geri Dön</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $baglanti->close(); ?>




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


?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kiralık Ürünler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

 <style>
    .logo-kapsayici {
      position: absolute;
      top: 10px;
      left: 10px;
      width: 150px;
      height: auto;
      z-index: 1000;
    }

    .logo-kapsayici video {
      width: 100%;
      height: auto;
      border-radius: 8px;
    }
  </style>
</head>
<body>

  <div class="logo-kapsayici">
    <video autoplay muted loop>
      <source src="resimler/KİRALIK 360.mp4" type="video/mp4">
      Tarayıcınız video etiketini desteklemiyor.
    </video>
  </div>

<style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .giriscubugu {
            background-color: #f8f8f8;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .giriscubugu .logo {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .giriscubugu .login-btn {
            text-decoration: none;
            padding: 8px 16px;
            background-color: rgb(153, 59, 230);
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .giriscubugu .login-btn:hover {
            background-color:rgb(203, 203, 203);
        }
    </style>
</head>



<body>



    
<!-- Arama çubuğu -->
<div class="container mt-5 pt-5">
    <h2 class="text-center mb-4">Kiralık Ürünler</h2>

    <form method="GET" action="kiralik.php" class="mb-4">
        <div class="input-group">
            <input type="text" name="arama" class="form-control" placeholder="Ürün ara..." value="<?= htmlspecialchars($arama) ?>">
            <button class="btn btn-outline-secondary" type="submit">Ara</button>
        </div>



<?php if (isset($_SESSION['kullanici_adi'])): ?>
    <div>
        <span style="margin-right: 10px; font-weight: bold;">
            👤 <?= htmlspecialchars($_SESSION['kullanici_adi']) ?>
        </span>
        <a href="hesabim.php" class="login-btn">Hesabım</a>
        <a href="logout.php" class="login-btn">Çıkış Yap</a>
    </div>
<?php else: ?>
    <a href="login.php" class="login-btn">Giriş Yap</a>
<?php endif; ?>




    <div class="container mt-4">
        <h2>Kiralık Ürünler</h2>
        <div class="row">
            <?php while($urun = $sonuc->fetch_assoc()):?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <?php if (!empty($urun['resim'])): ?>
                           <img src="resimler/<?= htmlspecialchars($urun['resim']) ?>" class="card-img-top" alt="<?= htmlspecialchars($urun['isim']) ?>">


                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($urun['isim']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($urun['aciklama']) ?></p>
                            <p><strong>Fiyat:</strong> ₺<?= number_format($urun['fiyat'], 2) ?> /günlük</p>
                            <a href="kiralabuton.php?urun_id=<?= $urun['id'] ?>" class="btn btn-primary">Kirala</a>

                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>

<?php $baglanti->close(); ?>




<?php
session_start();
if (isset($_SESSION['kullanici_adi'])) {
    header("Location: anasayfa.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kiralık360 | Giriş Yap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0px 0px 20px rgba(0,0,0,0.1);
        }
        .login-title {
            margin-bottom: 20px;
            font-weight: bold;
            color: #198754;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2 class="login-title">Kiralık360 Giriş</h2>

        <form action="login.php" method="post">
            <div class="mb-3">
                <label for="kullanici_adi" class="form-label">Kullanıcı Adı</label>
                <input type="text" name="kullanici_adi" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="sifre" class="form-label">Şifre</label>
                <input type="password" name="sifre" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Giriş Yap</button>
        </form>

        <hr>
        <p class="text-center">Henüz hesabın yok mu?</p>
        <a href="register.php" class="btn btn-outline-secondary w-100">Hesap Oluştur</a>
    </div>

</body>
</html>

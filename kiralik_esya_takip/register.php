<?php
session_start();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kayıt Ol</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ACB6E5, #74ebd5);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            width: 350px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 6px;
            font-weight: bold;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            margin-top: 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .login {
            margin-top: 20px;
        }

        .login a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }

        .login a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Kayıt Ol</h2>

    <?php
    if (isset($_SESSION['hata'])) {
        echo "<div class='message error'>" . $_SESSION['hata'] . "</div>";
        unset($_SESSION['hata']);
    }
    if (isset($_SESSION['basarili'])) {
        echo "<div class='message success'>" . $_SESSION['basarili'] . "</div>";
        unset($_SESSION['basarili']);
    }
    ?>

    <form action="registerpost.php" method="post">
        <input type="text" name="kullanici_adi" placeholder="Kullanıcı Adı" required>
        <input type="text" name="telefon_no" placeholder="Telefon Numarası" required>
        <input type="email" name="email" placeholder="E-posta" required>
        <input type="password" name="sifre" placeholder="Şifre" required>
        <input type="password" name="sifre_tekrar" placeholder="Şifre Tekrar" required>
        <input type="submit" value="Hesap Oluştur">
    </form>

    <div class="login">
        <p>Zaten hesabınız var mı?</p>
        <a href="login.php">Giriş Yap</a>
    </div>
</div>

</body>
</html>




<?php
session_start();
session_destroy(); // Oturumu sonlandır
header("Location:index.php"); // Kiralık sayfasına yönlendir
exit();
?>


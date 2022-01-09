<?php
//Config dosyası dahil ediliyor.
require_once('../config/db.php');
//session_destroy();
$sayfa = $_SERVER['REQUEST_URI'];
$sayfa_adi = explode('/',$sayfa);
$hangi_sayfa = end($sayfa_adi);
if(!isset($_SESSION['user']['type']) && $hangi_sayfa != "kullanici_girisi.php"){
    header('location:kullanici_girisi.php');
    exit();
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title></title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Eticaret</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Kullanıcı
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="kullanici_ekle.php">Kullanıcı Ekle</a></li>
                            <li><a class="dropdown-item" href="kullanici_listesi.php">Kullanıcı Düzenle</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Ürünler
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="urun_ekle.php">Ürün Ekle</a></li>
                            <li><a class="dropdown-item" href="urun_listesi.php">Ürün Düzenle</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
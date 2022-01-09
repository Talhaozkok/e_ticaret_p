<!doctype html>
<html lang="en">
<?php require_once './config/db.php';

//POST varmı kontrol ediyorum
if (isset($_POST['k_adi'])) {
    //Posttangelen verileri değişkene aktarıyorum
    $k_adi = $_POST['k_adi'];
    $sifre = md5($_POST['sifre']); // şifreyi md5 yöntemiyle hashliyorum
    $type = $_POST['type']; // kullanıcı mı admin mi type göre veritabanına ekliyorum.

    // Kullanıcı kayıtlı mı kontrol ediyorum
    $userKontrol  = $db->query('SELECT * FROM tbl_kullanici WHERE kullanici_adi = "' . $k_adi . '" AND sifre = "' . $sifre . '" ')->fetch();

    if (is_array($userKontrol)) {
        // Kullanıcı vardır
        $mesaj = '<div class="alert alert-success" role="alert">
        Giriş Başarılı
       </div>';

        if ($userKontrol['type'] === 1) {
            // admin kullanıcısı
            header('location: admin/index.php');
            $_SESSION['user'] = [
                'id' => $userKontrol['id'],
                'adi' => $userKontrol['kullanici_adi']
            ];
        } else {
            // Normal kullanıcı 
            header('location: /etic_odev/index.php');
            $_SESSION['user'] = [
                'id' => $userKontrol['id'],
                'adi' => $userKontrol['kullanici_adi']
            ];
        }
    } else {
        // Kullanıcı yoktur.
        $mesaj = '<div class="alert alert-danger" role="alert">
        Giriş hatalı lütfen tekrar deneyiniz
      </div>';
    }
}
?>
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
            <a class="navbar-brand" href="./index.php">E Ticaret</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./index.php">Anasayfa</a>
                    </li>
                    <?php
                        if(isset($_SESSION['user'])){ ?>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="./index.php?cikis_yap=1">Çıkış Yap</a>
                            </li>
                     <?php   }else{ ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="admin/kullanici_girisi.php">Giriş Yap</a>
                        </li>
                     <?php   }
                    ?>
                    
                </ul>
                <!-- <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Ürün Ara" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Ara</button>
                </form> -->
            </div>
        </div>
    </nav>
<div class="card">
    <?php
    if (isset($mesaj)) {
        echo $mesaj;
    }
    ?>
    <div class="card-body d-flex justify-content-center">

        <form action="" method="POST" style="width:50%;">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" style="width : 150px;">Kullanıcı Adı</span>
                <input type="text" name="k_adi" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" style="width : 150px;">Şifre</span>
                <input type="password" name="sifre" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
            </div>

            <div class="input-group mb-3 justify-content-end">
                <button class="btn btn-success" type="submit">Giriş Yap</button>
            </div>
        </form>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>

</html>
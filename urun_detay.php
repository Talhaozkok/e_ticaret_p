<!doctype html>
<html lang="en">
<?php require_once './config/db.php' ?>

<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
// Kullanıcı var mı diye bakıyorum yoksa login sayfasına geri gitsin
if (!isset($_SESSION['user'])) {
    header('location: admin/kullanici_girisi.php');
}

$id = $_SESSION['user']['id'];

$sepetMiktari = $db->query('SELECT * FROM tbl_sepet WHERE kullanici_id = ' . $id . ' ')->fetchAll();

if (isset($_GET['sepet'])) {
    $sepet = $db->query('SELECT * FROM tbl_sepet WHERE kullanici_id = ' . $id . ' AND urun_id = ' . $_GET['sepet'] . ' ')->fetchAll();

    $urun = $db->query('SELECT * FROM tbl_urunler WHERE id = ' . $_GET['sepet'] . ' ')->fetch();

    if (count($sepet) === 0) {
        $db->prepare('INSERT INTO tbl_sepet SET 
        urun_id =?,
        urun_miktari=?,
        urun_adi =?,
        urun_fiyati=?,
        kullanici_id=?
            ')->execute([
            $_GET['sepet'],
            1,
            $urun['urun_adi'],
            $urun['urun_fiyati'],
            $id
        ]);
    } else {
        $db->prepare('UPDATE  tbl_sepet SET urun_miktari = urun_miktari + 1 WHERE id = ?  ')->execute([$sepet[0]['urun_id']]);
    }

    $mesaj = '<div class="alert alert-success"> Ürün sepete başarıyla eklendi</div>';
}


$urun_bilgisi = $db->query('SELECT * FROM tbl_urunler WHERE id = ' . $_GET['urun_id'] . ' ')->fetch();
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
            <a class="navbar-brand" href="index.php">E Ticaret</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Dropdown
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled">Disabled</a>
                        </li> -->
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Ürün Ara" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Ara</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="d-flex justify-content-end" style="margin-right:50px">
        <a href="sepet.php"> Sepet <?php echo count($sepetMiktari) ?></a>
    </div>


    <!-- Ürünler -->

    <div class="container mt-5">



        <div class="d-flex justify-content-center w-100">
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        Ürün Barkod: <?php echo md5($urun_bilgisi['id']) ?>
                    </div>
                    <div class="card-body">
                        <img height="300" src="images/<?php echo $urun_bilgisi['urun_resmi'] ?>" class="card-img-top" alt="...">
                        <br>
                        <br>
                        <h5 class="card-title">Ürün Adı: <?php echo $urun_bilgisi['urun_adi'] ?></h5>
                        <p class="card-text"><b>Ürün Açıklama</b>: <?php echo $urun_bilgisi['urun_aciklamasi'] ?></p>
                        <p><b>Ürün Fiyati</b>: <?php echo $urun_bilgisi['urun_fiyati'] ?>₺</p>
                        <div class="d-flex justify-content-end">
                            <a href="urun_detay.php?sepet=<?php echo $urun_bilgisi['id'] ?>&user_id=<?php echo $id ?>&urun_id=<?php echo $_GET['urun_id'] ?>" class="btn btn-primary">Sepete Ekle</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <br>

        <div class="row">
           <?php 
           $detay_resim = $db->query('SELECT * FROM urun_detay_resim WHERE urun_id  = '.$_GET['urun_id'].'')->fetchAll();
           foreach ($detay_resim as $key => $value) {
            ?>
             <div class="card col-lg-4" >
                <img src="./images/<?=$value['img']?>" class="card-img-top" alt="...">
                <div class="card-body">
                </div>
                </div>
            <?php 
           }
           ?>
        </div>




    </div>





    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>

</html>
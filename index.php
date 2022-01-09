<!doctype html>
<html lang="en">
<?php require_once './config/db.php' ?>

<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
// Kullanıcı var mı diye bakıyorum yoksa login sayfasına geri gitsin
// if (!isset($_SESSION['user'])) {
//     header('location: admin/kullanici_girisi.php');
// }

if (isset($_SESSION['user'])) {
$id = $_SESSION['user']['id'];
$sepetMiktari = $db->query('SELECT * FROM tbl_sepet WHERE kullanici_id = ' . $id . ' ')->fetchAll();
}

if(isset($_GET['cikis_yap'])){
    session_destroy();
    header('location: kullanici_girisi.php');
}

if (isset($_GET['sepet']) ) {
    if(isset($_SESSION['user'])){
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
    }else{
        header('location: /kullanici_girisi.php');
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
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./index.php?kategori=1">Kozmetik</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./index.php?kategori=2">Elektronik</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./index.php?kategori=3">Giyim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./index.php?kategori=4">Aksesuar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./index.php?kategori=5">Kırtasiye</a>
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
    <?php
    $where = " WHERE 1=1";
    if(isset($_GET['kategori'])){
        $where .= " AND kategori = ".$_GET['kategori'];
    }

    $urunler = $db->query('SELECT * FROM tbl_urunler'.$where)->fetchAll();
    
    ?>
    <?php
        if(isset($_SESSION['user'])){ ?>
            <div class="d-flex justify-content-end" style="margin-right:50px">
                <a href="sepet.php"> Sepet <?php echo count($sepetMiktari) ?></a>
            </div>
      <?php  }
    ?>

    <!-- Ürünler -->
    <?php echo @$mesaj ;
    ?>

    <div class="container mt-5">
        <div class="row">
            <?php
            // Ürünleri veritabanından tbl_urunler tablosundan aldım 
            // pdo yöntemini kullandım 


            foreach ($urunler as $key => $item) { ?>
                <div class="col-lg-3 mt-5">
                    <div class="card" style="width: 18rem;">
                        <img src="./images/<?php echo $item['urun_resmi'] ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Ürün Adı: <?php echo $item['urun_adi'] ?></h5>
                            <p class="card-text">Açıklama: <?php echo $item['urun_aciklamasi'] ?></p>
                            <p>Urun Fiyatı: <?php echo $item['urun_fiyati'] ?></p>
                            <a href="index.php?sepet=<?php echo $item['id'] ?>" class="btn btn-primary">Sepete Ekle</a>

                            <a href="urun_detay.php?urun_id=<?php echo $item['id'] ?>" class="btn btn-primary">Detaya git</a>
                        </div>
                    </div>
                </div>
            <?php  } ?>



        </div>




    </div>





    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>

</html>
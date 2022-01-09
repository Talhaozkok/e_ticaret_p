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

if(isset($_GET['sepetten_cikar'])) {
    $sql = 'DELETE from tbl_sepet WHERE id ='.$_GET['sepetten_cikar'].' ';
    $db->exec($sql);

    header('location: '.$_SERVER['HTTP_REFERER'].' ');
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
        Sepet <?php echo count($sepetMiktari) ?>
    </div>


    <!-- Ürünler -->

    <div class="container mt-5">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Ürün Adı</th>
                    <th scope="col">Ürün Fiyatı</th>
                    <th scope="col">Ürün Mikarı</th>
                    <th scope="col">İşlemler</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                ?>

                <?php
                foreach ($sepetMiktari as $key => $value) {
                ?>
                    <tr>
                        <th scope="row">1</th>
                        <td><?php echo $value['urun_adi'] ?></td>
                        <td><?php echo $value['urun_fiyati'] ?></td>
                        <td><?php echo $value['urun_miktari'] ?></td>
                        <td><a href="sepet.php?sepetten_cikar=<?php echo $value['id'] ?>"><button class="btn btn-danger">Sepetten Çıkar</button></a></td>

                        <?php $total += $value['urun_fiyati'] * $value['urun_miktari'] ?>
                    </tr>
                <?php
                }

                ?>

            </tbody>
        </table>



        <div class="alert alert-success">Toplam <?php echo  number_format($total, 2, ',', '.')  ?>₺</div>

        <div>
            <br>
            <a href="odeme_ekrani.php" class="alert alert-primary">Alışverişi Tamamla </a>
        </div>


    </div>





    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>

</html>
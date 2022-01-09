<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
//header dahil ediliyor
require_once('header.php');

//POST varmı kontrol ediyorum
if (isset($_POST['id'])) {
    //Posttangelen verileri değişkene aktarıyorum
    $id = $_POST['id'];

    $sorgu = $db->prepare('DELETE FROM tbl_urunler WHERE id = ' . $id);
    $sorgu->execute();

    if ($sorgu) {
        $mesaj = '<div class="alert alert-success" role="alert">
        Ürün Başarıyla Silindi
      </div>';
    } else {
        $mesaj = '<div class="alert alert-danger" role="alert">
        Ürün Silme Sırasında Hata Oluştu.
      </div>';
    }
}
?>
<div class="card">
    <div class="card-header">
        Ürün Listesi
    </div>
    <div class="card-body d-flex justify-content-center row">
        <?php
        if (isset($mesaj)) {
            echo $mesaj;
        }
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Ürün Resmi</th>
                    <th scope="col">Ürün Adı</th>
                    <th scope="col">Ürün Fiyatı</th>
                    <th scope="col">Ürün Açıklaması</th>
                    <th scope="col">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // kullanıcı listesi alınıyor
                $sorgu = $db->query('SELECT * FROM tbl_urunler')->fetchAll();
                //kullanıcı listesi foreach yönetimiyle döndürülüyor.
                foreach ($sorgu as $key => $item) { ?>
                    <tr>
                        <th scope="row"><?= ++$key ?></th>
                        <td>
                            <img width="100" src="../images/<?= $item['urun_resmi'] ?>" alt="">
                        </td>
                        <td>
                            <?= $item['urun_adi'] ?>
                        </td>
                        <td>
                            <?= $item['urun_fiyati'] ?>
                        </td>
                        <td>
                            <?= $item['urun_aciklamasi'] ?>
                        </td>
                        <td>
                            <!-- Kullanıcı silmek için form kullanıp hide inputa kullanıcı idsi aktarılıyor -->
                            <form action="" method="POST" style="float:left;">
                                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                <button type="submit" class="btn btn-danger">Sil</button>
                            </form>
                            <a class="btn btn-primary" href="urun_duzenle.php?id=<?= $item['id'] ?>">Düzenle</a>
                        </td>
                    </tr>
                <?php   }
                ?>

            </tbody>
        </table>
    </div>
</div>
<?php
//footer dahil ediliyor
require_once('footer.php');
?>
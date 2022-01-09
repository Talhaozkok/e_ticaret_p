<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
//header dahil ediliyor
require_once('header.php');

//GET ten gelen kullanıcı idsini değişkene aktarıp kullanıcı PDO yöntemiyle sorguluyorum.
$urun_id = $_GET['id'];
$u_sorgu = $db->query('SELECT * FROM tbl_urunler WHERE id = ' . $urun_id)->fetchAll()[0];

//POST varmı kontrol ediyorum
if (isset($_POST['urun_adi'])) {
    //Posttangelen verileri değişkene aktarıyorum
    $urun_adi = $_POST['urun_adi'];
    $urun_fiyati = $_POST['urun_fiyati'];
    $kategori = $_POST['kategori'];
    $aciklama = $_POST['aciklama'];

    //Ürün resmi varsa images dosyasına taşıyorum yoksa eski resmi kullanacak.
    if ($_FILES['urun_resmi']['size'] > 0) {
        //resim ismini değişkene aktarıyorum
        $resim_adi = $_FILES["urun_resmi"]["name"];
        $resim_yolu = "../images/";
        move_uploaded_file($_FILES["urun_resmi"]["tmp_name"], $resim_yolu . $resim_adi);
    } else {
        $resim_adi = $u_sorgu['urun_resmi'];
    }


    //PDO yöntemiyle ürün kaydı yapılıyor.
    $sorgu = $db->prepare('UPDATE tbl_urunler SET urun_adi = "' . $urun_adi . '"  , urun_resmi = "' . $resim_adi . '", urun_aciklamasi = "' . $aciklama . '", urun_fiyati = "' . $urun_fiyati . '", kategori = "' . $kategori . '" WHERE id = ' . $urun_id);
    $sorgu->execute();

    //Sorgu başarılımı başarısız mı kontrölü yapılıyor
    if ($sorgu) {
        $mesaj = '<div class="alert alert-success" role="alert">
        Ürün Güncelleme Başarılı.
      </div>';
    } else {
        $mesaj = '<div class="alert alert-danger" role="alert">
        Ürün Güncelleme Sırasında Hata Oluştu.
      </div>';
    }
}

$u_sorgu = $db->query('SELECT * FROM tbl_urunler WHERE id = ' . $urun_id)->fetchAll()[0];
?>
<div class="card">
    <div class="card-header">
        Ürün Düzenle
    </div>
    <div class="card-body d-flex justify-content-center row">
        <?php
        //posttan dönen mesaj varsa ekrana basılıyor
        if (isset($mesaj)) {
            echo $mesaj;
        }
        ?>
        <form action="" method="POST" style="width:50%;" enctype="multipart/form-data">
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupSelect01" style="width: 150px;">Kategori</label>
                <select class="form-select" name="kategori" id="inputGroupSelect01">
                    <option <?php if ($u_sorgu == 1) {
                                echo "selected";
                            } ?> value="1">Erkek</option>
                    <option <?php if ($u_sorgu == 2) {
                                echo "selected";
                            } ?> value="2">Kadın</option>
                </select>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" style="width : 150px;">Ürün Adı</span>
                <input type="text" name="urun_adi" class="form-control" value="<?= $u_sorgu['urun_adi'] ?>" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" style="width : 150px;">Fiyatı</span>
                <input type="text" name="urun_fiyati" value="<?= $u_sorgu['urun_fiyati'] ?>" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" style="width:150px;">Ürün Açıklaması</span>
                <textarea class="form-control" name="aciklama" row="5" aria-label="With textarea"><?= $u_sorgu['urun_aciklamasi'] ?> </textarea>
            </div>
            <div class="input-group mb-3">
                <img width="200" src="../images/<?= $u_sorgu['urun_resmi'] ?>" alt="">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" style="width : 150px;">Ürün Resmi</span>
                <input type="file" name="urun_resmi" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
            </div>

            <div class="input-group mb-3 justify-content-end">
                <button class="btn btn-success" type="submit">Güncelle</button>
            </div>
        </form>
    </div>
</div>
<?php
//footer dahil ediliyor
require_once('footer.php');
?>
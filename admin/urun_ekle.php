<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
//header dahil ediliyor
require_once('header.php');

//POST varmı kontrol ediyorum
if (isset($_POST['urun_adi'])) {
    //Posttangelen verileri değişkene aktarıyorum
    $urun_adi = $_POST['urun_adi'];
    $urun_fiyati = $_POST['urun_fiyati'];
    $kategori = $_POST['kategori'];
    $aciklama = $_POST['aciklama'];

    //Ürün resmini images dosyasına taşıyorum.
    if ($_FILES["urun_resmi"]) {

        //resim ismini değişkene aktarıyorum
      
        $resim_adi = $_FILES["urun_resmi"]["name"][0];
        $resim_yolu = "../images/";
        move_uploaded_file($_FILES["urun_resmi"]["tmp_name"][0], $resim_yolu . $resim_adi);
       
    }

    //PDO yöntemiyle ürün kaydı yapılıyor.
    $sorgu = $db->prepare('INSERT INTO tbl_urunler (urun_adi , urun_resmi, urun_aciklamasi, urun_fiyati, kategori) VALUES ("' . $urun_adi . '" , "' . $resim_adi . '" , "' . $aciklama . '" , "' . $urun_fiyati . '" , "' . $kategori . '")');
    $sorgu->execute();
    $counter = 0;

    $urun_id = $db->lastInsertId();

    foreach ($_FILES["urun_resmi"]['name'] as $key => $value) {
           //resim ismini değişkene aktarıyorum
           $resim_adi = $_FILES["urun_resmi"]["name"][$counter];
           move_uploaded_file($_FILES["urun_resmi"]["tmp_name"][$counter], $resim_yolu . $resim_adi); 

           $db->prepare('INSERT INTO urun_detay_resim SET img = ?, urun_id= ?')->execute(array(
               $resim_adi,
               $urun_id
           ));
           $counter++;
           
        
    }

    //Sorgu başarılımı başarısız mı kontrölü yapılıyor
    if ($sorgu) {
        $mesaj = '<div class="alert alert-success" role="alert">
        Ürün Ekleme Başarılı.
      </div>';
    } else {
        $mesaj = '<div class="alert alert-danger" role="alert">
        Ürün Ekleme Sırasında Hata Oluştu.
      </div>';
    }
}
?>
<div class="card">
    <div class="card-header">
        Ürün Ekle
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
                    <option value="1">Kozmetik</option>
                    <option value="2">Elektronik</option>
                    <option value="3">Giyim</option>
                    <option value="4">Aksesuar</option>
                    <option value="5">Kırtasiye</option>
                </select>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" style="width : 150px;">Ürün Adı</span>
                <input type="text" name="urun_adi" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" style="width : 150px;">Fiyatı</span>
                <input type="text" name="urun_fiyati" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" style="width:150px;">Ürün Açıklaması</span>
                <textarea class="form-control" name="aciklama" row="5" aria-label="With textarea"></textarea>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" style="width : 150px;">Ürün Resmi</span>
                <input type="file" name="urun_resmi[]" multiple class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
            </div>

            <div class="input-group mb-3 justify-content-end">
                <button class="btn btn-success" type="submit">Kaydet</button>
            </div>
        </form>
    </div>
</div>
<?php
//footer dahil ediliyor
require_once('footer.php');
?>
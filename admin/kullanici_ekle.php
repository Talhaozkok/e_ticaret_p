<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
//header dahil ediliyor
require_once('header.php');

//POST varmı kontrol ediyorum
if (isset($_POST['k_adi'])) {
    //Posttangelen verileri değişkene aktarıyorum
    $k_adi = $_POST['k_adi'];
    $sifre = md5($_POST['sifre']); // şifreyi md5 yöntemiyle hashliyorum
    $type = $_POST['type']; // kullanıcı mı admin mi type göre veritabanına ekliyorum.

    //PDO yöntemiyle kullanıcı kaydı yapılıyor.
    $sorgu = $db->prepare('INSERT INTO tbl_kullanici (kullanici_adi , sifre, type) VALUES ("' . $k_adi . '" , "' . $sifre . '" , "' . $type . '")');
    $sorgu->execute();

    //Sorgu başarılımı başarısız mı kontrölü yapılıyor
    if ($sorgu) {
        $mesaj = '<div class="alert alert-success" role="alert">
        Kullanıcı Ekleme Başarılı.
      </div>';
    } else {
        $mesaj = '<div class="alert alert-danger" role="alert">
        Kullanıcı Ekleme Sırasında Hata Oluştu.
      </div>';
    }
}
?>
<div class="card">
    <div class="card-header">
        Kullanıcı Ekle
    </div>
    <div class="card-body d-flex justify-content-center row">
        <?php
        //posttan dönen mesaj varsa ekrana basılıyor
        if (isset($mesaj)) {
            echo $mesaj;
        }
        ?>
        <form action="" method="POST" style="width:50%;">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" style="width : 150px;">Kullanıcı Adı</span>
                <input type="text" name="k_adi" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" style="width : 150px;">Şifre</span>
                <input type="password" name="sifre" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupSelect01" style="width: 150px;">Kullanıcı Türü</label>
                <select class="form-select" name="type" id="inputGroupSelect01">
                    <option value="1">Admin</option>
                    <option value="2">Kullanıcı</option>
                </select>
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
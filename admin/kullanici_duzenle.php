<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
//header dahil ediliyor
require_once('header.php');

//GET ten gelen kullanıcı idsini değişkene aktarıp kullanıcı PDO yöntemiyle sorguluyorum.
$kullanici_id = $_GET['id'];
$k_sorgu = $db->query('SELECT * FROM tbl_kullanici WHERE id = ' . $kullanici_id)->fetchAll()[0];

//POST varmı kontrol ediyorum
if (isset($_POST['k_adi'])) {
    //Posttangelen verileri değişkene aktarıyorum
    $k_adi = $_POST['k_adi'];

    $type = $_POST['type']; // kullanıcı mı admin mi type göre veritabanına ekliyorum.

    //Şifre değiştirildimi kontrol ediyorum değiştirilmediyse eski şifresi geçerli olacak.
    if (isset($_POST['sifre']) && $_POST['sifre'] != "") {
        // şifreyi md5 yöntemiyle hashliyorum
        $sifre = md5($_POST['sifre']);
    } else {
        $sifre = $k_sorgu['sifre'];
    }


    //PDO yöntemiyle kullanıcı kaydı yapılıyor.
    $sorgu = $db->prepare('UPDATE tbl_kullanici SET kullanici_adi = "' . $k_adi . '" , sifre = "' . $sifre . '" , type="' . $type . '" WHERE id = ' . $kullanici_id);
    $sorgu->execute();

    //Sorgu başarılımı başarısız mı kontrölü yapılıyor
    if ($sorgu) {
        $mesaj = '<div class="alert alert-success" role="alert">
        Kullanıcı Güncelleme Başarılı.
      </div>';
    } else {
        $mesaj = '<div class="alert alert-danger" role="alert">
        Kullanıcı Güncelleme Sırasında Hata Oluştu.
      </div>';
    }
}

// Değişikliklerin hemen gösterilmesi için kullanıcı sorguyu tekrar çalıştırıyorum
$k_sorgu = $db->query('SELECT * FROM tbl_kullanici WHERE id = ' . $kullanici_id)->fetchAll()[0];
?>
<div class="card">
    <div class="card-header">
        Kullanıcı Düzenle
    </div>
    <div class="card-body d-flex justify-content-center row">
        <?php
        //posttan dönen mesaj varsa ekrana basılıyor
        if (isset($mesaj)) {
            echo $mesaj;
        }
        ?>

        <!-- Kullanıcı sorgusundan gelen verileri input value yazıdırıyorum -->
        <form action="" method="POST" style="width:50%;">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" style="width : 150px;">Kullanıcı Adı</span>
                <input type="text" name="k_adi" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?= $k_sorgu['kullanici_adi'] ?>">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" style="width : 150px;">Şifre</span>
                <input type="password" name="sifre" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupSelect01" style="width: 150px;">Kullanıcı Türü</label>
                <select class="form-select" name="type" id="inputGroupSelect01">
                    <option <?php if ($k_sorgu['type'] == 1) {
                                echo "selected";
                            } ?> value="1">Admin</option>
                    <option <?php if ($k_sorgu['type'] == 2) {
                                echo "selected";
                            } ?> value="2">Kullanıcı</option>
                </select>
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
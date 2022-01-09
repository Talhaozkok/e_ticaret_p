<?php
//header dahil ediliyor
require_once('header.php');

//POST varmı kontrol ediyorum
if (isset($_POST['k_adi'])) {
    //Posttangelen verileri değişkene aktarıyorum
    $k_adi = $_POST['k_adi'];
    $sifre = md5($_POST['sifre']); // şifreyi md5 yöntemiyle hashliyorum
    //$type = $_POST['type']; // kullanıcı mı admin mi type göre veritabanına ekliyorum.

    // Kullanıcı kayıtlı mı kontrol ediyorum
    $userKontrol  = $db->query('SELECT * FROM tbl_kullanici WHERE kullanici_adi = "' . $k_adi . '" AND sifre = "' . $sifre . '" ')->fetch();

    if (is_array($userKontrol)) {
        // Kullanıcı vardır
        $mesaj = '<div class="alert alert-success" role="alert">
        Giriş Başarılı
       </div>';

        if ($userKontrol['type'] == 1) {
            // admin kullanıcısı
            $_SESSION['user'] = [
                'id' => $userKontrol['id'],
                'adi' => $userKontrol['kullanici_adi'],
                'type' => $userKontrol['type']
            ];
            header('location: index.php');
        } else {
            // Normal kullanıcı 
            
            $_SESSION['user'] = [
                'id' => $userKontrol['id'],
                'adi' => $userKontrol['kullanici_adi']
            ];
            header('location: /etic_odev/index.php');
        }
    } else {
        // Kullanıcı yoktur.
        $mesaj = '<div class="alert alert-danger" role="alert">
        Giriş hatalı lütfen tekrar deneyiniz
      </div>';
    }
}
?>
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
<?php
//footer dahil ediliyor
require_once('footer.php');
?>
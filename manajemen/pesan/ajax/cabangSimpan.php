<?php
session_start();
include("../database.php");

$cabang_id = amankan(dekripsi($_POST['uID']));
$nama_cabang = amankan($_POST['nama_cabang']);
$telp = amankan($_POST['telp']);
$address = amankan($_POST['address']);
$address = amankan($_POST['address']); 
$jenisInput = amankan(dekripsi($_POST['jenisInput']));

if($jenisInput=='New'){
  $sCari  = " SELECT *
            FROM cabang
            WHERE nama_cabang='" . $nama_cabang . "' and status_hapus='0'";
  $qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn)); 
  $rCari  = mysqli_fetch_array($qCari);

  if(empty($rCari['cabang_id'])){
    $cabang_id = randomText(10);
    $sInsert  = " INSERT INTO cabang
                  SET cabang_id='" . $cabang_id . "',
                      nama_cabang='" . $nama_cabang . "', 
                      telp='" . $telp . "', 
                      email='" . $email . "', 
                      address='" . $address . "',
                      status_hapus='0'";
    $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));
    $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
  }else{
    $pesan = "<i class='fa fa-times'></i> Username sudah ada sebelumnya"; 
  }
}else{
  $sCari  = " SELECT *
            FROM cabang
            WHERE nama_cabang='" . $nama_cabang . "' and cabang_id <>'".$cabang_id."' and status_hapus='0'";
  $qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
  $rCari  = mysqli_fetch_array($qCari);

  if (empty($rCari['cabang_id'])) {

    if(!empty($upass)){
    $sUpdate  = " UPDATE cabang
                  SET nama_cabang='" . $nama_cabang . "', 
                      telp='" . $telp . "', 
                      email='" . $email . "', 
                      address='" . $address . "'
                  WHERE cabang_id='".$cabang_id."'";
    $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
    }else{
      $sUpdate  = " UPDATE cabang
                    SET nama_cabang='" . $nama_cabang . "', 
                        telp='" . $telp . "', 
                        email='" . $email . "', 
                        address='" . $address . "'
                    WHERE cabang_id='" . $cabang_id . "'";
      $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
    }
    $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
  } else {
    $pesan = "<i class='fa fa-times'></i> Nama Cabang sudah ada sebelumnya";
  }

} 
?>
<div class="pesanku">
  <?php if (!empty($pesan)) { ?>
    <div class="alert alert-danger">
      <?php echo $pesan; ?>
    </div>
  <?php }
  if (!empty($pesanSukses)) { ?>
    <div class="alert alert-success">
      <?php echo $pesanSukses; ?>
    </div>
    <script>
      $(".modal").on("hidden.bs.modal", function() {
        window.location = "?menu=cabang";
      });
    </script>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
<?php
session_start();
include("../database.php");

$user_id = amankan(dekripsi($_POST['uID']));
$cabang_id = amankan(dekripsi($_POST['cID']));
$username = amankan($_POST['uname']);
$user_type = amankan($_POST['tipe']);
$upass = amankan($_POST['upass']);
$jenisInput = amankan(dekripsi($_POST['jenisInput']));

if($jenisInput=='New'){
  $sCari  = " SELECT *
            FROM users
            WHERE username='" . $username . "' and status_hapus='0'";
  $qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn)); 
  $rCari  = mysqli_fetch_array($qCari);

  if(empty($rCari['user_id'])){
    $user_id = randomText(10);
    $sInsert  = " INSERT INTO users
                  SET user_id='" . $user_id . "',
                      username='" . $username . "',
                      cabang_id='" . $cabang_id . "',
                      password='" . md5($upass) . "',
                      user_type='" . $user_type . "',
                      status_hapus='0'";
    $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));
    $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
  }else{
    $pesan = "<i class='fa fa-times'></i> Username sudah ada sebelumnya"; 
  }
}else{
  $sCari  = " SELECT *
            FROM users
            WHERE username='" . $username . "' and user_id <>'".$user_id."' and status_hapus='0'";
  $qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
  $rCari  = mysqli_fetch_array($qCari);

  if (empty($rCari['user_id'])) {

    if(!empty($upass)){
    $sUpdate  = " UPDATE users
                  SET username='" . $username . "',
                      cabang_id='" . $cabang_id . "',
                      password='" . md5($upass) . "',
                      user_type='" . $user_type . "'
                  WHERE user_id='".$user_id."'";
    $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
    }else{
      $sUpdate  = " UPDATE users
                  SET username='" . $username . "', 
                      cabang_id='" . $cabang_id . "', 
                      user_type='" . $user_type . "'
                  WHERE user_id='" . $user_id . "'";
      $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
    }
    $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
  } else {
    $pesan = "<i class='fa fa-times'></i> Username sudah ada sebelumnya";
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
        window.location = "?menu=user";
      });
    </script>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
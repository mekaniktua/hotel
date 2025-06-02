<?php
session_start();
include("../database.php");

$pelanggan_id = amankan(dekripsi($_POST['pID']));
$nama = amankan($_POST['nama']);
$email = amankan($_POST['email']);
$no_hp = amankan($_POST['no_hp']);
$address = amankan($_POST['address']);
$tanggal_lahir = amankan($_POST['tanggal_lahir']); 
$jenisInput = amankan(dekripsi($_POST['jenisInput']));

if($jenisInput=='New'){
  $sCari  = " SELECT *
              FROM pelanggan
              WHERE (email='" . $email . "' or no_hp='" . $no_hp . "') and status_hapus='0'";
  $qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn)); 
  $rCari  = mysqli_fetch_array($qCari);

  if($rCari['email']==$email){
    $pesan .= "<i class='fa fa-times'></i> Email sudah ada sebelumnya <br />";
  }
  if ($rCari['no_hp'] == $no_hp) {
    $pesan .= "<i class='fa fa-times'></i> No HP sudah ada sebelumnya <br />";
  }
  if(empty($pesan)){
    $pelanggan_id = randomText(10);
    $sInsert  = " INSERT INTO pelanggan
                  SET pelanggan_id='" . $pelanggan_id . "',
                      tanggal_daftar='" . date("Y-m-d H:i:s") . "',
                      nama='" . $nama . "',
                      no_hp='" . ($no_hp) . "',
                      email='" . $email . "',
                      tanggal_lahir='" . databaseTanggal($tanggal_lahir) . "', 
                      address='" . $address . "',
                      status_hapus='0'";
    $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));
    $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
  } 
}else{
  $sCari  = " SELECT *
              FROM pelanggan
              WHERE (email='" . $email . "' or no_hp='" . $no_hp . "') and pelanggan_id <>'".$pelanggan_id."' and status_hapus='0'";
  $qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
  $rCari  = mysqli_fetch_array($qCari);

  if ($rCari['email'] == $email) {
    $pesan .= "<i class='fa fa-times'></i> Email sudah ada sebelumnya <br />";
  }
  if ($rCari['no_hp'] == $no_hp) {
    $pesan .= "<i class='fa fa-times'></i> No HP sudah ada sebelumnya <br />";
  }
  if (empty($pesan)) {
 
    $sUpdate  = " UPDATE pelanggan
                  SET nama='" . $nama . "',
                      no_hp='" . ($no_hp) . "',
                      address='" .($address) . "',
                      tanggal_lahir='" . databaseTanggal($tanggal_lahir) . "', 
                      email='" . $email . "'
                  WHERE pelanggan_id='".$pelanggan_id."'";
    $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
     
    $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
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
        window.location = "?t=pelanggan";
      });
    </script>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
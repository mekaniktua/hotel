<?php
session_start();
include("../database.php");

$grup_id = amankan(dekripsi($_POST['gID']));
$pelanggan_id = amankan(dekripsi($_POST['pID']));  

if(empty($pelanggan_id)){
  $pesan .= "<i class='fa fa-times'></i> Anda belum pilih pelanggan <br />"; 
}
if(empty($pesan)){ 
  $sCari  = " SELECT *
              FROM grup_detail
              WHERE pelanggan_id='" . ($pelanggan_id) . "' and grup_id='". $grup_id."' and status_hapus='0'";
  $qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn)); 
  $rCari  = mysqli_fetch_array($qCari);

  if(empty($rCari['grup_detail_id'])){
    $grup_detail_id = randomText(10);
    $sInsert  = " INSERT INTO grup_detail
                  SET grup_detail_id='" . $grup_detail_id . "',
                      grup_id='" . ($grup_id) . "', 
                      pelanggan_id='" . ($pelanggan_id) . "', 
                      status_hapus='0'";
    $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));
    $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
  }else{
    $pesan = "<i class='fa fa-times'></i> Pelanggan sudah ada sebelumnya"; 
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
     grupPelangganList();
    </script>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
<?php
session_start();
include("../database.php");

$facility_id = amankan(dekripsi($_POST['fID']));
$user_id = amankan(dekripsi($_SESSION['orangesky_user_id']));

//Cari Pembelian 
$sData  = " SELECT * FROM facility 
          WHERE facility_id='" . $facility_id . "'";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
$rData = mysqli_fetch_array($qData);

//Delete Pembelian
$sUpdate  = " UPDATE facility
              SET status_hapus='1',
                  user_hapus ='".$user_id. "',
                  tanggal_hapus ='" . date("Y-m-d H:i:s") . "'
            WHERE facility_id='" . $facility_id . "'";
$qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
$pesanSukses = "<i class='fa fa-check'></i> Data has been deleted";
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
      facilityList();
    </script>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
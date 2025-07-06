<?php
session_start();
include("../database.php");
 
$room_type_id = dekripsi(amankan($_POST['rtID'])); 
 
  $sCari  = " SELECT *
              FROM room_type
              WHERE room_type_id='" . $room_type_id . "' and status_hapus='0'";
  $qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
  $rCari  = mysqli_fetch_array($qCari);

  if (empty($rCari['room_type_id'])) {
    $pesan = "<i class='fa fa-times'></i> Room type not found";
  } 
  if (empty($pesan)) {

    $sUpdate  = " UPDATE room_type
                  SET status_hapus='1' 
                  WHERE  room_type_id='" . $room_type_id . "'";
    $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
    $pesanSukses = "<i class='fa fa-check'></i> Data has been deleted";
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
      roomTypeList();
    </script> 
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
<?php
session_start();
include("../database.php");

$room_id = amankan(dekripsi($_POST['kID']));
$user_id = dekripsi(amankan($_SESSION['orangesky_user_id'])); 

//Cari di tabel user apakah sudah ada?
$sCari  = " SELECT *
            FROM room
            WHERE room_id='" . $room_id . "' and status_hapus='0'";
$qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
$nCari  = mysqli_num_rows($qCari);
$rCari  = mysqli_fetch_array($qCari);
if ($nCari < 1) { // Jika tidak ketemu keluar notif
  $pesan = "<i class='fa fa-times'></i> Room not found";
}
if (empty($pesan)) {
  $sUpdate  = " UPDATE room
                SET status_hapus='1',
                 user_hapus='".$user_id."',
                 tanggal_hapus='".date("Y-m-d H:i:s")."'
                WHERE room_id='" . $room_id . "'";
  $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
  $pesanSukses = "<i class='fa fa-check'></i> Room data has been Deleted";
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
      roomList();
    </script>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
<?php
session_start();
include("../database.php");

$user_id = amankan(dekripsi($_POST['uID']));


//Cari di tabel user apakah sudah ada?
$sCari  = " SELECT *
            FROM users
            WHERE user_id='" . $user_id . "' and status_hapus='0'";
$qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
$nCari  = mysqli_num_rows($qCari);
$rCari  = mysqli_fetch_array($qCari);
if ($nCari < 1) { // Jika tidak ketemu keluar notif
  $pesan = "<i class='fa fa-times'></i> User not found";
}
if (empty($pesan)) {

  $sUpdate  = " UPDATE users
                SET status_hapus='1'
                WHERE user_id='" . $user_id . "'";
  $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
  $pesanSukses = "<i class='fa fa-check'></i> User telah dihapus";
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
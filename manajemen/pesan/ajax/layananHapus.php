<?php
session_start();
include("../database.php");

$layanan_id = amankan(dekripsi($_POST['lID']));


//Cari di tabel user apakah sudah ada?
$sCari  = " SELECT *
            FROM layanan
            WHERE layanan_id='" . $layanan_id . "' and status_hapus='0'";
$qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
$nCari  = mysqli_num_rows($qCari);
$rCari  = mysqli_fetch_array($qCari);
if ($nCari < 1) { // Jika tidak ketemu keluar notif
  $pesan = "<i class='fa fa-times'></i> Layanan not found";
}
if (empty($pesan)) {

  $sUpdate  = " UPDATE layanan
                SET status_hapus='1'
                WHERE layanan_id='" . $layanan_id . "'";
  $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
  $pesanSukses = "<i class='fa fa-check'></i> Layanan telah dihapus";
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
        window.location = "?menu=layanan";
      });
    </script>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
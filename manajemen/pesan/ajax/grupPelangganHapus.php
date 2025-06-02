<?php
session_start();
include("../database.php");

$grup_detail_id = amankan(dekripsi($_POST['gdID']));


//Cari di tabel user apakah sudah ada?
$sCari  = " SELECT *
            FROM grup_detail
            WHERE grup_detail_id='" . $grup_detail_id . "' and status_hapus='0'";
$qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
$nCari  = mysqli_num_rows($qCari);
$rCari  = mysqli_fetch_array($qCari);
if ($nCari < 1) { // Jika tidak ketemu keluar notif
  $pesan = "<i class='fa fa-times'></i> Pelanggan not found dalam grup";
}
if (empty($pesan)) {

  $sUpdate  = " UPDATE grup_detail
                SET status_hapus='1'
                WHERE grup_detail_id='" . $grup_detail_id . "'";
  $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
  $pesanSukses = "<i class='fa fa-check'></i> Pelanggan telah dihapus dalam grup";
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
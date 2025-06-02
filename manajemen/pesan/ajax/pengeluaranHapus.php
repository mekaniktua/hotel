<?php
session_start();
include("../database.php");

$pengeluaran_id = amankan(dekripsi($_POST['pID']));

//Delete Absen
$sUpdate  = " UPDATE pengeluaran
              SET status_hapus='1'
            WHERE pengeluaran_id='" . $pengeluaran_id . "'";
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
      pengeluaranList();
    </script>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
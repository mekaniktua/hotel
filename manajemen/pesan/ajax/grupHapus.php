<?php
session_start();
include("../database.php");

$grup_id = amankan(dekripsi($_POST['gID']));

//Delete Absen
$sUpdate  = " UPDATE grup
              SET status_hapus='1'
            WHERE grup_id='" . $grup_id . "'";
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
      $(".modal").on("hidden.bs.modal", function() {
        window.location = "?t=grup";
      });
    </script>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
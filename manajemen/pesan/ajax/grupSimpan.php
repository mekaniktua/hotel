<?php
session_start();
include("../database.php");

$grup_id = dekripsi(amankan($_POST['gID']));
$nama = (amankan($_POST['nama']));
$jenisInput = dekripsi(amankan($_POST['jenisInput']));

if ($jenisInput == 'New') {
  $sCari  = " SELECT *
            FROM grup
            WHERE nama='" . $nama . "' and status_hapus='0'";
  $qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
  $rCari  = mysqli_fetch_array($qCari);

  if (!empty($rCari['grup_id'])) {
    $pesan .= "<i class='fa fa-times'></i> Nama sudah ada sebelumnya <br />";
  }
  if (empty($pesan)) {
    $grup_id = randomText(10);
    $sInsert  = " INSERT INTO grup
                SET grup_id='" . $grup_id . "',
                    nama='" . $nama . "',
                    status_hapus='0'";
    $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));
    $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
  }
} else {
  $sCari  = " SELECT *
            FROM grup
            WHERE nama='" . $nama . "' and grup_id <>'" . $grup_id . "' and status_hapus='0'";
  $qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
  $rCari  = mysqli_fetch_array($qCari);

  if (!empty($rCari['grup_id'])) {
    $pesan .= "<i class='fa fa-times'></i> Nama sudah ada sebelumnya <br />";
  }
  if (empty($pesan)) {

    $sUpdate  = " UPDATE grup
                SET nama='" . $nama . "'
                WHERE grup_id='" . $grup_id . "'";
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
        window.location = "?t=grup";
      });
    </script>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
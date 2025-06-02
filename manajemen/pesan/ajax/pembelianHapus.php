<?php
session_start();
include("../database.php");

$pembelian_id = amankan(dekripsi($_POST['pID']));

//Cari Pembelian 
$sData  = " SELECT * FROM pembelian 
          WHERE pembelian_id='" . $pembelian_id . "'";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
$rData = mysqli_fetch_array($qData);

//Delete Pembelian
$sUpdate  = " UPDATE pembelian
              SET status_hapus='1'
            WHERE pembelian_id='" . $pembelian_id . "'";
$qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));

//Mengurangi stok barang jika dihapus
$sUpdate  = " UPDATE barang
              SET stok=(stok - ".$rData['jumlah'].") 
              WHERE barang_id='" . $rData['barang_id'] . "'";
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
      pembelianList();
    </script>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
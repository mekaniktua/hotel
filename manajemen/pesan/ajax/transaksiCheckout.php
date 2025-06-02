<?php
session_start();
include("../database.php");

$transaksi_id = amankan(dekripsi($_POST['tID']));
$via = amankan(($_POST['via']));
 
$sData  = " SELECT *
            FROM transaksi
            WHERE transaksi_id='" . $transaksi_id . "' and status_hapus='0'";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
$rData = mysqli_fetch_array($qData);

//Lunas transaksi
$sUpdate  = " UPDATE transaksi
              SET is_lunas='1',
                  via='".$via."'
            WHERE transaksi_id='" . $rData['transaksi_id'] . "'";
$qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
?>
<script>
  window.open("cetak/cetakPerawatan.php?tID=<?php echo enkripsi($transaksi_id);?>","_self");
</script>

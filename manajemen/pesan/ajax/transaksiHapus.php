<?php
session_start();
include("../database.php");

$detail_transaksi_id = amankan(dekripsi($_POST['dtID']));

//Delete transaksi
$sUpdate  = " UPDATE detail_transaksi
              SET status_hapus='1'
            WHERE detail_transaksi_id='" . $detail_transaksi_id . "'";
$qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
?>

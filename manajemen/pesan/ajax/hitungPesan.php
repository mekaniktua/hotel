<?php
session_start();
include("../database.php");
 
//Cari di tabel user apakah sudah ada?
$sCari  = " SELECT count(*) jumlah
            FROM pesan_wa
            WHERE status='Terkirim'";
$qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
$nCari  = mysqli_num_rows($qCari);
$rCari  = mysqli_fetch_array($qCari);
if ($nCari < 1) { // Jika tidak ketemu keluar notif
 echo "0";
}else{
  echo $rCari['jumlah'];
} 
?>
 
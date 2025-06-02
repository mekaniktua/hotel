<?php
session_start();
include("../database.php");

$barang_id = amankan(dekripsi($_POST['bID']));
$nama_barang = amankan($_POST['nama_barang']);
$stok = amankan($_POST['stok']);
$harga_jual = amankan($_POST['harga_jual']);
$harga_beli = amankan($_POST['harga_beli']);
$margin_penjual = amankan($_POST['margin_penjual']);
$jenisInput = amankan(dekripsi($_POST['jenisInput']));

if(empty($nama_barang)){
  $pesan .= "<i class='fa fa-times'></i> Nama barang masih kosong <br />"; 
}if (empty($stok)) {
  $pesan .= "<i class='fa fa-times'></i> Stok barang masih kosong <br />";
}
if (!is_numeric($stok)) {
  $pesan .= "<i class='fa fa-times'></i> Stok barang harus angka <br />";
}
if (empty($harga_jual)) {
  $pesan .= "<i class='fa fa-times'></i> Price Jual belum diset <br />";
}
if (!is_numeric($harga_jual)) {
  $pesan .= "<i class='fa fa-times'></i> Price jual harus angka <br />";
}
if (empty($harga_beli)) {
  $pesan .= "<i class='fa fa-times'></i> Price Beli belum diset <br />";
}
if (!is_numeric($harga_beli)) {
  $pesan .= "<i class='fa fa-times'></i> Price Beli harus angka <br />";
}

if(empty($pesan)){
  if($jenisInput=='New'){
    $sCari  = " SELECT *
                FROM barang
                WHERE lower(nama_barang)='" . strtolower($nama_barang) . "' and status_hapus='0'";
    $qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn)); 
    $rCari  = mysqli_fetch_array($qCari);

    if(empty($rCari['barang_id'])){
      $barang_id = randomText(10);
      $sInsert  = " INSERT INTO barang
                    SET barang_id='" . $barang_id . "',
                        nama_barang='" . $nama_barang . "',
                        stok=" . ($stok) . ",
                        harga_jual=" . $harga_jual . ",
                        harga_beli=" . $harga_beli . ",
                        margin_penjual=" . $margin_penjual . ",
                        status_hapus='0'";
      $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));
      $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
    }else{
      $pesan = "<i class='fa fa-times'></i> Barang sudah ada sebelumnya"; 
    }
  }else{
    $sCari  = " SELECT *
              FROM barang
              WHERE nama_barang='" . $nama_barang . "' and barang_id <>'".$barang_id."' and status_hapus='0'";
    $qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
    $rCari  = mysqli_fetch_array($qCari);

    if (empty($rCari['barang_id'])) {
  
      $sUpdate  = " UPDATE barang
                    SET nama_barang='" . $nama_barang . "',
                        stok=" . ($stok) . ",
                        harga_jual=" .($harga_jual) . ",
                        margin_penjual=" . $margin_penjual . ",
                        harga_beli=" . ($harga_beli) . "
                    WHERE barang_id='".$barang_id."'";
      $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
      
      $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
    } else {
      $pesan = "<i class='fa fa-times'></i> Barang sudah ada sebelumnya";
    }

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
        window.location = "?menu=barang";
      });
    </script>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
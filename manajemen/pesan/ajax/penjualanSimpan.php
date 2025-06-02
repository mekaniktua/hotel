<?php
session_start();
include("../database.php");

$tanggal = date('Y-m-d');
$barang_id = dekripsi(amankan($_POST['bID']));
$jumlah = (amankan($_POST['jumlah']));
$nama_pelanggan = (amankan($_POST['nama_pelanggan']));

//Cari Barang
$sBarang  = " SELECT * FROM barang
              WHERE barang_id ='".$barang_id."'";
$qBarang = mysqli_query($conn, $sBarang) or die(mysqli_error($conn));
$rBarang = mysqli_fetch_array($qBarang);
$harga_jual = $rBarang['harga_jual'];
$nama_barang = $rBarang['nama_barang'];
$margin = $rBarang['margin_penjual'];

if(empty($rBarang['barang_id'])){
  $pesan = "<i class='fa fa-times'></i> Barang not found";
}
if (!is_numeric($jumlah)) {
  $pesan = "<i class='fa fa-times'></i> Jumlah harus angka";
}
if (empty($pesan)) {

  $penjualan_id = randomText(10);
  $total = ($jumlah * ($harga_jual-$margin));
  $sInsert  = " INSERT INTO penjualan
                SET penjualan_id='" . $penjualan_id . "',
                    tanggal_penjualan='" . date("Y-m-d") . "', 
                    nama_pelanggan='" . $nama_pelanggan . "', 
                    barang_id='" . $barang_id . "',
                    nama_barang='" . $nama_barang . "', 
                    jumlah=" . $jumlah . ", 
                    harga_jual=" . $harga_jual . ", 
                    margin=" . $margin . ", 
                    total=" . $total . ", 
                    status_hapus='0'";
  $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));

  //menambah stok barang jika dihapus
  $sUpdate  = " UPDATE barang
              SET stok=(stok - " . $jumlah . ")
              WHERE barang_id='" . $barang_id . "'";
  $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
  $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
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
     penjualanList();
    </script>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
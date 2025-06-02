<?php
session_start();
include("../database.php");

$transaksi_id = amankan(dekripsi($_POST['tID']));
$layanan_id = amankan(dekripsi($_POST['lID']));
$nama = amankan(($_POST['nama']));
$no_hp = amankan(($_POST['no_hp']));
$pegawai_id = amankan(dekripsi($_POST['pID']));
$jenisInput = amankan(dekripsi($_POST['jenisInput']));

if($jenisInput=='New'){
  $transaksi_id = randomText(10); 
  $sInsert  = " INSERT INTO transaksi
              (transaksi_id,cabang_id,tanggal_transaksi,jenis_transaksi,nama,no_hp,email,pegawai_id,status_hapus)
              VALUES
              ('" . $transaksi_id . "','" . $_SESSION['cabang_id'] . "','" . date("Y-m-d H:i:s"). "','Perawatan','" . $nama. "','" . $no_hp . "','" . $email . "','" . $pegawai_id . "','0')";
  $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));
  $pesanSukses = " Silahkan dilengkapi";
}else{


$sLayanan = "  SELECT * FROM layanan 
                WHERE layanan_id ='". $layanan_id."' and (status_hapus is null or status_hapus='0')
                ORDER BY category,nama_layanan asc";
$qLayanan = mysqli_query($conn, $sLayanan) or die(mysqli_error($conn));
$rLayanan = mysqli_fetch_array($qLayanan);

$biaya = $rLayanan['biaya'];
  $biaya_tambahan = $rLayanan['biaya_tambahan'];
if(empty($biaya)){
  $biaya=0;
}if (empty($biaya_tambahan)) {
    $biaya_tambahan = 0;
  }
$total_biaya = $biaya + $biaya_tambahan;

$detail_transaksi_id = randomText(10); 
$sInsert  = " INSERT INTO detail_transaksi
              (detail_transaksi_id,transaksi_id,nama_layanan,harga_layanan,harga_tambahan_layanan,status_hapus)
              VALUES
              ('".$detail_transaksi_id."','" . $transaksi_id . "','" . $rLayanan['nama_layanan'] . "'," . $biaya . "," . $biaya_tambahan . ",'0')";
$qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));

$sCari = "  SELECT sum(harga_layanan)total FROM DETAIL_TRANSAKSI 
              WHERE transaksi_id ='" . $transaksi_id . "' and (status_hapus is null or status_hapus='0')";
$qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
$rCari = mysqli_fetch_array($qCari);

$sUpdate  = " UPDATE transaksi
              SET total =". $rCari['total']."
              WHERE transaksi_id='" . $transaksi_id . "'";
$qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
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
    <?php if ($jenisInput == 'New') { ?>
      <script>
        $(".modal").on("hidden.bs.modal", function() {
          window.location = "?menu=perawatanEdit&tID=<?php echo enkripsi($transaksi_id);?>";
        });
      </script>
    <?php } else { ?>
      <script>
        $(".modal").on("hidden.bs.modal", function() {
          window.location = "?menu=transaksi";
        });
      </script>
    <?php } ?>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
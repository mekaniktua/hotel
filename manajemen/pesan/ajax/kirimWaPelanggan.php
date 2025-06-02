<?php
session_start();
include("../database.php");

$pesanWa = $_POST['pesanWa'];
$pelanggan = ($_POST['pelanggan']);
if(empty($pesanWa)){
  $pesan = "<i class='fa fa-times'></i> Pesan Whatsapp masih kosong";
}if(empty($pelanggan)){
  $pesan = "<i class='fa fa-times'></i> Pelanggan masih kosong";
}if(empty($pesan)){
  
  $sData =  " SELECT * 
              FROM pelanggan 
              WHERE (status_hapus is null or status_hapus='0')  and pelanggan_id in (" . $pelanggan . ")";
  $qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));

  while ($rData = mysqli_fetch_array($qData)) {
   
    $pesan_wa_id = randomText(10);
    $pesanNew  = str_replace('NAMA_PELANGGAN',$rData['nama'],$pesanWa);
    $kirimWA = kirimWA(API_KEY,$pesanNew, $rData['no_hp']);
 
    $error_code = $kirimWA['error_code'];
    $ref_no = $kirimWA['ref_no'];
    $message = $kirimWA['message'];

    if(empty($error_code)){
      $status='Terkirim';
    }else{
      $status='Gagal';
    }

    $sInsert  = " INSERT INTO pesan_wa
                  SET pesan_wa_id='" . $pesan_wa_id . "',
                    tanggal = '" . date("Y-m-d H:i:s") . "',
                    pesan = '" . $pesanNew . "',
                    pelanggan_id='" . $rData['pelanggan_id'] . "',
                    no_hp='" . $rData['no_hp'] . "',
                    tipe='Individu',
                    status='" . $status . "',
                    error_code='" . $error_code . "',
                    ref_no='" . $ref_no . "',
                    Please wait='" . $message . "'";
    $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));
    $pesanSukses = "<i class='fa fa-check'></i> Pesan telah terkirim, lihat status pengiriman pada laporan";
  }
  
}
?>
<div class="pesanku">
  <?php if (!empty($pesan)) { ?>
    <div class="alert alert-danger">
      <?php echo $pesan; ?>
    </div>
  <?php } ?>
 <?php if (!empty($pesanSukses)) { ?>
    <div class="alert alert-success">
      <?php echo $pesanSukses; ?>
    </div>
  <?php }?>
</div> 
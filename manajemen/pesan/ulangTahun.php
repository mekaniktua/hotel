<?php
ob_start();
session_start();
include("database.php");

$sData =  " SELECT * 
              FROM pelanggan 
              WHERE (status_hapus is null or status_hapus='0')  and date(tanggal_lahir)='" . date("Y-m-d") . "'";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));

while ($rData = mysqli_fetch_array($qData)) {

    $sPesan =  " SELECT * 
              FROM template_wa 
              WHERE (status_hapus is null or status_hapus='0') and category='UlangTahun' and is_aktif='1'";
    $qPesan = mysqli_query($conn, $sPesan) or die(mysqli_error($conn));
    $rPesan = mysqli_fetch_array($qPesan);
    $pesanWa = $rPesan['pesan'];

    $pesan_wa_id = randomText(10);
    $pesanNew  = str_replace('NAMA_PELANGGAN', $rData['nama'], $pesanWa);
    $kirimWA = kirimWA(API_KEY, $pesanNew, $rData['no_hp']);

    $error_code = $kirimWA['error_code'];
    $ref_no = $kirimWA['ref_no'];
    $message = $kirimWA['message'];

    if (empty($error_code)) {
        $status = 'Terkirim';
    } else {
        $status = 'Gagal';
    }

    $sInsert  = " INSERT INTO pesan_wa
                  SET pesan_wa_id='" . $pesan_wa_id . "',
                    tanggal = '" . date("Y-m-d H:i:s") . "',
                    pesan = '" . $pesanNew . "',
                    pelanggan_id='" . $rData['pelanggan_id'] . "',
                    nama='" . $rData['nama'] . "',
                    no_hp='" . $rData['no_hp'] . "',
                    tipe='Ulang Tahun',
                    status='" . $status . "',
                    error_code='" . $error_code . "',
                    ref_no='" . $ref_no . "',
                    keterangan='" . $message . "'";
    $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));
    $pesanSukses = "<i class='fa fa-check'></i> Pesan telah terkirim, lihat status pengiriman pada laporan";
}
  

?> 
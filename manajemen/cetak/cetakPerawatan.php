<?php session_start();
ob_start();
include('../database.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <!-- basic -->
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- mobile metas -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="viewport" content="initial-scale=1, maximum-scale=1">
   <!-- site metas -->
   <title>Kapsterbox - Cetak </title>
   <meta name="keywords" content="">
   <meta name="description" content="">
   <meta name="author" content="">
   <!-- site icon -->
   <link rel="icon" href="../images/logo/favicon.ico" type="image/png" />
   <!-- bootstrap css -->
   <link rel="stylesheet" href="../css/bootstrap.min.css" />
   <!-- site css -->
   <link rel="stylesheet" href="../style.css" />
   <!-- responsive css -->
   <link rel="stylesheet" href="../css/responsive.css" />
   <!-- select bootstrap -->
   <link rel="stylesheet" href="../css/bootstrap-select.css" />
   <!-- scrollbar css -->
   <link rel="stylesheet" href="../css/perfect-scrollbar.css" />
   <!-- custom css -->
   <link rel="stylesheet" href="../css/custom.css" />

   <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
   <link rel="stylesheet" href=" https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
   <link rel="stylesheet" href="../css/select2.min.css" />

   <script src="../js/jquery.min.js"></script>
   <script src="../js/jquery-3.3.1.min.js"></script>
   <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
   <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
   <script src="../js/popper.min.js"></script>
   <script src="../js/bootstrap.min.js"></script>
   <!-- wow animation -->
   <script src="../js/animate.js"></script>
   <!-- select country -->
   <script src="../js/bootstrap-select.js"></script>
   <!-- owl carousel -->
   <script src="../js/owl.carousel.js"></script>
   <!-- chart js -->
   <script src="../js/Chart.min.js"></script>
   <script src="../js/Chart.bundle.min.js"></script>
   <script src="../js/utils.js"></script>
   <script src="../js/analyser.js"></script>
   <script src="../js/blockUI.js"></script>
   <script src="../js/select2.min.js"></script>
   <!-- nice scrollbar -->
   <!-- <script src="../js/perfect-scrollbar.min.js"></script> -->
   <script>
      // var ps = new PerfectScrollbar('#sidebar');
   </script>
   <!-- custom js -->
   <script src="../js/custom.js"></script>
</head>

<?php
$transaksi_id = amankan(dekripsi($_GET['tID']));
$sData = "  SELECT t.*,p.nama nama_pegawai,c.nama_cabang,c.address,c.telp FROM transaksi t 
            JOIN pegawai p ON p.pegawai_id=t.pegawai_id
            JOIN cabang c ON c.cabang_id=t.cabang_id
            WHERE t.transaksi_id='" . $transaksi_id . "'";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
$rData = mysqli_fetch_array($qData);

if (empty($rData['transaksi_id'])) {
   header("Location: ../");
}

$sDetail = "  SELECT d.* FROM detail_transaksi d  
            WHERE d.transaksi_id='" . $transaksi_id . "' and d.status_hapus='0'";
$qDetail = mysqli_query($conn, $sDetail) or die(mysqli_error($conn));
?>

<style>
   hr.new4 {
      border: 1px solid black;
   }

   @media print {

      .no-print,
      .no-print * {
         display: none !important;
      }
   }
</style>

<body>
   <table style="width: 100%;color:black;font-size:4em;">
      <tr>
         <td>
            <img src="../images/logo/kapsterbox_.png" width="200px">
            <div style="margin-left: 10px;">
               <?php echo $rData['address']; ?>
               <br />
               Telp. <?php echo $rData['telp']; ?>
               <br />
               <br />
               <table width="100%">
                  <tr>
                     <td width="20%">TRX ID</td>
                     <td>:</td>
                     <td><?php echo $rData['transaksi_id']; ?></td>
                  </tr>
                  <tr>
                     <td width="20%">NAMA</td>
                     <td>:</td>
                     <td><?php echo $rData['nama']; ?></td>
                  </tr>
                  <tr>
                     <td width="20%">TANGGAL</td>
                     <td>:</td>
                     <td><?php echo normalTanggalJam($rData['tanggal_transaksi']); ?></td>
                  </tr>
                  <tr>
                     <td width="20%">KAPSTER</td>
                     <td>:</td>
                     <td><?php echo ($rData['nama_pegawai']); ?></td>
                  </tr>
               </table>
               <hr class="new4">
               <table width="100%">
                  <?php while ($rDetail = mysqli_fetch_array($qDetail)) { ?>
                     <tr>
                        <td><?php echo $rDetail['nama_layanan']; ?></td>
                        <td width="100px" style="text-align: right;"><?php echo angka($rDetail['harga_layanan'] + $rDetail['harga_tambahan_layanan']); ?>,-</td>
                     </tr>
                  <?php } ?>
               </table>
               <hr class="new4">
               <table width="100%">
                  <tr>
                     <td>TOTAL</td>
                     <td>:</td>
                     <td style="text-align: right;"><?php echo angka($rData['total']); ?>,-</td>
                  </tr>
                  <tr>
                     <td>PEMBAYARAN VIA (<?php echo $rData['via']; ?>)</td>
                     <td>:</td>
                     <td width="35%" style="text-align: right;"><?php echo angka($rData['total']); ?>,-</td>
                  </tr>
               </table>
               <br /><br />
               <div class="text-center">
                  <h4>TERIMA KASIH</h4>
               </div>
            </div>
         </td>
      </tr>
      <tr>
         <td class="text-center"><button class="btn btn-danger no-print" onclick="back()">Tutup</button></td>
      </tr>
   </table>

</body>

</html>
<script>
   window.print();

   function back() {
      window.open("../?menu=perawatan", "_self");
   }
</script>
<?php ob_end_flush(); ?>
<?php
session_start();
include("../database.php");
require_once('../tcpdf/tcpdf.php');

$tanggal_awal = databaseTanggal(amankan($_POST['tanggalAwal']));
$tanggal_akhir = databaseTanggal(amankan($_POST['tanggalAkhir']));
$lama = lama($tanggal_awal, $tanggal_akhir);
//Data di tabel user apakah sudah ada?
$sData  = " SELECT d.*,t.tanggal_transaksi,t.nama,t.via, p.nama nama_pegawai,k.margin
            FROM detail_transaksi d
            JOIN transaksi t ON t.transaksi_id=d.transaksi_id
            JOIN pegawai p ON p.pegawai_id=t.pegawai_id
            JOIN kategori_pegawai k ON k.category=p.category
            WHERE t.is_lunas='1' and  date(tanggal_transaksi) between '" . $tanggal_awal . "' and '" . $tanggal_akhir . "' and d.status_hapus='0' and t.status_hapus='0'
            order by t.tanggal_transaksi";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));

$sMakan  = " SELECT SUM(CASE WHEN tanggal between '" . $tanggal_awal . "' and '" . $tanggal_akhir . "' THEN uang_makan ELSE 0 END)uang_makan
            FROM absensi
            WHERE status_hapus ='0'";
$qMakan = mysqli_query($conn, $sMakan) or die(mysqli_error($conn));
$rMakan = mysqli_fetch_array($qMakan);
$uang_makan = $rMakan['uang_makan'];

$sBeli  = " SELECT * FROM pembelian
             WHERE tanggal_pembelian between '" . $tanggal_awal . "' and '" . $tanggal_akhir . "' and status_hapus ='0'";
$qBeli = mysqli_query($conn, $sBeli) or die(mysqli_error($conn));
while ($rBeli = mysqli_fetch_array($qBeli)) {
  $total_pembelian += $rBeli['total'];
  $trBeli .= '<tr class="text-nowrap"> 
          <td>' . $rBeli['nama_barang'] . '</td> 
           <td >' . angka($rBeli['harga_beli']) . ',-</td> 
           <td >' . angka($rBeli['jumlah']) . '</td> 
          <td style="text-align: right;">' . angka($rBeli['total']) . ',-</td> 
        </tr>';
}

$sJual  = " SELECT * FROM penjualan
            WHERE tanggal_penjualan between '" . $tanggal_awal . "' and '" . $tanggal_akhir . "' and status_hapus ='0'";
$qJual = mysqli_query($conn, $sJual) or die(mysqli_error($conn));
while ($rJual = mysqli_fetch_array($qJual)) {
  $total_penjualan += $rJual['total'];
  $trJual .= '<tr class="text-nowrap"> 
  <td >' . $rJual['nama_barang'] . '</td> 
   <td >' . angka($rJual['harga_jual']) . ',-</td> 
   <td >' . angka($rJual['margin']) . ',-</td> 
   <td >' . angka($rJual['jumlah']) . '</td> 
  <td style="text-align: right;">' . angka($rJual['total']) . ',-</td> 
  </tr>';
}

$sPengeluaran  = " SELECT *
                    FROM pengeluaran
                    WHERE status_hapus ='0' and (tanggal between '" . $tanggal_awal . "' and '" . $tanggal_akhir . "')";
$qPengeluaran = mysqli_query($conn, $sPengeluaran) or die(mysqli_error($conn));
while ($rPengeluaran = mysqli_fetch_array($qPengeluaran)) {
  $pengeluaran += $rPengeluaran['jumlah'];
  $tr .= '<tr class="text-nowrap"> 
          <td colspan="2">' . $rPengeluaran['nama_pengeluaran'] . '</td> 
          <td style="text-align: right;">' . angka($rPengeluaran['jumlah']) . ',-</td> 
        </tr>';
}


$total_pengeluaran = $uang_makan + $pengeluaran;
?>
<div class="full white_shd margin_bottom_30">
  <div class="table_section padding_infor_info">
    <?php $html_a =
    '<h5>A. PERAWATAN</h5>
    <table class="table table-striped" border="1" style="padding:2px">
      <thead>
        <tr style="background-color:#ccc;color:white;">
          <th>TANGGAL</th>
          <th>PELANGGAN</th>
          <th>LAYANAN</th>
          <th>PEGAWAI</th>
          <th>BIAYA (Rp.)</th>
          <th>POTONGAN</th>
          <th>MARGIN %</th>
          <th>LABA (Rp.)</th>
        </tr>
      </thead>
      <tbody>'; ?>
    <?php while ($rData  = mysqli_fetch_array($qData)) {
      $i++;
      if(strpos(strtolower($rData['via']),'qris')!==false){
        $potongan = $rData['harga_layanan'] * (0.7/100);
      }else{
         $potongan =0;
      }
      
      $total += $rData['harga_layanan'];
      $margin = ($rData['harga_layanan']) * $rData['margin'] / 100;
      $total_margin += $margin;
      $laba = ($rData['harga_layanan'] - $margin) -$potongan;
      $total_laba += $laba;
      $total_potongan += $potongan;

      $html_a .= '<tr class="text-nowrap">
            <td>' . normalTanggal($rData['tanggal_transaksi']) . '</td>
            <td>' . $rData['nama'] . '</td>
            <td>' . $rData['nama_layanan'] . '</td>
            <td>' . $rData['nama_pegawai'] . '</td>
            <td style="text-align: right;">' . (!empty($rData['harga_layanan']) ? angka($rData['harga_layanan']) . ",-" : "0,-") . '</td>
            <td>' . angka($potongan) . ',-</td>
            <td>' . $rData['margin'] . '</td>
            <td style="text-align: right;">' . (!empty($rData['harga_layanan']) ? angka($laba) . ",-" : "0,-") . '</td>
          </tr>';
    }; ?>
    <?php $html_a .= '<tr>
          <th colspan="7" style="text-align: right;font-weight: bold;">TOTAL</th>
          <th style="text-align: right;font-weight: bold;">' . (!empty($total_laba) ? angka($total_laba) : "0") . ',-</th>
        </tr>
      </tbody>
    </table>'; ?>
    <?php echo $html_a; ?>

    <?php
    $html_b .= '<h5>B. PENJUALAN</h5>
    <table class="table table-striped" border="1"style="padding:2px">
      <thead>
        <tr style="background-color:#ccc;color:white;">
          <th>BARANG</th>
          <th>HARGA JUAL</th>
          <th>MARGIN</th>
          <th>JUMLAH</th>
          <th>TOTAL (Rp.)</th>
        </tr>
      </thead>
      <tbody>' . $trJual . '
        <tr>
          <th colspan="4" style="text-align: right;font-weight: bold;">TOTAL</th>
          <th style="text-align: right;font-weight: bold;">' . angka($total_penjualan) . ',-</th>
        </tr>
      </tbody>
    </table>';
    echo $html_b; ?>

    <?php
    $html_c .= '
    <h5>C. PENGELUARAN</h5>
    <table class="table table-striped" border="1" style="padding:2px">
      <thead>
        <tr style="background-color:#ccc;color:white;">
          <th>JENIS</th>
          <th>JUMLAH HARI</th>
          <th >TOTAL (Rp.)</th>
        </tr>
      </thead>
      <tbody>
        <tr class="text-nowrap">
          <td>Uang Makan</td>
          <td>' . $lama . '</td>
          <td style="text-align: right;">' . angka($uang_makan) . ',-</td>
        </tr>' . $tr . '
        <tr>
          <th colspan="2" style="text-align: right;font-weight: bold;">TOTAL</th>
          <th style="text-align: right;font-weight: bold;">' . angka($total_pengeluaran) . ',-</th>
        </tr>
      </tbody>
    </table>';
    echo $html_c; ?>

    <?php
    $html_d .= '<h5>D. PEMBELIAN</h5>

    <table class="table table-striped" border="1" style="padding:2px">
      <thead>
        <tr style="background-color:#ccc;color:white;">
          <th>BARANG</th>
          <th>HARGA BELI</th>
          <th>JUMLAH</th>
          <th>TOTAL (Rp.)</th>
        </tr>
      </thead>
      <tbody>' . $trBeli . '
        <tr>
          <th colspan="3" style="text-align: right;font-weight: bold;">TOTAL</th>
          <th style="text-align: right;font-weight: bold;">' . angka($total_pembelian) . ',-</th>
        </tr>
      </tbody>
    </table>
     <br /><br />
    <h4>TOTAL: ' . angka($total_laba + $total_penjualan - $total_pengeluaran - $total_pembelian) . ',-</h4>';
    echo $html_d;

    $html = $html_a . $html_b . $html_c . $html_d;
    ?>
    <?php buatPdf($html,$tanggal_awal,$tanggal_akhir) ?>

    <?php if(file_exists("../laporan/transaksi_" .$tanggal_awal."_".$tanggal_akhir . ".pdf")){?>
          <button class="btn btn-success" onclick="buka()">Unduh PDF</button>
    <?php }?>

  </div>
</div>



<script>
  function buka(){
    window.open("laporan/transaksi_<?php echo $tanggal_awal."_".$tanggal_akhir;?>.pdf","_blank");
  }
  $(document).ready(function() {
    $('#datatable').DataTable({
      dom: '<"container-fluid"<"row"<"col"B><"col"l><"col"f>>>rtip',
      buttons: [
        'print', 'excel'
      ],
      lengthMenu: [50, 100, 200, 500],
      order: [
        [1, 'desc']
      ]
    });
  });
</script>
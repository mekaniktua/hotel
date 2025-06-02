<?php
session_start();
include("../database.php");
require_once('../tcpdf/tcpdf.php');

$tanggal_awal = databaseTanggal(amankan($_POST['tanggalAwal']));
$tanggal_akhir = databaseTanggal(amankan($_POST['tanggalAkhir']));
$pegawai_id = dekripsi(amankan($_POST['pID']));

//Data di tabel user apakah sudah ada?
$sData  = " SELECT d.*,t.tanggal_transaksi,t.nama, p.nama nama_pegawai,k.margin,p.uang_makan,p.pegawai_id,k.category
            FROM detail_transaksi d
            JOIN transaksi t ON t.transaksi_id=d.transaksi_id
            JOIN pegawai p ON p.pegawai_id=t.pegawai_id
            JOIN kategori_pegawai k ON k.category=p.category
            WHERE t.is_lunas='1' " . (!empty($pegawai_id) ? " and p.pegawai_id='" . $pegawai_id . "' " : "") . " and  date(tanggal_transaksi) between '" . $tanggal_awal . "' and '" . $tanggal_akhir . "' and d.status_hapus='0' and t.status_hapus='0'
            order by t.tanggal_transaksi";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
?>
<div class="full white_shd margin_bottom_30">
  <div class="table_section padding_infor_info">
    <?php
    $html = '<table class="table table-striped" border="1" style="padding:2px">
      <thead>
        <tr>
          <th>TANGGAL</th>
          <th>NAMA PELANGGAN</th>
          <th>LAYANAN</th>
          <th>BIAYA (Rp.)</th>
          <th>MARGIN (%)</th>
          <th>BIAYA MARGIN (Rp.)</th>
          <th>NAMA PEGAWAI</th>
        </tr>
      </thead>
      <tbody>';

    $total = 0;
    $total_margin = 0;
    // Fetch each row of data from the database
    while ($rData = mysqli_fetch_array($qData)) {
      $total += $rData['harga_layanan'];
      $margin_amount = ($rData['harga_layanan'] * $rData['margin']) / 100;
      $total_margin += $margin_amount;
      $category = $rData['category'];
      $nama_pegawai = $rData['nama_pegawai'];

      if ($pegID != trim($rData['pegawai_id'])) {
        $nPegawai .= "'" . $rData['pegawai_id'] . "',";
        $pegID = trim($rData['pegawai_id']);
      }
      $html .= '<tr class="text-nowrap">
          <td>' . normalTanggal($rData['tanggal_transaksi']) . '</td>
          <td>' . htmlspecialchars($rData['nama']) . '</td>
          <td>' . htmlspecialchars($rData['nama_layanan']) . '</td>
          <td style="text-align: right;">' . (!empty($rData['harga_layanan']) ? angka($rData['harga_layanan']) . ",-" : "0,-") . '</td>
          <td style="text-align: right;">' . htmlspecialchars($rData['margin']) . '</td>
          <td style="text-align: right;">' . (!empty($rData['harga_layanan']) ? angka($margin_amount) . ",-" : "0,-") . '</td>
          <td>' . htmlspecialchars($rData['nama_pegawai']) . '</td>
        </tr>';
    }

    $sMakan = " SELECT p.nama,SUM(a.uang_makan) jumlah
        FROM absensi a
        JOIN pegawai p ON p.pegawai_id=a.pegawai_id
        WHERE date(a.tanggal) between '" . $tanggal_awal . "' and '" . $tanggal_akhir . "' " . (!empty($pegawai_id) ? " and a.pegawai_id='" . $pegawai_id . "' " : "") . "
        GROUP BY a.pegawai_id";
    $qMakan = mysqli_query($conn, $sMakan) or die(mysqli_error($conn));


    $html .= '<tr>
          <td colspan="5">
            <strong>' . ($category == 'Kasir' ? 'Gaji' : 'Uang Makan') . '</strong>
            <ol style="margin-left: 10px;">';

    while ($rMakan = mysqli_fetch_array($qMakan)) {
      $total_makan += $rMakan['jumlah'];
      $html .= '<li>' . $rMakan['nama'] . ' Rp. ' . angka($rMakan['jumlah']) . ',-</li>';
    }

    $html .= '</ol>
          </td>
          <td style="text-align: right;"><strong>' . angka($total_makan) . ',-</strong></td>
          <td style="text-align: right;">&nbsp;</td>
        </tr>
        <tr>
          <th colspan="5" style="text-align: right;">TOTAL</th>
          <th style="text-align: right;">' . angka($total_margin + $total_makan) . ',-</th>
          <th style="text-align: right;">&nbsp;</th>
        </tr>
      </tbody>
    </table>';

    echo $html;
    ?>

    <?php buatPdfPegawai($html, $nama_pegawai, $tanggal_awal, $tanggal_akhir) ?>

    <?php if (file_exists("../laporan/pegawai_" . $nama_pegawai . "_" . $tanggal_awal . "_" . $tanggal_akhir . ".pdf")) { ?>
      <button class="btn btn-success" onclick="buka()">Unduh PDF</button>
    <?php } ?>
  </div>
</div>


<script>
  function buka() {
    window.open("laporan/pegawai_<?php echo $nama_pegawai . "_" . $tanggal_awal . "_" . $tanggal_akhir; ?>.pdf", "_blank");
  }
</script>
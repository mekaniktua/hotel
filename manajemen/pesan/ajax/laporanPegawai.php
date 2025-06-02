<?php
session_start();
include("../database.php");

$tanggal_awal = databaseTanggal(amankan($_POST['tanggalAwal']));
$tanggal_akhir = databaseTanggal(amankan($_POST['tanggalAkhir']));
$pegawai_id = dekripsi(amankan($_POST['pID']));

//Data di tabel user apakah sudah ada?
$sData  = " SELECT d.*,t.tanggal_transaksi,t.nama, p.nama nama_pegawai,k.margin
            FROM detail_transaksi d
            JOIN transaksi t ON t.transaksi_id=d.transaksi_id
            JOIN pegawai p ON p.pegawai_id=t.pegawai_id
            JOIN kategori_pegawai k ON k.category=p.category
            WHERE t.is_lunas='1' ".(!empty($pegawai_id) ? " and p.pegawai_id='".$pegawai_id."' " : "")." and  date(tanggal_transaksi) between '" . $tanggal_awal . "' and '" . $tanggal_akhir . "' and d.status_hapus='0'
            order by t.tanggal_transaksi";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
?>
<div class="full white_shd margin_bottom_30">
  <div class="table_section padding_infor_info">

    <table class="table table-striped" id="datatable">
      <thead>
        <tr> 
          <th>TANGGAL</th>
          <th>NAMA PELANGGAN</th>
          <th>LAYANAN</th>
          <th width="20%">BIAYA (Rp.)</th>
          <th>MARGIN %</th>
          <th width="10%">BIAYA MARGIN (Rp.)</th>
          <th>NAMA PEGAWAI</th>

        </tr>
      </thead>
      <tbody>
        <?php while ($rData  = mysqli_fetch_array($qData)) {
          $i++;;
          $total += $rData['harga_layanan'];
        ?>
          <tr class="text-nowrap"> 
            <td><?php echo normalTanggal($rData['tanggal_transaksi']); ?></td>
            <td><?php echo $rData['nama']; ?></td>
            <td><?php echo $rData['nama_layanan']; ?></td>
            <td style="text-align: right;"><?php echo (!empty($rData['harga_layanan']) ? angka($rData['harga_layanan']) . ",-" : "0,-"); ?></td>
            <td><?php echo $rData['margin']; ?></td>
            <td style="text-align: right;"><?php echo (!empty($rData['harga_layanan']) ? angka(($rData['harga_layanan']) * $rData['margin'] / 100) . ",-" : "0,-"); ?></td>
            <td>
              <?php echo $rData['nama_pegawai']; ?>
            </td>
          </tr>
        <?php }; ?>
        <tr>
          
        </tr>
      </tbody>
    </table>
    <br /><br />
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#datatable').DataTable({
      dom: '<"container-fluid"<"row"<"col"B><"col"l><"col"f>>>rtip',
      buttons: [
        'print', 'excel'
      ],
      lengthMenu: [50, 100, 200, 500],
      order: [
        [2, 'desc']
      ]
    });
  });
</script>
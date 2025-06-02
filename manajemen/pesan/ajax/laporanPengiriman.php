<?php
session_start();
include("../database.php");

$tanggal_awal = databaseTanggal(amankan($_POST['tanggalAwal']));
$tanggal_akhir = databaseTanggal(amankan($_POST['tanggalAkhir']));

//Data di tabel user apakah sudah ada?
$sData  = " SELECT w.*,p.nama
            FROM pesan_wa w
            JOIN pelanggan p ON w.pelanggan_id=p.pelanggan_id
            WHERE date(tanggal) between '" . $tanggal_awal . "' and '" . $tanggal_akhir . "' and status_hapus='0'
            order by tanggal";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));

?>
<div class="panel panel-default">
  <div class="panel-body">
    <div class="row">
      <div class="col-lg-12">
        <table class="table table-striped" id="datatable">
          <thead>
            <tr>
              <th>TANGGAL</th>
              <th>NO HP</th>
              <th>NAMA</th>
              <th>TIPE</th>
              <th>STATUS</th>
              <th>KETERANGAN</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($rData  = mysqli_fetch_array($qData)) { ?>
              <tr class="text-nowrap">
                <td><?php echo normalTanggalJam($rData['tanggal']); ?></td>
                <td><?php echo ($rData['no_hp']); ?></td>
                <td><?php echo ($rData['nama']); ?></td>
                <td><?php echo ($rData['tipe']); ?></td>
                <td><?php echo ($rData['status']); ?></td>
                <td><?php echo ($rData['Please wait']); ?></td>
              </tr>
            <?php }; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


    <script>
      function buka() {
        window.open("laporan/transaksi_<?php echo $tanggal_awal . "_" . $tanggal_akhir; ?>.pdf", "_blank");
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
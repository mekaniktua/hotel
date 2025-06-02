<?php
session_start();
include("../database.php");

//Data di tabel user apakah sudah ada?
$sData  = " SELECT w.*,p.nama
            FROM pesan_wa w
            JOIN pelanggan p ON w.pelanggan_id=p.pelanggan_id
            WHERE status='Terkirim' and status_hapus='0'
            order by tanggal
            LIMIT 10";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));

?>
<div class="table-responsive">
  <table class="table table-bordered table-hover table-striped">
    <thead>
      <tr>
        <th>TANGGAL</th>
        <th>NO HP</th>
        <th>NAMA</th>
        <th>TIPE</th>
        <th>STATUS</th> 
      </tr>
    </thead>
    <tbody>
    <tbody>
      <?php while ($rData  = mysqli_fetch_array($qData)) { ?>
        <tr class="text-nowrap">
          <td><?php echo normalTanggalJam($rData['tanggal']); ?></td>
          <td><?php echo ($rData['no_hp']); ?></td>
          <td><?php echo ($rData['nama']); ?></td>
          <td><?php echo ($rData['tipe']); ?></td>
          <td><?php echo ($rData['status']); ?></td> 
        </tr>
      <?php }; ?>
    </tbody> 
  </table>
</div>
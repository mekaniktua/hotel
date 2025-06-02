<?php
session_start();
include("../database.php");

//Data di tabel user apakah sudah ada?
$sData  = " SELECT p.*
            FROM pelanggan p 
            WHERE status_hapus='0'
            order by tanggal_daftar
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
      </tr>
    </thead>
    <tbody>
    <tbody>
      <?php while ($rData  = mysqli_fetch_array($qData)) { ?>
        <tr class="text-nowrap">
          <td><?php echo normalTanggalJam($rData['tanggal_daftar']); ?></td>
          <td><?php echo ($rData['no_hp']); ?></td>
          <td><?php echo ($rData['nama']); ?></td> 
        </tr>
      <?php }; ?>
    </tbody>
  </table>
</div>
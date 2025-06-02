<?php
session_start();
include("../database.php");

$tanggal = date('Y-m-d');
$nama_pengeluaran = (amankan($_POST['nama_pengeluaran']));
$jumlah = (amankan($_POST['jumlah'])); 
 

  $pengeluaran_id = randomText(10);
  $sInsert  = " INSERT INTO pengeluaran
                SET pengeluaran_id='" . $pengeluaran_id . "',
                    tanggal='" . $tanggal . "', 
                    nama_pengeluaran='" . $nama_pengeluaran . "', 
                    jumlah=" . $jumlah . ", 
                    status_hapus='0'";
  $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));
  $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";

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
    <script>
     pengeluaranList();
    </script>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
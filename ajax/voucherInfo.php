<?php
session_start();
include("../manajemen/database.php");

$voucher_id = dekripsi(amankan($_POST['vID']));

$sCari = "SELECT * FROM voucher WHERE voucher_id = ?";
$stmt = mysqli_prepare($conn, $sCari);
mysqli_stmt_bind_param($stmt, "s", $voucher_id);
mysqli_stmt_execute($stmt);
$qCari = mysqli_stmt_get_result($stmt);
$rVoucher = mysqli_fetch_array($qCari);

if (empty($rVoucher)) {
  $pesan = "<i class='fa fa-times'></i> Voucher not found";
}else{?>
<div class="row">
          <!-- Gambar voucher -->
  <div class="col-md-12 text-center mb-3 mb-md-0">
    <img src="<?php echo $rVoucher['voucher_url'] ?>" alt="<?php echo $rVoucher['voucher_title'] ?>" class="img-fluid rounded">
  </div>
  <!-- Deskripsi voucher -->
    <div class="col-md-12 mt-3">
      <h6><?php echo $rVoucher['voucher_title'] ?? ""; ?></h6>
      <p><?php echo $rVoucher['description'] ?? ""; ?></p>
    <div class="d-flex justify-content-between">
      <div>
        <span class="text-muted">Valid From:</span>
        <p><strong><?php echo normalTanggal($rVoucher['start_date']) ?></strong></p>
      </div>
      <div>
        <span class="text-muted">Valid Until:</span>
        <p><strong><?php echo normalTanggal($rVoucher['end_date']) ?></strong></p>
      </div>
    </div>
  </div>
</div>
      
<?php } ?>


<?php if (!empty($pesan)) { ?>

  <div class="alert alert-danger" role="alert">
    <i class="fa fa-times"></i> <?php echo $pesan; ?>
  </div>
<?php } ?>
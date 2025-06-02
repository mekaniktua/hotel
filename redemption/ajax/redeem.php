<?php
session_start();
include("../../manajemen/database.php");
include("../../kirimMail.php");


$booking_id = (amankan($_POST['bID']));
$voucher_id = dekripsi(amankan($_POST['vID']));

$sCari  = " SELECT *
            FROM voucher
            WHERE voucher_id='" . $voucher_id . "' and status_hapus='0'";
$qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
$rCari  = mysqli_fetch_array($qCari);
$voucherTitle = $rCari['voucher_title'];

if (empty($rCari['voucher_id'])) {
  $pesan = "<i class='fa fa-times'></i> Voucher not found";
}

$sCari  = " SELECT b.*,m.email
            FROM booking b
            JOIN member m ON m.member_id=b.member_id
            WHERE b.booking_id='" . $booking_id . "' and b.status_hapus='0'";
$qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
$rCari  = mysqli_fetch_array($qCari);
$member_id = $rCari['member_id'];
$email = $rCari['email'];

if (empty($rCari['booking_id'])) {
  $pesan = "<i class='fa fa-times'></i> Your booking is not found.";
} else if (($rCari['status']) != 'Completed') {
  $pesan = "<i class='fa fa-times'></i> Your booking is not completed.";
} else if (($rCari['start_date']) > date("Y-m-d")) {
  $pesan = "<i class='fa fa-times'></i> Your booking has not started yet.";
} else if (($rCari['end_date']) < date("Y-m-d")) {
  $pesan = "<i class='fa fa-times'></i> Your booking has already expired.";
}

if (empty($pesan)) {

  $voucher_booking_id = randomText(10);

  $sender = "noreply@orangesky.id";
  $phone = $_SESSION['osg_phone'];
  $emailStatus = redeem($sender, $email, 'Redeem Voucher Succesfull', $voucherTitle, $phone);

  $sUpdate  = " INSERT INTO voucher_booking
                  SET voucher_booking_id='" . ($voucher_booking_id) . "',  
                      created_date = '" . date("Y-m-d H:i:s") . "',
                      voucher_id='" . $voucher_id . "',
                      booking_id='" . $booking_id . "',
                      member_id='" . $member_id . "'";
  $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));

  $pesanSukses = "1";
}
?>
<div class="pesanku">
  <?php if (!empty($pesan)) { ?>
    <div class="alert alert-danger">
      <?php echo $pesan; ?>
    </div>
  <?php }
  if (!empty($pesanSukses)) { ?>
    <p class="text-success"><i class="fa fa-check-circle fa-2x"></i></p>
    <p class="fs-5"><strong>Congratulations!</strong></p>
    <p>You have successfully redeemed the <strong><?php echo $voucherTitle ?></strong> voucher. Enjoy your benefit</p>
    <p><strong>Booking ID:</strong> <?php echo $booking_id ?><br /><small>Time Redeem: <?php echo normalTanggalJam(date("Y-m-d H:i:s")); ?></small></p>

  <?php } ?>
  <script>
    $(".modal").on("hidden.bs.modal", function() {
      window.location = "../";
    });
  </script>
</div>
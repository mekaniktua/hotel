<?php
session_start();
include("../database.php");

$user_id = dekripsi(amankan($_SESSION['orangesky_user_id']));

$booking_id = amankan(dekripsi($_POST['bID'])); 
$description = amankan($_POST['description']);

// Cek apakah booking valid
$sData = "SELECT booking_id
          FROM booking 
          WHERE status_hapus='0'  
          AND booking_id = '" . $booking_id . "' and status='Booked'";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
$rData = mysqli_fetch_array($qData); 

if (empty($rData['booking_id'])) {
  $pesan = "<i class='fa fa-times'></i> Booking not found.";
}

// Kalau valid, lanjut update
if (empty($pesan)) {
  $sUpdate = "UPDATE booking
              SET status = 'Cancelled',
                  cancelled_date = '" . date("Y-m-d H:i:s") . "',
                  user_id = '" . $user_id . "', 
                  description = '" . $description . "'
              WHERE booking_id = '" . $booking_id . "'";

  $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));

  $pesanSukses = "<i class='fa fa-check'></i> Booking $booking_id cancelled.";
}
?>

<div class="pesanku">
  <?php if (!empty($pesan)) { ?>
    <div class="alert alert-danger">
      <?php echo $pesan; ?>
    </div>
  <?php } ?>

  <?php if (!empty($pesanSukses)) { ?>
    <div class="alert alert-success">
      <?php echo $pesanSukses; ?>
    </div>
    <script>
      btnCari.click(); // Refresh data
      setTimeout(function() {
        $("#modalInfo").modal('hide');
        btnCari.click();
      }, 2000);
    </script>
  <?php } ?>
</div>
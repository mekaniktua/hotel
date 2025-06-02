<?php
session_start();
include("../database.php");

$user_id = dekripsi(amankan($_SESSION['orangesky_user_id']));

$booking_id = amankan(dekripsi($_POST['bID']));
$room_number = amankan($_POST['room_number']);
$description = amankan($_POST['description']);

// Cek apakah booking valid
$sData = "SELECT booking_id,point_used,point_earned,member_id 
          FROM booking 
          WHERE status_hapus='0'  
          AND booking_id = '" . $booking_id . "' and status='Booked'";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
$rData = mysqli_fetch_array($qData);
$point_used = $rData['point_used'];
$point_earned = $rData['point_earned'];

if (empty($rData['booking_id'])) {
  $pesan = "<i class='fa fa-times'></i> Booking not found.";
}

// Kalau valid, lanjut update
if (empty($pesan)) {
  $sUpdate = "UPDATE booking
              SET room_number = '" . $room_number . "',
                  status = 'Approved',
                  approved_date = '" . date("Y-m-d H:i:s") . "',
                  user_id = '" . $user_id . "',
                  room_number = '" . $room_number . "',
                  description = '" . $description . "'
              WHERE booking_id = '" . $booking_id . "'";

  $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));

  //Update point on member
  $point = $point_earned- $point_used;
  $member_id = $rData['member_id'];

  $sUpdate = "UPDATE member
              SET point = point + $point
              WHERE member_id = '" . $member_id . "'";
  $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));

  //Update member_log
  $member_log_id = randomText(10);
  $sInsert = "INSERT INTO member_log
              SET created_date = '" . date("Y-m-d H:i:s") . "',
                  member_id='" . $member_id . "',
                  user_id='" . $user_id . "',
                  type='Booking',
                  point = " . $point_earned . ",
                  description = 'Point added for your booking – sweet!'";
  $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));

  $member_log_id = randomText(10);
  $sInsert = "INSERT INTO member_log
              SET created_date = '".date("Y-m-d H:i:s")."',
                  member_id='".$member_id."',
                  user_id='".$user_id."',
                  type='Booking',
                  point = -".$point_used.",
                  description = 'Point used for your booking'";
  $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));


  $pesanSukses = "<i class='fa fa-check'></i> Booking $booking_id approved.";
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
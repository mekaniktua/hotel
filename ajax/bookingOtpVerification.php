<?php
session_start();
include("../manajemen/database.php"); 

$email = dekripsi(amankan($_POST['umail'] ?? ''));
$confirmation_code = amankan($_POST['otp'] ?? '');  
$booking_id = dekripsi(amankan($_POST['bID'] ?? ''));  

$sCari  = " SELECT *
            FROM member
            WHERE email='" . $email . "' and confirmation_code ='".$confirmation_code."' and status_hapus='0'";
$qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
$rCari  = mysqli_fetch_array($qCari);
$member_id = $rCari['member_id'] ?? '';
$enc_email = enkripsi($rCari['email'] ?? '');

if (empty($member_id)) {
  $pesan = "<i class='fa fa-times'></i> Sorry, wrong OTP. Please check your email ".maskEmail($email)." and try again ";
} else {
  $sUpdate = " UPDATE booking
                SET member_id='" . $rCari['member_id'] . "'
                WHERE booking_id='" . $booking_id . "'";
  $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));

  //insert to cookie
  setcookie('osg_member_id', enkripsi($member_id), time() + (86400 * 7), "/");
  setcookie('osg_member_email', ($rCari['email']), time() + (86400 * 7), "/");

   //insert to session
  $_SESSION['osg_member_id']    = $_COOKIE['osg_member_id'] ?? enkripsi($member_id);
  $_SESSION['osg_member_email'] = ($_COOKIE['osg_member_email'] ?? $rCari['email']);
  $pesanSukses = "<i class='fa fa-check'></i> OTP verified successfully. Please wait...";
 
}
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
      $('.pesanku').delay(2000).fadeOut('slow', function() {
         window.location.href = '?menu=booking&bID=<?php echo enkripsi($booking_id); ?>'; // Login
      });
    </script>
  <?php } ?>

</div>
<?php
session_start();
include("../../manajemen/database.php");
include("../../kirimMail.php");

$email = dekripsi(amankan($_POST['umail']));
$password = amankan($_POST['password']);
$confirmPassword = amankan($_POST['confirmUpass']);

$sCari  = " SELECT *
            FROM member
            WHERE email='" . $email . "' and status_hapus='0'";
$qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
$rCari  = mysqli_fetch_array($qCari);
$member_id = $rCari['member_id'];
$enc_email = enkripsi($rCari['email']);

if (empty($rCari['member_id'])) {
  $pesan = "<i class='fa fa-times'></i> Email not found";
}
if ($password !== $confirmPassword) {
  $pesan = "<i class='fa fa-times'></i> Your new passwords do not match.";
}
if (empty($pesan)) {
 
  $sender = "noreply@orangesky.id";
  $phone = $_SESSION['osg_phone'];
  $emailStatus = resetPass($sender, $email, 'Your OrangeSky Account Password Has Been Successfully Updated', $phone);

  if ($emailStatus == 1) {
    $sUpdate  = " UPDATE member
                  SET password='" . md5($confirmPassword) . "'
                  WHERE member_id='" . $member_id . "'";
    $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
    $pesanSukses = "<i class='fa fa-check'></i> Password reset successful. Please log in again.";
  } else {
    $pesan = "<i class='fa fa-times'></i> We were unable to send an email to your address. Reset Password was not completed.";
  }
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
        window.location.href = './'; // Login
      });
    </script>
  <?php } ?>

</div>
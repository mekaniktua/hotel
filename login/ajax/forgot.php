<?php
session_start();
include("../../manajemen/database.php");
include("../../kirimMail.php");

$email = (amankan($_POST['umail'])); 

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
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $pesan = "<i class='fa fa-times'></i> Not a valid email";
}
if (empty($email)) {
  $pesan = "<i class='fa fa-times'></i> Email field still empty";
}
if (($rCari['status']) != 'Active') {
  $pesan = "<i class='fa fa-times'></i> Your membership is not active";
}
if (empty($pesan)) {

$confirmation_code = randomAngka(6);
$enc_code = enkripsi($confirmation_code);
$sender = "noreply@orangesky.id";
$phone = $_SESSION['osg_phone'];
$emailStatus = forgot($sender, $email, 'Forgot Password OrangeSky Account', $enc_email, $enc_code, $phone);

  if ($emailStatus == 1) {
    $tomorrow = date('Y-m-d H:i:s', strtotime('+1 day')); 

    $sUpdate  = " UPDATE member
                  SET confirmation_code='" . ($confirmation_code) . "',  
                      link_expired = '".$tomorrow."'
                  WHERE member_id='".$member_id."'";
    $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
    $pesanSukses = "<i class='fa fa-check'></i> Please check your email ".$email." (including the spam folder) for detail inctruction.";
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
     
  <?php } ?>  

</div>
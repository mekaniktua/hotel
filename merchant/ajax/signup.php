<?php
session_start();
include("../../manajemen/database.php");
include("../../kirimMail.php");

$email = (amankan($_POST['umail']));
$password = (amankan($_POST['upass']));
$confirm_password = (amankan($_POST['confirmUpass']));

$sCari  = " SELECT *
            FROM member
            WHERE email='" . $email . "' and status_hapus='0'";
$qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
$rCari  = mysqli_fetch_array($qCari);

if (!empty($rCari['member_id'])) {
  $pesan = "<i class='fa fa-times'></i> Email " . $rCari['email'] . " has been used before";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $pesan = "<i class='fa fa-times'></i> Not a valid email";
}
if (empty($email)) {
  $pesan = "<i class='fa fa-times'></i> Email field still empty";
}
if (empty($password)) {
  $pesan = "<i class='fa fa-times'></i> Password field still empty";
}
if ($confirm_password != $password) {
  $pesan = "<i class='fa fa-times'></i> Confirm password not match";
}
if (empty($pesan)) {

  $member_id = randomText(15);
  $confirmation_code = randomAngka(6);
  $sender = "noreply@orangesky.id";
  $emailStatus = registration($sender, $email, 'Registration Activation', $enc_email, $address, $phone);

  if ($emailStatus == 1) {
    $sInsert  = " INSERT INTO member
                SET member_id='" . $member_id . "',
                    created_date='" . date("Y-m-d H:i:s") . "',
                    email='" . $email . "',
                    status='Pending',
                    member_type='Silver', 
                    tmt_tipe_member='" . date("Y-m-d H:i:s") . "',
                    password='" . md5($password) . "',
                    confirmation_code='" . ($confirmation_code) . "',  
                    status_hapus='0'";
    $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));
    $pesanSukses = "<i class='fa fa-check'></i> Registration successful. Please check your email ".$email." (including the spam folder) for your activation link.";
  } else {
    $pesan = "<i class='fa fa-times'></i> We were unable to send an email to your address. Registration was not completed.";
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
      $(".modal").on("hidden.bs.modal", function() {
       window.location = "./";
      });
    </script>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
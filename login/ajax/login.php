<?php
session_start();
include("../../manajemen/database.php");
include("../../kirimMail.php");

$email = (amankan($_POST['umail']?? '' ));
$password = (amankan($_POST['upass']?? '' ));
$redirect_uri = (amankan($_POST['redirect_uri']?? '' ));

$sCari  = " SELECT *
            FROM member
            WHERE email='" . $email . "' and password='" . md5($password) . "' and status_hapus='0'";
$qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
$rCari  = mysqli_fetch_array($qCari);

if (empty($rCari['member_id'])) {
  $pesan = "<i class='fa fa-times'></i> Email or password is not correct";
}
else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $pesan = "<i class='fa fa-times'></i> Not a valid email";
}
else if (($rCari['status'])!='Active') {
  $pesan = "<i class='fa fa-times'></i> Your account is not active, click the activation link from email";
}
else if (empty($email)) {
  $pesan = "<i class='fa fa-times'></i> Email field still empty";
}
else if (empty($password)) {
  $pesan = "<i class='fa fa-times'></i> Password field still empty";
}
if (empty($pesan)) {
  //generate otp
  $confirmation_code = rand(100000, 999999);
  $sUpdate = "UPDATE member 
              SET confirmation_code='" . $confirmation_code . "',
                  confirmation_code_expired=DATE_ADD(NOW(), INTERVAL 10 MINUTE)
         WHERE member_id='" . $rCari['member_id'] . "'";
  mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));

  //send email otp
  
    $title = "Your OTP Code - Orange Sky";
    $otp = $confirmation_code;
    $sender = "noreply@orangesky.id";
    $recepient = $email;
    if($_SERVER['HTTP_HOST'] !='localhost'){
        $sendOTP = sendOTP($sender, $recepient, $title, $otp);
      }else{
        $sendOTP = "1";
      }
      
    if ($sendOTP == "1") {?>
      <!-- //redirect to otp page -->
      <script>
        window.location.href = '?menu=otp&e=<?php echo enkripsi($email); ?>&c=<?php echo enkripsi($confirmation_code); ?>&redirect_uri=<?php echo $redirect_uri; ?>';
      </script>
    <?php } else {
      $pesan = "<i class='fa fa-times'></i> Failed to send OTP to your email " . maskEmail($email);
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
    <?php if(empty($redirect_uri)){?>
    <script>
      $('.pesanku').delay(2000).fadeOut('slow', function() {
        window.location.href = '../?menu=member'; // Ganti dengan URL tujuan
      });
    </script>
    <?php }else{?>
    <script>
      $('.pesanku').delay(2000).fadeOut('slow', function() {
        window.location.href = '<?php echo $redirect_uri ?>'; // Ganti dengan URL tujuan
      });
    </script>
  <?php }
} ?>  

</div>
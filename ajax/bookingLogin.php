<?php
session_start();
include("../manajemen/database.php");
include("../kirimMail.php");

$email = (amankan($_POST['umail'] ?? ''));
$password = (amankan($_POST['upass'] ?? ''));
$booking_id = dekripsi(amankan($_POST['bID'] ?? ''));

$sCari  = " SELECT *
            FROM member
            WHERE email='" . $email . "' and password='" . md5($password) . "' and status_hapus='0'";
$qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
$rCari  = mysqli_fetch_array($qCari);
$member_id = $rCari['member_id'] ?? '';

if (empty($rCari['member_id'])) {
  $pesan = "<i class='fa fa-times'></i> Email or password is not correct";
}
else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $pesan = "<i class='fa fa-times'></i> Not a valid email";
}
else if (($rCari['status'] ?? '')!='Active') {
  $pesan = "<i class='fa fa-times'></i> Your account is not active, click the activation link from email";
}
else if (empty($email)) {
  $pesan = "<i class='fa fa-times'></i> Email field still empty";
}
else if (empty($password)) {
  $pesan = "<i class='fa fa-times'></i> Password field still empty";
}
if (empty($pesan)) {

  //cari booking
  $sCariBooking  = " SELECT *
            FROM booking
            WHERE booking_id='" . $booking_id . "' and status_hapus='0'";
  $qCariBooking = mysqli_query($conn, $sCariBooking) or die(mysqli_error($conn));
  $rCariBooking  = mysqli_fetch_array($qCariBooking); 

  if(empty($rCariBooking['booking_id'])){
    $pesan = "<i class='fa fa-times'></i> Booking not found";
  }else if($rCariBooking['status']=='Draft' && empty($rCariBooking['member_id'])){//jika draft dan belum ada member maka update booking

    $code = random_int(100000, 999999);
    $sUpdate = " UPDATE member
                SET confirmation_code='" . $code . "', 
                    confirmation_code_expired='" . date("Y-m-d H:i:s", strtotime('+10 minutes')) . "'
                WHERE member_id='" . $member_id . "'";
    $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
    
    //send email otp
  
    $title = "Your OTP Code - Orange Sky";
    $otp = $code;
    $sender = "noreply@orangesky.id";
    $recepient = $email;

    if($_SERVER['HTTP_HOST'] !='localhost'){
      $sendOTP = sendOTP($sender, $recepient, $title, $otp);
    }else{
      $sendOTP = "1";
    }
    
    if ($sendOTP == "1") {
      //include ajax/bookingOtp.php
      
      include("bookingOtp.php");
    } else {
      $pesan = "<i class='fa fa-times'></i> Failed to send OTP to your email " . maskEmail($email);
    } 
  }else{//set session lalu kembalikan ke halaman member
    $_SESSION['osg_member_id'] = enkripsi($rCari['member_id']);
    $_SESSION['osg_member_email'] = ($rCari['email']);  
  ?>
    
    <script>
      
       window.location.href = '?menu=member'; // Ganti dengan URL tujuan
    </script>
<?php  }
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
        window.location.href = '?menu=booking&bID=<?php echo enkripsi($booking_id); ?>'; // Ganti dengan URL tujuan
      });
    </script>
    <?php } ?> 

</div>
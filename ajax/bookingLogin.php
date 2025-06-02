<?php
session_start();
include("../manajemen/database.php");

$email = (amankan($_POST['umail']));
$password = (amankan($_POST['upass']));
$booking_id = dekripsi(amankan($_POST['bID']));

$sCari  = " SELECT *
            FROM member
            WHERE email='" . $email . "' and password='" . md5($password) . "' and status_hapus='0'";
$qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
$rCari  = mysqli_fetch_array($qCari);

if (empty($rCari['member_id'])) {
  $pesan = "<i class='fa fa-times'></i> Email or password is not correct";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $pesan = "<i class='fa fa-times'></i> Not a valid email";
}
if (($rCari['status'])!='Active') {
  $pesan = "<i class='fa fa-times'></i> Your account is not active, click the activation link from email";
}
if (empty($email)) {
  $pesan = "<i class='fa fa-times'></i> Email field still empty";
}
if (empty($password)) {
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

    $sUpdate = " UPDATE booking
                SET member_id='" . $rCari['member_id'] . "'
                WHERE booking_id='" . $booking_id . "'";
    $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));

    $_SESSION['osg_member_id'] = enkripsi($rCari['member_id']);
    $_SESSION['osg_member_email'] = ($rCari['email']); 

    $pesanSukses = "<i class='fa fa-check'></i> Login success, please wait!!";
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
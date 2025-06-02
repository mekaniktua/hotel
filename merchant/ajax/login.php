<?php
session_start();
include("../../manajemen/database.php");

$email = (amankan($_POST['umail']));
$password = (amankan($_POST['upass']));
$redirect_uri = (amankan($_POST['redirect_uri']));

$sCari  = " SELECT *
            FROM merchant
            WHERE email='" . $email . "' and password='" . md5($password) . "' and status_hapus='0'";
$qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
$rCari  = mysqli_fetch_array($qCari);

if (empty($rCari['merchant_id'])) {
  $pesan = "<i class='fa fa-times'></i> Email or password is not correct";
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
if (empty($pesan)) {

  $_SESSION['osg_merchant_id'] = enkripsi($rCari['merchant_id']);
  $_SESSION['osg_merchant_email'] = ($rCari['email']);

  $pesanSukses = "<i class='fa fa-check'></i> Login success, please wait!!";
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
        window.location.href = '../?menu=merchant'; // Ganti dengan URL tujuan
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
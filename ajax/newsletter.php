<?php
session_start();
include("../manajemen/database.php");

$email = ($_POST['email']);


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $pesan = "Please enter a valid email address";
}
 
if (empty($pesan)) {
  $sCari = " SELECT * FROM newsletter WHERE email='" . $email . "'";
  $qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
  $jml = mysqli_num_rows($qCari);
  if ($jml > 0) {
    $pesan = "Email already registered";
  }
  if (empty($pesan)) {
    $newsletter_id = randomText(10);
    $sInsert  = " INSERT INTO newsletter  
                      SET newsletter_id='".$newsletter_id."',
                          email='" . $email . "',
                          created_date='" . date('Y-m-d H:i:s') . "'";
    $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));
    $pesanSukses = "Thank you for subscribing to our newsletter. we will send you the latest news and voucher";
  }
}
?>


<?php if (!empty($pesan)) { ?>

  <div class="alert alert-danger" role="alert">
    <i class="fa fa-exclamation-triangle"></i> <?php echo $pesan; ?>
  </div>
<?php }
if (!empty($pesanSukses)) { ?>
  <div class="alert alert-success" role="alert">  
    <i class="fa fa-check"></i> <?php echo $pesanSukses; ?>
  </div>
<?php } ?>
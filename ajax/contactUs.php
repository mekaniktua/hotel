<?php
session_start();
include("../manajemen/database.php");
include("../kirimMail.php");

$name = ($_POST['name']);
$email = ($_POST['email']);
$mesage = ($_POST['message']);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $pesan = "Please enter a valid email address";
}

 
if (empty($pesan)) {
  //Send Email
  $status = contactUs($email, "booknow@orangeskygroup.co.id", "Contact Us", $name, $message);
  if ($status == "1") {
    $pesanSukses = "Thank you for contacting us. we will reply you as soon as possible";
  } else {
    $pesan = $status;
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
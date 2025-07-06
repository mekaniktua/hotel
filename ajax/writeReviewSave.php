<?php
session_start();
include("../manajemen/database.php");

$member_id = dekripsi(amankan($_POST['mID']));
$booking_id = dekripsi(amankan($_POST['bID']));
$stars = (amankan($_POST['stars']));
$reviewText = (amankan($_POST['reviewText'])); 

$sCek  = " SELECT *
            FROM review  
            WHERE booking_id='" . $booking_id . "' and member_id='".$member_id."'";
$qCek = mysqli_query($conn, $sCek) or die(mysqli_error($conn));
$rCek  = mysqli_fetch_array($qCek);  

if (!empty($rCek['booking_id'])) {
  $pesan = "<i class='fa fa-times'></i> You have already write review for this booking";
}else if (empty($stars)) {
  $pesan = "<i class='fa fa-times'></i> Please select your rating";
}else if (empty($reviewText)) {
  $pesan = "<i class='fa fa-times'></i> Please write your review";
}
if (empty($pesan)) {
  $review_id = randomText(15);
  $sInsert = "INSERT INTO review (review_id,created_date, member_id, booking_id, star, review_text) VALUES ('".$review_id."','".date("Y-m-d H:i:s")."', '".$member_id."', '".$booking_id."', ".$stars.", '".$reviewText."')";
    
  if (mysqli_query($conn, $sInsert)) {
      $pesanSukses = "<i class='fa fa-check'></i> Thank you for your review";
  } else {
      die('Error: ' . mysqli_error($conn));
  }

}
?>


<?php if (!empty($pesan)) { ?>

  <div class="alert alert-danger">
    <?php echo $pesan; ?>
  </div> 
<?php }else if(!empty($pesanSukses)){?>
  <div class="alert alert-success">
    <?php echo $pesanSukses; ?>
  </div> 
<?php }?>

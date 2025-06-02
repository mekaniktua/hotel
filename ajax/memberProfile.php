<?php
session_start();
include("../manajemen/database.php");

$member_id = dekripsi(amankan($_SESSION['osg_member_id']));
$fullname = (amankan($_POST['fullname']));
$email = (amankan($_POST['email']));
$mobile_number = (amankan($_POST['mobile_number']));
$gender = (amankan($_POST['gender']));
$nationality = (amankan($_POST['nationality']));
$date = (amankan($_POST['date']));
$month = (amankan($_POST['month']));  
$year = (amankan($_POST['year']));
$birthdate = $year . "-" . $month . "-" . $date;

if (empty($fullname)) {
  $pesan = "Fullname field still empty";
}if (empty($email)) {
  $pesan = "Email field still empty";
}if (empty($mobile_number)) {
  $pesan = "Mobile Number field still empty";
}if (empty($gender)) {
  $pesan = "Please select your gender";
}if (empty($date)) {
  $pesan = "Please select your date of birth";  
}if (empty($month)) {
  $pesan = "Please select your month of birth";
}if (empty($year)) {
  $pesan = "Please select your year of birth";
}if (empty($nationality)) { 
  $pesan = "Nationality field still empty";
}if (empty($pesan)) {
  $sUpdate  = " UPDATE member
                  SET fullname='" . $fullname . "',
                      email='" . $email . "', 
                      mobile_number='" . $mobile_number . "',
                      birthdate='" . $birthdate . "',
                      nationality='" . $nationality . "',
                      gender='" . $gender . "'
                WHERE member_id='" . $member_id . "'";
  $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));             
  $pesanSukses = "Data telah disimpan";
}
?>


<?php if (!empty($pesan)) { ?>

  <div class="alert alert-danger">
    <i class="fa fa-times"></i>
      <?php echo $pesan; ?>
  </div>
<?php }
if (!empty($pesanSukses)) { ?>
  <div class="alert alert-success">
    <i class="fa fa-check"></i>
      <?php echo $pesanSukses; ?>
  </div> 
<?php } ?>
<?php
session_start();
include("../manajemen/database.php");

$member_id = dekripsi(amankan($_SESSION['osg_member_id']));
$member_email = (amankan($_SESSION['osg_member_email']));
$booking_id = dekripsi(amankan($_POST['bID']));
$point_used = (amankan($_POST['point_used']));
$total_price = dekripsi(amankan($_POST['tp']));

$sData  = " SELECT b.*
            FROM booking b  
            WHERE booking_id='" . $booking_id . "' and b.status_hapus='0'";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
$rData  = mysqli_fetch_array($qData);
$total_nilai_rupiah = $rData['total_nilai_rupiah']; 
 

$sMember  = " SELECT *
            FROM member
            WHERE status_hapus='0' and member_id='" . $member_id . "'";
$qMember = mysqli_query($conn, $sMember) or die(mysqli_error($conn));
$rMember = mysqli_fetch_array($qMember);
$point = $rMember['point'];

if ($point_used > $point) {
  $pesan = "Your point is not enough";
}
if ($point_used < 0) {
  $pesan = "Your point is not valid";
}
if (empty($point_used)) {
  $point_used = 0;
}


if (empty($pesan)) {
  $nilai_rupiah_point = ($point_used * $_SESSION['nilai_per_point']);



  $sData  = " SELECT b.*
              FROM booking b
              WHERE b.status_hapus='0' and b.booking_id='" . $booking_id . "' and b.member_id='" . $member_id . "'";
  $qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
  $rData = mysqli_fetch_array($qData);

  $nilai_point = round(($point_used * $_SESSION['nilai_per_point']) / $_SESSION['nilai_rupiah'], 1);
  $total_price = $total_price - $nilai_point;

  if (empty($rData['booking_id'])) {
    $pesan = "booking not found";
  }
  if (empty($pesan)) {
    $sInsert  = " UPDATE booking
                    SET total=" . $total_price . ", 
                        point_used='" . $point_used . "',
                        nilai_point='" . $nilai_point . "', 
                        nilai_rupiah_point='" . $nilai_rupiah_point . "',
                        currency='" . $_SESSION['osg_currency'] . "'
                  WHERE booking_id='" . $booking_id . "' and member_id='" . $member_id . "'";
    $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));
    $pesanSukses = "<i class='fa fa-check'></i>";
  }
}
?>


<?php if (!empty($pesan)) { ?>

  <div class="alert alert-danger">
    <?php echo $pesan; ?>
  </div>
  <script>
    $("#modalInfo").modal('show');
  </script>
<?php }
if (!empty($pesanSukses)) { ?>
  <script>
    $("#divPointUsed").removeClass("d-none").show();
    $("#point_used_price").html('<?php echo $point_used; ?>');
    $("#nilai_point").html('-<?php echo ($_SESSION['osg_currency']=='IDR' ? angka($nilai_point) : number_format($nilai_point,1)); ?>');
    $("#total_price").html('<?php echo $_SESSION['osg_currency'] . " " . ($_SESSION['osg_currency'] == 'IDR' ? angka($total_price) : number_format($total_price, 1)); ?>');
  </script>
<?php } ?>
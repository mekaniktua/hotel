<?php
session_start();
include("../manajemen/database.php");
include("../kirimMail.php");

$member_id = dekripsi(amankan($_SESSION['osg_member_id']));
$member_email = (amankan($_SESSION['osg_member_email']));
$booking_id = dekripsi(amankan($_POST['bID']));
$payment_method = (amankan($_POST['payment_method']));
$special_request = (amankan($_POST['special_request']));
$total_price = dekripsi(amankan($_POST['tp']));

$sData  = " SELECT b.*,tk.room_type,p.property_name
            FROM booking b
            join room_type tk on tk.room_type_id=b.room_type_id
            JOIN property p ON p.property_id=b.property_id
            WHERE b.status_hapus='0' and b.booking_id='" . $booking_id . "' and b.member_id='" . $member_id . "'";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
$rData = mysqli_fetch_array($qData);

if (empty($rData['booking_id'])) {
  $pesan = "booking not found";
}
if (empty($pesan)) {
  $startDate = new DateTime($rData['start_date']);
  $startDate->modify('+1 day');
  $expiredDate = $startDate->format('Y-m-d') . ' 14:00:00';

  $sInsert  = " UPDATE booking
                  SET status='Booked', 
                      expired_date='" . $expiredDate ."',
                      total='" . $total_price . "',
                      currency='" . $_SESSION['osg_currency'] . "',
                      payment_method='" . $payment_method . "', 
                      special_request='" . $special_request . "'
                WHERE booking_id='" . $booking_id . "' and member_id='" . $member_id . "'";
  $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));
  $pesanSukses = "<i class='fa fa-check'></i>";

  //send email
  $sMember  = " SELECT *
              FROM member
              WHERE status_hapus='0' and member_id='" . $member_id . "'";
  $qMember = mysqli_query($conn, $sMember) or die(mysqli_error($conn));
  $rMember = mysqli_fetch_array($qMember);
  $sender   = 'noreply@orangesky.id';
  $recepient = $rMember['email'];
  $title    = 'Booking Confirmation Orange Sky - ' . $rData['booking_id'];
  $start_date = $rData['start_date'];
  $end_date = $rData['end_date']; 
  $total_price = $rData['total'];
  $payment_method = $rData['payment_method'];
  $special_request = $rData['special_request'];
  $room_type = $rData['room_type'];
  $property_name = $rData['property_name'];
  $address = $_SESSION['osg_address'];
  $phone = $_SESSION['osg_phone'];
  $statusEmail = bookingConfirmation($sender, $recepient, $title, $booking_id,$room_type,$property_name, $start_date, $end_date,$total_price, $payment_method, $special_request,$address,$phone);
}
?>


<?php if (!empty($pesan)) { ?>

  <script>
    window.open("?menu=error&errmsg=<?php echo enkripsi($pesan); ?>", "_self");
  </script>
<?php }
if (!empty($pesanSukses)) { ?>
  <script>
    window.open("?menu=confirmation&bID=<?php echo enkripsi($booking_id); ?>&mID=<?php echo enkripsi($member_id); ?>&email=<?php echo ($member_email); ?>", "_self");
  </script>
<?php } ?>
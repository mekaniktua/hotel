<?php
session_start();
include("../manajemen/database.php");
include("../kirimMail.php"); 


$member_id = dekripsi(amankan($_SESSION['osg_member_id'])); 
$booking_id = dekripsi(amankan($_POST['bID']));
$payment_method = (amankan('PayNow'));
$special_request = (amankan($_POST['special_request']));
$total_price = dekripsi(amankan($_POST['tp']));

$sData  = " SELECT b.*,tk.room_type,p.property_name
            FROM booking b
            join room_type tk on tk.room_type_id=b.room_type_id
            JOIN property p ON p.property_id=b.property_id
            WHERE b.status_hapus='0' and b.booking_id='" . $booking_id . "' and b.member_id='" . $member_id . "'";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
$rData = mysqli_fetch_array($qData);

//invoice number
$invoice_number = $rData['invoice_number'];

if (empty($rData['booking_id'])) {
  $pesan = "booking not found";
}
if (empty($pesan)) {

  $sMember  = " SELECT *
              FROM member
              WHERE status_hapus='0' and member_id='" . $member_id . "'";
  $qMember = mysqli_query($conn, $sMember) or die(mysqli_error($conn));
  $rMember = mysqli_fetch_array($qMember);

  $nama = $rMember['fullname'] ? $rMember['fullname'] : 'Noname';
  $sender   = 'noreply@orangesky.id';
  $recepient = $rMember['email'];
  $title    = 'Booking Confirmation '. $rData['property_name'] . ' - ' . $rData['booking_id'];
  $start_date = $rData['start_date'];
  $end_date = $rData['end_date']; 
  $total_price = $rData['total'];  
  $room_type = $rData['room_type'];
  $property_name = $rData['property_name'];
  $address = $_SESSION['osg_address'];
  $phone = $_SESSION['osg_phone'];
  
  if($payment_method == 'PayNow'){ 
    if($env =='production'){
      $statusXenditPayment = xenditPayment($booking_id,$nama, $recepient, $total_price);
      //$statusDokuPayment = dokuHostedCheckout($booking_id,$invoice_number,$total_price,$_SESSION['osg_currency'],$nama,$rMember['email'],$rMember['mobile_number'],$member_id);
    }else{
      $statusXenditPayment = xenditPayment($booking_id,$nama, $recepient, $total_price);
     // $statusDokuPayment = dokuHostedCheckoutLocalhost($booking_id,$invoice_number,$total_price,$_SESSION['osg_currency'],$nama,$rMember['email'],$rMember['mobile_number'],$member_id);      
    }
    if ($statusXenditPayment['invoice_url']) {
      //set expired date +60 minutes
      $startDate = new DateTime($rData['created_date']);
      $startDate->modify('+60 minutes');
      $expiredDate = $startDate->format('Y-m-d H:i:s'); 
      $payment_link = $statusXenditPayment['invoice_url'];
      $invoice_id = $statusXenditPayment['invoice_id'];

    
      //update booking 
      $sUpdate  = " UPDATE booking
                      SET status='Waiting', 
                          expired_date='" . $expiredDate ."',
                          total='" . $total_price . "',
                          currency='" . $_SESSION['osg_currency'] . "',
                          payment_method='" . $payment_method . "',  
                          payment_link='" . $payment_link . "',
                          special_request='" . $special_request . "',
                          invoice_id='" . $invoice_id . "'
                    WHERE booking_id='" . $booking_id . "' and member_id='" . $member_id . "'";
      $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
      $pesanSukses = "1";
    }else{
      $payment_link = '';  
      $pesan = "Failed to process payment: " . $statusXenditPayment['error'];
    }
  }else{ 
    

     $statusEmail = bookingConfirmation($sender, $recepient, $title, $booking_id,$room_type,$property_name, $start_date, $end_date,$total_price, $payment_method, $special_request,$address,$phone);

      //update booking
      $payment_link = '';
      $sUpdate  = " UPDATE booking
                      SET status='Booked',  
                          total='" . $total_price . "',
                          currency='" . $_SESSION['osg_currency'] . "',
                          payment_method='" . $payment_method . "', 
                          special_request='" . $special_request . "',
                          payment_link='" . $payment_link . "'
                    WHERE booking_id='" . $booking_id . "' and member_id='" . $member_id . "'";
      $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
      $pesanSukses = "1";
  }
}
?>


<?php if (!empty($pesan)) { ?>

  <script>
    window.open("?menu=error&errmsg=<?php echo enkripsi($pesan); ?>", "_self");
  </script>
<?php }
if (!empty($pesanSukses) && $payment_method == "PayNow") { ?>
  <div id="loading-message" style="text-align:center; font-family:Arial; padding:20px;">
    Redirecting to payment... Please wait.
  </div>
  <script>
    // Tampilkan pesan loading, lalu redirect setelah 1 detik
    setTimeout(function() {
      window.open("<?php echo $payment_link; ?>", "_self");
    }, 1000); // 1000 milidetik = 1 detik
  </script> 
<?php }else if (!empty($pesanSukses) && $payment_method == "PayHotel") { ?>
  <script>
    window.open("?menu=confirmation&bID=<?php echo enkripsi($booking_id); ?>&mID=<?php echo enkripsi($member_id); ?>&email=<?php echo ($member_email); ?>", "_self");
  </script>
<?php } ?>
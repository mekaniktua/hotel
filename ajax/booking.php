<?php
session_start();
include("../manajemen/database.php");

$member_id = dekripsi(amankan($_SESSION['osg_member_id'] ?? ''));
$room_id = dekripsi(amankan($_POST['kID'] ?? ''));
$property_id = dekripsi(amankan($_POST['pID'] ?? ''));
$adult =  dekripsi(amankan($_POST['adult'] ?? 1));
$child = dekripsi(amankan($_POST['child'] ?? 0));
$rooms = dekripsi(amankan($_POST['rooms'] ?? 1));
$total_price = dekripsi(amankan($_POST['tp'] ?? 0));
$start_date = (amankan($_POST['start_date'] ?? ''));
$end_date = (amankan($_POST['end_date'] ?? ''));

$nights = lama($start_date, $end_date);

if(!isset($adult) || !isset($child) || !isset($rooms) || !isset($total_price)){
  $pesan = "Failed booking. Please make other booking";
}else{

  if($_SESSION['osg_currency'] != 'IDR'){
    $total_price = round($total_price,1) * $rooms * $nights;
    $total_nilai_rupiah = $total_price * $_SESSION['nilai_rupiah'];
    
  }else{
    $total_price = intval($total_price) * intval($rooms) * $nights;
    $total_nilai_rupiah = $total_price; 
  }
  $point_earned = (($_SESSION['persen_booking_point'] * $total_nilai_rupiah / 100)/$_SESSION['nilai_per_point']);

  if (empty($child)) {
    $child = 0;
  }

  $sData  = " SELECT k.*
              FROM room k
              JOIN room_type tk On tk.room_type_id=k.room_type_id
              WHERE k.status_hapus='0' and k.room_id='" . $room_id . "' and k.property_id='" . $property_id . "'";
  $qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
  $rData = mysqli_fetch_array($qData);
  $room_type_id = $rData['room_type_id'];


  if (empty($rData['room_id'])) {
    $pesan = "Failed booking. Please make other booking";
  }
  if (empty($pesan)) {
    $booking_id = randomText(10);
    $invoice_number = date('YmdHis').rand(0,9);
    $sInsert  = " INSERT INTO booking
                    SET booking_id='" . $booking_id . "',
                        invoice_number='" . $invoice_number . "',
                        created_date='" . date('Y-m-d H:i:s') . "', 
                        start_date='" . $start_date . "', 
                        end_date='" . $end_date . "',
                        room_id='" . $room_id . "', 
                        room_type_id='" . $room_type_id . "',
                        property_id='" . $property_id . "',
                        rooms=" . $rooms . ",
                        nights=" . $nights . ",
                        adult=" . $adult . ",
                        child=" . $child . ",
                        member_id='" . $member_id . "',
                        total=" . $total_price . ",
                        status ='Draft',
                        expired_date='" . date('Y-m-d H:i:s', strtotime('+30 minutes')) . "', 
                        currency='". $_SESSION['osg_currency']. "',
                        total_nilai_rupiah=" . $total_nilai_rupiah . ",
                        point_earned =".$point_earned.",
                        status_hapus='0'";
  $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));
    $pesanSukses = "<i class='fa fa-check'></i> Data telah disimpan";
  }
}
?>


<?php if (!empty($pesan)) { ?>

  <script>
    window.open("?menu=error&errmsg=<?php echo enkripsi($pesan);?>", "_self");
  </script>
<?php }
if (!empty($pesanSukses)) { ?>
  <script>
    window.open("?menu=booking&bID=<?php echo enkripsi($booking_id); ?>", "_self");
  </script>
<?php } ?>
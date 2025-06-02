<?php
$booking_id = dekripsi(amankan($_GET['bID']));
if (empty($_SESSION['osg_member_id'])) {
    header("Location: ./");
}
$member_id  = dekripsi(amankan($_GET['mID']));
$member_email =  (amankan($_GET['email']));
$booking_id =  dekripsi(amankan($_GET['bID']));

$sBooking   = " SELECT b.*,m.email 
                FROM booking b
                JOIN member m On m.member_id=b.member_id
                WHERE b.booking_id='" . $booking_id . "' and b.status='Booked' and b.member_id='" . $member_id . "' and b.status_hapus='0' and email='" . $member_email . "'";
$qBooking   = mysqli_query($conn, $sBooking) or die(mysqli_error($conn));
$rBooking   = mysqli_fetch_array($qBooking);

?>

<!-- Service Start -->
<div class="container-fluid py-5" style="margin-bottom: 100px;">
    <div class="container-fluid">

        <div class="row g-4">
            <div class="col-lg-12 col-md-12 wow fadeInUp" style="color: black;font-size: 18px;" data-wow-delay="0.2s">
                <div class="card mb-3" style="box-shadow: 0 0 45px rgba(0, 0, 0, .08);">
                    <div class="card-body text-center">
                        <h1 class="mb-4 text-primary"><i class="fa fa-check-circle fa-lg"></i></h1>
                        <h5 class="card-title">Booking Confirmation</h5>
                        <p class="card-text">Thank you for booking with us. Your booking is confirmed.<br /><smal>Please check your email for the booking details.</small></p>
                        <small class="fs-5">Booking ID : <strong class="text-primary"><?php echo $booking_id; ?></strong></small><br />

                        <button class="btn btn-success rounded mt-3" onclick="window.open('./', '_self')"><i class="fa fa-home"></i> Home</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Service End -->
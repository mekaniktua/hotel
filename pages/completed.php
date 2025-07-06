<?php
session_start();
include("kirimMail.php");
// require_once '../config.php'; // Uncomment if needed
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Sanitize and decrypt GET parameters once
$booking_id = dekripsi(amankan($_GET['bID'] ?? ''));
$member_id = dekripsi(amankan($_GET['mID'] ?? ''));
$member_email = dekripsi(amankan($_GET['email'] ?? ''));
$invoice_number = dekripsi(amankan($_GET['iNumber'] ?? ''));

if (empty($_SESSION['osg_member_id'])) {
    header("Location: ./");
    exit;
} 
// Ambil data booking dan member dalam satu query
$stmt = $conn->prepare("
    SELECT b.*,tk.room_type,p.property_name, m.fullname, m.email,m.mobile_number 
    FROM booking b 
    JOIN room_type tk on tk.room_type_id=b.room_type_id
    JOIN property p ON p.property_id=b.property_id
    LEFT JOIN member m ON b.member_id = m.member_id 
    WHERE b.booking_id = ? AND b.invoice_number = ?
");
$stmt->bind_param("ss", $booking_id, $invoice_number);
$stmt->execute();
$result = $stmt->get_result();
$rData = $result->fetch_assoc();
$stmt->close();

$status = '';
$message = '';
$showButton = true;

if ($rData) {
    $currentStatus = $rData['status'] ?? '';

    if ($currentStatus === 'Waiting') {
        // Update status menjadi Completed
        $newStatus = 'Completed';
        $stmt = $conn->prepare("
            UPDATE booking 
            SET status = ? 
            WHERE booking_id = ? AND invoice_number = ?
        ");
        $stmt->bind_param("sss", $newStatus, $booking_id, $invoice_number);
        $stmt->execute();
        $stmt->close();

        // Kirim email konfirmasi
        $payment_method = $rData['payment_method'] ?? 'Payment'; // pastikan tersedia
        $statusEmail = bookingPayment(
            'noreply@orangesky.id',
            $rData['email'],
            'Booking Confirmation Orange Sky - ' . $booking_id,
            $booking_id,
            $invoice_number,
            $rData['fullname'], 
            $rData['room_type'],
            $rData['property_name'],
            $rData['start_date'],
            $rData['end_date'],
            $rData['total'],
            $payment_method,
            $rData['special_request'],
            $_SESSION['osg_address'] ?? '',
            $_SESSION['osg_phone'] ?? ''
        );


        //send email to admin hotel
        $statusEmail = bookingPaymentNotif(
            'noreply@orangesky.id',
            'booknow@orangeskygroup.co.id',
            'Booking Confirmation Orange Sky - ' . $booking_id,
            $booking_id,
            $invoice_number,
            $rData['fullname'], 
            $rData['email'],
            $rData['mobile_number'],
            $rData['room_type'],
            $rData['property_name'],
            $rData['start_date'],
            $rData['end_date'],
            $rData['total'],
            $payment_method,
            $rData['special_request'],
            $_SESSION['osg_address'] ?? '',
            $_SESSION['osg_phone'] ?? ''
        );

        $status = 'Payment Confirmation';
        $message = 'Thank you for booking with us. Your payment is confirmed.<br /><small>Please check your email for the booking details.</small>';
    } elseif ($currentStatus === 'Completed') {
        $status = 'Already make confirmation';
        $message = 'You have already made payment confirmation.<br /><small>Please check your email for the booking details.</small>';
    } else {
        $status = 'Invalid Status';
        $message = 'We could not process your payment confirmation due to an unexpected status.';
    }
} else {
    $status = 'Payment Not Found';
    $message = 'We cannot find your payment.<br /><small>Please go to your booking (button below) and try to make payment again.</small>';
    $showButton = false;
}
?> 

<!-- Service Start -->
<div class="container-fluid py-5" style="margin-bottom: 100px;">
    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-lg-12 col-md-12 wow fadeInUp" style="color: black;font-size: 18px;" data-wow-delay="0.2s">
                <div class="card mb-3" style="box-shadow: 0 0 45px rgba(0, 0, 0, .08);">
                    <div class="card-body text-center">
                        <h1 class="mb-4 text-primary">
                            <i class="fa <?php echo ($status == 'Payment Not Found') ? 'fa-times-circle' : 'fa-check-circle'; ?> fa-lg"></i>
                        </h1>
                        <h5 class="card-title"><?php echo $status; ?></h5>
                        <p class="card-text"><?php echo $message; ?></p>
                        <small class="fs-5">Booking ID : <strong class="text-primary"><?php echo $booking_id; ?></strong></small><br />
                        <small class="fs-5">Invoice Number : <strong class="text-primary"><?php echo $invoice_number; ?></strong></small><br />
                        <?php if ($showButton && $status != 'Payment Not Found'): ?>
                            <button class="btn btn-success rounded mt-3" onclick="window.open('./', '_self')"><i class="fa fa-home"></i> Home</button>
                        <?php elseif ($status == 'Payment Not Found'): ?>
                            <button class="btn btn-success rounded mt-3" onclick="window.open('./?menu=member&t=myBooking', '_self')"><i class="fa fa-home"></i> My Booking</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Service End -->
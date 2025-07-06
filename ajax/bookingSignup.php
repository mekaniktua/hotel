<?php
session_start();
include("../manajemen/database.php");
include("../kirimMail.php");

$fullname = (amankan($_POST['fullname'] ?? ''));
$email = (amankan($_POST['email'] ?? ''));
$mobile_number = (amankan($_POST['mobile_number'] ?? ''));
$password = (amankan($_POST['passwordSignup'] ?? '')); 
$booking_id = dekripsi(amankan($_POST['bID'] ?? ''));

$pesan = '';

// Validation
if (empty($fullname)) {
    $pesan = "<i class='fa fa-times'></i> Full name field is required";
} else if (empty($email)) {
    $pesan = "<i class='fa fa-times'></i> Email field is required";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $pesan = "<i class='fa fa-times'></i> Not a valid email";
} else if (empty($mobile_number)) {
    $pesan = "<i class='fa fa-times'></i> Mobile number field is required";
} else if (empty($password)) {
    $pesan = "<i class='fa fa-times'></i> Password field is required";
} else if (strlen($password) < 6) {
    $pesan = "<i class='fa fa-times'></i> Password must be at least 6 characters long";
} else if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d).+$/', $password)) {
    $pesan = "<i class='fa fa-times'></i> Password must contain both letters and numbers";
} else {
    // Check if email already exists
    $sCariEmail = "SELECT member_id FROM member WHERE email = ? AND status_hapus = '0'";
    $stmt = $conn->prepare($sCariEmail);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $pesan = "<i class='fa fa-times'></i> Email already exists. Please use a different email or login.";
    } else {
        // Check if mobile number already exists
        $sCariMobile = "SELECT member_id FROM member WHERE mobile_number = ? AND status_hapus = '0'";
        $stmt = $conn->prepare($sCariMobile);
        $stmt->bind_param("s", $mobile_number);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $pesan = "<i class='fa fa-times'></i> Mobile number already exists. Please use a different mobile number.";
        } else {
            // Create new member
            $member_id = randomText(10);
            $hashed_password = md5($password);
            $confirmation_code = random_int(100000, 999999);
            $confirmation_code_expired = date("Y-m-d H:i:s", strtotime('+10 minutes'));
            
            $sInsert = "INSERT INTO member (member_id, fullname, email, mobile_number, password, confirmation_code, confirmation_code_expired, status, status_hapus, created_date) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, 'Active', '0', NOW())";
            $stmt = $conn->prepare($sInsert);
            $stmt->bind_param("sssssss", $member_id, $fullname, $email, $mobile_number, $hashed_password, $confirmation_code, $confirmation_code_expired);
            
            if ($stmt->execute()) {
                //cari booking
                $sCariBooking   = " SELECT *
                                    FROM booking
                                    WHERE booking_id='" . $booking_id . "' and status_hapus='0'";
                $qCariBooking   = mysqli_query($conn, $sCariBooking) or die(mysqli_error($conn));
                $rCariBooking   = mysqli_fetch_array($qCariBooking); 

                if(empty($rCariBooking['booking_id'])){
                    $pesan = "<i class='fa fa-times'></i> Booking not found";
                }else if($rCariBooking['status']=='Draft' && empty($rCariBooking['member_id'])){//jika draft dan belum ada member maka update booking

                    $code = random_int(100000, 999999);
                    $sUpdate    = " UPDATE member
                                    SET confirmation_code='" . $code . "', 
                                        confirmation_code_expired='" . date("Y-m-d H:i:s", strtotime('+10 minutes')) . "'
                                    WHERE member_id='" . $member_id . "'";
                    $qUpdate    = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));

                    //send email otp

                    $title = "Your OTP Code - Orange Sky";
                    $otp = $code;
                    $sender = "noreply@orangesky.id";
                    $recepient = $email;

                    if($_SERVER['HTTP_HOST'] !='localhost'){
                        $sendOTP = sendOTP($sender, $recepient, $title, $otp);
                    }else{
                        $sendOTP = "1";
                    }

                    if ($sendOTP == "1") { 
                        //send email otp
                        include("bookingOtp.php");
                    } else {
                        $pesan = "<i class='fa fa-times'></i> Failed to send OTP to your email " . maskEmail($email);
                    } 
                }else{//set session lalu kembalikan ke halaman member
                    $_SESSION['osg_member_id'] = enkripsi($rCari['member_id']);
                    $_SESSION['osg_member_email'] = ($rCari['email']);  
                ?>

                    <script>
                        window.location.href = '?menu=member'; // Ganti dengan URL tujuan
                    </script>
                <?php  }
            } else {
                $pesan = "<i class='fa fa-times'></i> Failed to create account. Please try again.";
            }
        }
    }
} 
?>

<div class="pesanku">
    <?php if (!empty($pesan)) { ?>
    <div class="alert alert-danger">
        <?php echo $pesan; ?>
    </div>
    <?php }?>
</div>
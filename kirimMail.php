<?php
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function bookingPayment($sender, $recepient, $title, $booking_id,$invoice_number,$name, $room_type, $property_name, $start_date, $end_date, $total_price, $payment_method, $special_request, $address, $phone)
{

require 'vendor/autoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();

/* Set the mail sender. */
$mail->setFrom($sender, $sender);

/* Add a recipient. */
$mail->addAddress($recepient, $recepient); 
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'mail.orangesky.id'; // Specify main and backup SMTP servers
$mail->SMTPAuth = false; // Enable SMTP authentication
$mail->SMTPSecure = '';
// $mail->Username = 'noreply@orangesky.id'; // SMTP username
// $mail->Password = 'noreply_123'; // SMTP password 
$mail->Port = 25; // TCP port to connect to 

/* Set the subject. */
$mail->Subject = $title;
$mail->isHTML(TRUE);
/* Set the mail message body. */
$mail->Body = '<html>
	<head>
	  <title>Booking Confirmation</title>
	</head>
	<body>
		<style> 
            body { font-family: Arial, sans-serif; color: #333; }
            table { border-collapse: collapse; width: 100%; margin-top: 10px; }
            th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
            th { background-color: #f2f2f2; }
            h2 { color: #0d6efd; }
        </style> 
		<p>Hello, '.$name.'</p>
		<p>We are happy to inform you that your booking  is confirmed! Get ready to create some unforgettable memories. We have made things easy for you and. All you need to do is show us this email with Booking ID on the day you arrive, and you’ll be good to go!</p>
		<p>
			<h2>Booking ID : <strong class="text-primary">'.$booking_id.'</strong></h2>
			<table border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
				<tr>
					<th><strong>Property Name</strong></th>
					<td>'.$property_name.'</td>
				</tr>
				<tr>
					<th><strong>Room Type</strong></th>
					<td>'.$room_type.'</td>
				</tr>
				<tr>
					<th><strong>Check In</strong></th>
					<td>'.$start_date.'</td>
				</tr>
				<tr>
					<th><strong>Check Out</strong></th>
					<td>'.$end_date.'</td>
				</tr>
				<tr>
					<th><strong>Total Price</strong></th>
					<td>'.$total_price.'</td>
				</tr>
				<tr>
					<th><strong>Invoice Number</strong></th>
					<td>'.$invoice_number.'</td>
				</tr>
				<tr>
					<th><strong>Payment Method</strong></th>
					<td>'.$payment_method.'</td>
				</tr>

				<tr>
					<th><strong>Payment Status</strong></th>
					<td>Confirmed</td>
				</tr>
				<tr>
					<th><strong>Special Request</strong></th>
					<td>'.$special_request.'</td>
				</tr>
				</table>
		</p>
		<p>We are looking forward to welcoming you to our property. If you have any questions or need assistance, please feel free to reach out to us.</p>
		<br /><br />
		
		<p>Best regards,<br />
		OrangeSkyGroup<br />
		'.$address.'<br />
		Phone: '.$phone. '<br />
		<br />
		Thank you.<br />
		Note: Please do not reply to this email as it is an automated message.<br /> 
		</p>
	</body>
	</html>
	';


	/* Finally send the mail. */
	if ($mail->send())
	{
	   
	   $emailStatus = "1"; //Email Terkirim
	}else{
		/* PHPMailer error. */
	   	$mail->ErrorInfo; 
		$emailStatus = "0"; //Email Gagal
	}
	return $emailStatus;
}

function bookingPaymentNotif($sender, $recepient, $title, $booking_id,$invoice_number,$name,$email,$mobile_number, $room_type, $property_name, $start_date, $end_date, $total_price, $payment_method, $special_request,	$address, $phone)
{

require 'vendor/autoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();

/* Set the mail sender. */
$mail->setFrom($sender, $sender);

/* Add a recipient. */
$mail->addAddress($recepient, $recepient);  
$mail->isSMTP();  
                                    // Set mailer to use SMTP
$mail->Host = 'mail.orangesky.id'; // Specify main and backup SMTP servers
$mail->SMTPAuth = false; // Enable SMTP authentication
$mail->SMTPSecure = '';
// $mail->Username = 'noreply@orangesky.id'; // SMTP username
// $mail->Password = 'noreply_123'; // SMTP password 
$mail->Port = 25; // TCP port to connect to 

/* Set the subject. */
$mail->Subject = $title;
$mail->isHTML(TRUE);
/* Set the mail message body. */
$mail->Body = '
 <html>
    <head>
        <title>Booking Notification</title>
        <style>
            body { font-family: Arial, sans-serif; color: #333; }
            table { border-collapse: collapse; width: 100%; margin-top: 10px; }
            th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
            th { background-color: #f2f2f2; }
            h2 { color: #0d6efd; }
        </style>
    </head>
    <body>
        <h2>Booking Confirmation</h2>
        
        <p>Dear Orange Sky Team,</p>

		<p>We would like to inform you that a new booking has been successfully received with the following details:</p>


        <h3>Booking Details</h3>
        <table>
            <tr><th>Booking ID</th><td>' . ($booking_id) . '</td></tr>
            <tr><th>Invoice Number</th><td>' . ($invoice_number) . '</td></tr>
            <tr><th>Check-In</th><td>' . ($start_date) . '</td></tr>
            <tr><th>Check-Out</th><td>' . ($end_date) . '</td></tr>
            <tr><th>Total Price</th><td>' . ($total_price) . '</td></tr>
            <tr><th>Payment Method</th><td>' . ($payment_method) . '</td></tr>
            <tr><th>Payment Status</th><td><strong style="color: green;">Confirmed</strong></td></tr>
            <tr><th>Special Request</th><td>' . ($special_request ?: '-') . '</td></tr>
        </table>

        <h3>Guest Details</h3>
        <table>
            <tr><th>Name</th><td>' . ($name) . '</td></tr>
			<tr><th>Mobile Number</th><td>' . ($mobile_number) . '</td></tr>
            <tr><th>Email</th><td>' . ($email) . '</td></tr>
        </table>

        <h3>Room Details</h3>
        <table>
            <tr><th>Property</th><td>' . ($property_name) . '</td></tr>
            <tr><th>Room Type</th><td>' . ($room_type) . '</td></tr>
        </table>

        <p>If you have any questions, feel free to reach out to us.</p>
        <p>
            <strong>OrangeSkyGroup</strong><br />
            ' . ($address) . '<br />
            Phone: ' . ($phone) . '<br />
            <em>Note: This is an automated email. Please do not reply.</em>
        </p>
    </body>
    </html>
	';


	/* Finally send the mail. */
	if ($mail->send())
	{
	   
	   $emailStatus = "1"; //Email Terkirim
	}else{
		/* PHPMailer error. */
	   	$mail->ErrorInfo; 
		$emailStatus = "0"; //Email Gagal
	}
	return $emailStatus;
}

function bookingConfirmation($sender, $recepient, $title, $booking_id,$invoice_number,$name, $room_type, $property_name, $start_date, $end_date, $total_price, $payment_method, $special_request, $address, $phone)
{

require '../vendor/autoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();

/* Set the mail sender. */
$mail->setFrom($sender, $sender);

/* Add a recipient. */
$mail->addAddress($recepient, $recepient); 
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'mail.orangesky.id'; // Specify main and backup SMTP servers
$mail->SMTPAuth = false; // Enable SMTP authentication
$mail->SMTPSecure = '';
// $mail->Username = 'noreply@orangesky.id'; // SMTP username
// $mail->Password = 'noreply_123'; // SMTP password 
$mail->Port = 25; // TCP port to connect to 

/* Set the subject. */
$mail->Subject = $title;
$mail->isHTML(TRUE);
/* Set the mail message body. */
$mail->Body = '<html>
	<head>
	  <title>Booking Confirmation</title>
	</head>
	<body>
		<style> 
            body { font-family: Arial, sans-serif; color: #333; }
            table { border-collapse: collapse; width: 100%; margin-top: 10px; }
            th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
            th { background-color: #f2f2f2; }
            h2 { color: #0d6efd; }
        </style> 
		<p>Hello, '.$name.'</p>
		<p>We are happy to inform you that your booking  is confirmed! Get ready to create some unforgettable memories. We’ve made things easy for you and. All you need to do is show us this email with Booking ID on the day you arrive, and you’ll be good to go!</p>
		<p>
			<h2>Booking ID : <strong class="text-primary">'.$booking_id.'</strong></h2>
			<table border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
				<tr>
					<th><strong>Property Name</strong></th>
					<td>'.$property_name.'</td>
				</tr>
				<tr>
					<th><strong>Room Type</strong></th>
					<td>'.$room_type.'</td>
				</tr>
				<tr>
					<th><strong>Check In</strong></th>
					<td>'.$start_date.'</td>
				</tr>
				<tr>
					<th><strong>Check Out</strong></th>
					<td>'.$end_date.'</td>
				</tr>
				<tr>
					<th><strong>Total Price</strong></th>
					<td>'.$total_price.'</td>
				</tr>
				<tr>
					<th><strong>Payment Method</strong></th>
					<td>'.$payment_method.'</td>
				</tr>
				<tr>
					<th><strong>Special Request</strong></th>
					<td>'.$special_request.'</td>
				</tr>
			</table>
		</p>
		<p>We are looking forward to welcoming you to our property. If you have any questions or need assistance, please feel free to reach out to us.</p>
		<br /><br />
		
		<p>Best regards,<br />
		OrangeSkyGroup<br />
		'.$address.'<br />
		Phone: '.$phone. '<br />
		<br />
		Thank you.<br />
		Note: Please do not reply to this email as it is an automated message.<br /> 
		</p>
	</body>
	</html>
	';


	/* Finally send the mail. */
	if ($mail->send())
	{
	   
	   $emailStatus = "1"; //Email Terkirim
	}else{
		/* PHPMailer error. */
	   	$mail->ErrorInfo; 
		$emailStatus = "0"; //Email Gagal
	}
	return $emailStatus;
}


function registration($sender, $recepient,$title,$enc_email,$name, $mobile_number)
{
	require 'vendor/autoload.php';

	//Create a new PHPMailer instance
	$mail = new PHPMailer();

	/* Set the mail sender. */
	$mail->setFrom($sender, $sender);

	/* Add a recipient. */
	$mail->addAddress($recepient, $recepient);

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'mail.orangesky.id'; // Specify main and backup SMTP servers
	$mail->SMTPAuth = false; // Enable SMTP authentication
	$mail->SMTPSecure = '';
	// $mail->Username = 'noreply@orangesky.id'; // SMTP username
	// $mail->Password = 'noreply_123'; // SMTP password 
	$mail->Port = 25; // TCP port to connect to 

	/* Set the subject. */
	$mail->Subject = $title;
	$mail->isHTML(TRUE);
	/* Set the mail message body. */
	$mail->Body = '
	<html>
<head>
  <meta charset="UTF-8">
  <title>Registration Confirmation</title>
  <style>
    body {
      font-family: Cambria, serif;
      background-color: #f9f9f9;
      padding: 20px;
    }
    .container {
      max-width: 600px;
      margin: auto;
      background-color: #ffffff;
      border: 1px solid #dddddd;
      padding: 20px;
      border-radius: 8px;
    }
    h2 {
      font: bold 20px Cambria;
      color: #333333;
    }
    p {
      font-size: 16px;
      color: #555555;
    }
    .button {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>'.$title.'</h2>
    <p>Dear '.$name.',</p>
    <p>Thank you for registering! Your account has been successfully created.</p>
    <p>Click the button below to activate your account:</p>
    <a href="http://orangesky.id/activation?e='.$enc_email.'" class="button">Activate Account</a>
    <p>If you did not register, please ignore this email.</p>
    <p>Best regards,
	<br>Orange Sky Team
	<br /> 
	Note: Please do not reply to this email as it is an automated message.<br /> 
	</p>
  </div>
</body>
</html>
	';


	/* Finally send the mail. */
	if (!$mail->send()) { 
		return 'Mailer Error: ' . $mail->ErrorInfo;
	}else{return "1";}
}

function forgot($sender, $recepient, $title, $enc_email,$enc_code, $phone)
{
	require 'vendor/autoload.php';

	//Create a new PHPMailer instance
	$mail = new PHPMailer();

	/* Set the mail sender. */
	$mail->setFrom($sender, $sender);

	/* Add a recipient. */
	$mail->addAddress($recepient, $recepient);

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'mail.orangesky.id'; // Specify main and backup SMTP servers
	$mail->SMTPAuth = false; // Enable SMTP authentication
	$mail->SMTPSecure = '';
	// $mail->Username = 'noreply@orangesky.id'; // SMTP username
	// $mail->Password = 'noreply_123'; // SMTP password 
	$mail->Port = 25; // TCP port to connect to 

	/* Set the subject. */
	$mail->Subject = $title;
	$mail->isHTML(TRUE);
	/* Set the mail message body. */
	$mail->Body = '
	<html>
<head>
  <meta charset="UTF-8">
  <title>' . $title . '</title>
  <style>
    body {
      font-family: Cambria, serif;
      background-color: #f9f9f9;
      padding: 20px;
    }
    .container {
      max-width: 600px;
      margin: auto;
      background-color: #ffffff;
      border: 1px solid #dddddd;
      padding: 20px;
      border-radius: 8px;
    }
    h2 {
      font: bold 20px Cambria;
      color: #333333;
    }
    p {
      font-size: 16px;
      color: #555555;
    }
    .button {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }
		
	.button:visited,
	.button:hover,
	.button:active {
	color: white;
	text-decoration: none;
	}
  </style>
</head>
<body>
  <div class="container">
    <h2>' . $title . '</h2>
    <p>Dear ' . $recepient . ',</p>
    <p>We received a request to reset the password for your OrangeSky account.</p>
    <p>To create a new password, please click the link below:</p>
    <a href="http://orangesky.id/login/?menu=reset&e=' . $enc_email . '&c='.$enc_code. '" class="button">Reset Your Password</a>
    <p>If you didn’t request a password reset, please disregard this email or contact our support team immediately.</p>
	<p>For your security, this link will expire in 24 hours.</p>
    <p>Best regards,
	<br><strong>The Orange Sky Team</strong><br />
	<a href="https://orangesky.id">orangesky.id</a> | <a href="mailto:booknow@orangeskygroup.co.id">booknow@orangeskygroup.co.id</a><br />
	Phone: ' . $phone . '<br />
	<br /> 
	Note: Please do not reply to this email as it is an automated message.<br /> 
	</p>
  </div>
</body>
</html>
	';


	/* Finally send the mail. */
	if (!$mail->send()) {
		return 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		return "1";
	}
}

function resetPass($sender, $recepient, $title, $phone)
{
	require 'vendor/autoload.php';

	//Create a new PHPMailer instance
	$mail = new PHPMailer();

	/* Set the mail sender. */
	$mail->setFrom($sender, $sender);

	/* Add a recipient. */
	$mail->addAddress($recepient, $recepient);

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'mail.orangesky.id'; // Specify main and backup SMTP servers
	$mail->SMTPAuth = false; // Enable SMTP authentication
	$mail->SMTPSecure = '';
	// $mail->Username = 'noreply@orangesky.id'; // SMTP username
	// $mail->Password = 'noreply_123'; // SMTP password 
	$mail->Port = 25; // TCP port to connect to 

	/* Set the subject. */
	$mail->Subject = $title;
	$mail->isHTML(TRUE);
	/* Set the mail message body. */
	$mail->Body = '
	<html>
<head>
  <meta charset="UTF-8">
  <title>' . $title . '</title>
  <style>
    body {
      font-family: Cambria, serif;
      background-color: #f9f9f9;
      padding: 20px;
    }
    .container {
      max-width: 600px;
      margin: auto;
      background-color: #ffffff;
      border: 1px solid #dddddd;
      padding: 20px;
      border-radius: 8px;
    }
    h2 {
      font: bold 20px Cambria;
      color: #333333;
    }
    p {
      font-size: 16px;
      color: #555555;
    }
    .button {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }
		
	.button:visited,
	.button:hover,
	.button:active {
	color: white;
	text-decoration: none;
	}
  </style>
</head>
<body>
  <div class="container">
    <h2>' . $title . '</h2>
    <p>Dear ' . $recepient . ',</p>
    <p>You have successfully set a new password for your account.</p>
	<p>If you did not make this change, please contact our support team immediately.</p>
    <p>Best regards,
	<br><strong>The Orange Sky Team</strong><br />
	<a href="https://orangesky.id">orangesky.id</a> | <a href="mailto:booknow@orangeskygroup.co.id">booknow@orangeskygroup.co.id</a><br />
	Phone: ' . $phone . '<br />
	<br /> 
	Note: Please do not reply to this email as it is an automated message.<br /> 
	</p>
  </div>
</body>
</html>
	';


	/* Finally send the mail. */
	if (!$mail->send()) {
		return 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		return "1";
	}
}

function redeem($sender, $recepient, $title, $voucherTitle, $phone)
{
	require 'vendor/autoload.php';

	//Create a new PHPMailer instance
	$mail = new PHPMailer();

	/* Set the mail sender. */
	$mail->setFrom($sender, $sender);

	/* Add a recipient. */
	$mail->addAddress($recepient, $recepient);

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'mail.orangesky.id'; // Specify main and backup SMTP servers
	$mail->SMTPAuth = false; // Enable SMTP authentication
	$mail->SMTPSecure = '';
	// $mail->Username = 'noreply@orangesky.id'; // SMTP username
	// $mail->Password = 'noreply_123'; // SMTP password 
	$mail->Port = 25; // TCP port to connect to 

	/* Set the subject. */
	$mail->Subject = $title;
	$mail->isHTML(TRUE);
	/* Set the mail message body. */
	$mail->Body = '
	<html>
<head>
  <meta charset="UTF-8">
  <title>' . $title . '</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f6f6f6;
      margin: 0;
      padding: 20px;
    }
    .email-container {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 8px;
      max-width: 600px;
      margin: auto;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .header {
      background-color: #f97316;
      padding: 15px;
      border-radius: 8px 8px 0 0;
      color: white;
      text-align: center;
      font-size: 20px;
    }
    .content {
      padding: 20px;
      color: #333;
    }
    .voucher {
      background-color: #f1f1f1;
      padding: 15px;
      margin: 15px 0;
      border-left: 5px solid #f97316;
      border-radius: 5px;
    }
    .footer {
      text-align: center;
      font-size: 12px;
      color: #999;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="header">
      🎉 Voucher Redemption Successful
    </div>
    <div class="content">
		<p>Dear Customer,</p>
		<p>We are happy to inform you that you have successfully redeemed the following voucher:</p>

		<div class="voucher">
		<strong>Voucher:</strong> ' . ($voucherTitle) . '<br>
		<strong>Valid Until:</strong> ' . htmlspecialchars($validUntil) . '
		</div>

		<p>Best regards,
		<br><strong>The Orange Sky Team</strong><br />
		<a href="https://orangesky.id">orangesky.id</a> | <a href="mailto:booknow@orangeskygroup.co.id">booknow@orangeskygroup.co.id</a><br />
		Phone: ' . $phone . '<br />
		<br /> 
		Note: Please do not reply to this email as it is an automated message.<br /> 
		</p>
    </div>
</body>
</html>
	';


	/* Finally send the mail. */
	if (!$mail->send()) {
		return 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		return "1";
	}
}

function sendOTP($sender, $recepient, $title, $otp)
{
	require 'vendor/autoload.php';

	//Create a new PHPMailer instance	
	$mail = new PHPMailer();

	/* Set the mail sender. */
	$mail->setFrom($sender, $sender);

	/* Add a recipient. */
	$mail->addAddress($recepient, $recepient);

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'mail.orangesky.id'; // Specify main and backup SMTP servers
	$mail->SMTPAuth = false; // Enable SMTP authentication
	$mail->SMTPSecure = '';
	// $mail->Username = 'noreply@orangesky.id'; // SMTP username
	// $mail->Password = 'noreply_123'; // SMTP password 
	$mail->Port = 25; // TCP port to connect to	

	/* Set the subject. */
	$mail->Subject = $title;
	$mail->isHTML(TRUE);
	/* Set the mail message body. */
	$mail->Body = '
	<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>' . $title . '</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f6f9fc;
      padding: 20px;
      color: #333;
    }
    .container {
      max-width: 480px;
      margin: auto;
      background: #ffffff;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      padding: 30px;
      text-align: center;
    }
    .otp-code {
      font-size: 36px;
      letter-spacing: 8px;
      margin: 20px 0;
      color: #007bff;
      font-weight: bold;
    }
    .footer {
      font-size: 12px;
      color: #888;
      margin-top: 30px;
    }
    .logo {
      max-height: 100px;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <img src="https://orangesky.id/img/logo-OSM.png" alt="Logo" class="logo">
    <h2>Your OTP Code</h2>
    <p>Use the code below to continue the verification process.</p>
    <div class="otp-code">' . $otp . '</div>
    <p>This code is only valid for 10 minutes.</p>
    <div class="footer">
      If you did not request this code, ignore this email.<br>
      &copy; 2025 Orange Sky
    </div>
  </div>
</body>
</html>';


	/* Finally send the mail. */
	if (!$mail->send()) {
		return 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		return "1";
	}	
}

function contactUs($sender, $recepient, $title, $name, $message)
{
	require 'vendor/autoload.php';

	//Create a new PHPMailer instance	
	$mail = new PHPMailer();

	/* Set the mail sender. */
	$mail->setFrom($sender, $sender);

	/* Add a recipient. */
	$mail->addAddress($recepient, $recepient);

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'mail.orangesky.id'; // Specify main and backup SMTP servers
	$mail->SMTPAuth = false; // Enable SMTP authentication
	$mail->SMTPSecure = '';
	// $mail->Username = 'noreply@orangesky.id'; // SMTP username
	// $mail->Password = 'noreply_123'; // SMTP password 
	$mail->Port = 25; // TCP port to connect to	

	/* Set the subject. */
	$mail->Subject = $title;
	$mail->isHTML(TRUE);
	/* Set the mail message body. */
	$mail->Body = '
	<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>' . $title . '</title>
  <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #eee; background: #fafafa; }
        h2 { color: #333; }
        p { margin: 5px 0; }
        .footer { margin-top: 20px; font-size: 12px; color: #888; }
    </style>
</head>
<body>
  <div class="container">
    <h2>New Message from ' . $name . '</h2>
    <p>' . $message . '</p>
    <div class="footer">
      This email is sent from contact us form
    </div>
  </div>
</body>
</html>';


	/* Finally send the mail. */
	if (!$mail->send()) {
		return 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		return "1";
	}	
}

?>
<?php
session_start();
include("../database.php");


$sMember = "SELECT SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) AS member_pending,
            SUM(CASE WHEN status = 'Active' THEN 1 ELSE 0 END) AS member_active
            FROM member 
            WHERE status_hapus = 0"; 
$qMember = mysqli_query($conn,$sMember) or die(mysqli_error($conn));
$rMember = mysqli_fetch_array($qMember);
 
$sBooking = " SELECT 
              SUM(CASE WHEN status = 'Booked' THEN 1 ELSE 0 END) AS booked,
              SUM(CASE WHEN status = 'Complete' THEN 1 ELSE 0 END) AS complete
              FROM booking 
              WHERE status_hapus = 0";
$qBooking = mysqli_query($conn, $sBooking) or die(mysqli_error($conn));
$rBooking = mysqli_fetch_array($qBooking);
 

$sMerchant = "SELECT 
              SUM(CASE WHEN status = 'Active' THEN 1 ELSE 0 END) AS active,
              SUM(CASE WHEN status = 'Inactive' THEN 1 ELSE 0 END) AS inactive
              FROM merchant 
              WHERE status_hapus = 0";
$qMerchant = mysqli_query($conn, $sMerchant) or die(mysqli_error($conn));
$rMerchant = mysqli_fetch_array($qMerchant);
 

$sVoucher = " SELECT 
            SUM(CASE WHEN start_date > '" . date("Y-m-d") . "' THEN 1 ELSE 0 END) AS upcoming,
            SUM(CASE WHEN end_date > '" . date("Y-m-d") . "' THEN 1 ELSE 0 END) AS expired,
            SUM(CASE WHEN start_date <= '" . date("Y-m-d") . "' and end_date <= '" . date("Y-m-d") . "' THEN 1 ELSE 0 END) AS active
            FROM voucher 
            WHERE status_hapus = 0";
$qVoucher = mysqli_query($conn, $sVoucher) or die(mysqli_error($conn));
$rVoucher = mysqli_fetch_array($qVoucher);

?>


<div class="row g-4">
  <!-- Card 1 -->
  <div class="col-md-3">
    <div class="card text-white bg-info h-100 shadow-sm">
      <div class="card-body">
        <h4 class="card-title text-white"><i class="fa fa-users"></i> Total Member</h4>
        <hr class="bg-white" />
        <div class="d-flex justify-content-between">
          <div>
            <p class="text-white fs-4">Not Active<br />Active</p>
          </div>
          <div>
            <p class="text-white fs-4"><?php echo $rMember['member_pending'] ?><br /><?php echo $rMember['member_active'] ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Card 2 -->
  <div class="col-md-3">
    <div class="card text-white bg-success h-100">
      <div class="card-body">
        <h4 class="card-title text-white"><i class="fa fa-book"></i> Total Booking</h4>
        <hr class="bg-white" />
        <div class="d-flex justify-content-between">
          <div>
            <p class="text-white fs-4">Booked<br />Completed</p>
          </div>
          <div>
            <p class="text-white fs-4"><?php echo $rBooking['booked'] ?><br /><?php echo $rBooking['complete'] ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Card 3 -->
  <div class="col-md-3">
    <div class="card text-white bg-warning h-100">
      <div class="card-body">
        <h4 class="card-title text-white"><i class="fa fa-store"></i> Total Merchant</h4>
        <hr />
        <div class="d-flex justify-content-between">
          <div>
            <p class="text-white fs-4">Active<br />Inactive</p>
          </div>
          <div>
            <p class="text-white fs-4"><?php echo $rMerchant['active'] ?><br /><?php echo $rMerchant['inactive'] ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Card 4 -->
  <div class="col-md-3">
    <div class="card text-white bg-danger h-100">
      <div class="card-body">
        <h4 class="card-title text-white"><i class="fa fa-bullhorn"></i> Total Voucher</h4>
        <hr class="bg-white" />
        <div class="d-flex justify-content-between">
          <div>
            <p class="text-white fs-4">Upcoming<br />Active<br />Expired</p>
          </div>
          <div>
            <p class="text-white fs-4"><?php echo $rVoucher['upcoming'] ?><br /><?php echo $rVoucher['active'] ?><br /><?php echo $rVoucher['expired'] ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php  mysqli_close($conn);?>
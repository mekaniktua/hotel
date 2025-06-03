<?php
$t = isset($_GET['t']) ? amankan($_GET['t']) : '';
if (empty($_SESSION['osg_member_id'])) {
    header("Location: login/");
}
$global_member_id = dekripsi(amankan($_SESSION['osg_member_id']??  ''));
$sData  = " SELECT *
            FROM member
            WHERE member_id='" . $global_member_id . "' and status_hapus='0'";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
$rData  = mysqli_fetch_array($qData);
$global_member_email = $rData['email'];
$global_member_avatar = $rData['avatar'];
$global_member_type = $rData['member_type'];
$global_member_point = $rData['point'];
?>

<!-- Service Start -->
<div class="container-xxl py-5" style="margin-bottom: 100px;">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title text-center text-primary text-uppercase">Member Page</h6>
            <h1 class="mb-5">Explore <span class="text-primary text-uppercase">More</span></h1>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-12 wow fadeInUp" data-wow-delay="0.1s">
                <div class="card" style="box-shadow: 0 0 45px rgba(0, 0, 0, .08);">
                    <div class="card-body">
                        <div class="sidebar">
                            <div class="text-center mb-3">
                                <img src="<?php echo (!$global_member_avatar) ? 'img/user.png' : $global_member_avatar; ?>" class="rounded-circle" width="150px" height="150px"><br />
                                <div class=" mt-1"><?php echo $global_member_email; ?></div>
                                <div class="text-primary mt-1"><?php echo $global_member_type; ?></div>
                            </div>
                            <hr />
                            <a href="?menu=detail"><i class="fa fa-shopping-cart"></i> Book Now</a>
                            <hr />
                            <a href="?menu=member"><i class="fa fa-user"></i> Profile</a>
                            <a href="?menu=member&t=myBooking"><i class="fa fa-file-o"></i> My Booking</a>
                            <a href="?menu=member&t=myPoint"><i class="fas fa-solid fa-coins"></i> My Point(s)</a> 
                            <a href="?menu=member&t=setting"><i class="fa fa-cog"></i> Setting</a>
                            <a href="?menu=member&t=signOut"><i class="fa fa-power-off"></i> Logout</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-12 wow fadeInUp" style="color: black;font-size: 18px;" data-wow-delay="0.2s">
                <?php include("isiMember.php"); ?>
            </div>
        </div>
    </div>
</div>
<!-- Service End -->
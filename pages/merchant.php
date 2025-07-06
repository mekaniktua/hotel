<?php
$t = amankan($_GET['t'] ?? "");
if (empty($_SESSION['osg_merchant_id'])) {
    header("Location: login/");
}
$global_merchant_id = dekripsi(amankan($_SESSION['osg_merchant_id']));
$sData  = " SELECT *
            FROM merchant
            WHERE merchant_id='" . $global_merchant_id . "' and status_hapus='0'";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
$rData  = mysqli_fetch_array($qData);
$global_merchant_email = $rData['email'];
$global_merchant_type = $rData['merchant_type'];
$global_merchant_point = $rData['point'];
?>

<!-- Service Start -->
<div class="container-xxl py-5" style="margin-bottom: 100px;">
    <div class="container">
        <div class="text-center wow fadeInUp mb-5" data-wow-delay="0.1s">
            <h6 class="section-title text-center text-primary text-uppercase">Merchant Page</h6> 
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-12 wow fadeInUp" data-wow-delay="0.1s">
                <div class="card" style="box-shadow: 0 0 45px rgba(0, 0, 0, .08);">
                    <div class="card-body">
                        <div class="sidebar">
                            <div class="text-center mb-3">
                                <img src="<?php echo (!empty($rData['merchant_url']) ? $rData['merchant_url'] : "img/user.png");?>" class="rounded-circle" width="50%"><br />
                                <div class=" mt-1"><?php echo $global_merchant_email; ?></div>
                                <div class="text-primary mt-1"><?php echo $global_merchant_type; ?></div>
                            </div>
                            <hr /> 
                            <a href="?menu=merchant"><i class="fa fa-user"></i> Profile</a>
                            <a href="?menu=merchant&t=voucherList"><i class="fa fa-file-o"></i> Voucher</a> 
                            <a href="?menu=merchant&t=setting"><i class="fa fa-cog"></i> Setting</a>
                            <a href="?menu=merchant&t=signOut"><i class="fa fa-power-off"></i> Logout</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-12 wow fadeInUp" style="color: black;font-size: 18px;" data-wow-delay="0.2s">
                <?php include("isiMerchant.php"); ?>
            </div>
        </div>
    </div>
</div>
<!-- Service End -->
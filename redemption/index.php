<?php
ob_start();
session_start();
include("../manajemen/database.php");
$menu = amankan($_GET['menu']);

if (!empty($_SESSION['osg_member_id'])) {
    header("Location: ../?menu=member");
}

if (empty($_SESSION['osg_currency'])) {
    if (empty($_GET['currency'])) {
        $_SESSION['osg_currency'] = 'IDR'; //Set default currency
    } else {
        $_SESSION['osg_currency'] = amankan($_GET['currency']); //Change currency
    }
} else {
    if (!empty($_GET['currency'])) {
        $_SESSION['osg_currency'] = amankan($_GET['currency']); //Change currency
    }
}

$setting = getSetting($conn, $_SESSION['osg_currency']); //Set Setting
$_SESSION['osg_address'] = $setting['address'] ?? ''; //Set OSG address
$_SESSION['osg_phone'] = $setting['phone'] ?? ''; //Set OSG email   
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Redeem a Voucher - Orangeskygroup</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="../img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Libraries Stylesheet -->
    <link href="../lib/animate/animate.min.css" rel="stylesheet">
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JavaScript Libraries -->
    <script src="../lib/wow/wow.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/counterup/counterup.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../lib/tempusdominus/js/moment.min.js"></script>
    <script src="../lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="../lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
    <script src="../js/blockUI.js"></script>
</head>

<style>
    .card {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 30px;
        border-radius: 10px;
        background-color: #fff;
    }

    .voucher-title {
        font-size: 1.75rem;
        font-weight: bold;
        color: #f97316;
    }

    .voucher-description {
        font-size: 1.1rem;
        margin-top: 5px;
        color: #555;
    }

    .valid-until {
        font-size: 0.95rem;
        color: #888;
        margin-bottom: 20px;
    }

    .form-label {
        color: #333;
    }

    .form-control {
        border-color: #f97316;
    }

    .form-control:focus {
        border-color: #f97316;
        box-shadow: 0 0 0 0.2rem rgba(249, 115, 22, 0.2);
    }

    .btn-primary {
        background-color: #f97316;
        border-color: #f97316;
    }

    .btn-primary:hover {
        background-color: #f76300;
        border-color: #f76300;
    }

    .voucher-not-found {
        text-align: center;
        background-color: #ffffff;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .voucher-not-found h2 {
        color: #dc3545;
    }
</style>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Header Start -->
        <div class="container-fluid bg-dark px-0">
            <div class="row gx-0">
                <div class="col-lg-3 bg-dark d-none d-lg-block">
                    <a href="../" class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                        <h1 class="m-0 text-primary text-uppercase" style="font-size: 25px;">Orangesky</h1>
                    </a>
                </div>
                <div class="col-lg-9">
                    <div class="row gx-0 bg-white d-none d-lg-flex">
                        <div class="col-lg-7 px-5 text-start">
                            <div class="h-100 d-inline-flex align-items-center py-2 me-4">
                                <i class="fa fa-envelope text-primary me-2"></i>
                                <p class="mb-0">booknow@orangeskygroup.co.id</p>
                            </div>
                            <div class="h-100 d-inline-flex align-items-center py-2">
                                <i class="fa fa-phone-alt text-primary me-2"></i>
                                <p class="mb-0">(62) 811 668 7008</p>
                            </div>
                        </div>
                        <div class="col-lg-5 px-5 text-end">
                            <div class="d-inline-flex align-items-center py-2">
                                <a class="me-3" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="me-3" href=""><i class="fab fa-twitter"></i></a>
                                <a class="me-3" href=""><i class="fab fa-linkedin-in"></i></a>
                                <a class="me-3" href=""><i class="fab fa-instagram"></i></a>
                                <a class="" href=""><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                    <nav class="navbar navbar-expand-lg bg-dark navbar-dark p-3 p-lg-0">
                        <a href="../" class="navbar-brand d-block d-lg-none">
                            <h1 class="m-0 text-primary text-uppercase">Orangesky</h1>
                        </a>


                    </nav>
                </div>
            </div>
        </div>
        <!-- Header End -->
        <?php

        $voucher_id = dekripsi(amankan($_GET['v']));
        $sVoucher   = " SELECT *
                        FROM voucher
                        WHERE status_hapus='0' and voucher_id='" . $voucher_id . "'";
        $qVoucher = mysqli_query($conn, $sVoucher) or die(mysqli_error($conn));
        $rVoucher = mysqli_fetch_array($qVoucher);
        ?>

        <?php if (!empty($rVoucher['voucher_id'])) { ?>
            <div class="container">
                <div class="card py-5 pt-5  mt-3">
                    <div class="text-center mb-2 wow fadeInUp" data-wow-delay="0.1s">
                        <h6 class="section-title text-center text-primary text-uppercase">Voucher Redemption</h6>
                    </div>
                    <!-- Voucher Info -->
                    <div class="voucher-title"><?php echo $rVoucher['voucher_title'] ?></div>
                    <div class="voucher-description">
                        <?php echo $rVoucher['description'] ?>
                    </div>
                    <div class="valid-until">
                        <strong>Valid until:</strong> <?php echo normalTanggal($rVoucher['end_date']); ?>
                    </div>

                    <!-- Redemption Form -->
                    <form id="frmRedeem" method="post">
                        <div class="mb-5">
                            <label for="bookingId" class="form-label">Enter your Booking ID</label>
                            <input type="text" class="form-control" id="bID" name="bID" placeholder="e.g., BK123456" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Redeem Voucher</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php } else { ?>
            <div class="container">

                <div class="card voucher-not-found py-5 pt-5 mt-3">

                    <h2><i class="fa fa-times-circle"></i> Voucher Not Found</h2>
                    <p>Sorry, the voucher you're trying to redeem could not be found. Please check the details and try again.</p>
                    <div class="text-center">
                        <a href="../" class="btn btn-primary">Go Back to Home</a>
                    </div>
                </div>
            </div>
        <?php } ?>
        <p>&nbsp;</p>
        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="modalInfo" tabindex="-1" aria-labelledby="modalInfoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-success">
                <div class="modal-body text-center">
                    <div id="ajaxInfo"></div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        $("#frmRedeem").submit(function(e) {
            e.preventDefault(e);
            var frm = $('#frmRedeem')[0];
            var formData = new FormData(frm);
            formData.append('vID', '<?php echo enkripsi($voucher_id) ?>');
            $.ajax({
                type: "POST",
                url: "ajax/redeem.php",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $.blockUI({
                        message: '<h6><img src="../img/loading.gif" width="50" /> Please Wait</h6>'
                    });
                },
                success: function(data) {
                    $("#modalInfo").modal('show');
                    $("#ajaxInfo").html(data);

                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });
    </script>

</body>

</html>
<?php ob_end_flush(); ?>
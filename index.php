<?php
session_start();
ob_start();
include("manajemen/database.php");
$menu = amankan($_GET['menu'] ?? ''); 

$_SESSION['osg_member_id'] = $_COOKIE['osg_member_id'] ?? '';

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
$_SESSION['nilai_rupiah'] = $setting['nilai_rupiah']; //Set currency Rate
$_SESSION['nilai_per_point'] = $setting['nilai_per_point']; //Set nilai rupiah per point
$_SESSION['persen_max_point'] = $setting['persen_max_point']; //Set persen point maksimal saat booking
$_SESSION['persen_booking_point'] = $setting['persen_booking_point']; //Set persen point tambahan saat booking


//list currency
$sCurrency = "SELECT * FROM currency";
$qCurrency = mysqli_query($conn, $sCurrency) or die(mysqli_error($conn));


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Orangesky - Booking Service</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/select2.min.css" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">

    <!-- Splide CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>

    <!-- Owl Carousel JS -->
    <script src="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/owl.carousel.min.js"></script>

    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>


    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="js/select2.min.js"></script>
    <script src="js/blockUI.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>



</head>

<body>
    <div class="bg-white p-0">
        <!-- Spinner Start -->
        <!-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> -->
        <!-- Spinner End -->

        <!-- Header Start -->
        <div class="container-fluid bg-dark px-0">
            <div class="row gx-0">
                <div class="col-lg-3 bg-dark d-none d-lg-block">
                    <a href="./"
                        class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                        <h1 class="m-0 text-primary text-uppercase" style="font-size: 40px;">OrangeSky.id</h1>
                    </a>
                </div>
                <div class="col-lg-9">
                    <div class="row gx-0 bg-white d-none d-lg-flex">
                        <div class="col-lg-7 px-5 text-start">
                            <div class="h-100 d-inline-flex align-items-center py-2 me-4">
                                <i class="fa fa-envelope text-primary me-2"></i>
                                <p class="mb-0"><?php echo $setting['email'] ?></p>
                            </div>
                            <div class="h-100 d-inline-flex align-items-center py-2 me-4">
                                <i class="fas fa-phone-alt text-primary me-2"></i>
                                <p class="mb-0"><?php echo $setting['phone'] ?></p>
                            </div>

                        </div>
                        <div class="col-lg-5 px-5 text-end">
                            <div class="d-inline-flex align-items-center py-2">
                                <a class="me-3" href="<?php echo $setting['facebook'] ?>"><i
                                        class="fab fa-facebook-f"></i></a>
                                <a class="me-3" href="<?php echo $setting['twitter'] ?>"><i
                                        class="fab fa-twitter"></i></a>
                                <a class="me-3" href="<?php echo $setting['instagram'] ?>"><i
                                        class="fab fa-instagram"></i></a>
                                <a class="" href="<?php echo $setting['youtube'] ?>"><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
                        <div class="container-fluid">

                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarCollapse">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                                <!-- Nav Menu -->
                                <ul class="navbar-nav mb-2 mb-lg-0">
                                    <li class="nav-item">
                                        <a href="./" class="nav-link <?php echo $menu == '' ? 'active' : '' ?>"><i
                                                class="fa fa-home me-1"></i> Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="./?menu=voucher"
                                            class="nav-link <?php echo $menu == 'voucher' ? 'active' : '' ?>"><i
                                                class="fa fa-ticket me-1"></i> Voucher</a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a href="./merchant" class="nav-link"><i class="fa fa-building me-1"></i>
                                            Merchant</a>
                                    </li> -->
                                    <li class="nav-item">
                                        <a href="./?menu=contactUs"
                                            class="nav-link <?php echo $menu == 'contactUs' ? 'active' : '' ?>"><i
                                                class="fa fa-envelope me-1"></i> Contact Us</a>
                                    </li>

                                    <!-- Currency Dropdown -->
                                    <?php if($menu != 'booking'){ ?>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="currencyDropdown" role="button"
                                            data-bs-toggle="dropdown">
                                            <i class="fa fa-coin me-1"></i> <?php echo $_SESSION['osg_currency']; ?>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <?php while($rCurrency = mysqli_fetch_array($qCurrency)) {
                            $currency = $rCurrency['currency']; ?>
                                            <li>
                                                <a class="dropdown-item" href="<?php echo getFullUrl($currency) ?>"
                                                    data-currency="<?php echo $currency; ?>">
                                                    <?php echo $currency ?>
                                                    <?php if ($_SESSION['osg_currency'] == $currency) echo '<i class="fa fa-check text-success ms-2"></i>'; ?>
                                                </a>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                    <?php } ?>
                                </ul>

                                <!-- Account Button (Responsive) -->
                                <div class="d-flex" style="margin-right: 10px;">
                                    <?php if (!empty($_SESSION['osg_member_id'])) { ?>
                                    <a href="?menu=member" class="btn btn-outline-primary rounded-pill px-4 me-2">
                                        <i class="fa fa-user me-1"></i> My Account
                                    </a>
                                    <?php } else if (!empty($_SESSION['osg_merchant_id'])) { ?>
                                    <a href="./merchant" class="btn btn-outline-primary rounded-pill px-4 me-2">
                                        <i class="fa fa-user me-1"></i> My Account
                                    </a>
                                    <?php } else { ?>
                                    <a href="login/" class="btn btn-primary rounded-pill px-4 me-2">
                                        <i class="fa fa-sign-in me-1"></i> Login / Sign Up
                                    </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </nav>

                </div>
            </div>
        </div>
        <!-- Header End -->

        <?php include("isi.php"); ?>

        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-light footer wow fadeIn" data-wow-delay="0.1s">
            <div class="container pb-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-4">
                        <div class="bg-primary rounded p-4">
                            <a href="./">
                                <h1 class="text-white text-uppercase mb-3" style="font-size: 20px;">Orangesky</h1>
                            </a>
                            <p class="text-white mb-0">

                            Your Journey Starts Under the Orange Sky.</p>

                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <h6 class="section-title text-start text-primary text-uppercase mb-4">Contact</h6>
                        <p class="mb-2"><i class="fas fa-map-marker-alt me-3"></i><?php echo $setting['address'] ?></p>
                        <p class="mb-2"><i class="fas fa-phone-alt me-3"></i><?php echo $setting['phone'] ?></p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i><?php echo $setting['email'] ?></p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href="<?php echo $setting['twitter'] ?>"><i
                                    class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href="<?php echo $setting['facebook'] ?>"><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href="<?php echo $setting['youtube'] ?>"><i
                                    class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href="<?php echo $setting['instagram'] ?>"><i
                                    class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <!-- <div class="col-lg-5 col-md-12">
                        <div class="row gy-5 g-4">
                            <div class="col-md-6">
                                <h6 class="section-title text-start text-primary text-uppercase mb-4">Company</h6>
                                <a class="btn btn-link" href="">About Us</a>
                                <a class="btn btn-link" href="">Contact Us</a>
                                <a class="btn btn-link" href="">Privacy Policy</a>
                                <a class="btn btn-link" href="">Terms & Condition</a>
                                <a class="btn btn-link" href="">Support</a>
                            </div>
                            <div class="col-md-6">
                                <h6 class="section-title text-start text-primary text-uppercase mb-4">Services</h6>
                                <a class="btn btn-link" href="">Food & Restaurant</a>
                                <a class="btn btn-link" href="">Spa & Fitness</a>
                                <a class="btn btn-link" href="">Sports & Gaming</a>
                                <a class="btn btn-link" href="">Event & Party</a>
                                <a class="btn btn-link" href="">GYM & Yoga</a>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="container">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="./">OrangeSkyID</a>, All Right Reserved<a
                                class="border-bottom" href="https://htmlcodex.com">.</a>

                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="./">Home</a>
                                <a href="?menu=merchant">Merchant</a>
                                <a href="?menu=voucher">Vouchers</a>
                                <a href="?menu=contact">Contact</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>
    <!-- Template Javascript -->
    <script src="js/main.js"></script>


</body>

</html>
<?php
ob_end_flush();
?>
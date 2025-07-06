<?php session_start();
ob_start();
include('database.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <!-- basic -->
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- mobile metas -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="viewport" content="initial-scale=1, maximum-scale=1">
   <!-- site metas -->
   <title>Hotel - Admin Panel </title>
   <meta name="keywords" content="">
   <meta name="description" content="">
   <meta name="author" content="">
   <!-- site icon -->
   <link rel="icon" href="images/logo/favicon.ico" type="image/png" />
   <!-- bootstrap css -->
   <link rel="stylesheet" href="css/bootstrap.min.css" />
   <!-- site css -->
   <link rel="stylesheet" href="style.css" />
   <!-- responsive css -->
   <link rel="stylesheet" href="css/responsive.css" />
   <!-- select bootstrap -->
   <link rel="stylesheet" href="css/bootstrap-select.css" />
   <!-- scrollbar css -->
   <link rel="stylesheet" href="css/perfect-scrollbar.css" />
   <!-- custom css -->
   <link rel="stylesheet" href="css/custom.css" />
   <!-- Font Awesome 6 CDN (Free) -->
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"> 
 
 
   <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
   <link rel="stylesheet" href=" https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
   <link rel="stylesheet" href="css/select2.min.css" />
   <link href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
   <script src="js/jquery.min.js"></script>
   <script src="js/jquery-3.3.1.min.js"></script>

   <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
   <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
   <script src="js/popper.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
   <!-- wow animation -->
   <script src="js/animate.js"></script>
   <!-- select country -->
   <script src="js/bootstrap-select.js"></script>
   <!-- owl carousel -->
   <script src="js/owl.carousel.js"></script>
   <!-- chart js -->
   <script src="js/Chart.min.js"></script>
   <script src="js/Chart.bundle.min.js"></script>
   <script src="js/utils.js"></script>
   <script src="js/analyser.js"></script>
   <script src="js/blockUI.js"></script>
   <script src="js/select2.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>


   <!-- custom js -->
   <script src="js/custom.js"></script>
   <!-- Ekko Lightbox -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
   <script src="js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
   <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>
</head>

<?php
$user_id = amankan(dekripsi($_SESSION['orangesky_user_id'] ?? ''));
$sData = "  SELECT u.*
            FROM users u 
            WHERE u.user_id='" . $user_id . "'";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
$rData = mysqli_fetch_array($qData);

if (empty($rData['user_id'])) {
   header("Location: login.php");
}
?>

<body class="dashboard dashboard_1">
   <div class="full_container">
      <div class="inner_container">
         <!-- Sidebar  -->
         <nav id="sidebar">
            <div class="sidebar_blog_1">
               <div class="sidebar-header">
                  <div class="logo_section">
                     <a href="./"><img class="logo_icon img-responsive" src="../img/logo-OSM.png" alt="#" /></a>
                  </div>
               </div>
               <div class="sidebar_user_info">
                  <div class="icon_setting"></div>
                  <div class="user_profle_side">
                     <div class="user_img"><img src="<?php echo (!empty($rData['user_url']) ? "../" . $rData['user_url'] : "images/no_image.png"); ?>" class="img-responsive"></div>
                     <div class="user_info">
                        <h6><?php echo $rData['name'] ?? ''; ?></h6>
                        <p><span class="online_animation"></span> <?php echo $rData['user_type'] ?? '' ?></p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="sidebar_blog_2">
               <h4>Menu</h4>
               <ul class="list-unstyled components">
                  <li><a href="./"><i class="fa fa-dashboard orange_color"></i> <span>Home</span></a></li>
                  <li>
                     <a href="#menuBooking" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-shopping-cart blue1_color"></i> <span>Booking</span></a>
                     <ul class="collapse list-unstyled" id="menuBooking">
                        <li><a href="?menu=bookingKeyword"> <span>By Keyword</span></a></li>
                        <li><a href="?menu=bookingDate"> <span>By Date</span></a></li>
                     </ul>
                  </li>
                  <!-- <li><a href="?menu=absensi"><i class="fa fa-user orange_color"></i> <span>Absensi</span></a></li> -->
                  <li><a href="?menu=member"><i class="fa fa-users orange_color"></i> <span>Data Member</span></a></li>
                  <li>
                     <a href="#property" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-building yellow_color"></i> <span>Property</span></a>
                     <ul class="collapse list-unstyled" id="property">
                        <li><a href="?menu=propertyNew"> <span>New Property</span></a></li>
                        <li><a href="?menu=property"> <span>Data Property</span></a></li>
                        <li><a href="?menu=facility"> <span>Data Facility</span></a></li>
                        <li><a href="?menu=ratePlans"> <span>Rate Plan & Avability</span></a></li>
                     </ul>
                  </li>
                  <li>
                     <a href="#merchant" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-store-alt blue2_color"></i> <span>Merchant</span></a>
                     <ul class="collapse list-unstyled" id="merchant">
                        <li><a href="?menu=merchantNew"> <span>New Merchant</span></a></li>
                        <li><a href="?menu=merchant"> <span>Data Merchant</span></a></li>
                        
                     </ul>
                  </li>
                  <li>
                     <a href="#voucher" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-bullhorn yellow_color"></i> <span>Voucher</span></a>
                     <ul class="collapse list-unstyled" id="voucher">
                        <li><a href="?menu=voucherNew"> <span>New Voucher</span></a></li>
                        <li><a href="?menu=voucher"> <span>Data Voucher</span></a></li>
                     </ul>
                  </li>
                  <li>
                     <a href="#user" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-user orange_color"></i> <span>Users</span></a>
                     <ul class="collapse list-unstyled" id="user">
                        <li><a href="?menu=userNew"> <span>New User</span></a></li>
                        <li><a href="?menu=user"> <span>Data User</span></a></li>
                     </ul>
                  </li>

                  <li class="active">
                     <a href="#additional_page" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-clone yellow_color"></i> <span>Laporan</span></a>
                     <ul class="collapse list-unstyled" id="additional_page">
                        <li>

                           <a href="?menu=lapBooking"> <span>Booking</span></a>
                           <a href="?menu=lapMember"> <span>Member</span></a>
                           <a href="?menu=lapMerchant"> <span>Merchant</span></a>
                           <a href="?menu=lapVoucher"> <span>Voucher</span></a>
                           <a href="?menu=lapRoom"> <span>Room</span></a>   
                        </li>
                     </ul>
                  </li>
               </ul>
               <div class="text-center" style="text-align: center;">
                  <p style="color: orange;">Copyright © <?php echo date("Y"); ?> OrangeSkyGroup.</p>
               </div>
            </div>

         </nav>
         <!-- end sidebar -->
         <!-- right content -->
         <div id="content">
            <!-- topbar -->
            <div class="topbar">
               <nav class="navbar navbar-expand-lg navbar-light">
                  <div class="full">
                     <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
                     <div class="logo_section">
                        <a href="./"><img class="img-responsive" src="../img/logo-OSM.png" alt="#" /></a>
                     </div>
                     <div class="right_topbar">
                        <div class="icon_info">

                           <ul class="user_profile_dd">
                              <li>
                                 <a class="dropdown-toggle" data-toggle="dropdown"><img class="img-responsive rounded-circle" src="<?php echo (!empty($rData['user_url']) ? "../" . $rData['user_url'] : "images/no_image.png"); ?>" alt="#" /><span class="name_user"><?php echo $rData['name'] ?? '' ?></span></a>
                                 <div class="dropdown-menu">
                                    <a class="dropdown-item" href="?menu=gantiPass">Ganti Password</a>
                                    <a class="dropdown-item" href="?menu=keluar"><span>Log Out</span> <i class="fa fa-sign-out"></i></a>
                                 </div>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </nav>
            </div>
            <!-- end topbar -->
            <?php include('isi.php'); ?>
         </div>
      </div>
   </div>
   <!-- jQuery -->
</body>

</html>
<?php ob_end_flush(); ?>
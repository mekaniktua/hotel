<?php
$booking_id = dekripsi(amankan($_GET['bID'] ?? ''));

$global_member_id = dekripsi(amankan($_COOKIE['osg_member_id'] ?? $_SESSION['osg_member_id']));
$sData  = " SELECT b.*,m.email,p.property_name,p.address,p.city,p.property_url,rt.room_type,rt.price,rt.description,rt.space,m.point,rt.price
            FROM booking b 
            left JOIN member m ON m.member_id=b.member_id
            JOIN property p ON p.property_id=b.property_id
            JOIN room_type rt ON rt.room_type_id=b.room_type_id
            WHERE booking_id='" . $booking_id . "' and b.status='Draft' and b.status_hapus='0'";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
$rData  = mysqli_fetch_array($qData);

if(empty($rData)){
    header("Location: ./");
    exit();
}
$roomsCount = $rData['rooms'];
$room_type_id = $rData['room_type_id'];
$property_id = $rData['property_id'];
$room_id = $rData['room_id'];
 

if ($_SESSION['osg_currency'] != 'IDR') {
    $total_price = ($rData['total_nilai_rupiah'] / $_SESSION['nilai_rupiah']);
    // $sUpdate = " UPDATE booking SET currency='".$_SESSION['osg_currency']."', total = ".$total_price." WHERE booking_id='".$booking_id."' and status='Draft'";
    // $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
} else {
    $total_price = $rData['total_nilai_rupiah'];
    // $sUpdate = " UPDATE booking SET currency='" . $_SESSION['osg_currency'] . "', total = " . $total_price . " WHERE booking_id='" . $booking_id . "' and status='Draft'";
    // $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
}
 
//setprice


$start = new DateTime($rData['start_date']);
$end = new DateTime($rData['end_date']);

$nightCount = $start->diff($end)->days;


$start_date = date('D, M j', strtotime($rData['start_date']));
$end_date = date('D, M j', strtotime($rData['end_date']));

$sRoom = "SELECT * FROM room WHERE room_id='" . $room_id . "' and status_hapus='0' ";
$qRoom = mysqli_query($conn, $sRoom) or die(mysqli_error($conn));
$rRoom = mysqli_fetch_array($qRoom);

$sGallery = "SELECT * FROM gallery WHERE room_type_id='" . $room_type_id . "' and status_hapus='0' 
            ORDER BY gallery_id DESC 
            LIMIT 1";
$qGallery = mysqli_query($conn, $sGallery) or die(mysqli_error($conn));
$rGallery = mysqli_fetch_array($qGallery);

$sFacility = " SELECT f.facility_name
                FROM facility f
                JOIN room_facility fk On fk.facility_id=f.facility_id 
                WHERE fk.status_hapus='0' and room_type_id ='" . $room_type_id . "'";
$qFacility = mysqli_query($conn, $sFacility) or die(mysqli_error($conn));

//Point maks yang bsa digunakan 10% dari total harga   
$max_point_used = round(($_SESSION['persen_max_point'] * $rData['total_nilai_rupiah'] / 100) / $_SESSION['nilai_per_point'], 1);


?>

<!-- Service Start -->
<div class="container-fluid py-5" style="margin-bottom: 100px;">
    <div class="container-fluid">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title text-center text-primary text-uppercase">Booking</h6>
            <h1 class="mb-5">Final <span class="text-primary text-uppercase">step</span></h1>
        </div>
        <div class="row g-4">
            <div class="col-lg-8 col-md-12 wow fadeInUp" style="color: black;font-size: 18px;" data-wow-delay="0.2s">
                <?php if (!empty($global_member_id)) { ?>
                <div class="card mb-3" style="box-shadow: 0 0 45px rgba(0, 0, 0, .08);">
                    <div class="card-body">
                        <div class="d-flex align-items-center">

                            <img src="img/user.png" class="rounded me-2" width="55" alt="User">
                            <div class="">
                                <small class="d-block">Booked by</small>
                                <h5 class="mb-0 fs-6"><?php echo $rData['email'] ?></h5>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card mb-3" style="box-shadow: 0 0 45px rgba(0, 0, 0, .08);">
                    <div class="card-body">
                        <h5 class="mb-0 fs-5"><i class="fas fa-solid fa-comment me-2"></i>Special Request</h5>
                        <small>Select your preference(s). Subject to availability.</small>
                        <div class="row g-4 mt-1">
                            <div class="col-md-12 wow fadeInUp" data-wow-delay="0.1s">
                                <textarea id="special_request" class="form-control" rows="5"
                                    placeholder="Type your request here"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3" style="box-shadow: 0 0 45px rgba(0, 0, 0, .08);">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="mb-0 fs-5"><i class="fas fa-solid fa-coins"></i> Points<span
                                        style="color: red;">*</span></h5>
                                <small>Use your points for a discount (max 10% of the transaction).</small>
                            </div>
                            <div>
                                <h5 class="card-title"><?php echo $rData['point'] ?></h5>
                            </div>
                        </div>

                        <div class="row g-4 mt-1">
                            <div class="col-md-12 wow fadeInUp d-flex align-items-center" data-wow-delay="0.1s">
                                <input type="hidden" name="point" id="point" value="<?php echo $rData['point'] ?>">
                                <input type="hidden" class="form-control me-2" value="<?php echo $max_point_used; ?>"
                                    name="point_used" id="point_used">
                                <h3 class="mb-0 text-primary"><?php echo $max_point_used; ?></h3>&nbsp;
                                <button class="btn btn-primary" id="btnPoint">Use Point</button>
                            </div>
                            <small class="text-muted fs-6" style="margin-top: 0">Click button to use point.</small>
                        </div>
                    </div>
                </div>
                <div class="card mb-3" style="box-shadow: 0 0 45px rgba(0, 0, 0, .08);">
                    <div class="card-body">
                        <h5 class="mb-0 fs-5"><i class="fas fa-solid fa-money me-2"></i>Payment Method</h5>
                        <small>Select your payment method.</small>
                        <form id="frmSimpan" method="post" action="">
                            <input type="hidden" name="bID" id="bID"
                                value="<?php echo enkripsi($rData['booking_id']); ?>">
                            <div class="row g-4 mt-1">
                                <div class="col-md-12 wow fadeInUp" data-wow-delay="0.1s">
                                    <select class="select2_single form-select" name="payment_method" id="payment_method"
                                        aria-label="Default select example">
                                        <option value="PayNow">Pay Now</option>
                                        <option value="PayHotel">Pay at Hotel</option>
                                    </select>
                                    <button class="btn btn-primary btn-lg mt-3" style="width: 100%;"
                                        id="btnConfirm">Confirm Booking</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <?php }else{ //card login?>
                <div class="card mb-3" style="box-shadow: 0 0 45px rgba(0, 0, 0, .08);">
                    <div class="card-body">
                         <!-- Bootstrap 5 Nav Tabs -->
<ul class="nav nav-tabs justify-content-center mb-4" id="authTabs" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">
    <i class="bi bi-box-arrow-in-right me-2"></i>Login
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="signup-tab" data-bs-toggle="tab" data-bs-target="#signup" type="button" role="tab">
    <i class="bi bi-person-plus-fill me-2"></i> Sign Up
    </button>
  </li>
</ul>

<!-- Tab Content -->
<div class="tab-content" id="authTabsContent">

  <!-- Login Tab -->
  <div class="tab-pane fade show active" id="login" role="tabpanel">
    <h5 class="mb-0 fs-5"><i class="fas fa-user me-2"></i>Login</h5>
    <small>Please login to continue.</small>
    <form id="frmLogin" method="post">
      <div class="row g-4 mt-1">
        <div class="col-md-12">
          <input type="hidden" name="bID" id="bID" value="<?php echo enkripsi($booking_id); ?>">
          <input type="text" class="form-control" name="umail" id="email" placeholder="Email">
        </div>
        <div class="col-md-12">
          <div class="input-group">
            <input type="password" class="form-control" name="upass" id="upass" placeholder="Password">
            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
              <i class="bi bi-eye"></i>
            </button>
          </div>
        </div>
        <div class="col-md-12 text-center">
          <div class="d-grid gap-3 mt-3">
            <button class="btn btn-primary btn-lg" id="btnLogin">
              <i class="bi bi-box-arrow-in-right me-2"></i> Login
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>

  <!-- Sign Up Tab -->
  <div class="tab-pane fade" id="signup" role="tabpanel">
    <h5 class="mb-0 fs-5"><i class="fas fa-user-plus me-2"></i>Sign Up</h5>
    <small>Create a new account.</small>
    <form id="frmSignUp" method="post">
      <div class="row g-4 mt-1">
        <div class="col-md-12">
          <input type="text" class="form-control" name="fullname" placeholder="Full Name">
        </div>
        <div class="col-md-12">
          <input type="email" class="form-control" name="email" placeholder="Email">
        </div>
        <div class="col-md-12">
          <input type="tel" class="form-control" name="mobile_number" placeholder="Mobile Number">
        </div>
        <div class="col-md-12">
          <div class="input-group">
            <input type="password" class="form-control" name="passwordSignup" id="passwordSignup" placeholder="Min 6 characters and contain both letters and numbers">
            <button class="btn btn-outline-secondary" type="button" id="togglePasswordSignup">
              <i class="bi bi-eye"></i>
            </button>
          </div>
        </div>
        <div class="col-md-12 text-center">
          <div class="d-grid gap-3 mt-3">
            <button class="btn btn-warning btn-lg" id="btnSignUp">
              <i class="bi bi-person-plus-fill me-2"></i> Sign Up
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

                    </div>
                </div>
                <script>
                // Password toggle functionality for login
                const togglePassword = document.getElementById('togglePassword');
                const password = document.getElementById('upass');

                togglePassword.addEventListener('click', function() {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);

                    // Ganti ikon
                    this.innerHTML = type === 'password' ?
                        '<i class="bi bi-eye"></i>' :
                        '<i class="bi bi-eye-slash"></i>';
                });

                // Password toggle functionality for signup password
                const togglePasswordSignup = document.getElementById('togglePasswordSignup');
                const passwordSignup = document.getElementById('passwordSignup');

                togglePasswordSignup.addEventListener('click', function() {
                    const type = passwordSignup.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordSignup.setAttribute('type', type);

                    // Ganti ikon
                    this.innerHTML = type === 'password' ?
                        '<i class="bi bi-eye"></i>' :
                        '<i class="bi bi-eye-slash"></i>';
                });

                 

                // Login form submission
                $("#frmLogin").submit(function(e) {
                    e.preventDefault();
                    var frm = $('#frmLogin')[0];
                    var formData = new FormData(frm);
                    $.ajax({
                        type: "POST",
                        url: "ajax/bookingLogin.php",
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            $('#btnLogin').prop('disabled', true);
                            $.blockUI({
                                message: '<h6><img src="img/loading.gif" width="50" /> Please Wait</h6>'
                            });
                        },
                        success: function(data) {
                            $("#modalInfo").modal('show');
                            $("#ajaxInfo").html(data);
                        },
                        complete: function() {
                            $('#btnLogin').prop('disabled', false);
                            $.unblockUI();
                        }
                    });
                });

                // Signup form submission
                $("#frmSignUp").submit(function(e) {
                    e.preventDefault();
                     
                    var frm = $('#frmSignUp')[0];
                    var formData = new FormData(frm);
                    formData.append('bID', '<?php echo enkripsi($booking_id); ?>');
                    $.ajax({
                        type: "POST",
                        url: "ajax/bookingSignup.php",
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            $('#btnSignup').prop('disabled', true);
                            $.blockUI({
                                message: '<h6><img src="img/loading.gif" width="50" /> Please Wait</h6>'
                            });
                        },
                        success: function(data) {
                            $("#modalInfo").modal('show');
                            $("#ajaxInfo").html(data);
                        },
                        complete: function() {
                            $('#btnSignup').prop('disabled', false);
                            $.unblockUI();
                        }
                    });
                });
                </script>
                <?php } ?>

            </div>
            <div class="col-lg-4 col-md-12 wow fadeInUp" data-wow-delay="0.1s">
                <div class="card mb-3" style="box-shadow: 0 0 45px rgba(0, 0, 0, .08);">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <small class="text-muted">Check-In</small>
                                <h5 class="card-title"><?php echo $start_date ?></h5>
                            </div>
                            <div>
                                <small class="text-muted">Check-Out</small>
                                <h5 class="card-title"><?php echo $end_date ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3" style="box-shadow: 0 0 45px rgba(0, 0, 0, .08);">
                    <div class="card-body">
                        <div class="d-flex mb-5">
                            <div class="me-3"
                                style="width: 250px; height: 150px; overflow: hidden; border-radius: 0.375rem;">
                                <img src="<?php echo $rData['property_url'] ?>"
                                    style="object-fit: cover; width: 100%; height: 100%;" class="rounded img-fluid"
                                    alt="<?php echo $rData['property_name'] ?>">
                            </div>
                            <div>
                                <h5 class="mb-2 "><?php echo $rData['property_name'] ?></h5>
                                <small class="text-muted  "><?php echo $rData['address'] ?></small><br>
                                <i class="fa fa-map-marker text-primary me-2"></i><small
                                    class="text-muted"><?php echo $rData['city'] ?></small>
                            </div>
                        </div>

                        <small class="text-muted mb-2">
                            <i class="fa fa-bed"></i> Room Type
                        </small>

                        <div class="d-flex mb-3">
                            <!-- Gambar -->
                            <div class="me-3">
                                <div style="width: 150px; height: 150px; overflow: hidden; border-radius: 0.375rem;">
                                    <img class="img-fluid" src="<?php echo $rGallery['gallery_url'] ?>" alt="Room Type"
                                        style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            </div>

                            <!-- Teks Samping Gambar -->
                            <div class="align-self-start">
                                <h5 class="fs-5 fw-semibold d-block mb-1"><?php echo $rData['room_type'] ?></h5>
                                <p class="mb-3">
                                    <span class="text-primary"><?php echo $rData['space'] ?> m<sup>2</sup></span> |
                                    <span class="text-secondary"><i
                                            class="fas fa-bed me-1"></i><?php echo $rRoom['bed']; ?> Bed</span> |
                                    <span class="text-secondary"><i
                                            class="fa fa-solid fa-user"></i><?php echo $rData['adult']; ?> <i
                                            class="fa fa-solid fa-child"></i><?php echo $rData['child']; ?></span>
                                </p>

                                <ul class="p-0 list-unstyled">
                                    <?php while ($rFacility = mysqli_fetch_array($qFacility)) { ?>
                                    <li class="text-muted"><i
                                            class="fa fa-check text-success me-2"></i><?php echo $rFacility['facility_name'] ?>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3" style="box-shadow: 0 0 45px rgba(0, 0, 0, .08);">
                    <div class="card-body">
                        <h5 class="mb-0 fs-5"><i class="fas fa-file-invoice me-1 mb-2"></i>Price Total</h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted"><?php echo $roomsCount; ?> room(s) x <?php echo $nightCount; ?>
                                    night(s)</p>
                            </div>
                            <div class="text-primary fw-bold" style="font-size: 20px;">
                                <p><?php
                                    if ($_SESSION['osg_currency'] == 'IDR') {
                                        echo angka($total_price);
                                    } else {
                                        echo number_format($total_price, 1, '.', ',');
                                    }
                                    ?></p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center d-none" id="divPointUsed">
                            <div>
                                <p class="text-muted"><span id="point_used_price"></span> Points Used</p>
                            </div>
                            <div class="text-primary fw-bold" style="font-size: 20px;">
                                <p><span id="nilai_point"></span></p>
                            </div>
                        </div>
                        <hr />
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted"><span id="point_used_price"></span> &nbsp;</p>
                            </div>
                            <div class="text-primary fw-bold" style="font-size: 20px;">
                                <p><span id="total_price"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Service End -->

<!-- Modal -->
<div class="modal fade" id="modalInfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="ajaxInfo"></div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $("#total_price").html(
        '<?php echo $_SESSION['osg_currency'] . " " . ($_SESSION['osg_currency'] == 'IDR' ? angka($total_price) : number_format($total_price, 1)); ?>'
    );
    $(".select2_single").select2();
});

function bookingUpdate() {
    var formData = new FormData();
    formData.append('point_used', $("#point_used").val());
    formData.append('bID', '<?php echo enkripsi($booking_id); ?>');
    formData.append('tp', '<?php echo enkripsi($total_price); ?>');

    $.ajax({
        type: "POST",
        url: "ajax/bookingUpdate.php",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
            $.blockUI({
                message: '<h6><img src="img/loading.gif" width="50" /> Please Wait</h6>'
            });
        },
        success: function(data) {
            $('#btnConfirm').prop('disabled', false);
            $("#ajaxInfo").html(data);

        },
        complete: function() {
            $.unblockUI();
        }
    });
}


$("#btnPoint").click(function(e) {
    var max_point_used = <?php echo $max_point_used; ?>;
    if ($("#point_used").val() > max_point_used) {
        alert("Max points to use is " + max_point_used);
        $("#point_used").val(max_point_used); //set ke max point
        return false;
    } else {

        bookingUpdate();
    }
});


$("#frmSimpan").submit(function(e) {
    e.preventDefault();
    if (confirm("Are you sure you want to confirm this booking?")) {

        var frm = $('#frmSimpan')[0];
        var formData = new FormData(frm);
        formData.append('special_request', $("#special_request").val());
        formData.append('tp', '<?php echo enkripsi($total_price); ?>');
        $.ajax({
            type: "POST",
            url: "ajax/bookingConfirmation.php",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                // $('#btnConfirm').prop('disabled', true);
                $.blockUI({
                    message: '<h6><img src="img/loading.gif" width="50" /> Please Wait</h6>'
                });
            },
            success: function(data) {
                //bookingUpdate();
                $("#modalInfo").modal('show');
                $("#ajaxInfo").html(data);

            },
            complete: function() {
                $.unblockUI();
            }
        });
    }
});
</script>
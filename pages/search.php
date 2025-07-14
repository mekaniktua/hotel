<?php
$t = amankan($_GET['t'] ?? '');
$rooms = amankan($_GET['rooms'] ?? 1);
$adults = amankan($_GET['adult'] ?? 2);
$children = amankan($_GET['child'] ?? 0);

$global_member_id = dekripsi(amankan($_SESSION['osg_member_id'] ?? ''));
$sProperti  = " SELECT *
            FROM property
            WHERE status_hapus='0'";
$qProperti = mysqli_query($conn, $sProperti) or die(mysqli_error($conn));

$i = 0;
$divProperti = '';
while ($rProperti  = mysqli_fetch_array($qProperti)) {
    $i += 1;
    $divProperti .= "<div class='form-check mb-2 mt-2'>
                        <input class='form-check-input' name='properties[]' value='" . enkripsi($rProperti['property_id']) . "' type='checkbox' id='Properti$i'>
                        <label class='form-check-label' for='Properti$i'>
                            <span>" . $rProperti['property_name'] . "</span> 
                        </label>
                    </div>";
}

$sVoucher = " SELECT p.*,m.merchant_url,m.name merchant_name
                FROM voucher p
                JOIN merchant m ON p.merchant_id = m.merchant_id
                WHERE p.status_hapus='0' and p.status='Publish' and p.start_date <= CURDATE() and p.end_date >= CURDATE()";
$qVoucher = mysqli_query($conn, $sVoucher) or die(mysqli_error($conn));

$sProperty  = " SELECT *
            FROM property p
            WHERE p.status_hapus='0'";
$qProperty  = mysqli_query($conn, $sProperty) or die(mysqli_error($conn));

// $rMerchant  = " SELECT m.* 
//                 FROM merchant m
//                 JOIN merchant_type mt ON m.merchant_type = mt.merchant_type
//                 WHERE m.status_hapus='0' 
//                 LIMIT 6";
// $qMerchant  = mysqli_query($conn, $rMerchant) or die(mysqli_error($conn));

// $mType = '';
// $mList = '';
// while ($rMerchant = mysqli_fetch_array($qMerchant)) {
//     $mType .= "<button class='btn btn-outline-primary filter-btn' data-filter='" . $rMerchant['merchant_type'] . "'>" . $rMerchant['merchant_type'] . "</button> ";
//     $mList .= "
// <div class='col-md-3 portfolio-item wow fadeInUp' data-wow-delay='0.1s' data-category='" . $rMerchant['merchant_type'] . "'>
//     <div class='room-item bg-transparent rounded shadow text-center'>
//         <div class='w-100 h-100 rounded d-flex align-items-center justify-content-center pt-4'>
//             <img src='" . $rMerchant['merchant_url'] . "' class='img-fluid' alt='" . $rMerchant['name'] . "' style='width: 200px; height: 200px; object-fit: cover;'>
//         </div>

//         <h5 class='mb-2 mt-3'>" . $rMerchant['name'] . "</h5>
//         <div class='d-flex justify-content-center mb-3'>
//             <small class='mb-3'>
//                 <i class='fas fa-envelope text-primary me-2'></i>" . $rMerchant['email'] . "
//             </small>
//         </div>
//     </div>
// </div>";
// }
?>

<style>
.form-check-input {
    transform: scale(1.5);
    /* Make checkbox 1.5x bigger */
    margin-right: 8px;
    /* Optional: better spacing */

}

.form-check-lab el {
    font-size: 18px;
}

.filter-btn.active {
    background-color: #FEA116;
    color: white;
}
</style>

<!-- Page Header Start -->
<div class="container-fluid page-header mb-5 p-0" style="background-image: url(img/carousel-1.jpg);">
    <div class="container-fluid page-header-inner py-5">


        <!-- Page Header End -->

        <!-- Booking Start -->
        <div class="container-fluid booking pb-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="px-3" style="margin-top: 120px;">
                <div class="bg-white shadow" style="padding: 35px;">
                    <div class="row g-2">
                        <form id="frmCari" class="row g-2">
                            <div class="col-md-10">
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="date" id="date1">
                                            <input type="text" name="date" class="form-control form-control-lg"
                                                id="rangePicker" style="background-color: white;"
                                                placeholder="Check in" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative">
                                            <!-- Tombol Pemicu -->
                                            <button type="button" class="form-control form-control-lg text-start"
                                                id="guestSummary" style="background-color: white;">
                                                <?php echo $rooms ?> Room<?php echo $rooms > 1 ? 's' : '' ?>,
                                                <?php echo $adults ?> Adult<?php echo $adults > 1 ? 's' : '' ?>,
                                                <?php echo $children ?> Child<?php echo $children > 1 ? 'ren' : '' ?>
                                            </button>

                                            <!-- Dropdown Manual -->
                                            <div class="dropdown-menu p-3" id="guestDropdown" style="min-width: 300px;">
                                                <div class="mb-2">
                                                    <label class="form-label">Rooms</label>
                                                    <div class="input-group">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            onclick="updateGuest('rooms', -1)">−</button>
                                                        <input type="text" id="rooms" name="rooms"
                                                            class="form-control text-center"
                                                            value="<?php echo $rooms ?>" readonly>
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            onclick="updateGuest('rooms', 1)">+</button>
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Adults <small
                                                            class="text-muted">(12+)</small></label>
                                                    <div class="input-group">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            onclick="updateGuest('adults', -1)">−</button>
                                                        <input type="text" id="adults" name="adult"
                                                            class="form-control text-center"
                                                            value="<?php echo $adults ?>" readonly>
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            onclick="updateGuest('adults', 1)">+</button>
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Children <small
                                                            class="text-muted">(0-12)</small></label>
                                                    <div class="input-group">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            onclick="updateGuest('children', -1)">−</button>
                                                        <input type="text" id="children" name="child"
                                                            class="form-control text-center"
                                                            value="<?php echo $children ?>" readonly>
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            onclick="updateGuest('children', 1)">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-lg rounded btn-primary w-100"><i
                                        class="fa fa-search"></i> Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Booking End -->

<?php if (isset($_GET['search']) && $_GET['search'] == 1) { ?>

<!-- Service Start -->
<div class="container-fluid py-5" style="margin-top:-30px;margin-bottom: 100px;">
    <div class="px-3">
        <div class="row g-4">
            <!-- <div class="col-lg-3 col-md-12 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="card mb-3" style="box-shadow: 0 0 45px rgba(0, 0, 0, .08);">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2" data-bs-toggle="collapse" data-bs-target="#collapseFacilities" aria-expanded="true" role="button">
                                <h5 class="fw-bold mb-2">Properties</h5>
                                <i id="toggleFacilities" class="bi bi-chevron-up"></i>
                            </div>

                            <div class="collapse show" id="collapseFacilities">
                                <?php //echo $divProperti; ?>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="box-shadow: 0 0 45px rgba(0, 0, 0, .08);">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center mb-2" data-bs-toggle="collapse" data-bs-target="#collapseSpace" aria-expanded="true" role="button">
                                <h5 class="fw-bold mb-2">Space</h5>
                                <i id="toggleSpace" class="bi bi-chevron-up"></i>
                            </div>

                            <div class="collapse show" id="collapseSpace">
                                <div class=' form-check mb-2 mt-2'>
                                    <input class='form-check-input' type='checkbox' value="L1020" name='spaces[]' id='L1020'>
                                    <label class='form-check-label' for='L1020'>
                                        <span>10 - 20 m2</span>
                                    </label>
                                </div>
                                <div class='form-check mb-2 mt-2'>
                                    <input class='form-check-input' type='checkbox' value="L2030" name='spaces[]' id='L2030'>
                                    <label class='form-check-label' for='L2030'>
                                        <span>21 - 30 m2</span>
                                    </label>
                                </div>
                                <div class='form-check mb-2 mt-2'>
                                    <input class='form-check-input' type='checkbox' value="L3040" name='spaces[]' id='L3040'>
                                    <label class='form-check-label' for='L3040'>
                                        <span>31- 40 m2</span>
                                    </label>
                                </div>
                                <div class='form-check mb-2 mt-2'>
                                    <input class='form-check-input' type='checkbox' value="L40" name='spaces[]' id='L40'>
                                    <label class='form-check-label' for='L40'>
                                        <span>> 40 m2</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            <div class="col-lg-12 col-md-12 wow fadeInUp" data-wow-delay="0.2s">
                <div id="propertiList"></div>
            </div>
        </div>
    </div>
</div>
<!-- Service End -->

<?php } else { ?>
    <style>
.owl-nav-custom button {
    z-index: 10;
}
</style>
<div class="container mt-5 wow zoomIn mb-5" data-wow-delay="0.1s">
    
    <div class="d-flex justify-content-between">
    <div>
        <h5><i class="fa fa-ticket"></i> Voucher For You</h5>
    </div>
    <div style="margin-right: 40px;">
        <a href="?menu=voucher">View All</a>
    </div>
    </div>

    <div class="position-relative">
        <div class="owl-carousel testimonial-carousel py-2" style="z-index: 0   ;">
            <?php while ($rVoucher = mysqli_fetch_array($qVoucher)) { ?>
            <img src="<?php echo $rVoucher['voucher_url'] ?>" alt="<?php echo $rVoucher['voucher_title'] ?>"
                class="img-fluid" style="width: 400px; height: 200px; object-fit: cover;border-radius: 30px;cursor: pointer;" onclick="voucherInfo('<?php echo enkripsi($rVoucher['voucher_id']); ?>')">
            <?php } ?>
        </div>

        <!-- Tombol Navigasi -->
        <div class="owl-nav-custom">
            <button
                class="owl-prev-custom btn btn-primary position-absolute start-0 top-50 translate-middle-y">
                <i class="fa fa-chevron-left"></i>
            </button>
            <button class="owl-next-custom btn btn-primary position-absolute end-0 top-50 translate-middle-y">
                <i class="fa fa-chevron-right"></i>
            </button>
        </div>
    </div>
</div>
<script>

    function voucherInfo(x) {
        $.ajax({
            url: "ajax/voucherInfo.php",
            type: "POST",
            data: {
                vID: x
            },
            beforeSend: function() {
                $.blockUI({
                    message: '<img src="img/loading.gif" width="50" /> Please Wait'
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
    }

    // Custom button actions
    $('.owl-next-custom').click(function() {
        owl.trigger('next.owl.carousel');
    });
    $('.owl-prev-custom').click(function() {
        owl.trigger('prev.owl.carousel');
    });

    // Initialize Owl Carousel
    var owl = $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 15,
        nav: true,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
    });
</script>


<style>
.swiper {
    padding: 10px;
}

.swiper-slide {
    width: auto;
}
</style>
<!-- Room Start -->
<div class="container my-5 mb-5">
    <div class="row g-4">
        <h5><i class="fa fa-bed"></i> Our Properties</h5>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <?php while ($rProperty = mysqli_fetch_array($qProperty)) {
                        $sRoomType = "SELECT * FROM room_type WHERE property_id='" . $rProperty['property_id'] . "' ORDER BY price asc LIMIT 1";
                        $qRoomType = mysqli_query($conn, $sRoomType) or die(mysqli_error($conn));
                        $rRoomType = mysqli_fetch_array($qRoomType);
                        //get price from rate_plan
                        $sql = "SELECT price FROM rate_plans WHERE property_id=? AND rate_date=? order by price asc";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ss", $rProperty['property_id'] , date('Y-m-d'));
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                        //Set price today
                        $price = $row['price'] ?? 0;
                    ?>
                <div class="swiper-slide">
                    <div class="room-item shadow rounded overflow-hidden mb-4">
                        <div class="position-relative">
                            <img src="<?php echo $rProperty['property_url']; ?>" class="img-fluid w-100"
                                style="height: 300px; object-fit: cover;" />
                            <small
                                class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4">
                                <sup>Start</sup>
                                <?php
                                        echo $_SESSION['osg_currency'] == 'IDR'
                                            ? $_SESSION['osg_currency'] . " " . angka($price)
                                            : $_SESSION['osg_currency'] . " " . number_format($price / $_SESSION['nilai_rupiah'], 1, '.', ',');
                                        ?>
                            </small>
                        </div>
                        <div class="p-4 mt-2" style="height: 300px;">
                            <div class="d-flex justify-content-between mb-3" style="height: 50px;">
                                <h5 class="mb-0" style="width: 60%;"><?php echo $rProperty['property_name']; ?></h5>
                                <div style="width: 40%;">
                                    Rating: <?php for ($i = 0; $i < 5; $i++) echo '<small class="fa fa-star text-primary"></small>'; ?>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-3" style="height: 25px;">
                                <p class="text-body mb-1"><i
                                        class="fas fa-building me-1"></i><?php echo $rProperty['city']; ?></p>
                            </div>
                            <p class="text-body mb-3" style="height: 80px;"><?php echo $rProperty['address']; ?></p>
                            <a class="btn btn-sm btn-dark rounded py-2 px-4" href="#"
                                onclick="book('<?php echo enkripsi($rProperty['property_id']); ?>')">Book Now</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>

            <!-- Optional navigation & pagination -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>


    </div>
</div>

<div class="container my-4">
    <!-- <h5><i class="fas fa-solid fa-store"></i> Merchant</h5> -->
    <div class="text-center mb-4">
        <!-- <button class="btn btn-outline-primary filter-btn" data-filter="all">All</button> -->
        <?php //echo $mType; ?>
    </div>
    <?php
        // $rMerchant = " SELECT * 
        //                     FROM merchant
        //                     WHERE status_hapus='0'";
        // $qMerchant = mysqli_query($conn, $rMerchant) or die(mysqli_error($conn));
        ?>
    <div class="row" id="portfolio-items">
        <?php //echo $mList; ?>

    </div>
</div>
<!-- Room End -->

<!-- Newsletter Start -->
<div class="container newsletter mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="row justify-content-center">
        <div class="col-lg-10 border rounded p-1">
            <div class="border rounded text-center p-1">
                <div class="bg-white rounded text-center p-5">
                    <h4 class="mb-4">Stay updated with our notification and latest <span
                            class="text-primary text-uppercase"> vouchers</span></h4>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <form id="frmNewsletter" name="frmNewsletter" method="post">
                            <input class="form-control w-100 py-3 ps-4 pe-5" name="email" type="email"
                                placeholder="Enter your email">
                            <button
                                class="btn btn-primary py-2 px-3 position-absolute top-0 end-0 mt-2 me-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Newsletter Start -->

<!-- Modal -->
<div class="modal fade" id="modalInfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
       
        <div class="modal-content position-relative">
        
            <div class="modal-body">
            <button type="button" class="btn-close rounded-circle border bg-light p-2 position-absolute top-0 end-0 m-3" 
                style="border: 1px solid #ccc;" 
                data-bs-dismiss="modal" aria-label="Close">
        </button>
                <div id="ajaxInfo"></div>
            </div>

        </div>
    </div>
</div>
 
<?php } ?>

<script>
const swiper = new Swiper('.mySwiper', {
    loop: true,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true, // Ini yang menghentikan saat hover
    },
    slidesPerView: 1,
    spaceBetween: 20,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    breakpoints: {
        576: {
            slidesPerView: 1
        },
        768: {
            slidesPerView: 2
        },
        992: {
            slidesPerView: 3
        }
    }
});
</script>

<script>
const guestBtn = document.getElementById("guestSummary");
const guestDropdown = document.getElementById("guestDropdown");

let dropdownOpen = false;

guestBtn.addEventListener("click", function(e) {
    e.stopPropagation();
    guestDropdown.classList.toggle("show");
    dropdownOpen = !dropdownOpen;
});

// Menutup dropdown jika klik di luar
document.addEventListener("click", function(e) {
    if (!guestDropdown.contains(e.target) && !guestBtn.contains(e.target)) {
        guestDropdown.classList.remove("show");
        dropdownOpen = false;
    }
});

function updateGuest(type, delta) {
    const input = document.getElementById(type);
    let value = parseInt(input.value);

    if (isNaN(value)) value = 0;

    value += delta;

    // Batas minimal semua tetap 0 atau 1 untuk rooms/adults sesuai kebutuhan
    if (type === "rooms" && value < 1) value = 1;
    if (type === "adults" && value < 1) value = 1;
    if (type === "children" && value < 0) value = 0;

    // Batas maksimal sesuai tipe
    if (type === "rooms" && value > 5) value = 5;
    if (type === "adults" && value > 10) value = 10;
    if (type === "children" && value > 15) value = 15;

    input.value = value;

    updateGuestSummary();
}

function updateGuestSummary() {
    const rooms = document.getElementById("rooms").value;
    const adults = document.getElementById("adults").value;
    const children = document.getElementById("children").value;

    const summary =
        `${rooms} Room${rooms > 1 ? 's' : ''}, ${adults} Adult${adults > 1 ? 's' : ''}, ${children} Child${children > 1 ? 'ren' : ''}`;
    document.getElementById("guestSummary").innerText = summary;
}

document.addEventListener("DOMContentLoaded", updateGuestSummary);
</script>

<script>
$("#frmNewsletter").submit(function(e) {
    e.preventDefault(e);
    var frm = $('#frmNewsletter')[0];
    var formData = new FormData(frm);
    $.ajax({
        type: "POST",
        url: "ajax/newsletter.php",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
            $.blockUI({
                message: '<img src="img/loading.gif" width="50" /> Please Wait'
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

function book(x) {
    // Format tanggal ke format Indonesia (YYYY-MM-DD)
    function formatDateIndo(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    let today = new Date();
    let tomorrow = new Date(today);
    tomorrow.setDate(today.getDate() + 1);

    let todayIndo = formatDateIndo(today);
    let tomorrowIndo = formatDateIndo(tomorrow);

    window.location.href = "?menu=detail&pID=" + x + "&start_date=" + todayIndo + "&end_date=" + tomorrowIndo +
        "&adult=1&child=0&rooms=1&search=1";
}

// jQuery to toggle chevron icon when collapse is shown or hidden
$('#collapseFacilities').on('hide.bs.collapse', function() {
    // Change icon to chevron-down when the collapse is shown
    $('#toggleFacilities').removeClass('bi-chevron-up').addClass('bi-chevron-down');
});

$('#collapseFacilities').on('show.bs.collapse', function() {
    // Change icon to chevron-up when the collapse is hidden
    $('#toggleFacilities').removeClass('bi-chevron-down').addClass('bi-chevron-up');
});

$('#collapseSpace').on('hide.bs.collapse', function() {
    // Change icon to chevron-down when the collapse is shown
    $('#toggleSpace').removeClass('bi-chevron-up').addClass('bi-chevron-down');
});

$('#collapseSpace').on('show.bs.collapse', function() {
    // Change icon to chevron-up when the collapse is hidden
    $('#toggleSpace').removeClass('bi-chevron-down').addClass('bi-chevron-up');
});

$(document).on('change', 'input[name="properties[]"], input[name="spaces[]"]', function() {
    propertiList();
});

$(document).ready(function() {

    propertiList();

    $('.filter-btn').click(function() {
        var category = $(this).data('filter');

        if (category === 'all') {
            $('.portfolio-item').fadeIn();
        } else {
            $('.portfolio-item').hide();
            $('.portfolio-item[data-category="' + category + '"]').fadeIn();
        }

        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
    });

});

function getUrlParams() {
    const params = new URLSearchParams(window.location.search);
    return {
        start: params.get("start_date"),
        end: params.get("end_date")
    };
}


function parseDates({
    start,
    end
}) {
    if (start && end) {
        const startDate = new Date(start);
        const endDate = new Date(end);
        if (!isNaN(startDate) && !isNaN(endDate)) {
            return [startDate, endDate];
        }
    }
    return null;
}

const urlParams = getUrlParams();
const selectedDates = parseDates(urlParams);

const rangeInput = document.getElementById("rangePicker");

flatpickr(rangeInput, {
    mode: "range",
    dateFormat: "d M",
    minDate: "today", // disables all past dates
    defaultDate: selectedDates,
    locale: {
        rangeSeparator: " - "
    },
    onReady: function(selectedDates, dateStr) {
        if (selectedDates.length === 2) {
            const start = selectedDates[0];
            const end = selectedDates[1];
            const nights = (end - start) / (1000 * 60 * 60 * 24);

            // Format ulang tampilan ke dalam input
            const formatted =
                `${formatDate(start)} - ${formatDate(end)}, ${nights} night${nights > 1 ? "s" : ""}`;
            rangeInput.value = formatted;
        }
    },
    onChange: function(selectedDates, dateStr) {
        if (selectedDates.length === 2) {
            const start = selectedDates[0];
            const end = selectedDates[1];
            const nights = (end - start) / (1000 * 60 * 60 * 24);

            // Format ulang tampilan ke dalam input
            const formatted =
                `${formatDate(start)} - ${formatDate(end)}, ${nights} night${nights > 1 ? "s" : ""}`;
            rangeInput.value = formatted;
        }
    }
});

function formatDate(date) {
    const options = {
        day: '2-digit',
        month: 'short'
    };
    return date.toLocaleDateString('en-ID', options);
}

function propertiList() {

    const formData = new FormData();

    formData.append('adult', '<?php echo enkripsi($_GET['adult'] ?? ''); ?>');
    formData.append('rooms', '<?php echo enkripsi($_GET['rooms'] ?? ''); ?>');
    formData.append('child', '<?php echo enkripsi($_GET['child'] ?? ''); ?>');
    formData.append('start_date', '<?php echo enkripsi($_GET['start_date'] ?? ''); ?>');
    formData.append('end_date', '<?php echo enkripsi($_GET['end_date'] ?? ''); ?>');

    $('input[name="properties[]"]:checked').each(function() {
        formData.append('properties[]', $(this).val());
    });
    $('input[name="spaces[]"]:checked').each(function() {
        formData.append('spaces[]', $(this).val());
    });

    $.ajax({
        type: 'POST',
        url: 'ajax/propertiList.php',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function() {
            // setting a timeout
            $.blockUI({
                message: '<img src="img/loading.gif" width="50" /> Please wait...'
            });
        },
        success: function(data) {
            $("#propertiList").html(data);
        },
        complete: function() {
            $.unblockUI();
        },
    })
}

function convertDateRange(input) {
    const parts = input.split(' - ');
    const endPart = parts[1].split(',')[0].trim(); // e.g., "14 May"
    const startPart = parts[0].trim(); // e.g., "13 May"

    const currentYear = new Date().getFullYear();

    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
    ];

    const startDateParts = startPart.split(' ');
    const endDateParts = endPart.split(' ');

    const startDay = startDateParts[0];
    const startMonth = startDateParts[1];
    const endDay = endDateParts[0];
    const endMonth = endDateParts[1];

    let startYear = currentYear;
    let endYear = currentYear;
    if (monthNames.indexOf(endMonth) < monthNames.indexOf(startMonth)) {
        endYear += 1;
    }

    // Format numbers to 2-digit
    function pad(n) {
        return n.toString().padStart(2, '0');
    }

    const startDate = new Date(`${startYear}-${pad(monthNames.indexOf(startMonth) + 1)}-${pad(startDay)}`);
    const endDate = new Date(`${endYear}-${pad(monthNames.indexOf(endMonth) + 1)}-${pad(endDay)}`);

    const format = (date) => date.toISOString().split('T')[0];

    return {
        start: format(startDate),
        end: format(endDate)
    };
}



$("#frmCari").submit(function(e) {
    e.preventDefault(); // Stop default form submission

    const dateInput = document.getElementById("rangePicker").value.trim();

    if (!dateInput) {
        document.getElementById("rangePicker").focus();
        return;
    }

    var frm = $('#frmCari')[0];
    var formData = new FormData(frm);

    const rawDate = formData.get("date"); // "23 Apr - 25 Apr, 2"
    const converted = convertDateRange(rawDate);

    if (converted) {
        formData.set("start_date", converted.start);
        formData.set("end_date", converted.end);
        formData.delete("date"); // remove original raw date if not needed
    }

    var queryString = new URLSearchParams(formData).toString();

    // Example URL, replace with your actual endpoint
    var targetUrl = "?menu=search&" + queryString + "&search=1";

    // Redirect to the URL with query params (GET method)
    window.location.href = targetUrl;
});
</script>
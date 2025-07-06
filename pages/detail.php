<?php

$t = amankan($_GET['t'] ?? '');
$rooms = (amankan($_GET['rooms'] ?? '1'));
$adults = (amankan($_GET['adult'] ?? '2'));
$children = (amankan($_GET['child'] ?? '0'));

$global_member_id = dekripsi(amankan($_SESSION['osg_member_id'] ?? ''));
$property_id = dekripsi(amankan($_GET['pID'] ?? ''));

$sTipeKamar  = " SELECT *
            FROM room_type
            WHERE status_hapus='0' and property_id='" . $property_id . "'";
$qTipeKamar = mysqli_query($conn, $sTipeKamar) or die(mysqli_error($conn));

$i = 0;
$divTipeKamar = '';
while ($rTipeKamar  = mysqli_fetch_array($qTipeKamar)) {
    $i += 1;
    $divTipeKamar .= "<div class='form-check form-check-inline mb-2 mt-2'>
                        <input class='form-check-input' name='tipeKamar[]' value='" . enkripsi($rTipeKamar['room_type_id']) . "' type='checkbox' id='TipeKamar$i'>
                        <label class='form-check-label' for='TipeKamar$i'>
                            " . $rTipeKamar['room_type'] . "
                        </label>
                    </div>";
}

$sProperti  = " SELECT *
                FROM property
                WHERE status_hapus='0'";
$qProperti = mysqli_query($conn, $sProperti) or die(mysqli_error($conn));

$sGaleri    = " SELECT g.*,p.property_url
                FROM gallery g 
                JOIN room_type tk ON tk.room_type_id=g.room_type_id
                JOIN property p ON p.property_id=tk.property_id
                WHERE g.status_hapus='0' and p.property_id='" . $property_id . "'";
$qGaleri    = mysqli_query($conn, $sGaleri) or die(mysqli_error($conn));

$i = 0;
$divGaleri = '';
while ($rGaleri = mysqli_fetch_array($qGaleri)) {
    $i += 1;
    $divGaleri .= " <div class='col-6 mb-3'>
                        <a href='" . $rGaleri['gallery_url'] . "' data-lightbox='gallery'>
                            <img src='" . $rGaleri['gallery_url'] . "' class='img-fluid rounded' />
                        </a>
                    </div>
                    ";

    $property_url = $rGaleri['property_url'];
}
?>

<style>
    .form-check-input {
        transform: scale(1.5);
        /* Make checkbox 1.5x bigger */
        margin-right: 8px;
        /* Optional: better spacing */

    }

    .form-check-label {
        font-size: 18px;
    }
</style>

<!-- Booking Start -->
<div class="container-fluid booking pb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="px-3" style="margin-top: 120px;">
        <div class="bg-white shadow" style="padding: 35px;">
            <div class="row g-2">
                <form id="frmCari" class="row g-2">
                    <div class="col-md-10">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <select name="pID" class="form-select form-select-lg">
                                    <?php while ($rProperti = mysqli_fetch_array($qProperti)) { ?>
                                        <option value="<?php echo enkripsi($rProperti['property_id']) ?>" <?php if ($rProperti['property_id'] == $property_id) echo 'SELECTED'; ?>><?php echo $rProperti['property_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="date" id="date1">
                                    <input type="text" name="date" class="form-control form-control-lg" id="rangePicker" style="background-color: white;" placeholder="Check in" />
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="position-relative">
                                    <button type="button" class="form-control form-control-lg text-start" id="guestSummary" style="background-color: white;">
                                    <?php echo $rooms ?> Room<?php echo $rooms > 1 ? 's' : '' ?>, 
                                    <?php echo $adults ?> Adult<?php echo $adults > 1 ? 's' : '' ?>, 
                                    <?php echo $children ?> Child<?php echo $children > 1 ? 'ren' : '' ?>
                                    </button>
                                    
                                    <!-- Dropdown Manual -->
                                    <div class="dropdown-menu p-3" id="guestDropdown" style="min-width: 300px;">
                                        <div class="mb-2">
                                            <label class="form-label">Rooms</label>
                                            <div class="input-group">
                                                <button class="btn btn-outline-secondary" type="button" onclick="updateGuest('rooms', -1)">−</button>
                                                <input type="text" id="rooms" name="rooms" class="form-control text-center" value="<?php echo $rooms ?>" readonly>
                                                <button class="btn btn-outline-secondary" type="button" onclick="updateGuest('rooms', 1)">+</button>
                                            </div>
                                            </div>
                                            <div class="mb-2">
                                            <label class="form-label">Adults <small class="text-muted">(12+)</small></label>
                                            <div class="input-group">
                                                <button class="btn btn-outline-secondary" type="button" onclick="updateGuest('adults', -1)">−</button>
                                                <input type="text" id="adults" name="adult" class="form-control text-center" value="<?php echo $adults ?>" readonly>
                                                <button class="btn btn-outline-secondary" type="button" onclick="updateGuest('adults', 1)">+</button>
                                            </div>
                                            </div>
                                            <div class="mb-2">
                                            <label class="form-label">Children <small class="text-muted">(0-12)</small></label>
                                            <div class="input-group">
                                                <button class="btn btn-outline-secondary" type="button" onclick="updateGuest('children', -1)">−</button>
                                                <input type="text" id="children" name="child" class="form-control text-center" value="<?php echo $children ?>" readonly>
                                                <button class="btn btn-outline-secondary" type="button" onclick="updateGuest('children', 1)">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-lg rounded btn-primary w-100"><i class="fa fa-search"></i> Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Booking End -->
 

<?php if ($_GET['search'] == 1) { ?>
    <div class="container-fluid">
        <div class="row px-3">
            <!-- Large Main Image -->
            <div class="col-md-6 mb-3">
                <a href="<?php echo $property_url; ?>" data-lightbox="gallery">
                    <img src="<?php echo $property_url; ?>" class="rounded shadow" style="max-width:100%;height: 100%;" />
                </a>
            </div>

            <!-- Smaller Gallery Images -->
            <div class="col-md-6">
                <div class="row">
                    <?php echo $divGaleri; ?>
                </div>
            </div>
            <!-- <div class="position-relative">
                <a href="img/gallery.jpg" data-lightbox="gallery">
                    <img src="img/gallery.jpg" class="img-fluid rounded" />
                    <div class="position-absolute top-50 start-50 translate-middle text-white bg-dark bg-opacity-50 px-3 py-1 rounded">
                        <i class="bi bi-grid"></i> See All Photos
                    </div>
                </a>
            </div> -->
        </div>
    </div>

    <!-- Service Start -->
    <div class="container-fluid py-5" style="margin-top:-30px;margin-bottom: 100px;">
        <div class="px-3">
            <div class="row g-4">
                <!-- <div class="col-lg-12 col-md-12 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="row g-4">
                        <div class="col-lg-6 col-md-12">
                            <div class="card mb-3" style="box-shadow: 0 0 45px rgba(0, 0, 0, .08);">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2" data-bs-toggle="collapse" data-bs-target="#collapseTipeKamar" aria-expanded="true" role="button">
                                        <h5 class="fw-bold mb-2">Room Type</h5>
                                        <i id="toggleTipeKamar" class="bi bi-chevron-up"></i>
                                    </div>

                                    <div class="collapse show" id="collapseTipeKamar">
                                        <?php //echo $divTipeKamar; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="card" style="box-shadow: 0 0 45px rgba(0, 0, 0, .08);">
                                <div class="card-body">

                                    <div class="d-flex justify-content-between align-items-center mb-2" data-bs-toggle="collapse" data-bs-target="#collapseSpace" aria-expanded="true" role="button">
                                        <h5 class="fw-bold mb-2">Space</h5>
                                        <i id="toggleSpace" class="bi bi-chevron-up"></i>
                                    </div>

                                    <div class="collapse show" id="collapseSpace">
                                        <div class=' form-check form-check-inline mb-2 mt-2'>
                                            <input class='form-check-input' type='checkbox' value="L1020" name='spaces[]' id='L1020'>
                                            <label class='form-check-label' for='L1020'>
                                                <span>10 - 20 m2</span>
                                            </label>
                                        </div>
                                        <div class='form-check form-check-inline mb-2 mt-2'>
                                            <input class='form-check-input' type='checkbox' value="L2030" name='spaces[]' id='L2030'>
                                            <label class='form-check-label' for='L2030'>
                                                <span>21 - 30 m2</span>
                                            </label>
                                        </div>
                                        <div class='form-check form-check-inline mb-2 mt-2'>
                                            <input class='form-check-input' type='checkbox' value="L3040" name='spaces[]' id='L3040'>
                                            <label class='form-check-label' for='L3040'>
                                                <span>31- 40 m2</span>
                                            </label>
                                        </div>
                                        <div class='form-check form-check-inline mb-2 mt-2'>
                                            <input class='form-check-input' type='checkbox' value="L40" name='spaces[]' id='L40'>
                                            <label class='form-check-label' for='L40'>
                                                <span>> 40 m2</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="col-lg-12 col-md-12 wow fadeInUp" data-wow-delay="0.2s">
                    <div id="tipeKamarList"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->



<?php } else { ?>
    <div style="height: 200px;">

        

    </div>
    <div style="height: 200px;">

        

    </div>
<?php } ?>

<script>
  const guestBtn = document.getElementById("guestSummary");
  const guestDropdown = document.getElementById("guestDropdown");

  let dropdownOpen = false;

  guestBtn.addEventListener("click", function (e) {
    e.stopPropagation();
    guestDropdown.classList.toggle("show");
    dropdownOpen = !dropdownOpen;
  });

  // Menutup dropdown jika klik di luar
  document.addEventListener("click", function (e) {
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

    const summary = `${rooms} Room${rooms > 1 ? 's' : ''}, ${adults} Adult${adults > 1 ? 's' : ''}, ${children} Child${children > 1 ? 'ren' : ''}`;
    document.getElementById("guestSummary").innerText = summary;
  }
  
  document.addEventListener("DOMContentLoaded", updateGuestSummary);
</script>

<script>
    // jQuery to toggle chevron icon when collapse is shown or hidden
    $('#collapseTipeKamar').on('hide.bs.collapse', function() {
        // Change icon to chevron-down when the collapse is shown
        $('#toggleTipeKamar').removeClass('bi-chevron-up').addClass('bi-chevron-down');
    });

    $('#collapseTipeKamar').on('show.bs.collapse', function() {
        // Change icon to chevron-up when the collapse is hidden
        $('#toggleTipeKamar').removeClass('bi-chevron-down').addClass('bi-chevron-up');
    });

    $('#collapseSpace').on('hide.bs.collapse', function() {
        // Change icon to chevron-down when the collapse is shown
        $('#toggleSpace').removeClass('bi-chevron-up').addClass('bi-chevron-down');
    });

    $('#collapseSpace').on('show.bs.collapse', function() {
        // Change icon to chevron-up when the collapse is hidden
        $('#toggleSpace').removeClass('bi-chevron-down').addClass('bi-chevron-up');
    });

    $(document).on('change', 'input[name="tipeKamar[]"], input[name="spaces[]"]', function() {
        tipeKamarList();
    });

    $(document).ready(function() {

        tipeKamarList();
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
                const formatted = `${formatDate(start)} - ${formatDate(end)}, ${nights} night${nights > 1 ? "s" : ""}`;
                rangeInput.value = formatted;
            }
        },
        onChange: function(selectedDates, dateStr) {
            if (selectedDates.length === 2) {
                const start = selectedDates[0];
                const end = selectedDates[1];
                const nights = (end - start) / (1000 * 60 * 60 * 24);

                // Format ulang tampilan ke dalam input
                const formatted = `${formatDate(start)} - ${formatDate(end)}, ${nights} night${nights > 1 ? "s" : ""}`;
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

    function tipeKamarList() {

        const formData = new FormData();
        formData.append('pID', '<?php echo enkripsi($property_id); ?>');
        formData.append('adult', '<?php echo enkripsi($_GET['adult']?? 1); ?>');
        formData.append('child', '<?php echo enkripsi($_GET['child']?? 0); ?>');
        formData.append('rooms', '<?php echo enkripsi($_GET['rooms']?? 1); ?>');
        formData.append('start_date', '<?php echo enkripsi($_GET['start_date']); ?>');
        formData.append('end_date', '<?php echo enkripsi($_GET['end_date']); ?>');

        $('input[name="tipeKamar[]"]:checked').each(function() {
            formData.append('tipeKamar[]', $(this).val());
        });
        $('input[name="spaces[]"]:checked').each(function() {
            formData.append('spaces[]', $(this).val());
        });

        $.ajax({
            type: 'POST',
            url: 'ajax/tipeKamarList.php',
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
                $("#tipeKamarList").html(data);
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
        var targetUrl = "?menu=detail&" + queryString + "&search=1";

        // Redirect to the URL with query params (GET method)
        window.location.href = targetUrl;
    });
</script>


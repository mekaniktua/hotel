<?php
session_start();
include("../manajemen/database.php");

$global_member_id = dekripsi(amankan($_SESSION['osg_member_id'] ?? ''));

// Inisialisasi query tambahan
$query = '';
$i = 0;

// Ambil dan escape filter dari POST
$start_date_filter = isset($_POST['start_date']) ? mysqli_real_escape_string($conn, $_POST['start_date']) : '';
$booking_id_filter = isset($_POST['booking_id']) ? mysqli_real_escape_string($conn, $_POST['booking_id']) : '';
$tab = $_POST['tab'] ?? 'upcoming';

// Filter tambahan
if (!empty($start_date_filter)) {
    $query .= " AND b.start_date >= '$start_date_filter'";
}

if (!empty($booking_id_filter)) {
    $query .= " AND b.booking_id LIKE '%$booking_id_filter%'";
}
  
$today = date("Y-m-d"); 

// Status berdasarkan tab
if ($tab === 'upcoming') {
    $status_filter = "b.status IN ('Booked', 'Waiting', 'Completed') AND  DATE(start_date) >= '$today'";
} elseif ($tab === 'completed') {
    $status_filter = "b.status = 'Completed' AND DATE(start_date) < '$today'";
} elseif ($tab === 'expired') {
    $status_filter = "b.status = 'Expired'";
} else {
    $status_filter = "b.status = 'Booked'";
}

// Query utama
$sQuery = "SELECT b.*, r.room_type
           FROM booking b
           JOIN room_type r ON b.room_type_id = r.room_type_id
           WHERE $status_filter AND b.member_id = '$global_member_id' $query
           ORDER BY b.start_date DESC
           LIMIT 30";

$qBookings = mysqli_query($conn, $sQuery) or die("Query error: " . mysqli_error($conn));

// Output data
while ($r = mysqli_fetch_array($qBookings)) {
    $i++;

    $sGallery = "SELECT * FROM gallery WHERE status_hapus='0' AND room_type_id='" . $r['room_type_id'] . "' LIMIT 1";
    $qGallery = mysqli_query($conn, $sGallery);
    $rGallery = mysqli_fetch_array($qGallery);

    $start_date = date('D, M j', strtotime($r['start_date']));
    $end_date = date('D, M j', strtotime($r['end_date']));

    if ($r['status'] == 'Booked') {
        $bg = "bg-primary";
        $status = "Booked";
    } elseif ($r['status'] == 'Completed') {
        $bg = "bg-success";
        $status = "Completed";
    } elseif ($r['status'] == 'Expired') {
        $bg = "bg-danger";
        $status = "Expired";
    } elseif ($r['status'] == 'Waiting') {
        $bg = "bg-warning";
        $status = "Waiting Payment";
    } else {
        $bg = "bg-secondary";
        $status = "Booked";
    }
?>
    <div class="mb-1" data-name="<?php echo strtolower($r['booking_id']); ?>">
        <div class="d-flex border rounded shadow-sm p-3 mb-4 bg-white align-items-start">
            <div class="me-3">
                <div style="width: 150px; height: 150px; overflow: hidden; border-radius: 0.375rem;">
                    <img
                        class="img-fluid"
                        src="<?php echo $rGallery['gallery_url']; ?>"
                        alt="Room Type"
                        style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>

            <div class="flex-grow-1">
                <div class="d-flex justify-content-between mb-2">
                    <div>
                        <strong>ID:</strong> <?php echo $r['booking_id']; ?><br>
                        <strong class="text-primary"><?php echo $r['room_type']; ?></strong>
                    </div>
                    <div><span class="badge <?php echo $bg; ?>"><?php echo $status; ?></span></div>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <div><strong>Check-in:</strong> <?php echo $start_date; ?></div>
                    <div><strong>Check-out:</strong> <?php echo $end_date; ?></div>
                </div>

                <div class="text-muted">
                    <small><?php echo $r['adult'] ?> <i class="fa fa-user"></i> <?php echo $r['child'] ?> <i class="fa fa-child"></i></small>
                </div>
                <?php if ($r['status'] == 'Waiting') { ?>
                    <div class="pull-right">
                        <a href="<?php echo $r['payment_link']?>"><i class="fa fa-credit-card"></i> Continue Payment</a>
                    </div>
                <?php }else if ($r['status'] == 'Completed') { 
                    $sReview = "SELECT review_id FROM review WHERE member_id='".$global_member_id."' AND booking_id='" . $r['booking_id'] . "'";
                    $qReview = mysqli_query($conn, $sReview);
                    $rReview = mysqli_fetch_array($qReview);
                    if(empty($rReview['review_id'])){
                ?>
                    <div class="pull-right">
                        <a href="#" onclick="writeReview('<?php echo enkripsi($r['booking_id']); ?>')"><i class="fa fa-comment"></i> Write Review</a>
                    </div>
                <?php }} ?>
            </div>
        </div>
    </div>
<?php } ?>

<?php if ($i == 0) { ?>
    <div class="text-center">
        <img src="img/not_found.jpg" class="img-fluid" width="300px">
        <h5 class="text-muted">No bookings found.</h5>
    </div>
<?php } ?>


<script>
    function writeReview(x) {
        
        $.ajax({
            type: 'POST',
            url: 'ajax/writeReview.php',
            data: {
                'bID': x,
                'mID': '<?php echo enkripsi($global_member_id);?>',
            },
            beforeSend: function() {
                // setting a timeout
                $.blockUI({
                message: '<img src="img/loading.gif" width="50" /> Please wait...'
                });
            },
            success: function(data) {
                $("#modalReview").modal("show");
                $("#ajaxReview").html(data);
            },
            complete: function() {
                $.unblockUI();
            },
        })
    }
</script>
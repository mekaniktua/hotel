<?php
session_start();
include("../manajemen/database.php");

$global_member_id = dekripsi(amankan($_SESSION['osg_member_id']));
// Mendapatkan parameter filter dari request GET 
$tab = isset($_POST['tab']) ? $_POST['tab'] : 'activity'; // Mengambil tab yang aktif (upcoming, completed, cancelled)


// Sesuaikan query berdasarkan tab yang aktif
if ($tab == 'activity') {
  $status = ['Upgrade', 'Booking'];
} elseif ($tab == 'expired') {
  $status = ['Expired'];
}
// Escape each status and build the IN clause
$statusList = "'" . implode("','", array_map('addslashes', $status)) . "'";

// Query untuk point activity
$sQuery = "SELECT *
            FROM member_log 
            WHERE type in (" . $statusList . ") and member_id='" . $global_member_id . "'
            ORDER BY created_date DESC
            LIMIT 30";
$qQuery = mysqli_query($conn, $sQuery);

while ($r = mysqli_fetch_array($qQuery)) {
  $i++;

?>

  <div class="flex-grow-1">
    <div class="d-flex justify-content-between mb-2">
      <div> <?php echo $r['description']; ?></div>
      <div class="text-primary">+<?php echo $r['point']; ?></div>
    </div>

  </div>

  <hr />
<?php } ?>

<?php if ($i == 0) { ?>
  <div class="text-center">
    <img src="img/not_found.jpg" class="img-fluid" width="300px">
    <h5 class="text-muted">No Point found.</h5>
  </div>
<?php } ?>
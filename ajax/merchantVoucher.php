<?php
session_start();
include("../manajemen/database.php");
include("../phpqrcode/qrlib.php");

$global_merchant_id = dekripsi(amankan($_SESSION['osg_merchant_id']));
// Mendapatkan parameter filter dari request GET
$end_date_filter = isset($_POST['end_date']) ? $_POST['end_date'] : '';
$voucher_title_filter = isset($_POST['voucher_title']) ? $_POST['voucher_title'] : '';
$tab = isset($_POST['tab']) ? $_POST['tab'] : 'active'; // Mengambil tab yang aktif (active, expired)

if (!empty($end_date_filter)) {
  $query .= " AND end_date <= '$end_date_filter'";
}

if ($voucher_title_filter) {
  $query .= " AND voucher_title LIKE '%$voucher_title_filter%'";
}

// Sesuaikan query berdasarkan tab yang aktif
if ($tab == 'active') {
  $query .= " AND end_date >='" . date("Y-m-d") . "'";
} elseif ($tab == 'expired') {
  $query .= " AND end_date <'" . date("Y-m-d") . "'";
}

// Query untuk active voucher
$sQuery = "SELECT *
            FROM voucher
            WHERE status = 'Publish' and merchant_id='" . $global_merchant_id . "'" . $query . "
            ORDER BY end_date DESC";

$qQuery = mysqli_query($conn, $sQuery);

while ($r = mysqli_fetch_array($qQuery)) {
  $i++;

  $start_date = date('D, M j', strtotime($r['start_date']));
  $end_date = date('D, M j', strtotime($r['end_date']));

  if ($tab == 'active') {
    $bg = "bg-success";
  } else if ($tab == 'expired') {
    $bg = "bg-danger";
  }

  //qrcode
  $tempDir = 'temp/';
  $dataQrcode = "https://orangesky.id/redemption/?v=" . enkripsi($r['voucher_id']);
  // Nama file berdasarkan hash isi QR
  $fileName = 'qrcode_' . md5(enkripsi($r['voucher_id'])) . '.png';
  $qrcodePath = $tempDir . $fileName;

  // Level error (L, M, Q, H) dan ukuran
  $ecc = 'H'; // High error correction
  $pixelSize = 3;

  // Generate QR code
  QRcode::png($dataQrcode, "../" . $qrcodePath, $ecc, $pixelSize, 2);

  //update if not exist
  if (!file_exists($r['qrcode_url'])) {

    $sUpdate = "UPDATE voucher 
                SET qrcode_url ='" . $qrcodePath . "'
                WHERE voucher_id='" . $r['voucher_id'] . "'
                ORDER BY end_date DESC";
    $qUpdate = mysqli_query($conn, $sUpdate);
  }

?>
  <div class="mb-1" data-name="<?php echo strtolower($r['voucher_title']); ?>">

    <!-- Gambar -->
    <div class="d-flex border rounded shadow-sm p-3 mb-4 bg-white align-items-start">
      <!-- Gambar -->
      <div class="me-3">
        <div style="width: 150px; height: 150px; overflow: hidden; border-radius: 0.375rem;">
          <img
            class="img-fluid"
            src="<?php echo $r['voucher_url']; ?>"
            alt="Voucher"
            style="width: 100%; height: 100%; object-fit: cover;">
        </div>
      </div>

      <!-- Detail -->
      <div class="flex-grow-1">
        <div class="d-flex justify-content-between mb-2">
          <div>
            <strong class="text-primary"><?php echo $r['voucher_title']; ?></strong><br>
            <span><?php echo $r['description']; ?></span>
            <div class="text-muted"><strong>Period:</strong> <?php echo $start_date; ?> - <?php echo $end_date; ?></div>
          </div>
          <div class="text-center">
            <div class="badge <?php echo $bg; ?> mb-3"><?php echo $tab; ?></div>
            <div style="cursor: pointer;" onclick="qrcode('<?php echo enkripsi($r['voucher_id']) ?>')"><img src="<?php echo $qrcodePath; ?>" class="img-thumbnail" width="75px" alt='QR Code'><br /><small style="font-size: .7rem;">Click Me</small></div>
          </div>
        </div>

      </div>
    </div>
  </div>
<?php } ?>

<?php if ($i == 0) { ?>
  <div class="text-center">
    <img src="img/not_found.jpg" class="img-fluid" width="300px">
    <h5 class="text-muted">No Voucher found.</h5>
  </div>
<?php } ?>
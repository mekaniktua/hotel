<?php
session_start();
include("../manajemen/database.php");

$adult = dekripsi(amankan($_POST['adult'] ?? ''));
$child = dekripsi(amankan($_POST['child'] ?? ''));
$rooms = dekripsi(amankan($_POST['rooms'] ?? ''));
$start_date = dekripsi(amankan($_POST['start_date'] ?? ''));
$end_date = dekripsi(amankan($_POST['end_date'] ?? ''));

$properties = ($_POST['properties'] ?? '');
$spaces = ($_POST['spaces'] ?? '');

if (is_array($properties)) {
  foreach ($properties as $property) {
    $dataProperti .= "'" . dekripsi($property) . "',";
  }
  $dataProperti = trim($dataProperti, ",");
  $queryProperti = "AND p.property_id IN ($dataProperti) ";
}

if (is_array($spaces)) {
  foreach ($spaces as $space) {
    if ($space == 'L1020') {
      $querySpace .= " (tk.space between 10 and 20) OR ";
    } else if ($space == 'L2030') {
      $querySpace .= " (tk.space between 21 and 30) OR ";
    } else if ($space == 'L3040') {
      $querySpace .= " (tk.space between 31 and 40) OR ";
    } else if ($space == 'L40') {
      $querySpace .= " (tk.space >40) OR ";
    }
  }

  $querySpace = preg_replace('/^OR\s+|\s+OR\s*$/', '', $querySpace);
  $querySpace = "AND " . $querySpace;
}

$sData  = " SELECT p.* 
            FROM property p
            LEFT JOIN room_type tk ON tk.property_id=p.property_id
            WHERE p.status_hapus='0' " . (!empty($queryProperti) ? $queryProperti : '') . (!empty($querySpace) ? $querySpace : '') . "  
            GROUP BY p.property_id
            ORDER BY p.property_name";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));

?>

<?php $i=0; $divProperti = ''; 
while ($rData = mysqli_fetch_array($qData)) {
  $i++;
  $sTipe  = " SELECT *
              FROM room_type 
              WHERE status_hapus='0' and property_id ='" . $rData['property_id'] . "' 
              order by price desc,room_type
              limit 3";
  $qTipe = mysqli_query($conn, $sTipe) or die(mysqli_error($conn));

  $tipe = '';
  while ($rTipe = mysqli_fetch_array($qTipe)) {
    $tipe .= "<span class='bg-warning bg-opacity-50 text-white rounded-pill px-2 py-1' style='backdrop-filter: blur(6px);'>" . $rTipe['room_type'] . "</span>&nbsp;";
    $price = $rTipe['price'];
  }
?>
  <div class="card mb-2" style="box-shadow: 0 0 45px rgba(0, 0, 0, .08);cursor:pointer;" onclick="pilih('<?php echo enkripsi($rData['property_id']); ?>')">
    <div class="row g-0">
      <div class="col-md-2">
        <img src="<?php echo $rData['property_url'] ?>" class="img-fluid rounded-start" style='width: 100%' alt="<?php echo $rData['property_name'] ?>">
      </div>
      <div class="col-md-10">
        <div class="card-body">
          <h5 class="card-title"><?php echo $rData['property_name'] ?></h5>
          <p class="card-text"><small class="text-muted"><?php echo $rData['address'] ?></small></p>
          <!-- <p class="card-text"><i class="fa fa-map-marker"></i> <?php echo $rData['city'] ?></p> -->
          <p class="card-text"><small class="text-muted" style="font-size: 12px;"><?php echo $tipe; ?></small></p>
          <hr />
          <div class="d-flex justify-content-between align-items-center">
            <div class="text-left"><sup>Start from </sup><span style="font-weight: bold; font-size: 20px;color: orange;">
                <?php if ($_SESSION['osg_currency'] == 'IDR') {
                            echo $_SESSION['osg_currency'] . " " . angka($price);
                      } else {
                           echo $_SESSION['osg_currency'] . " " . number_format($price / $_SESSION['nilai_rupiah'], 1, '.', ',');
                      } 
                ?>
              </span></div>
            <div class="text-right">
              <button class="btn btn-primary rounded" onclick="pilih()">Select Room</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php
  unset($tipe);
  unset($price);
}
if (empty($i)) { ?>
  <div class="text-center">
    <img src="img/dataNotFound.png" class="img-responsive">
    <h2>We're sorry, no properties matched your criteria.</h2>
  </div>
<?php } ?>

<script>
  function pilih(x) {
    window.open("?menu=detail&start_date=<?php echo $start_date; ?>&rooms=<?php echo $rooms; ?>&end_date=<?php echo $end_date; ?>&adult=<?php echo $adult; ?>&child=<?php echo $child ?>&search=1&pID=" + x, "_self");
  }
</script>
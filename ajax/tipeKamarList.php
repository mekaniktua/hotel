<?php
session_start();
include("../manajemen/database.php");

$property_id = dekripsi(amankan($_POST['pID'] ?? ''));
$adult = dekripsi(amankan($_POST['adult'] ?? 0));
$child = dekripsi(amankan($_POST['child'] ?? 0));
$rooms = dekripsi(amankan($_POST['rooms'] ?? 0));
$start_date = dekripsi(amankan($_POST['start_date'] ?? ''));
$end_date = dekripsi(amankan($_POST['end_date'] ?? ''));

$tipeKamar = ($_POST['tipeKamar'] ?? '');
$spaces = ($_POST['spaces'] ?? '');

if (is_array($tipeKamar)) {
  foreach ($tipeKamar as $room) {
    $dataKamar .= "'" . dekripsi($room) . "',";
  }
  $dataKamar = trim($dataKamar, ",");
  $queryTipeKamar = "AND tk.room_type_id IN ($dataKamar) ";
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

$sData  = " SELECT tk.* 
            FROM property p
            JOIN room_type tk ON tk.property_id=p.property_id
            WHERE p.status_hapus='0' and p.property_id='" . $property_id . "' " . (!empty($queryTipeKamar) ? $queryTipeKamar : '') . (!empty($querySpace) ? $querySpace : '') . "  
            ORDER BY tk.price";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));

?>
<?php 
$i = 0;
while ($rData = mysqli_fetch_array($qData)) {
  $i++;
  $sGaleri  = " SELECT *
              FROM gallery 
              WHERE status_hapus='0' and room_type_id ='" . $rData['room_type_id'] . "'";
  $qGaleri = mysqli_query($conn, $sGaleri) or die(mysqli_error($conn));
  $rGaleri = mysqli_fetch_array($qGaleri);

  $sFasilitas  = " SELECT f.facility_name
              FROM facility f
              JOIN room_facility fk On fk.facility_id=f.facility_id 
              WHERE fk.status_hapus='0' and room_type_id ='" . $rData['room_type_id'] . "'";
  $qFasilitas = mysqli_query($conn, $sFasilitas) or die(mysqli_error($conn));

  $sKamar  = " SELECT *
              FROM room 
              WHERE status_hapus='0' and room_type_id ='" . $rData['room_type_id'] . "'";
  $qKamar = mysqli_query($conn, $sKamar) or die(mysqli_error($conn));

?>
  <style>
    .custom-table thead {
      background-color: rgb(247, 249, 250);

    }

    .custom-table tbody tr:hover {
      background-color: #f1f1f1;
    }

    .custom-table th,
    .custom-table td {
      vertical-align: middle;
      text-align: center;
    }
  </style>
  <div class="card mb-2" style="box-shadow: 0 0 45px rgba(0, 0, 0, .08);font-size: 18px;">
    <div class="row g-0">
      <div class="col-md-4">
        <img src="<?php echo $rGaleri['gallery_url'] ?? 'img/no_room_image.png'; ?>" class='img-fluid rounded' alt=" <?php echo $rData['room_type'] ?? 'No Image' ?>">
        <div class="px-5 py-2">
          <h5><i class="fas fa-ruler"></i> <?php echo $rData['space']; ?> m<sup>2</sup></h5>
          <div class="row">
            <?php while ($rFasilitas = mysqli_fetch_array($qFasilitas)) { ?>
              <div class="col-md-6 mb-2">
                <?php echo $rFasilitas['facility_name']; ?>
              </div>
            <?php } ?>
          </div>

        </div>
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h4 class="card-title"><?php echo $rData['room_type'] ?></h4>

          <table class="table custom-table table-bordered table-hover">
            <thead>
              <tr>
                <th style="width: 40%;">Room Option(s)</th>
                <th style="width: 20%;">Guest(s)</th>
                <th style="width: 20%;">Price</th>
                <th style="width: 20%;">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($rKamar = mysqli_fetch_array($qKamar)) {

                if ($rKamar['is_breakfast'] == 1) {
                  if ($_SESSION['osg_currency'] == 'IDR') {
                    $breakfast_price = $rKamar['breakfast_price'];
                    $total_price = $rData['price'] + $breakfast_price;
                  } else {
                    $breakfast_price = ($rKamar['breakfast_price'] / $_SESSION['nilai_rupiah']);
                    $total_price = (($rData['price'] / $_SESSION['nilai_rupiah']) + $breakfast_price);
                  }
                } else {
                  $breakfast_price = 0;
                  if ($_SESSION['osg_currency'] == 'IDR') {
                    $total_price = $rData['price'] + $breakfast_price;
                    $text_breakfast = "<p>Nice Breakfast Available (". $_SESSION['osg_currency'] . " " . $rKamar['breakfast_price'] . ")</p>";
                  } else {
                    $total_price = (($rData['price'] / $_SESSION['nilai_rupiah']) + $breakfast_price);
                    $text_breakfast = "<p>Nice Breakfast Available (".$_SESSION['osg_currency'] . " " . number_format($rKamar['breakfast_price'] / $_SESSION['nilai_rupiah'],1,".",",") . ")</p>";
                  }
                }

              ?>
                <tr>
                  <td style="text-align: left;">
                    <p><i class='fa fa-bed'></i> <?php echo $rKamar['bed'] ?> Bed</p>
                    <?php echo ($rKamar['is_breakfast'] == 1 ? "<p style='color: green;'><i class='fa fa-check'></i> Nice Breakfast Included</p>" : $text_breakfast); ?>
                    <?php echo ($rKamar['is_wifi'] == 1 ? "<p><i class='fa fa-check'></i> Free Wifi</p>" : "<p>No Wifi</p>"); ?>
                    <?php echo ($rKamar['is_parking'] == 1 ? "<p><i class='fa fa-check'></i> Parking</p>" : ""); ?>
                    <?php echo ($rKamar['is_fitness'] == 1 ? "<p><i class='fa fa-check'></i> Fitness Access</p>" : ""); ?>
                  </td>
                  <td><?php echo $rKamar['adult']; ?> <i class='fa fa-solid fa-user'></i> <?php echo $rKamar['child']; ?> <i class='fa fa-solid fa-child'></i> </td>
                  <td class="text-right">
                    <?php if ($_SESSION['osg_currency'] == 'IDR') {
                      echo $_SESSION['osg_currency']." " . angka($total_price);
                    } else {
                      echo $_SESSION['osg_currency']." " . number_format($total_price, 1, '.', ',');
                    }
                    ?>
                  </td>
                  <td><button class="btn btn-primary" onclick="pilih('<?php echo enkripsi($rKamar['room_id']) ?>','<?php echo enkripsi($total_price) ?>')"><i class="fa fa-check"></i> Choose</button></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>

  <div id="booking"></div>


<?php
  unset($tipe);
  unset($price);
}
if (empty($i)) { ?>
  <div class="text-center">
    <img src="img/dataNotFound.png" class="img-responsive">
    <h2>We' re sorry, no room(s) matched your criteria.</h2>
  </div>
<?php } ?>

<script>
  function pilih(x,y) {

    $.ajax({
      type: 'POST',
      url: 'ajax/booking.php',
      data: {
        'pID': '<?php echo enkripsi($property_id) ?>',
        'kID': x,
        'rooms': '<?php echo enkripsi(amankan($rooms)) ?>',
        'adult': '<?php echo enkripsi(amankan($adult)) ?>',
        'child': '<?php echo enkripsi(amankan($child)) ?>',
        'start_date': '<?php echo ($start_date) ?>',
        'end_date': '<?php echo ($end_date) ?>',
        'tp': y,

      },
      beforeSend: function() {
        // setting a timeout
        $.blockUI({
          message: '<img src="img/loading.gif" width="50" /> Please wait...'
        });
      },
      success: function(data) {
        $("#booking").html(data);
      },
      complete: function() {
        $.unblockUI();
      },
    })
  }
</script>
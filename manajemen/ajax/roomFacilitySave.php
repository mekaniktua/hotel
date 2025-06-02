<?php
session_start();
include("../database.php");
 
$room_type_id = dekripsi(amankan($_POST['tkID']));
$facility_id = dekripsi(amankan($_POST['fID']));

$sCari  = " SELECT f.facility_name,fk.*
            FROM room_facility fk
            JOIN facility f ON f.facility_id=fk.facility_id
            WHERE fk.room_type_id='" . $room_type_id . "' and fk.facility_id ='" . $facility_id . "' and fk.status_hapus='0'";
$qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
$rCari  = mysqli_fetch_array($qCari);

if (!empty($rCari['room_facility_id'])) {
  $pesan = "<i class='fa fa-times'></i> Fasilitas " . $rCari['facility_name'] . " telah ada sebelumnya";
} else {

  $room_facility_id = randomText(10);
  $sInsert  = " INSERT INTO room_facility
                SET room_facility_id='" . $room_facility_id . "',
                    room_type_id='" . $room_type_id . "', 
                    facility_id='" . $facility_id . "',  
                    status_hapus='0'";
  $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));
  $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
}
?>
<div class="pesanku">
  <?php if (!empty($pesan)) { ?>
    <div class="alert alert-danger">
      <?php echo $pesan; ?>
    </div>
  <?php }
  if (!empty($pesanSukses)) { ?>
    <div class="alert alert-success">
      <?php echo $pesanSukses; ?>
    </div>
    <script>
      roomFacilityList();
    </script>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
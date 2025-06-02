<?php
session_start();
include("../database.php");

$room_type = amankan($_POST['room_type']);
$price = amankan($_POST['price']);
$space = amankan($_POST['space']);
$room_type_id = dekripsi(amankan($_POST['tkID']));
$property_id = dekripsi(amankan($_POST['prID']));
$jenis = dekripsi(amankan($_POST['jenis']));

if ($jenis == 'New') {
  $sCari  = " SELECT *
              FROM room_type
              WHERE lower(room_type)='" . strtolower($room_type) . "' and property_id ='" . $property_id . "' and status_hapus='0'";
  $qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
  $rCari  = mysqli_fetch_array($qCari);

  if (!empty($rCari['room_type_id'])) {
    $pesan = "<i class='fa fa-times'></i> Tipe room telah ada sebelumnya";
  }
  if (!is_numeric($price)) {
    $pesan = "<i class='fa fa-times'></i> Price harus angka";
  }
  if (!is_numeric($space)) {
    $pesan = "<i class='fa fa-times'></i> Space harus angka";
  }
  if (empty($pesan)) {

    $room_type_id = randomText(10);
    $sInsert  = " INSERT INTO room_type
                  SET room_type_id='" . $room_type_id . "',
                      room_type='" . $room_type . "', 
                      property_id='" . $property_id . "', 
                      space=" . $space . ",
                      price=" . $price . ", 
                      status_hapus='0'";
    $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));
    $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
  }
} else {
  $sCari  = " SELECT *
              FROM room_type
              WHERE lower(room_type)='" . strtolower($room_type) . "' and room_type_id <>'" . $room_type_id . "' and status_hapus='0'";
  $qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
  $rCari  = mysqli_fetch_array($qCari);

  if (!empty($rCari['room_type_id'])) {
    $pesan = "<i class='fa fa-times'></i> Tipe room telah ada sebelumnya";
  }
  if (!is_numeric($price)) {
    $pesan = "<i class='fa fa-times'></i> Price harus angka";
  }
  if (!is_numeric($space)) {
    $pesan = "<i class='fa fa-times'></i> Space harus angka";
  }
  if (empty($pesan)) {

    $sUpdate  = " UPDATE room_type
                  SET room_type='" . $room_type . "', 
                      space=" . $space . ",  
                      price=" . $price . " 
                  WHERE  room_type_id='" . $room_type_id . "'";
    $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
    $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
  }
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
    <?php if ($jenis == 'New') {?>
    <script>
      roomTypeList();
    </script>
    <?php }?>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
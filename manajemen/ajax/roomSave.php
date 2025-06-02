<?php
session_start();
include("../database.php");

$room_name = amankan($_POST['room_name']);
$status = amankan($_POST['status']);
$is_breakfast = amankan($_POST['is_breakfast']);
$is_smoking = amankan($_POST['is_smoking']);
$is_wifi = amankan($_POST['is_wifi']);
$is_fitness = amankan($_POST['is_fitness']);
$is_parking = amankan($_POST['is_parking']);
$bed = amankan($_POST['bed']);
$adult = amankan($_POST['adult']);
$child = amankan($_POST['child']);
$jumlah = amankan($_POST['jumlah']);
$description = amankan($_POST['description']);
$room_type_id = dekripsi(amankan($_POST['tkID']));
$property_id = dekripsi(amankan($_POST['prID']));
$room_id = dekripsi(amankan($_POST['kID']));
$jenis = dekripsi(amankan($_POST['jenis']));

if ($jenis == 'New') {
  $sCari  = " SELECT *
              FROM room
              WHERE lower(room_name)='" . strtolower($room_name) . "' and room_type_id ='" . $room_type_id . "' and status_hapus='0'";
  $qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
  $rCari  = mysqli_fetch_array($qCari);

  if (!empty($rCari['room'])) {
    $pesan = "<i class='fa fa-times'></i> room telah ada sebelumnya";
  }
  if (empty($bed)) {
    $pesan = "<i class='fa fa-times'></i> Bed masih kosong";
  }
  if (!is_numeric($jumlah)) {
    $pesan = "<i class='fa fa-times'></i> Jumlah bukan angka";
  }
  if (empty($description)) {
    $pesan = "<i class='fa fa-times'></i> Keterangan masih kosong";
  }
  if (empty($status)) {
    $pesan = "<i class='fa fa-times'></i> Status masih kosong";
  } 
  if (empty($pesan)) {

    $room_id = randomText(10);
    $sInsert  = " INSERT INTO room
                  SET room_id='" . $room_id . "',
                      room_name=" . $room_name . ", 
                      room_type_id='" . $room_type_id . "',
                      property_id='" . $property_id . "', 
                      is_breakfast=" . $is_breakfast . ",
                      is_smoking=" . $is_smoking . ",
                      is_wifi=" . $is_wifi . ",
                      is_fitness=" . $is_fitness . ",
                      is_parking=" . $is_parking . ",
                      bed='" . $bed . "',
                      adult=" . $adult . ",
                      child=" . $child . ",
                      status='" . $status . "', 
                      description='" . $description . "', 
                      status_hapus='0'";
    $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));
    $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
  }
} else {
  $sCari  = " SELECT *
              FROM room
              WHERE lower(room_name)='" . strtolower($room_name) . "' and room_type_id <>'" . $room_type_id . "' and status_hapus='0'";
  $qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
  $rCari  = mysqli_fetch_array($qCari);

  if (!empty($rCari['room_type_id'])) {
    $pesan = "<i class='fa fa-times'></i> Nomor room telah ada sebelumnya";
  }
  if (!is_numeric($room_name)) {
    $pesan = "<i class='fa fa-times'></i> Nomor room harus angka";
  }
  if (empty($status)) {
    $pesan = "<i class='fa fa-times'></i> Status masih kosong";
  }
  if (empty($pesan)) {

    $sUpdate  = " UPDATE room
                  SET room_name=" . $room_name . ",   
                      status='" . $status . "', 
                      description='" . $description . "'
                  WHERE  room_id='" . $room_id . "'";
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
    <?php if ($jenis == 'New') { ?>
      <script>
        roomList();
      </script>
    <?php } ?>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
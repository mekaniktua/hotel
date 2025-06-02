<?php
session_start();
include("../database.php");

$category = (amankan($_POST['category']));
$facility_name = (amankan($_POST['facility'])); 
 
$sCari  = " SELECT *
            FROM facility
            WHERE category='" . $category . "' and facility_name ='". $facility_name."' and status_hapus='0'";
$qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn)); 
$rCari  = mysqli_fetch_array($qCari);

if(!empty($rCari['facility_id'])){
  $pesan = "<i class='fa fa-times'></i> Fasilitas ". $rCari['facility_name']." dengan category ". $rCari['category']." telah ada sebelumnya";
}else{
  
  $facility_id = randomText(10);
  $sInsert  = " INSERT INTO facility
                SET facility_id='" . $facility_id . "',
                    category='" . $category . "', 
                    facility_name='" . $facility_name . "',  
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
     facilityList();
    </script>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
<?php
session_start();
include("../database.php");

$filename = $_FILES['upload_file']['name'];
$size = $_FILES['upload_file']['size'];

$property_id = amankan(dekripsi($_POST['pID']));
$property_name = amankan($_POST['property_name']);
$telp = amankan($_POST['telp']);
$email = amankan($_POST['email']);
$city = amankan($_POST['city']);
$address = amankan($_POST['address']); 
$jenisInput = amankan(dekripsi($_POST['jenisInput']));

if($jenisInput=='New'){
  if($size>500000){
    $pesan .="<i class='fa fa-times'></i> Filesize too big max. 500kb";
  }if(empty($filename)){
    $pesan .="<i class='fa fa-times'></i> Photo file not found";
  }if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $pesan .= "<i class='fa fa-times'></i> Invalid email address";
  }if(empty($pesan)){
    $sCari  = " SELECT *
              FROM property
              WHERE property_name='" . $property_name . "' and status_hapus='0'";
    $qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn)); 
    $rCari  = mysqli_fetch_array($qCari);

    if(empty($rCari['property_id'])){
      $property_id = randomText(10);
      $property_url = "uploads/property/" . $property_id . "_" . basename($filename);

      $imageFileType = strtolower(pathinfo($property_url, PATHINFO_EXTENSION));
      $valid_extensions = array("jpg", "jpeg");

      if (in_array($imageFileType, $valid_extensions)) {
        if (move_uploaded_file($_FILES['upload_file']['tmp_name'], "../../" . $property_url)) {

          $sInsert  = " INSERT INTO property
                        SET property_id='" . $property_id . "',
                            property_name='" . $property_name . "', 
                            telp='" . $telp . "', 
                            email='" . $email . "', 
                            property_url='" . $property_url . "', 
                            city='" . $city . "', 
                            address='" . $address . "',
                            status_hapus='0'";
          $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));
          $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
        } else {
          echo "Upload failed: Only JPG files are allowed.";
        }
      } else {
        echo "Invalid Photo file.";
      }
    }else{
      $pesan = "<i class='fa fa-times'></i> Failed upload photo."; 
    }
  }
}else{
  $sCari  = " SELECT *
            FROM property
            WHERE property_name='" . $property_name . "' and property_id <>'".$property_id."' and status_hapus='0'";
  $qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
  $rCari  = mysqli_fetch_array($qCari);

  if (empty($rCari['property_id'])) {
    //Jika ada foto
    if (!empty($filename)) {
      $location = "uploads/property/" . $property_id . "_" . basename($filename);

      $imageFileType = strtolower(pathinfo($location, PATHINFO_EXTENSION));
      $valid_extensions = array("jpg", "jpeg", "png");

      if (in_array($imageFileType, $valid_extensions)) {
        if (move_uploaded_file($_FILES['upload_file']['tmp_name'],"../../".$location)) {
          $sUpdate  = " UPDATE property
                        SET property_name='" . $property_name . "',
                            city='" . $city . "',   
                            telp='" . $telp . "', 
                            property_url='" . $location . "', 
                            email='" . $email . "', 
                            address='" . $address . "'
                        WHERE property_id='".$property_id."'";
          $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
          $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
        } else {
          echo "File upload failed. The file must be in JPG or PNG format.";
        }
      } else {
        echo "Invalid foto format.";
      }
    }else{
        $sUpdate  = " UPDATE property
                        SET property_name='" . $property_name . "', 
                            city='" . $city . "',  
                            telp='" . $telp . "',  
                            email='" . $email . "', 
                            address='" . $address . "'
                        WHERE property_id='" . $property_id . "'";
        $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
        $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
    }
  } else {
    $pesan = "<i class='fa fa-times'></i> Property name already exists.";
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
    <script>
      $(".modal").on("hidden.bs.modal", function() {
        window.location = "?menu=property";
      });
    </script>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
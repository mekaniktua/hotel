<?php
session_start();
include("../manajemen/database.php");

$merchant_id = dekripsi(amankan($_SESSION['osg_merchant_id']));
$name = (amankan($_POST['name']));
$email = (amankan($_POST['email']));
$phone = (amankan($_POST['phone']));
$merchant_type = (amankan($_POST['merchant_type']));
$address = (amankan($_POST['address']));
$fileTmp = $_FILES['image']['tmp_name'];
$fileSize = $_FILES['image']['size'];
$fileInfo = getimagesize($fileTmp);

  if(!empty($fileTmp)){
  if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
  

    if ($fileInfo === false) {
      $pesan = "File is not a valid image.";
    }

    $allowedTypes = ['image/jpeg'];
    if (!in_array($fileInfo['mime'], $allowedTypes)) {
      $pesan = "Only JPG/JPEG images are allowed.";
    }

    $width = $fileInfo[0];
    $height = $fileInfo[1];
    $mime = $fileInfo['mime'];

    // Size check: Max 250 KB
    if ($fileSize > 250 * 1024) {
      $pesan = "Image must be less than 250 KB.";
    }

    // Dimension check: 200x200 pixels
    if ($width !== 200 || $height !== 200) {
      $pesan = "Image must be exactly 200x200 pixels.";
    }

    if (empty($pesan)) {
      if (empty($name)) {
        $pesan = "Merchant name field still empty";
      }
      if (empty($email)) {
        $pesan = "Email field still empty";
      }
      if (empty($phone)) {
        $pesan = "Mobile Number field still empty";
      }
      if (empty($merchant_type)) {
        $pesan = "Please select your merchant_type";
      }
      if (empty($pesan)) {

        $targetDir = "uploads/merchant/";
        $fileName = $merchant_id . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($fileTmp, "../".$targetFile)) {
          $sUpdate  = " UPDATE merchant
                        SET name='" . $name . "',
                            email='" . $email . "', 
                            phone='" . $phone . "',
                            address='" . $address . "',
                            merchant_url='" . $targetFile . "',
                            merchant_type='" . $merchant_type . "'
                      WHERE merchant_id='" . $merchant_id . "'";
          $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
          $pesanSukses = "Data telah disimpan";
        } else {
          $pesan = "Failed to save the image.";
        }
      }
    }
  } else {
    $pesan = "Upload error.";
  }
}else{ //tanpa unggah foto
  if (empty($name)) {
    $pesan = "Merchant name field still empty";
  }
  if (empty($email)) {
    $pesan = "Email field still empty";
  }
  if (empty($phone)) {
    $pesan = "Mobile Number field still empty";
  }
  if (empty($merchant_type)) {
    $pesan = "Please select your merchant_type";
  }
  if (empty($pesan)) {
    if (move_uploaded_file($fileTmp, $targetFile)) {
      $sUpdate  = " UPDATE merchant
                    SET name='" . $name . "',
                        email='" . $email . "', 
                        phone='" . $phone . "',
                        address='" . $address . "',
                        merchant_type='" . $merchant_type . "'
                  WHERE merchant_id='" . $merchant_id . "'";
      $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
      $pesanSukses = "Data telah disimpan";
    } else {
      $pesan = "Failed to save the image.";
    }
  }
}

?>


<?php if (!empty($pesan)) { ?>

  <div class="alert alert-danger">
    <i class="fa fa-times"></i>
      <?php echo $pesan; ?>
  </div>
<?php }
if (!empty($pesanSukses)) { ?>
  <div class="alert alert-success">
    <i class="fa fa-check"></i>
      <?php echo $pesanSukses; ?>
  </div> 
<?php } ?>
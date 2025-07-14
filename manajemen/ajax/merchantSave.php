<?php
session_start();
include("../database.php");

$merchant_id = amankan(dekripsi($_POST['mID']));
$filename = $_FILES['upload_file']['name'];
$size = $_FILES['upload_file']['size'];
$name = amankan($_POST['name']);
$email = amankan($_POST['email']);
$phone = amankan($_POST['phone']);
$address = amankan($_POST['address']);
$merchant_type = amankan($_POST['merchant_type']);
$jenisInput = amankan(dekripsi($_POST['jenisInput']));


if ($jenisInput == 'New') {

  if ($size > 500000) {
    $pesan .= "<i class='fa fa-times'></i> File size is too large, max. 500kb";
  }
  if (empty($filename)) {
    $pesan .= "<i class='fa fa-times'></i> Photo file is missing";
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $pesan .= "<i class='fa fa-times'></i> Invalid email address";
  }
  if (empty($merchant_type)) {
    $pesan .= "<i class='fa fa-times'></i> Merchant type is required";
  }
  if (empty($pesan)) {
    $sCari  = " SELECT *
              FROM merchant
              WHERE lower(email)='" . strtolower($email) . "' and status_hapus='0'";
    $qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
    $rCari  = mysqli_fetch_array($qCari);

    if (empty($rCari['merchant_id'])) {
      $merchant_id = randomText(10);
      $location = "uploads/merchant/" . $merchant_id . "_" . basename($filename);

      $imageFileType = strtolower(pathinfo($location, PATHINFO_EXTENSION));
      $valid_extensions = array("jpg", "jpeg", "png");

      if (in_array($imageFileType, $valid_extensions)) {
        if (move_uploaded_file($_FILES['upload_file']['tmp_name'], "../../" . $location)) {
          $sInsert  = " INSERT INTO merchant
                    SET merchant_id='" . $merchant_id . "',
                        created_date='" . date("Y-m-d H:i:s") . "',
                        name='" . $name . "', 
                        email='" . $email . "',
                        merchant_type='" . $merchant_type . "',
                        merchant_url='" . $location . "',
                        phone='" . ($phone) . "',
                        address='" . $address . "',
                        status='Active',
                        status_hapus='0'";
          $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));
          $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
        } else {
          echo "Failed to upload file. The file must be jpg/png";
        }
      } else {
        echo "File format is not supported.";
      }
    } else {
      $pesan = "<i class='fa fa-times'></i> Email already exists";
    }
  }
} else {
  $sCari  = " SELECT *
            FROM merchant
            WHERE lower(email)='" . strtolower($email) . "' and merchant_id <>'" . $merchant_id . "' and status_hapus='0'";
  $qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
  $rCari  = mysqli_fetch_array($qCari);

  if (empty($rCari['merchant_id'])) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $pesan .= "<i class='fa fa-times'></i> Invalid email address";
    }
    if (empty($pesan)) {
      //Jika ada foto
      if (!empty($filename)) {
        $location = "uploads/merchant/" . $merchant_id . "_" . basename($filename);

        $imageFileType = strtolower(pathinfo($location, PATHINFO_EXTENSION));
        $valid_extensions = array("jpg", "jpeg", "png");

        if (in_array($imageFileType, $valid_extensions)) {
          if (move_uploaded_file($_FILES['upload_file']['tmp_name'], "../../" . $location)) {
              $sUpdate  = " UPDATE merchant
                            SET email='" . $email . "',
                                name='" . $name . "',
                                merchant_type='" . $merchant_type . "',
                                merchant_url='" . $location . "',
                                phone='" . ($phone) . "',
                                address='" . $address . "'
                            WHERE merchant_id='" . $merchant_id . "'";
              $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
              $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
          } else {
            echo "Failed to upload file. The file must be jpg/png";
          }
        } else {
          echo "File format is not supported.";
        }
      } else { //Jika tidak ada foto 
          $sUpdate  = " UPDATE merchant
                        SET email='" . $email . "',
                            name='" . $name . "', 
                            merchant_type='" . $merchant_type . "',
                            phone='" . ($phone) . "',
                            address='" . $address . "'
                        WHERE merchant_id='" . $merchant_id . "'";
          $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
          $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
      }
    }
  } else {
    $pesan = "<i class='fa fa-times'></i> Email already exists";
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
        window.location = "?menu=merchant";
      });
    </script>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
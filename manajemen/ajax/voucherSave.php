<?php
session_start();
include("../database.php");

$voucher_id = amankan(dekripsi($_POST['pID'] ?? ''));
$filename = $_FILES['upload_file']['name'] ?? '';
$size = $_FILES['upload_file']['size'] ?? '';
$voucher_title = amankan($_POST['voucher_title'] ?? '');
$start_date = amankan($_POST['start_date'] ?? '');
$end_date = amankan($_POST['end_date'] ?? '');
$status = amankan($_POST['status'] ?? '');
$merchant_id = dekripsi(amankan($_POST['mID'] ?? ''));
$description = amankan($_POST['description'] ?? '');
$jenisInput = amankan(dekripsi($_POST['jenisInput'] ?? ''));

if (empty($voucher_title)) {
  $pesan .= "<i class='fa fa-times'></i> Voucher title is missing<br />";
}
if (empty($start_date)) {
  $pesan .= "<i class='fa fa-times'></i> Start date is missing<br />";
}
if (empty($end_date)) {
  $pesan .= "<i class='fa fa-times'></i> End date is missing<br />";
}
if (($start_date > $end_date)) {
  $pesan .= "<i class='fa fa-times'></i> Start date must be earlier than end date<br />";
}if (empty($pesan)) {

  if ($jenisInput == 'New') {

    if ($size > 500000) {
      $pesan .= "<i class='fa fa-times'></i> File size is too large, max. 500kb<br />";
    }
    if (empty($filename)) {
      $pesan .= "<i class='fa fa-times'></i> Photo file is missing<br />";
    }
    
    if (empty($pesan)) {
      $sCari  = " SELECT *
                FROM voucher
                WHERE lower(voucher_title)='" . strtolower($voucher_title) . "' and start_date='".$start_date."' and end_date='".$end_date."' and status_hapus='0'";
      $qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
      $rCari  = mysqli_fetch_array($qCari);

      if (empty($rCari['voucher_id'])) {
        $voucher_id = randomText(10);
        $location = "uploads/voucher/" . $voucher_id . "_" . basename($filename);

        $imageFileType = strtolower(pathinfo($location, PATHINFO_EXTENSION));
        $valid_extensions = array("jpg", "jpeg", "png");

        if (in_array($imageFileType, $valid_extensions)) {
          if (move_uploaded_file($_FILES['upload_file']['tmp_name'], "../../" . $location)) {
            $sInsert  = " INSERT INTO voucher
                          SET voucher_id='" . $voucher_id . "',
                              created_date='".date("Y-m-d H:i:s")."',
                              voucher_title='" . $voucher_title . "', 
                              merchant_id='" . $merchant_id . "',
                              voucher_url='" . $location . "',
                              start_date='" . ($start_date) . "',
                              end_date='" . $end_date . "',
                              status='" . $status . "',
                              description='". $description."',
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
        $pesan = "<i class='fa fa-times'></i> Voucher already exists";
      }
    }
  } else {
    $sCari  = " SELECT *
              FROM voucher
              WHERE lower(voucher_title)='" . strtolower($voucher_title) . "' and start_date='" . $start_date . "' and end_date='" . $end_date . "' and voucher_id <>'" . $voucher_id . "' and status_hapus='0'";
    $qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
    $rCari  = mysqli_fetch_array($qCari);

    if (empty($rCari['voucher_id'])) {
      
      //Jika ada foto
      if (!empty($filename)) {
        $location = "uploads/voucher/" . $voucher_id . "_" . basename($filename);

        $imageFileType = strtolower(pathinfo($location, PATHINFO_EXTENSION));
        $valid_extensions = array("jpg", "jpeg", "png");

        if (in_array($imageFileType, $valid_extensions)) {
          if (move_uploaded_file($_FILES['upload_file']['tmp_name'], "../../" . $location)) {
            $sUpdate  = " UPDATE voucher
                            SET voucher_title='" . $voucher_title . "', 
                            merchant_id='" . $merchant_id . "',
                            voucher_url='" . $location . "',
                            start_date='" . ($start_date) . "',
                            end_date='" . $end_date . "',
                            status='" . $status . "',
                            description='" . $description . "'
                            WHERE voucher_id='" . $voucher_id . "'";
            $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
            $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
          } else {
            echo "Failed to upload file. The file must be jpg/png";
          }
        } else {
          echo "File format is not supported.";
        }
      } else { //Jika tidak ada foto 
        $sUpdate  = " UPDATE voucher
                        SET voucher_title='" . $voucher_title . "', 
                            merchant_id='" . $merchant_id . "', 
                            start_date='" . ($start_date) . "',
                            end_date='" . $end_date . "',
                            status='" . $status . "',
                            description='" . $description . "'
                        WHERE voucher_id='" . $voucher_id . "'";
        $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
        $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
      } 
    } else {
      $pesan = "<i class='fa fa-times'></i> Voucher already exists";
    }
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
        window.location = "?menu=voucher";
      });
    </script>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
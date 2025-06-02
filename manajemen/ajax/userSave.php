<?php
session_start();
include("../database.php");

$user_id = amankan(dekripsi($_POST['uID'])); 
$filename = $_FILES['upload_file']['name'];
$size = $_FILES['upload_file']['size'];
$name = amankan($_POST['name']); 
$email = amankan($_POST['email']);
$phone = amankan($_POST['phone']);
$address = amankan($_POST['address']);
$jenisInput = amankan(dekripsi($_POST['jenisInput']));


if($jenisInput=='New'){

  if($size>500000){
    $pesan .= "<i class='fa fa-times'></i> File size is too large, max. 500kb";
  }if(empty($filename)){
    $pesan .= "<i class='fa fa-times'></i> Photo file is missing";
  }if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $pesan .= "<i class='fa fa-times'></i> Invalid email address";
  }if(empty($pesan)){
    $sCari  = " SELECT *
              FROM users
              WHERE username='" . $username . "' and status_hapus='0'";
    $qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn)); 
    $rCari  = mysqli_fetch_array($qCari);

    if(empty($rCari['user_id'])){
      $user_id = randomText(10);
      $location = "uploads/users/". $user_id."_" . basename($filename);

      $imageFileType = strtolower(pathinfo($location, PATHINFO_EXTENSION));
      $valid_extensions = array("jpg", "jpeg", "png");

      if (in_array($imageFileType, $valid_extensions)) {
        if (move_uploaded_file($_FILES['upload_file']['tmp_name'], "../../".$location)) {
          $sInsert  = " INSERT INTO users
                    SET user_id='" . $user_id . "',
                        name='" . $name . "',
                        username='" . $username . "',
                        email='" . $email . "',
                        user_url='" . $location . "',
                        password='" . md5($upass) . "',
                        user_type='" . $user_type . "',
                        status_hapus='0'";
          $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));
          $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
        } else {
          echo "Failed to upload file. The file must be jpg/png";
        }
      } else {
        echo "File format is not supported.";
      }
    }else{
      $pesan = "<i class='fa fa-times'></i> Username already exists"; 
    }
  }
}else{
  $sCari  = " SELECT *
            FROM users
            WHERE username='" . $username . "' and user_id <>'".$user_id."' and status_hapus='0'";
  $qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
  $rCari  = mysqli_fetch_array($qCari);

  if (empty($rCari['user_id'])) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $pesan .= "<i class='fa fa-times'></i> Invalid email address";
    }if(empty($pesan)){
      //Jika ada foto
      if(!empty($filename)){
        $location = "uploads/users/" . $user_id . "_" . basename($filename);

        $imageFileType = strtolower(pathinfo($location, PATHINFO_EXTENSION));
        $valid_extensions = array("jpg", "jpeg", "png");

        if (in_array($imageFileType, $valid_extensions)) {
          if (move_uploaded_file($_FILES['upload_file']['tmp_name'], "../../" . $location)) {
            if (!empty($upass)) {
              $sUpdate  = " UPDATE users
                    SET email='" . $email . "',
                        name='" . $name . "',
                        password='" . md5($upass) . "',
                        user_url='" . $location . "',
                        user_type='" . $user_type . "'
                    WHERE user_id='" . $user_id . "'";
              $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
            } else {
              $sUpdate  = " UPDATE users
                    SET email='" . $email . "',
                        name='" . $name . "',
                        user_url='" . $location . "' , 
                        user_type='" . $user_type . "'
                    WHERE user_id='" . $user_id . "'";
              $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
            } 
            $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
          } else {
            echo "Failed to upload file. The file must be jpg/png";
          }
        } else {
          echo "File format is not supported.";
        }
      }else{//Jika tidak ada foto
        if (!empty($upass)) {
          $sUpdate  = " UPDATE users
                        SET username='" . $username . "',
                            name='" . $name . "',
                            password='" . md5($upass) . "', 
                            user_type='" . $user_type . "'
                        WHERE user_id='" . $user_id . "'";
          $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
        } else {
          $sUpdate  = " UPDATE users
                        SET email='" . $email . "', 
                            name='" . $name . "', 
                            user_type='" . $user_type . "'
                        WHERE user_id='" . $user_id . "'";
          $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
        }
        $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
      }
    } 
  } else {
    $pesan = "<i class='fa fa-times'></i> Username already exists";
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
        window.location = "?menu=user";
      });
    </script>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
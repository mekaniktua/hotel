<?php
session_start();
include("../database.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_FILES['image'])) {
    $uploadDir = 'uploads/roomtype/';
    $room_type_id = dekripsi(amankan($_POST['tkID']));
    $user_id = dekripsi(amankan($_SESSION['orangesky_user_id'])); 
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $tmpName = $_FILES['image']['tmp_name'];
    $size = ($_FILES['image']['size'])/1000;
    $name = basename($_FILES['image']['name']);
    $targetFile = $uploadDir . time() . "_" . $name;

    if ($size > 500) {
        
      $pesan = "<i class='fa fa-times'></i> Ukuran file maks. 500kb";
    }
    if(empty($pesan)){
      if (move_uploaded_file($tmpName, "../../" . $targetFile)) {
        $gallery_id = randomText(10);
        $sInsert  = " INSERT INTO gallery
                    SET gallery_id='" . $gallery_id . "',
                        upload_date='" . date("Y-m-d H:i:s") . "', 
                        gallery_url='" . $targetFile . "', 
                        size='" . number_format($size, 2, ",", ".") . "', 
                        room_type_id='" . $room_type_id . "', 
                        user_id='" . $user_id . "', 
                        status_hapus='0'";
        $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));
        $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
      } else { 
        $pesan = "<i class='fa fa-times'></i> Gagal Unggah File";
      }
    }
  }else{
    $pesan = "<i class='fa fa-times'></i> Silahkan pilih file gambar";
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
        galleryList();
      </script> 
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
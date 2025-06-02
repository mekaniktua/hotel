<?php
session_start();
include("../database.php");

$template_wa_id = dekripsi(amankan($_POST['twID']));
$pesanWA = (amankan($_POST['pesanWA']));
$jenisInput = dekripsi(amankan($_POST['jenisInput']));
$category = dekripsi(amankan($_POST['category']));

if (strlen($pesanWA)<10) {
  $pesan .= "<i class='fa fa-times'></i> Pesan terlalu pendek <br />";
}
if (empty($pesan)) {

  if ($jenisInput == 'New') {
    
      $template_wa_id = randomText(10);
      $sInsert  = " INSERT INTO template_wa
                    SET template_wa_id='" . $template_wa_id . "',
                      pesan='" . $pesanWA . "',
                      category='".$category."',
                      status_hapus='0'";
      $qInsert = mysqli_query($conn, $sInsert) or die(mysqli_error($conn));
      $pesanSukses = "<i class='fa fa-check'></i> Data has been saved";
  
  } else {
    
      $sUpdate  = " UPDATE template_wa
                    SET pesan='" . $pesanWA . "'
                    WHERE template_wa_id='" . $template_wa_id . "'";
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
    <script>
      $(".modal").on("hidden.bs.modal", function() {
        templateWAList();
      });
    </script>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
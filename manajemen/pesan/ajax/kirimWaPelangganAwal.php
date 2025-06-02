<?php
session_start();
include("../database.php");

$pesanWa = $_POST['pesanWa'];
if (empty($_POST['pelanggan'])) {
  $pesan .= "<i class='fa fa-times'></i> Anda belum memilih pelanggan<br />";
}
if (empty($pesan)) {

  $datas = ($_POST['pelanggan']);
  foreach ($datas as $data) {
    $data = (dekripsi($data));
    $query .= "'" . ($data) . "',";
  }
  $query = trim($query, ","); // Untuk menghilangkan koma dibelakang
  
  $sData =  " SELECT * 
              FROM pelanggan 
              WHERE (status_hapus is null or status_hapus='0') " . (!empty($query) ? " and pelanggan_id in (" . $query . ") " : "");
  $qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));

  while ($rData = mysqli_fetch_array($qData)) {
    $li .= "<li>" . $rData['nama'] . " - " . $rData['no_hp'] . "</li>";
  }
}
?>
<div class="pesanku">
  <?php if (!empty($pesan)) { ?>
    <div class="alert alert-danger">
      <?php echo $pesan; ?>
    </div>
  <?php } else { ?>

    <div class="panel panel-default">
      <div class="panel-body">
        <table class="table table-striped">
          <tr>
            <th>PESAN</th>
          </tr>
          <tr>
            <td>
              <?php echo nl2br($pesanWa); ?>
            </td>
          </tr>
          <tr>
            <th>PELANGGAN</th>
          </tr>
          <tr>
            <td>
              <ol><?php echo $li; ?></ol>
            </td>
          </tr>
        </table>
      </div>
    </div>

    <div class="row form-group">
      <div class="col-md-12 form-group">
        <h4>Apakah anda akan mengirim pesan tersebut?</h4>
        <button type="button" class="btn btn-success" onclick="kirim()"><i class="fa fa-send"></i> Kirim</button>
      </div>
    </div>
  <?php } ?>
</div>

<script>
  function kirim() {
 
    $.ajax({
      type: "POST",
      url: "ajax/kirimWaPelanggan.php",
      data: {
        pesanWa: '<?php echo $pesanWa; ?>',
        pelanggan: "<?php echo $query; ?>",
      },
      beforeSend: function() {
        $.blockUI({
          message: '<h5><img src="images/loading.gif" width="50px" /> Please wait</h5>'
        });
      },
      success: function(data) {
        $("#modalInfo").modal('show');
        $("#ajaxInfo").html(data);

      },
      complete: function() {
        $.unblockUI();
      }
    });
  }
</script>
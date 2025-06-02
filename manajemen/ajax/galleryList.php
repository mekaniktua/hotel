<?php
session_start();
include("../database.php");

$room_type_id = dekripsi(amankan($_POST['tkID']));
$sData  = " SELECT g.*,u.name
            FROM gallery g 
            JOIN users u ON u.user_id=g.user_id 
            WHERE g.status_hapus='0' and g.room_type_id='" . $room_type_id . "'
            order by upload_date desc";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));

?>
<div class="full white_shd margin_bottom_30">
  <div class="table_section padding_infor_info">
    <span style="font-size: 18px;font-weight: bold;">TYPE ROOM GALLERY</span>
    <div class="pull-right">
      <button type="button" onclick="galleryList()" class="btn btn-warning"><i class="fa fa-refresh"></i></button>
    </div>
    <hr />
    <div class="table-responsive">
      <table class="table table-striped" id="datatable">
        <thead>
          <tr>
            <th width="10%">&nbsp;</th>
            <th>UPLOAD DATE</th>
            <th>FILESIZE</th>
            <th>UPLOADED BY</th>
            <th>DELETE??</th>
          </tr>
        </thead>
        <tbody>
          <!-- data-gallery="gallery" -->
          <?php while ($rData  = mysqli_fetch_array($qData)) {
          ?>
            <tr class="text-nowrap">
              <td>
                <a href="<?php echo "../".$rData['gallery_url'] ?>" data-toggle="lightbox">
                  <img src="<?php echo "../" .$rData['gallery_url'] ?>" class="img-responsive" width="200px">
                </a>
              </td>
              <td><?php echo normalTanggalJam($rData['upload_date']); ?></td>
              <td><?php echo ($rData['size']); ?> kb</td>
              <td><?php echo ($rData['name']); ?></td>
              <td style="width: 10px;"><button onclick="hapus('<?php echo enkripsi($rData['gallery_id']);?>')" class="btn btn-danger"> <i class="fa fa-trash"></i></button></td>
            </tr>
          <?php }; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#datatable').DataTable({
      // dom: '<"container-fluid"<"row"<"col"B><"col"l><"col"f>>>rtip',
      // buttons: [
      //   'print', 'excel'
      // ],
      lengthMenu: [50, 100, 200, 500],
      order: [
        [0, 'desc']
      ]
    });
  });

 

  function hapus(x) {
    if (confirm("Do you want to delete this data?")) {
      $.ajax({
        type: "POST",
        url: "ajax/galleryDelete.php",
        data: {
          'gID': x
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
  }
</script>
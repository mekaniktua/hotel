<?php
session_start();
include("../database.php");

$property_id = dekripsi(amankan($_POST['prID']));
$room_type_id = dekripsi(amankan($_POST['tkID']));

$sData  = " SELECT f.*,fk.room_facility_id
            FROM room_facility fk
            JOIN facility f On f.facility_id=fk.facility_id 
            WHERE fk.status_hapus='0' and room_type_id ='" . $room_type_id . "'";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));

?>
<div class="full white_shd margin_bottom_30">
  <div class="table_section padding_infor_info">
    <span style="font-size: 18px;font-weight: bold;">DATA ROOM FACILITIES </span>
    <div class="pull-right">
      <button type="button" onclick="roomFacilityList()" class="btn btn-warning"><i class="fa fa-refresh"></i></button>
    </div>
    <hr />
    <div class="table-responsive">
      <table class="table table-striped" id="datatable">
        <thead>
          <tr>
            <th width="10%">&nbsp;</th>
            <th>CATEGORY</th>
            <th>FACILITY</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($rData  = mysqli_fetch_array($qData)) { ?>
            <tr class="text-nowrap">
              <td>
                <button class="btn btn-danger" onclick="hapus('<?php echo enkripsi($rData['room_facility_id']) ?>')"><i class="fa fa-trash"></i></button>
              </td>
              <td><?php echo ($rData['category']); ?></td>
              <td><?php echo ($rData['facility_name']); ?></td>
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
        url: "ajax/facilityDelete.php",
        data: {
          'fID': x
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
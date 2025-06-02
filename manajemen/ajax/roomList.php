<?php
session_start();
include("../database.php");

$property_id = dekripsi(amankan($_POST['prID']));
$room_type_id = dekripsi(amankan($_POST['tkID']));
$sData  = " SELECT *
            FROM room 
            WHERE status_hapus='0' and room_type_id='" . $room_type_id . "' 
            order by room_name";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));

?>
<div class="full white_shd margin_bottom_30">
  <div class="table_section padding_infor_info">
    <span style="font-size: 18px;font-weight: bold;">DATA ROOM</span>
    <div class="pull-right">
      <button type="button" onclick="roomList()" class="btn btn-warning"><i class="fa fa-refresh"></i></button>
    </div>
    <hr />
    <div class="table-responsive">
      <table class="table table-striped" id="datatable">
        <thead>
          <tr>
            <th width="10%">&nbsp;</th>
            <th>ROOM</th>
            <th>FITUR</th>
            <th>JUMLAH</th>
            <th>ADULT</th>
            <th>CHILD</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($rData  = mysqli_fetch_array($qData)) {

          ?>
            <tr class="text-nowrap">
              <td>
                <div class="dropdown">
                  <button class="btn btn-success dropdown-toggle" type="button" id="menuTipeRoom" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-pencil"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="menuTipeRoom">
                    <a class="dropdown-item" href="#" onclick="edit('<?php echo enkripsi($rData['room_id']); ?>')">edit</a>
                  </div><br /><br />
                  <?php echo ($rData['status'] == 'Publish' ? "<span style='color:green'>".$rData['status']."</span>" : "<span style='color:orange'>" . $rData['status'] . "</span>"); ?>
                </div>
              </td>
              <td><?php echo ($rData['room_name']); ?></td>
              <td><?php echo ($rData['is_breakfast'] == 1 ? "<p style='color: green;'><i class='fa fa-check'></i> Nice Breakfast Included</p>" : "<p style='color: red;'><i class='fa fa-times'></i> No Breakfast Included</p>"); ?>
                <?php echo ($rData['is_wifi'] == 1 ? "<p><i class='fa fa-check'></i> Free Wifi</p>" : "<p><i class='fa fa-times'></i> No Wifi</p>"); ?>
                <?php echo ($rData['is_parking'] == 1 ? "<p><i class='fa fa-check'></i> Parking</p>" : ""); ?>
                <?php echo ($rData['is_fitness'] == 1 ? "<p><i class='fa fa-check'></i> Fitness Access</p>" : ""); ?></td>
              <td><?php echo angka($rData['jumlah']); ?></td>
              <td><?php echo angka($rData['adult']); ?></td>
              <td><?php echo angka($rData['child']); ?></td>
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

  function edit(x) {
    window.open("?menu=roomEdit&prID=<?php echo enkripsi($property_id); ?>&tkID=<?php echo enkripsi($room_type_id); ?>&kID=" + x, "_self");
  }

  function hapus(x) {
    if (confirm("Do you want to delete this data?")) {
      $.ajax({
        type: "POST",
        url: "ajax/roomDelete.php",
        data: {
          'kID': x
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
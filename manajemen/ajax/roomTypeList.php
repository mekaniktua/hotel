<?php
session_start();
include("../database.php");

$property_id = dekripsi(amankan($_POST['prID'] ?? ''));
$sData  = " SELECT *
            FROM room_type 
            WHERE status_hapus='0' and property_id='" . $property_id . "'
            order by room_type";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));

?>
<div class="full white_shd margin_bottom_30">
  <div class="table_section padding_infor_info">
    <span style="font-size: 18px;font-weight: bold;">DATA ROOM TYPE</span>
    <div class="pull-right">
      <button type="button" onclick="roomTypeList()" class="btn btn-warning"><i class="fa fa-refresh"></i></button>
    </div>
    <hr />
    <div class="table-responsive">
      <table class="table table-striped" id="datatable">
        <thead>
          <tr>
            <th width="10%">&nbsp;</th>
            <th>ROOM TYPE</th>
            <th>SPACE (m2)</th>
            <th>PRICE (Rp)</th>
            <th>TOTAL</th> 
          </tr>
        </thead>
        <tbody>
          <?php while ($rData  = mysqli_fetch_array($qData)) {
            $sJumlah  = " SELECT 
                            SUM(total) AS total
                          FROM room 
                          WHERE status_hapus='0' and room_type_id='" . $rData['room_type_id'] . "'";
            $qJumlah = mysqli_query($conn, $sJumlah) or die(mysqli_error($conn));
            $rJumlah = mysqli_fetch_array($qJumlah);
          ?>
            <tr class="text-nowrap">
              <td>
                <div class="dropdown">
                  <button class="btn btn-success dropdown-toggle" type="button" id="menuTipeKamr" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-pencil"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="menuTipeKamr">
                    <a class="dropdown-item" onclick="edit('<?php echo enkripsi($rData['room_type_id']); ?>')" href="#">Edit</a>
                    <a class="dropdown-item" onclick="facility('<?php echo enkripsi($rData['room_type_id']); ?>')" href="#">Facility</a>
                    <a class="dropdown-item" onclick="dataRoom('<?php echo enkripsi($rData['room_type_id']); ?>')" href="#">Room(s)</a>
                    <a class="dropdown-item" onclick="gallery('<?php echo enkripsi($rData['room_type_id']); ?>')" href="#">Gallery</a>
                    <a class="dropdown-item" href="#" onclick="hapus('<?php echo enkripsi($rData['room_type_id']); ?>')">Delete</a>
                  </div>
                </div>
              </td>
              <td><?php echo ($rData['room_type']); ?></td>
              <td><?php echo angka($rData['space']); ?></td>
              <td><?php echo angka($rData['price']); ?>,-</td>
              <td><?php echo angka($rJumlah['total']); ?></td> 
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

  function facility(x) {
    window.open("?menu=roomFacility&prID=<?php echo enkripsi($property_id); ?>&tkID=" + x, "_self");
  }

  function dataRoom(x) {
    window.open("?menu=room&prID=<?php echo enkripsi($property_id); ?>&tkID=" + x, "_self");
  }

  function edit(x) {
    window.open("?menu=roomTypeEdit&prID=<?php echo enkripsi($property_id); ?>&tkID=" + x, "_self");
  }

  function gallery(x) {
    window.open("?menu=gallery&prID=<?php echo enkripsi($property_id); ?>&tkID=" + x, "_self");
  }

  function hapus(x) {
    if (confirm("Do you want to delete this data?")) {
      $.ajax({
        type: "POST",
        url: "ajax/roomTypeDelete.php",
        data: {
          'rtID': x
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
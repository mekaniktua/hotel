<?php
session_start();
include("../database.php");

$kriteria = amankan($_POST['kriteria']);
$keyword = amankan($_POST['keyword']);

$sData  = " SELECT *
            FROM member
            WHERE status_hapus='0'" . (!empty($keyword) ? " and lower(" . $kriteria . ") like '%" . strtolower($keyword) . "%'" : "") . " 
            order by fullname";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));

?>
<div class="full white_shd margin_bottom_30">
  <div class="table_section padding_infor_info">
    <h5>MEMBER LIST</h5>
    <br />
    <div class="table-responsive">
      <table class="table table-striped" id="datatable">
        <thead>
          <tr>
            <th width="5%">&nbsp;</th>
            <th>NAME</th> 
            <th>EMAIL</th>
            <th>MOBILE</th>
            <th>TYPE</th>
            <th>POINT</th>
            <th>NATIONALITY</th>
            <th>STATUS</th>

          </tr>
        </thead>
        <tbody>
          <?php while ($rData  = mysqli_fetch_array($qData)) { ?>
            <tr class="text-nowrap">
              <td>
                <div class="dropdown">
                  <button class="btn btn-success dropdown-toggle" type="button" id="menuMember" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-pencil"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="menuMember">
                    <a class="dropdown-item" href="#" onclick="upgrade('<?php echo enkripsi($rData['member_id']); ?>')">Upgrade</a>
                    <a class="dropdown-item" href="#" onclick="log('<?php echo enkripsi($rData['member_id']); ?>')">Member Log</a>
                  </div>
                </div>
              </td>
              <td><?php echo ($rData['fullname']); ?></td> 
              <td><?php echo ($rData['email']); ?></td>
              <td><?php echo ($rData['mobile_number']); ?></td>
              <td><?php echo ($rData['member_type']); ?></td>
              <td><?php echo angka($rData['point']); ?></td>
              <td><?php echo ($rData['nationality']); ?></td>
              <td><?php echo ($rData['status']); ?></td>

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

  function upgrade(x) {
    if (confirm("Do you want to upgrade this member?")) {
      $.ajax({
        type: "POST",
        url: "ajax/memberUpgrade.php",
        data: {
          'mID': x
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

  function log(x) {
    
      $.ajax({
        type: "POST",
        url: "ajax/memberLog.php",
        data: {
          'mID': x
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
<?php
session_start();
include("../database.php");

$kriteria = amankan($_POST['kriteria']);
$bookingValue = amankan($_POST['bookingValue']);
$start_date = amankan($_POST['start_date']);
$end_date = amankan($_POST['end_date']);

$allowedKriteria = ['b.booking_id', 'm.email', 'm.fullname','start_date'];

if (!in_array($kriteria, $allowedKriteria)) {
  die('Invalid search criteria');
}

$sData  = " SELECT b.*,m.fullname,m.email,p.property_name,k.room_name,tk.room_type
            FROM booking b
            JOIN member m ON m.member_id=b.member_id
            JOIN property p ON p.property_id=b.property_id
            JOIN room_type tk ON tk.room_type_id=b.room_type_id
            JOIN room k ON b.room_id=k.room_id
            WHERE b.status_hapus='0' and b.status<>'Draft' " . (!empty($bookingValue) ? " and " . $kriteria . " like '%" . $bookingValue . "%'" : ""). (!empty($start_date) ? " and " . $kriteria . " between '" . $start_date . "' and '" . $end_date . "'" : "") . " 
            order by b.created_date";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));

?>
<div class="full white_shd margin_bottom_30">
  <div class="table_section padding_infor_info">
    <h5>DAFTAR BOOKING</h5>
    <br />
    <div class="table-responsive">
      <table class="table table-striped" id="datatable">
        <thead>
          <tr>
            <th width="5%">&nbsp;</th>
            <th>BOOKING ID</th>
            <th>START DATE</th>
            <th>END DATE</th>
            <th>BOOKED BY</th>
            <th>PROPERTY (ROOM)</th>
            <th>TOTAL</th>
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
                    <a class="dropdown-item" href="#" onclick="detail('<?php echo enkripsi($rData['booking_id']); ?>')">Detail</a>
                  </div>
                </div>
              </td>
              <td><?php echo ($rData['booking_id']); ?></td>
              <td><?php echo normalTanggal($rData['start_date']); ?></td>
              <td><?php echo normalTanggal($rData['end_date']); ?></td>
              <td><?php echo ($rData['email']); ?></td>
              <td>
                <?php echo ($rData['property_name']); ?>
                <br /><?php echo ($rData['room_type']); ?>
              </td>
              <td><?php echo ($rData['currency']=='IDR' ? $rData['currency'] . " " .angka($rData['total']) : $rData['currency']." ".number_format($rData['total'],1))?></td>
              <td><?php 
                  if ($rData['status'] == 'Booked'){
                    echo "<span style='color:orange;'>" . $rData['status'] . "</span>";
                  } else if ($rData['status'] == 'Expired') {
                    echo "<span style='color:red;'>" . $rData['status'] . "</span>";
                  } else if ($rData['status'] == 'Cancelled') {
                    echo "<span style='color:red;'>" . $rData['status'] . "</span>";
                  }else if ($rData['status'] == 'Completed') {
                    echo "<span style='color:green;'>" . $rData['status'] . "</span>";
                  }?></td>

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

    });
  });

  function detail(x) {
    $.ajax({
      type: "POST",
      url: "ajax/bookingDetail.php",
      data: {
        'bID': x
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
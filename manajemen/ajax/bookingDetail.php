<?php
session_start();
include("../database.php");

$booking_id = dekripsi(amankan($_POST['bID']));


$sData  = " SELECT b.*,m.fullname,m.email,p.property_name,k.room_name,tk.room_type
            FROM booking b
            JOIN member m ON m.member_id=b.member_id
            JOIN property p ON p.property_id=b.property_id
            JOIN room_type tk ON tk.room_type_id=b.room_type_id
            JOIN room k ON b.room_id=k.room_id
            WHERE b.status_hapus='0' and b.status<>'Draft' and b.booking_id ='" . $booking_id . "'
            order by created_date";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
$rData  = mysqli_fetch_array($qData)


?>
<h5><i class="fa fa-info-circle"></i> BOOKING DETAIL</h5>
<hr />
<div style="overflow-x: scroll;max-height: 500px;">
  <table class="table table-striped">
    <tbody>
      <tr>
        <td>
          <label>BOOKING ID</label><br />
          <?php echo ($rData['booking_id']); ?>
        </td>
        <td><label>STATUS</label><br />
          <?php if ($rData['status'] == 'Booked') {
            echo "<span style='color:orange;'>" . $rData['status'] . "</span>";
          } else if ($rData['status'] == 'Expired') {
            echo "<span style='color:red;'>" . $rData['status'] . "</span>";
          } else if ($rData['status'] == 'Cancelled') {
            echo "<span style='color:red;'>" . $rData['status'] . "</span>";
          } else if ($rData['status'] == 'Completed') {
            echo "<span style='color:green;'>" . $rData['status'] . "</span>";
          } ?>
        </td>
      </tr>
      <tr>
        <td><label>BOOKED BY</label><br />
          <?php echo ($rData['email']); ?>
        </td>
        <td>
          <label>BOOKED DATE</label><br />
          <?php echo normalTanggal($rData['created_date']); ?>
        </td>
      </tr>
      <tr>
        <td><label>START DATE</label><br />
          <?php echo normalTanggal($rData['start_date']); ?>
        </td>
        <td>
          <label>END DATE</label><br />
          <?php echo normalTanggal($rData['end_date']) ?>
        </td>
      </tr>
      <tr>
        <td>
          <label>PROPERTY</label><br />
          <?php echo ($rData['property_name']); ?>
        </td>
        <td>
          <label>ROOM TYPE</label><br />
          <?php echo ($rData['room_type']); ?>
        </td>
      </tr>
      <tr>
        <td>
          <label>ADULT(s)</label><br />
          <?php echo ($rData['adult']); ?>
        </td>
        <td>
          <label>CHILD(s)</label><br />
          <?php echo ($rData['child']); ?>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <label>SPECIAL REQUEST</label><br />
          <?php echo ($rData['special_request']); ?>
        </td>

      </tr>
      <tr>
        <td>
          <label>TOTAL</label><br />
          <?php echo ($rData['currency'] == 'IDR' ? $rData['currency'] . " " . angka($rData['total']) : $rData['currency'] . " " . number_format($rData['total'], 1)) ?>
        </td> 
        <td>
          <label>ROOM</label><br />
          <?php echo ($rData['room_number']); ?>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <label>DESCRIPTION</label><br />
          <?php echo ($rData['description']); ?>
        </td>
      </tr>

      <?php if (!empty($rData['approved_date']) && $rData['status']=='Completed') { ?>
        <tr>
          <td colspan="2">
            <label>APPROVED DATE</label><br />
            <?php echo normalTanggal($rData['approved_date']); ?>
          </td>
        </tr>
      <?php } ?>
      <?php if (!empty($rData['expired_date']) && $rData['status'] == 'Expired') { ?>
        <tr>
          <td colspan="2">
            <label>EXPIRED DATE</label><br />
            <?php echo normalTanggal($rData['expired_date']); ?>
          </td>
        </tr>
      <?php } ?>
      <?php if (!empty($rData['cancelled_date']) && $rData['status'] == 'Cancelled') { ?>
        <tr>
          <td colspan="2">
            <label>CANCELLED DATE</label><br />
            <?php echo normalTanggal($rData['cancelled_date']); ?>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<div class="modal-footer">
  <?php if ($rData['status'] == 'Booked') { ?>
    <button type="button" onclick="cancel('<?php echo enkripsi($booking_id); ?>')" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</button>
    <button type="button" onclick="approve('<?php echo enkripsi($booking_id); ?>')" class="btn btn-success"><i class="fa fa-check"></i> Completed</button>
  <?php } ?>
</div>

<script>
  function approve(x) {
    $.ajax({
      type: "POST",
      url: "ajax/bookingApproveAwal.php",
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

  function cancel(x) {
    if (confirm("Are you sure want to cancel this booking?")) {
      $.ajax({
        type: "POST",
        url: "ajax/bookingCancelAwal.php",
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
  }
</script>
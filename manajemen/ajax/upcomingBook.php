<?php
session_start();
include("../database.php");

//Data di tabel user apakah sudah ada?
$sData  = " SELECT b.*,m.email
            FROM booking b
            JOIN member m ON m.member_id=b.member_id
            WHERE b.status_hapus='0' and b.status='Booked'
            LIMIT 10";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));

?>
<div class="card border-info">
  <div class="card-header bg-info text-white"><i class="fa-solid fa-receipt"></i> Latest Upcoming Book</div>
  <div class="card-body">
    <table class="table table-striped" id="datatable">
      <thead>
        <tr>
          <th>Created Date</th>
          <th>Booking ID</th>
          <th>Email</th>
          <th>Start Date</th>
          <th>End Date</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($rData = mysqli_fetch_array($qData)) { ?>
          <tr>
            <td><?php echo normalTanggalJam($rData['created_date']) ?></td>
            <td><?php echo $rData['booking_id'] ?></td>
            <td><?php echo $rData['email'] ?></td>
            <td><?php echo normalTanggal($rData['created_date']) ?></td>
            <td><?php echo normalTanggal($rData['end_date']) ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#datatable').DataTable({
      paging: false, // Tidak ada pagination
      info: false, // Tidak menampilkan info "Showing X to Y..."
      ordering: false
    });
  });
</script>
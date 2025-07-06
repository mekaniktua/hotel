<?php
session_start();
include("../database.php"); 

$property_id = dekripsi(amankan($_POST['pID']));
$tanggal_awal = (amankan($_POST['tanggalAwal']));
$tanggal_akhir = (amankan($_POST['tanggalAkhir']));
$lama = lama($tanggal_awal, $tanggal_akhir);
//Data di tabel user apakah sudah ada?
$sData  = " SELECT b.*,p.property_name,r.room_type,m.fullname,m.mobile_number,m.email
            FROM booking b
            JOIN property p ON p.property_id=b.property_id
            JOIN room_type r ON r.room_type_id=b.room_type_id
            JOIN member m ON m.member_id=b.member_id
            WHERE b.property_id='" . $property_id . "' and  start_date >= '" . $tanggal_awal . "' and end_date <= '" . $tanggal_akhir . "' and b.status_hapus='0'
            order by b.start_date";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
   
?>
<div class="full white_shd margin_bottom_30">
  <div class="table_section padding_infor_info table-responsive">
    <table id="datatable" class="table table-bordered table-striped table-hover">
      <thead>
        <tr>
          <th>No</th>
          <th>Property</th>
          <th>Room Type</th>
          <th>Guest</th>
          <th>Check In</th>
          <th>Check Out</th>
          <th>Currency</th>
          <th>Total</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; while ($rData = mysqli_fetch_array($qData)) { ?>
          <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $rData['property_name']; ?></td> 
            <td><?php echo $rData['room_type']; ?></td>
            <td><?php echo $rData['fullname']; ?></td>
            <td><?php echo $rData['start_date']; ?></td>
            <td><?php echo $rData['end_date']; ?></td>
            <td><?php echo $rData['currency']; ?></td>
            <td><?php echo $rData['total']; ?></td>
            <td><?php echo $rData['status']; ?></td>
          </tr>
        <?php $no++; } ?>
      </tbody>
    </table>
  </div>
</div>



<script> 
  $(document).ready(function() {
    $('#datatable').DataTable({
      dom: '<"container-fluid"<"row"<"col"B><"col"l><"col"f>>>rtip',
      buttons: [
        {
          extend: 'excel',
          title: 'Booking Report'
        }
      ],
      lengthMenu: [50, 100, 200, 500],
      order: [
        [1, 'desc']
      ]
    });
  });
</script>
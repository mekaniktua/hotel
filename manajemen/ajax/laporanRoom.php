<?php
session_start();
include("../database.php"); 

$property_id = dekripsi(amankan($_POST['pID']));
$room_type_id = dekripsi(amankan($_POST['roomTypeID']));
$room_id = dekripsi(amankan($_POST['roomID']));
$tanggal_awal = (amankan($_POST['tanggalAwal']));
$tanggal_akhir = (amankan($_POST['tanggalAkhir']));
$lama = lama($tanggal_awal, $tanggal_akhir);
//Data di tabel user apakah sudah ada?
$sData  = " SELECT  
    b.property_id,
    b.room_type_id,
    b.room_id, 
    p.property_name,
    r.room_type,
    rm.room_name,
    COUNT(b.booking_id) AS total_booked
FROM booking b
JOIN property p ON p.property_id = b.property_id
JOIN room_type r ON r.room_type_id = b.room_type_id 
JOIN room rm ON rm.room_id = b.room_id
WHERE b.start_date >= '$tanggal_awal'
  AND b.end_date <= '$tanggal_akhir'
  AND b.status_hapus = '0'
  " . (!empty($property_id) ? " AND b.property_id = '$property_id'" : "") . "
  " . (!empty($room_type_id) ? " AND b.room_type_id = '$room_type_id'" : "") . "
  " . (!empty($room_id) ? " AND b.room_id = '$room_id'" : "") . "
GROUP BY 
   
    b.property_id,
    b.room_type_id,
    b.room_id,  p.property_name, r.room_type, rm.room_name
ORDER BY p.property_name, r.room_type, rm.room_name;
";
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
          <th>Room Name</th>
          <th>Total Booked</th> 
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; while ($rData = mysqli_fetch_array($qData)) { ?>
          <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $rData['property_name']; ?></td> 
            <td><?php echo $rData['room_type']; ?></td>
            <td><?php echo $rData['room_name']; ?></td>
            <td><?php echo $rData['total_booked']; ?></td> 
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
          title: 'Room Report'
        }
      ],
      lengthMenu: [50, 100, 200, 500],
      order: [
        [1, 'desc']
      ]
    });
  });
</script>
<?php
session_start();
include("../database.php"); 

$criteria = amankan($_POST['criteria'] ?? '');
$value = amankan($_POST['value'] ?? '');

if(!empty($value)){
    $sData  = " SELECT m.*,count(b.booking_id) as total_booking FROM member m
            left join booking b on b.member_id=m.member_id
            WHERE lower(m." . $criteria . ") LIKE '%" . strtolower($value) . "%' and m.status_hapus='0' and b.status='Completed'
            group by m.member_id
            order by m.fullname,total_booking desc";
}else{
    $sData  = " SELECT m.*,count(b.booking_id) as total_booking FROM member m
            left join booking b on b.member_id=m.member_id
            WHERE m.status_hapus='0' and b.status='Completed'
            group by m.member_id
            order by m.fullname,total_booking desc";
}
 
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
   
?>
<div class="full white_shd margin_bottom_30">
  <div class="table_section padding_infor_info">
    <div class="table-responsive">
    <table id="datatable" class="table table-bordered table-striped table-hover">
      <thead>
        <tr>
          <th>No</th>
          <th>Avatar</th>
          <th>Fullname</th>
          <th>Mobile Number</th>
          <th>Email</th>
          <th>Birth Date</th>
          <th>Member Type</th>
          <th>Point</th> 
          <th>Total Booking</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; while ($rData = mysqli_fetch_array($qData)) { ?>
          <tr>
            <td><?php echo $no; ?></td>
            <td><img src="<?php echo "../".$rData['avatar']; ?>" width="50px" height="50px"></td> 
            <td><?php echo $rData['fullname']; ?></td>
            <td><?php echo $rData['mobile_number']; ?></td>
            <td><?php echo $rData['email']; ?></td>
            <td><?php echo $rData['birthdate']; ?></td>
            <td><?php echo $rData['member_type']; ?></td>
            <td><?php echo $rData['point']; ?></td>
            <td><?php echo $rData['total_booking']; ?></td>
            <td><?php echo $rData['status']; ?></td>
          </tr>
        <?php $no++; } ?>
      </tbody>
    </table>
    <br /><br />
    </div>
  </div>
</div>



<script> 
  $(document).ready(function() {
    $('#datatable').DataTable({
        dom: '<"container-fluid"<"row"<"col"B><"col"l><"col"f>>>rtip',
        buttons: [
            {
                extend: 'excel',
                title: 'Member Report'
            }
        ],
        lengthMenu: [50, 100, 200, 500],
        order: [
            [1, 'desc']
        ]
    });
});
</script>
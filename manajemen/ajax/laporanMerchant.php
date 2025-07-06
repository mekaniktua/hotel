<?php
session_start();
include("../database.php"); 

$criteria = amankan($_POST['criteria'] ?? '');
$value = amankan($_POST['value'] ?? '');

if(!empty($value)){
    $sData  = " SELECT m.*,count(v.voucher_id) as total_voucher,count(vb.voucher_booking_id) as voucher_booking FROM merchant m
            left join voucher v on m.merchant_id=v.merchant_id
            left join voucher_booking vb on v.voucher_id=vb.voucher_id
            WHERE lower(m." . $criteria . ") LIKE '%" . strtolower($value) . "%' and m.status_hapus='0' and v.status_hapus='0'     
            group by m.merchant_id
            order by m.name,total_voucher desc";
}else{
    $sData  = " SELECT m.*,count(v.voucher_id) as total_voucher,count(vb.voucher_booking_id) as voucher_booking FROM merchant m
            left join voucher v on m.merchant_id=v.merchant_id
            left join voucher_booking vb on v.voucher_id=vb.voucher_id
            WHERE m.status_hapus='0' and v.status_hapus='0' 
            group by m.merchant_id
            order by m.name,total_voucher desc";
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
          <th>Logo</th>
          <th>Created Date</th>
          <th>Name</th>
          <th>Phone</th>
          <th>Email</th>
          <th>Address</th>
          <th>Merchant Type</th>
          <th>Total Voucher</th>
          <th>Total Voucher Booking</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; while ($rData = mysqli_fetch_array($qData)) { ?>
          <tr>
            <td><?php echo $no; ?></td>
            <td><img src="<?php echo "../".$rData['merchant_url']; ?>" width="50px" height="50px"></td> 
            <td><?php echo $rData['created_date']; ?></td>
            <td><?php echo $rData['name']; ?></td>
            <td><?php echo $rData['phone']; ?></td>
            <td><?php echo $rData['email']; ?></td>
            <td><?php echo $rData['address']; ?></td>
            <td><?php echo $rData['merchant_type']; ?></td> 
            <td><?php echo $rData['total_voucher']; ?></td>
            <td><?php echo $rData['voucher_booking']; ?></td>
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
                title: 'Merchant Report'
            }
        ],
        lengthMenu: [50, 100, 200, 500],
        order: [
            [1, 'desc']
        ]
    });
});
</script>
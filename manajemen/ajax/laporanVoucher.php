<?php
session_start();
include("../database.php"); 

$criteria = amankan($_POST['criteria'] ?? '');
$value = amankan($_POST['value'] ?? '');

if(!empty($value)){
    $sData  = " SELECT v.*,m.name as merchant_name,count(vb.voucher_booking_id) as total_used 
                FROM voucher v
                JOIN merchant m on v.merchant_id=m.merchant_id
                left join voucher_booking vb on v.voucher_id=vb.voucher_id
                WHERE lower(" . $criteria . ") LIKE '%" . strtolower($value) . "%' and v.status_hapus='0'      
                group by v.voucher_id
            order by v.voucher_title";
}else{
    $sData  = " SELECT v.*,m.name as merchant_name,count(vb.voucher_booking_id) as total_used 
                FROM voucher v
                JOIN merchant m on v.merchant_id=m.merchant_id
                left join voucher_booking vb on v.voucher_id=vb.voucher_id
                WHERE v.status_hapus='0'     
                group by v.voucher_id
            order by v.voucher_title";
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
                        <th>&nbsp;</th>
                        <th>Created Date</th>
                        <th>Voucher Title</th>
                        <th>Merchant Name</th> 
                        <th>Start Date</th>
                        <th>End Date</th> 
                        <th>Total Used</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($rData = mysqli_fetch_array($qData)) { ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><img src="<?php echo "../".$rData['voucher_url']; ?>" width="50px" height="50px"></td>
                        <td><?php echo $rData['created_date']; ?></td>
                        <td><?php echo $rData['voucher_title']; ?></td>
                        <td><?php echo $rData['merchant_name']; ?></td> 
                        <td><?php echo $rData['start_date']; ?></td>
                        <td><?php echo $rData['end_date']; ?></td>  
                        <td><?php echo $rData['total_used']; ?></td>
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
                title: 'Voucher Report'
            }
        ],
        lengthMenu: [50, 100, 200, 500],
        order: [
            [1, 'desc']
        ]
    });
});
</script>
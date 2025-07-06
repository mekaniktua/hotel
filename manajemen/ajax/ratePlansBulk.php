<?php
session_start();
include("../database.php");

$room_type_id = dekripsi(amankan($_POST['rtID']));
$room_id = dekripsi(amankan($_POST['rID'])); 

// Use prepared statements to prevent SQL injection and optimize queries
$stmt = mysqli_prepare($conn, "SELECT rt.room_type, r.room_name,rt.property_id 
                               FROM room_type rt 
                               JOIN room r ON r.room_type_id = rt.room_type_id 
                               WHERE rt.status_hapus = '0' 
                               AND r.status_hapus = '0' 
                               AND rt.room_type_id = ? 
                               AND r.room_id = ?");
mysqli_stmt_bind_param($stmt, "ss", $room_type_id, $room_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$rType = mysqli_fetch_assoc($result);
$room_type = $rType['room_type'];
$room_name = $rType['room_name'];
$property_id = $rType['property_id'];
mysqli_stmt_close($stmt);

?>
 <div class="full white_shd">
    <div class="table_section padding_infor_info">

    <form id="frmSave" method="post">
        <div class="form-group">
            <label for="price">Room Type</label> 
            <input type="hidden" value="<?php echo enkripsi('Bulk')?>" class="form-control" id="input_type" name="input_type">
            <input type="hidden" value="<?php echo enkripsi($property_id)?>" class="form-control" id="pID" name="pID">
            <input type="hidden" value="<?php echo enkripsi($room_type_id)?>" class="form-control" id="rtID" name="rtID">
            <input type="text" value="<?php echo $room_type;?>" class="form-control" id="room_type" name="room_type" disabled>
        </div>
        <div class="form-group">
            <label for="price">Room Name</label>
            <input type="hidden" value="<?php echo enkripsi($room_id)?>" class="form-control" id="rID" name="rID">
            <input type="text" value="<?php echo $room_name;?>" class="form-control" id="room_name" name="room_name" disabled>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="eventDate">Start Date</label>
                <input type="date" class="form-control" id="eventDate" name="eventDate" required>
            </div>
            <div class="col-md-6">
                <label for="end_date">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>

            <div class="col-md-6">
                <label for="total_room">Total Room</label>
                <input type="number" class="form-control" id="total_room" name="total_room" required>
            </div>
        </div>

        <div class="form-group">
            <label for="total_room">Total Booked</label>
            <input type="number" class="form-control" id="booked" name="booked" disabled>
        </div>

        <div class="form-group">
            <label for="rate_type">Rate Type</label>
            <select name="rate_type" id="rate_type" class="form-control select2_single">
                <option value="Regular">Regular</option>
                <option value="Promo">Promo</option>
                <option value="Weekend">Weekend</option>
                <option value="HighSeason">High Season</option>
                <option value="Closed">Closed</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-success"><i class='fa fa-save'></i> Save</button>
    </form>
    <span style="color:red;">Note: Bulk Edit will only create rate plans for dates that don't already have existing rate plans</span>
    </div>
</div>

 
    
    <script>
    $("#frmSave").submit(function(e) {
        e.preventDefault();
        var frm = $('#frmSave')[0];
        var formData = new FormData(frm);

        $.ajax({
            type: "POST",
            url: "ajax/ratePlanSave.php",
            data: formData,
            processData: false,
            contentType: false,
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
    });
    </script>

 
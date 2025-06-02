<?php
$global_member_id = dekripsi(amankan($_SESSION['osg_member_id']));
$sData  = " SELECT *
            FROM member
            WHERE member_id='" . $global_member_id . "' and status_hapus='0'";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
$rData  = mysqli_fetch_array($qData);
$global_email = $rData['email'];

$day = date('d', strtotime($rData['birthdate']));
$month = date('m', strtotime($rData['birthdate']));
$year = date('Y', strtotime($rData['birthdate']));
?>

<div class="card" style="box-shadow: 0 0 45px rgba(0, 0, 0, .08);">
    <div class="card-header">
        <h4 class="mt-2"><i class="fa fa-user"></i> Profile</h4>
    </div>
    <div class="card-body">
        <form id="frmSimpan" name="frmSimpan" method="post">
            <div class="row">

                <div class="col-md-12 mb-3">
                    <label>Full Name</label>
                    <input type="text" name="fullname" value="<?php echo $rData['fullname'] ?>" class="form-control">
                </div>
                <div class="col-md-12 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo $rData['email'] ?>" class="form-control">
                </div>
                <div class="col-md-12 mb-3">
                    <label>Mobile Number</label>
                    <input type="text" name="mobile_number" value="<?php echo $rData['mobile_number'] ?>" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label>Gender</label>
                    <select name="gender" class="form-control select2_single">
                        <option value=""></option>
                        <option value="Male" <?php echo ($rData['gender'] == 'Male' ? "SELECTED" : ""); ?>>Male</option>
                        <option value="Female" <?php echo ($rData['gender'] == 'Female' ? "SELECTED" : ""); ?>>Female</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Birthdate</label>
                    <select name="date" class="form-control select2_single">
                        <option value="">&nbsp;</option>
                        <?php for ($x = 1; $x <= 31; $x++) {
                            if ($x < 10) $x = "0" . $x; ?>
                            <option value="<?php echo $x; ?>" <?php echo ($day == $x ? "SELECTED" : ""); ?>><?php echo $x; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    &nbsp;
                    <select name="month" class="form-control select2_single">
                        <option value="">&nbsp;</option>
                        <option value="01" <?php echo ($month == '01' ? "SELECTED" : ""); ?>>January</option>
                        <option value="02" <?php echo ($month == '02' ? "SELECTED" : ""); ?>>February</option>
                        <option value="03" <?php echo ($month == '03' ? "SELECTED" : ""); ?>>March</option>
                        <option value="04" <?php echo ($month == '04' ? "SELECTED" : ""); ?>>April</option>
                        <option value="05" <?php echo ($month == '05' ? "SELECTED" : ""); ?>>May</option>
                        <option value="06" <?php echo ($month == '06' ? "SELECTED" : ""); ?>>June</option>
                        <option value="07" <?php echo ($month == '07' ? "SELECTED" : ""); ?>>July</option>
                        <option value="08" <?php echo ($month == '08' ? "SELECTED" : ""); ?>>August</option>
                        <option value="09" <?php echo ($month == '09' ? "SELECTED" : ""); ?>>September</option>
                        <option value="10" <?php echo ($month == '10' ? "SELECTED" : ""); ?>>October</option>
                        <option value="11" <?php echo ($month == '11' ? "SELECTED" : ""); ?>>November</option>
                        <option value="12" <?php echo ($month == '12' ? "SELECTED" : ""); ?>>December</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    &nbsp;
                    <select name="year" class="form-control select2_single">
                        <option value="">&nbsp;</option>
                        <?php for ($y = 1928; $y <= (date("Y") - 10); $y++) { ?>
                            <option value="<?php echo $y; ?>" <?php echo ($year == $y ? "SELECTED" : ""); ?>><?php echo $y; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label>Nationality</label>
                    <input type="text" name="nationality" value="<?php echo $rData['nationality'] ?>" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <button class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div id="ajaxInfo"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>

            </div>
        </div>
    </div>
</div>

<script>
    $(".select2_single").select2();

    $("#frmSimpan").submit(function(e) {
        e.preventDefault(e);
        var frm = $('#frmSimpan')[0];
        var formData = new FormData(frm);
        $.ajax({
            type: "POST",
            url: "ajax/memberProfile.php",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                // setting a timeout
                $.blockUI({
                    message: '<img src="img/loading.gif" width="50" /> Please wait...'
                });
            },
            success: function(data) {
                $("#ajaxInfo").html(data);
                $("#modalInfo").modal("show");
            },
            complete: function() {
                $.unblockUI();
            },
        })
    });
</script>
<?php
$global_merchant_id = dekripsi(amankan($_SESSION['osg_merchant_id']));
$sData  = " SELECT *
            FROM merchant
            WHERE merchant_id='" . $global_merchant_id . "' and status_hapus='0'";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
$rData  = mysqli_fetch_array($qData);
$global_email = $rData['email'];

$sType  = " SELECT *
FROM merchant_type
WHERE status_hapus='0'";
$qType = mysqli_query($conn, $sType) or die(mysqli_error($conn));


$day = date('d', strtotime($rData['birthdate']));
$month = date('m', strtotime($rData['birthdate']));
$year = date('Y', strtotime($rData['birthdate']));
?>

<div class="card" style="box-shadow: 0 0 45px rgba(0, 0, 0, .08);">
    <div class="card-header">
        <h4 class="mt-2"><i class="fa fa-user"></i> Profile</h4>
    </div>
    <div class="card-body">
        <form id="frmSimpan" name="frmSimpan" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="mb-3">
                        <img src="<?php echo $rData['merchant_url'] ?>" class="img-fluid">
                    </div>
                    <input type="file" name="image" id="image" accept=".jpg,.jpeg" required>
                </div>
            </div>

            <div class="row">

                <div class="col-md-12 mb-3">
                    <label>Merchant Name</label>
                    <input type="text" name="name" value="<?php echo $rData['name'] ?>" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo $rData['email'] ?>" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Phone</label>
                    <input type="text" name="phone" value="<?php echo $rData['phone'] ?>" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label>Merchant Type</label>
                    <select name="merchant_type" class="form-control select2_single">
                        <?php while ($rType  = mysqli_fetch_array($qType)) { ?>
                            <option value="<?php echo $rType['merchant_type'] ?>" <?php echo ($rData['merchant_type'] == $rType['merchant_type'] ? "SELECTED" : ""); ?>><?php echo $rType['merchant_type'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label>Address</label>
                    <input type="text" name="address" value="<?php echo $rData['address'] ?>" class="form-control">
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

    let isValid = false;

    $('#image').on('change', function() {
        const file = this.files[0];

        if (!file) return;

        const fileName = file.name.toLowerCase();
        if (!fileName.endsWith('.jpg') && !fileName.endsWith('.jpeg')) {
            window.alert("Only JPG/JPEG images are allowed.");
            this.value = '';
            return;
        }

        if (!file.type.startsWith('image/')) {
            window.alert("File must be an image.");
            this.value = '';
            return;
        }

        if (file.size > 250 * 1024) {
            window.alert("Image must be less than 250 KB.");
            this.value = '';
            return;
        }

        const img = new Image();
        const objectUrl = URL.createObjectURL(file);
        img.onload = function() {
            if (img.width !== 200 || img.height !== 200) {
                window.alert("Image must be exactly 200x200 pixels.");
                $('#image').val('');
                URL.revokeObjectURL(objectUrl);
                return;
            }

            // Valid preview
            $('#preview').attr('src', objectUrl).show();
            isValid = true;
        };

        img.onerror = function() {
            window.alert("Invalid image file.");
            $('#image').val('');
            URL.revokeObjectURL(objectUrl);
        };

        img.src = objectUrl;
    });

    $("#frmSimpan").submit(function(e) {
        e.preventDefault(e);
        if (!isValid) {
            window.alert("Please select a valid 200x200px image under 250 KB.");
            return;
        }

        var frm = $('#frmSimpan')[0];
        var formData = new FormData(frm);
        $.ajax({
            type: "POST",
            url: "ajax/merchantProfile.php",
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
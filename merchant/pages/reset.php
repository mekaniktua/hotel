<?php
$email = dekripsi(amankan($_GET['e']));
$code = dekripsi(amankan($_GET['c']));

$sCari  = " SELECT *
            FROM merchant
            WHERE email='" . $email . "' and confirmation_code='" . $code . "' and status_hapus='0'";
$qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
$rCari  = mysqli_fetch_array($qCari);

if (empty($rCari['email'])) {
    $pesan = "Sorry, the reset password link was not found";
} elseif ($rCari['link_expired'] < date("Y-m-d H:i:s")) {
    $pesan = "Sorry, the reset password link has expired";
}
if (empty($pesan)) {
?>
    <div class="container-xxl mt-5">
        <div class="container">
            <div class="text-center wow fadeInUp" style="margin-bottom: 20px;" data-wow-delay="0.1s">
                <h6 class="section-title text-center text-primary text-uppercase">RESET PASSWORD</h6>
            </div>
            <div class="row g-5">
                <div class="col-lg-12">
                    <div class="wow fadeInUp" data-wow-delay="0.2s">
                        <form id="frmReset" name="frmReset" method="post">
                            <div class="row g-3">
                                <div class="col-md-12 mb-3">
                                    <input type="hidden" class="form-control" name="umail" value="<?php echo enkripsi($email) ?>">
                                    <div class="form-floating">

                                        <input type="password" class="form-control" id="password" name="password" placeholder="New Password">
                                        <span class="input-group" id="toggle-password" style="position: relative; ">
                                            <i class="fas fa-eye" id="eye-icon" style=" position: absolute;top: -35px;right: 10px; cursor: pointer;color: #888;"></i>
                                        </span>
                                        <label for="password">New Password</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="confirmUpass" name="confirmUpass" placeholder="Confirm New Password">
                                        <span class="input-group" id="toggle-password2" style="position: relative; ">
                                            <i class="fas fa-eye" id="eye-icon2" style=" position: absolute;top: -35px;right: 10px; cursor: pointer;color: #888;"></i>
                                        </span>
                                        <label for="confirmUpass">Confirm New Password</label>
                                    </div>
                                </div>

                                <div class="col-12 mb-3">
                                    <button class="btn btn-primary w-100 py-3">Send</button>
                                </div>
                                <hr />
                                <p>
                                    Already have account? <a href="./">Login here</a><br /> 
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }
if (!empty($pesan)) { ?>
    <div class="container-xxl mt-5 mb-5">
        <div class="container">
            <div class="text-center wow fadeInUp mb-3" data-wow-delay="0.1s">
                <h6 class="section-title text-center text-primary text-uppercase"><?php echo $pesan; ?></h6>
            </div>
            <div class="text-center">
                <button class="btn btn-danger" onclick="login()"><i class="fa fa-chevron-left"></i> Back</button>
                <p>&nbsp;</p>
            </div>
        </div>
    </div>
<?php } ?>


<!-- Modal -->
<div class="modal fade" id="modalInfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div id="ajaxInfo"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function login() {
        window.open("./", "_self");
    }

    $("#frmReset").submit(function(e) {
        e.preventDefault(e);
        var frm = $('#frmReset')[0];
        var formData = new FormData(frm);
        $.ajax({
            type: "POST",
            url: "ajax/reset.php",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $.blockUI({
                    message: '<h6><img src="../img/loading.gif" width="50" /> Please Wait</h6>'
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
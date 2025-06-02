<!-- Sign up Start -->
<div class="container-xxl mt-5">
    <div class="container">
        <div class="text-center wow fadeInUp" style="margin-bottom: 20px;" data-wow-delay="0.1s">
            <h6 class="section-title text-center text-primary text-uppercase">SIGNUP PAGE</h6>
        </div>
        <div class="row g-5">

            <div class="col-lg-12">
                <div class="wow fadeInUp" data-wow-delay="0.2s">
                    <form id="frmSimpan" name="frmSimpan" method="post">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="umail" id="email" placeholder="Your Email" required>
                                    <label for="email">Email</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="password" class="form-control" name="upass" style="padding-right: 40px;" id="password" placeholder="Your Password" required>
                                    <span class="input-group" id="toggle-password" style="position: relative; ">
                                        <i class="fas fa-eye" id="eye-icon" style=" position: absolute;top: -35px;right: 10px; cursor: pointer;color: #888;"></i>
                                    </span>
                                    <label for="password">Password</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="password" class="form-control" name="confirmUpass" style="padding-right: 40px;" id="confirmUpass" placeholder="Your Password" required>
                                    <span class="input-group" id="toggle-password2" style="position: relative; ">
                                        <i class="fas fa-eye" id="eye-icon2" style=" position: absolute;top: -35px;right: 10px; cursor: pointer;color: #888;"></i>
                                    </span>
                                    <label for="confirmUpass">Confirm Password</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Sign up</button>
                            </div>
                            <hr />
                            <p>Already have an account? <a href="./">Login Here</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Sign up End -->

<!-- Modal -->
<div class="modal fade" id="modalInfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-info"></i> Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
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
    $("#frmSimpan").submit(function(e) {
        e.preventDefault(e);
        var frm = $('#frmSimpan')[0];
        var formData = new FormData(frm);
        $.ajax({
            type: "POST",
            url: "ajax/signup.php",
            data: formData,
            processData: false,
            contentType: false,
            // beforeSend: function() {
            //     $.blockUI({
            //         message: '<h6><img src="../img/loading.gif" width="50" /> Please Wait</h6>'
            //     });
            // },
            success: function(data) {
                $("#modalInfo").modal('show');
                $("#ajaxInfo").html(data);

            },
            // complete: function() {
            //     $.unblockUI();
            // }
        });
    });
</script>
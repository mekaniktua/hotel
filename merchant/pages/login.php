 <!-- Login Start -->
 <div class="container-xxl mt-5">
     <div class="container">
         <div class="text-center wow fadeInUp" style="margin-bottom: 20px;" data-wow-delay="0.1s">
             <h6 class="section-title text-center text-primary text-uppercase">MERCHANT LOGIN PAGE</h6>
         </div>
         <div class="row g-5">

             <div class="col-lg-12">
                 <div class="wow fadeInUp" data-wow-delay="0.2s">
                     <form id="frmSimpan" name="frmSimpan" method="post">
                         <div class="row g-3">
                             <div class="col-md-12">
                                 <div class="form-floating">
                                     <input type="text" class="form-control" id="email" name="umail" placeholder="Your Email">
                                     <label for="email">Email</label>
                                 </div>
                             </div>
                             <div class="col-md-12">
                                 <div class="form-floating">
                                     <input type="password" class="form-control" style="padding-right: 40px;" name="upass" id="password" placeholder="Your Password">
                                     <span class="input-group" id="toggle-password" style="position: relative; ">
                                         <i class="fas fa-eye" id="eye-icon" style=" position: absolute;top: -35px;right: 10px; cursor: pointer;color: #888;"></i>
                                     </span>
                                     <label for="password">Password</label>
                                 </div>
                             </div>

                             <div class="col-12">
                                 <div class="text-right"><a href="?menu=forgot">Forgot Password?</a></div><br />
                                 <button class="btn btn-primary w-100 py-3">Login</button>
                             </div>
                             <hr />
                             <p>
                                Resend activation link? <a href="?menu=resend">Click here</a><br />
                                
                            </p>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- Login End -->


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
     $("#frmSimpan").submit(function(e) {
         e.preventDefault(e);
         var frm = $('#frmSimpan')[0];
         var formData = new FormData(frm);
         formData.append('redirect_uri', '<?php echo ($_GET['redirect_uri']) ?>');
         $.ajax({
             type: "POST",
             url: "ajax/login.php",
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
 <!-- Login Start -->
 <div class="container-xxl mt-5">
     <div class="container">
         <div class="text-center wow fadeInUp" style="margin-bottom: 20px;" data-wow-delay="0.1s">
             <h6 class="section-title text-center text-primary text-uppercase">FORGOT PASSWORD ACCOUNT</h6>
         </div>
         <div class="row g-5">

             <div class="col-lg-12">
                 <div class="wow fadeInUp" data-wow-delay="0.2s">
                     <form id="frmForgot" name="frmForgot" method="post">
                         <div class="row g-3">
                             <div class="col-md-12">
                                 <div class="form-floating">
                                     <input type="text" class="form-control" id="email" name="umail" placeholder="Your Email">
                                     <label for="email">Email</label>
                                 </div>
                             </div>

                             <div class="col-12 mb-3">
                                 <button class="btn btn-primary w-100 py-3">Send</button>
                             </div>
                             <hr/>
                             <p>
                                 Already have account? <a href="./">Login here</a><br />
                                 Don't have an account? <a href="?menu=signup">Sign up here</a>
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
     $("#frmForgot").submit(function(e) {
         e.preventDefault(e);
         var frm = $('#frmForgot')[0];
         var formData = new FormData(frm);
         $.ajax({
             type: "POST",
             url: "ajax/forgot.php",
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
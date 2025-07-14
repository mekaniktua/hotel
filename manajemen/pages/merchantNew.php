<?php 
$stmtMerchantType = mysqli_prepare($conn, "SELECT * FROM merchant_type WHERE status_hapus = '0'");
mysqli_stmt_execute($stmtMerchantType);
$qMerchantType = mysqli_stmt_get_result($stmtMerchantType);
?>

<div class="midde_cont">
   <div class="container-fluid">
      <div class="row column_title">
         <div class="col-md-12">
            <div class="page_title">
               <h2>NEW DATA MERCHANT</h2>
            </div>
         </div>
      </div>
      <!-- row -->
      <div class="row column1">
         <div class="col-md-12 col-lg-12">
            <div class="full white_shd margin_bottom_10">
               <div class="table_section padding_infor_info">
                  <form id="frmSave" name="frmSave" enctype="multipart/form-data">
                     <div class="row form-group">
                        <div class="col-md-4 form-group text-center">
                           <img src="images/no_image.png" width="50%" class="img-thumbnail form-group">

                           <input type="file" name="upload_file" id="upload_file">

                           <br />

                           <small style="color:red">Max. 500kb (jpg - 225x225)</small>
                        </div>
                        <div class="col-md-8 form-group">
                           <div class="row form-group">
                              <div class="col-md-12 form-group">
                                 <label>NAME</label>
                                 <input type="hidden" name="jenisInput" value="<?php echo enkripsi('New'); ?>">
                                 <input type="text" name="name" class="form-control">
                              </div>
                              <div class="col-md-6 form-group">
                                 <label>EMAIL</label>
                                 <input type="email" name="email" class="form-control" required>
                              </div>
                              <div class="col-md-6 form-group">
                                 <label>PHONE</label>
                                 <input type="text" name="phone" id="phone" class="form-control" required>
                              </div>
                              <div class="col-md-12 form-group">
                                 <label>MERCHANT TYPE</label>
                                 <select name="merchant_type" class="form-control">
                                    <option value="">Select Merchant Type</option>
                                    <?php while ($rMerchantType = mysqli_fetch_array($qMerchantType)) { ?>
                                       <option value="<?php echo $rMerchantType['merchant_type']; ?>"><?php echo $rMerchantType['merchant_type']; ?></option>
                                    <?php } ?>
                                 </select>
                              </div>

                              <div class="col-md-12 form-group">
                                 <label>ADDRESS</label>
                                 <input type="text" name="address" class="form-control" required>
                              </div>
                           </div>

                        </div>
                     </div>
                     <hr />
                     <div class="row form-group">
                        <div class="col-md-12 form-group text-center">
                           <button class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                           <button type="button" class="btn btn-danger" onclick="back()"><i class="fa fa-chevron-left"></i> Back</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-info"></i> Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

         </div>
         <div class="modal-body">
            <div id="ajaxInfo"></div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Tutup</button>
         </div>
      </div>
   </div>
</div>

<script>
   $(".select2_single").select2();
   $(document).ready(function() {
      const togglePassword = document.querySelector('#togglePassword');
      const password = document.querySelector('#upass');

      togglePassword.addEventListener('click', function(e) {
         // toggle the type attribute
         const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
         password.setAttribute('type', type);
         // toggle the eye slash icon
         this.classList.toggle('fa-eye-slash');
      });

      $('#datatable').DataTable({
         // dom: '<"container-fluid"<"row"<"col"B><"col"l><"col"f>>>rtip',
         // buttons: [
         //    'print', 'excel'
         // ],
         lengthMenu: [50, 100, 200, 500]
      });
   });

   function back() {
      window.open("?menu=merchant", "_self");
   }

   $("#frmSave").submit(function(e) {
      e.preventDefault(e);
      var frm = $('#frmSave')[0];
      var formData = new FormData(frm);
      $.ajax({
         type: "POST",
         url: "ajax/merchantSave.php",
         data: formData,
         processData: false,
         contentType: false,
         beforeSend: function() {
            $.blockUI({
               message: '<h3><img src="images/loading.gif" /> Please wait</h3>'
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
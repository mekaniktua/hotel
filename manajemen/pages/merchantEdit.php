<?php
$merchant_id = amankan(dekripsi($_GET['mID']));
$sData = "  SELECT * 
            FROM merchant 
            WHERE merchant_id='" . $merchant_id . "' and (status_hapus is null or status_hapus='0')";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
$rData = mysqli_fetch_array($qData);

?>

<div class="midde_cont">
   <div class="container-fluid">
      <div class="row column_title">
         <div class="col-md-12">
            <div class="page_title">
               <h2>UPDATE DATA MERCHANT</h2>
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
                           <img src="<?php echo (!empty($rData['merchant_url']) ? "../" . $rData['merchant_url'] : "images/no_image.png"); ?>" width="50%" class="img-thumbnail form-group">
                           <input type="file" name="upload_file" id="upload_file">

                           <br />

                           <small style="color:red">Max. 500kb (jpg - 225x225)</small>
                        </div>
                        <div class="col-md-8 form-group">
                           <div class="row form-group">
                              <div class="col-md-12 form-group">
                                 <label>NAME</label>
                                 <input type="hidden" name="mID" value="<?php echo enkripsi($merchant_id); ?>">
                                 <input type="hidden" name="jenisInput" value="<?php echo enkripsi('Edit'); ?>">
                                 <input type="text" name="name" class="form-control" value="<?php echo $rData['name'] ?>">
                              </div>
                              <div class="col-md-6 form-group">
                                 <label>EMAIL</label>
                                 <input type="email" name="email" value="<?php echo $rData['email'] ?>" class="form-control" required>
                              </div>
                              <div class="col-md-6 form-group">
                                 <label>PHONE</label>
                                 <input type="text" name="phone" id="phone" value="<?php echo $rData['phone'] ?>" class="form-control">
                              </div>
                              <div class="col-md-12 form-group">
                                 <label>ADDRESS</label>
                                 <input type="text" name="address" value="<?php echo $rData['address'] ?>" class="form-control" required>
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
               message: '<h3><img src="images/loading.gif" width="50" /> Please wait</h3>'
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
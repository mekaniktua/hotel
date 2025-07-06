<?php
$voucher_id = amankan(dekripsi($_GET['pID']));
$sData = "  SELECT * 
            FROM voucher 
            WHERE voucher_id='" . $voucher_id . "' and (status_hapus is null or status_hapus='0')";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
$rData = mysqli_fetch_array($qData);


$sMerchant = "  SELECT * 
            FROM merchant 
            WHERE (status_hapus is null or status_hapus='0')";
$qMerchant = mysqli_query($conn, $sMerchant) or die(mysqli_error($conn));
?>

<div class="midde_cont">
   <div class="container-fluid">
      <div class="row column_title">
         <div class="col-md-12">
            <div class="page_title">
               <h2>UPDATE DATA PROMOTION</h2>
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
                        <div class="col-md-12 form-group text-center">
                           <img src="<?php echo (!empty($rData['voucher_url']) ? "../" . $rData['voucher_url'] : "images/no_image.png"); ?>" width="25%" class="img-thumbnail form-group">
                           <br />
                           <input type="file" name="upload_file" id="upload_file">
                           <br />
                           <small style="color:red">Max. 500kb (jpg/png)</small>
                        </div>
                        <div class="col-md-12 form-group">
                           <div class="row form-group">
                              <div class="col-md-12 form-group">
                                 <label>MERCHANT</label>
                                 <select name="mID" class="form-control select2_single">
                                    <?php while ($rMerchant = mysqli_fetch_array($qMerchant)) { ?>
                                       <option value="<?php echo enkripsi($rMerchant['merchant_id']); ?>" <?php if ($rData['merchant_id'] == $rMerchant['merchant_id']) {echo "SELECTED";} ?>>
                                       <?php echo $rMerchant['name'] ?></option>
                                    <?php } ?>
                                 </select>
                              </div>
                              <div class="col-md-12 form-group">
                                 <label>TITLE</label>
                                 <input type="hidden" name="pID" value="<?php echo enkripsi($voucher_id); ?>">
                                 <input type="hidden" name="jenisInput" value="<?php echo enkripsi('Edit'); ?>">
                                 <input type="text" name="voucher_title" class="form-control" value="<?php echo $rData['voucher_title'] ?>">
                              </div>
                              <div class="col-md-4 form-group">
                                 <label>START DATE</label>
                                 <input type="text" id="start_date" name="start_date" value="<?php echo $rData['start_date'] ?>" class="form-control datepicker" required>
                              </div>
                              <div class="col-md-4 form-group">
                                 <label>END DATE</label>
                                 <input type="text" name="end_date" id="end_date" value="<?php echo $rData['end_date'] ?>" class="form-control datepicker">
                              </div>
                              <div class="col-md-4 form-group">
                                 <label>STATUS</label>
                                 <select name="status" class="form-control select2_single">
                                    <option value="Publish" <?php if ($rData['status'] == 'Publish') echo 'SELECTED'; ?>>Publish</option>
                                    <option value="Draft" <?php if ($rData['status'] == 'Draft') echo 'SELECTED'; ?>>Draft</option>
                                 </select>
                              </div>
                              <div class="col-md-12 form-group">
                                 <label>DESCRIPTION</label>
                                 <textarea id="description" name="description" class="form_control"><?php echo $rData['description'] ?></textarea>
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
      tinymce.init({
         selector: '#description',
      });

      $('#datatable').DataTable({
         // dom: '<"container-fluid"<"row"<"col"B><"col"l><"col"f>>>rtip',
         // buttons: [
         //    'print', 'excel'
         // ],
         lengthMenu: [50, 100, 200, 500]
      });

      flatpickr("#start_date", {
         mode: "single",
         minDate: "today",
         dateFormat: "Y-m-d"
      });
      flatpickr("#end_date", {
         mode: "single",
         minDate: "today",
         dateFormat: "Y-m-d"
      });
   });

   function back() {
      window.open("?menu=voucher", "_self");
   }

   $("#frmSave").submit(function(e) {
      e.preventDefault(e);
      var frm = $('#frmSave')[0];
      var formData = new FormData(frm);
      $.ajax({
         type: "POST",
         url: "ajax/voucherSave.php",
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
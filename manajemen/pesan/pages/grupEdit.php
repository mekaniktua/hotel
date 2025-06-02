<?php
$grup_id = amankan(dekripsi($_GET['gID']));
$sData = "  SELECT * FROM grup 
            WHERE grup_id='" . $grup_id . "' and (status_hapus is null or status_hapus='0')";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
$rData = mysqli_fetch_array($qData);

?>
<div class="row">
   <div class="col-lg-12">
      <h1 class="page-header">Update Data Grup</h1>
   </div>
   <!-- /.col-lg-12 -->
</div>
<div class="row">
   <div class="col-md-12">
      <form id="frmSave" name="frmSave">
         <div class="row form-group">
            <div class="col-md-12 form-group">
               <label>NAMA</label>
               <input type="hidden" name="gID" value="<?php echo enkripsi($grup_id); ?>">
               <input type="hidden" name="jenisInput" value="<?php echo enkripsi('Edit'); ?>">
               <input type="text" name="nama" class="form-control" value="<?php echo $rData['nama'] ?>" required>
            </div>
         </div>
         <div class="row form-group">
            <div class="col-md-12 form-group">
               <button class="btn btn-success"><i class="fa fa-save"></i> Save</button>
               <button type="button" class="btn btn-danger" onclick="back()"><i class="fa fa-chevron-left"></i> Back</button>
            </div>
         </div>
      </form>
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
      window.open("?t=grup", "_self");
   }

   $("#frmSave").submit(function(e) {
      e.preventDefault(e);
      var frm = $('#frmSave')[0];
      var formData = new FormData(frm);
      $.ajax({
         type: "POST",
         url: "ajax/grupSave.php",
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
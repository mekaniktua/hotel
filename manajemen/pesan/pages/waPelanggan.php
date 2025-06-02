<?php

$sPelanggan = "  SELECT * FROM pelanggan 
                  WHERE  (status_hapus is null or status_hapus='0')";
$qPelanggan = mysqli_query($conn, $sPelanggan) or die(mysqli_error($conn));

?>
<div class="row">
   <div class="col-lg-12">
      <h1 class="page-header">Kirim Pesan ke Pelanggan</h1>
   </div>
   <!-- /.col-lg-12 -->
</div>
<div class="row">
   <div class="col-md-12">
      <form id="frmSave" name="frmSave">
         <div class="row form-group">
            <div class="col-md-12 form-group">
               <label>PESAN</label>
               <textarea rows="5" name="pesanWa" class="form-control" required></textarea>
               <small>Gunakan <b>NAMA_PELANGGAN</b> untuk memasukkan nama pelanggan</small>
            </div>
         </div>
         <div class="row form-group">
            <div class="col-md-12 form-group">
               <label>PELANGGAN</label>
               <select id="pelanggan" name="pelanggan[]" multiple="multiple" class="form-control">
                  <?php while ($rPelanggan = mysqli_fetch_array($qPelanggan)) { ?>
                     <option value="<?php echo enkripsi($rPelanggan['pelanggan_id']) ?>"><?php echo $rPelanggan['nama'] . " - " . $rPelanggan['no_hp'] ?></option>
                  <?php } ?>
               </select>
               <small>Bisa pilih lebih dari 1 pelanggan</small>
            </div>
         </div>
         <div class="row form-group">
            <div class="col-md-12 form-group">
               <button class="btn btn-success"><i class="fa fa-send"></i> Kirim</button>
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
            <h4 class="modal-title" style="float: left;" id="myModalLabel"><i class="fa fa-info"></i> Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <br />
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
   $(document).ready(function() {
      // Initialize Select2
      $('#pelanggan').select2({
         placeholder: "Select options",
         allowClear: true
      });
   })

   $("#frmSave").submit(function(e) {
      e.preventDefault(e);

      let formData = new FormData(this);

      $.ajax({
         type: "POST",
         url: "ajax/kirimWaPelangganAwal.php",
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
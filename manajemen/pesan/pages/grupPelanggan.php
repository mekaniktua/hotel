<?php
$grup_id = amankan(dekripsi($_GET['gID']));

$sData = "  SELECT * FROM grup 
            WHERE grup_id='" . $grup_id . "' and (status_hapus is null or status_hapus='0')";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
$rData = mysqli_fetch_array($qData);

$sPelanggan = "  SELECT * FROM pelanggan 
            WHERE (status_hapus is null or status_hapus='0')";
$qPelanggan = mysqli_query($conn, $sPelanggan) or die(mysqli_error($conn));

?>
<div class="row">
   <div class="col-lg-12">
      <h1 class="page-header">Grup New</h1>
   </div>
   <!-- /.col-lg-12 -->
</div>
<div class="row">
   <div class="col-md-12">
      <form id="frmSave" name="frmSave">
         <div class="row form-group">
            <div class="col-md-12 form-group">
               <label>NAMA</label>
               <input type="hidden" name="jenisInput" value="<?php echo enkripsi('New'); ?>">
               <input type="hidden" name="gID" class="form-control" value="<?php echo enkripsi($rData['grup_id']) ?>">
               <input type="text" name="nama" class="form-control" value="<?php echo $rData['nama'] ?>" disabled>
            </div>
         </div>
         <div class="row form-group">
            <div class="col-md-12 form-group">
               <label>PELANGGAN</label>
               <select name="pID" class="form-control select2_single">
                  <?php while ($rPelanggan = mysqli_fetch_array($qPelanggan)) { ?>
                     <option value="<?php echo enkripsi($rPelanggan['pelanggan_id']) ?>"><?php echo $rPelanggan['nama'] . " - " . $rPelanggan['no_hp']; ?></option>
                  <?php } ?>
               </select>
            </div>
         </div>
         <div class="row form-group">
            <div class="col-md-12 form-group">
               <button class="btn btn-success"><i class="fa fa-save"></i> Save</button>
               <button type="button" class="btn btn-danger" onclick="back()"><i class="fa fa-chevron-left"></i> Back</button>
               <button type="button" class="btn btn-info" onclick="grupPelangganList()"><i class="fa fa-refresh"></i> Refresh</button>
            </div>
         </div>
      </form>

      <div id="ajaxGrupPelanggan"></div>
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
   $(document).ready(function() {

      $('#datatable').DataTable({
         // dom: '<"container-fluid"<"row"<"col"B><"col"l><"col"f>>>rtip',
         // buttons: [
         //    'print', 'excel'
         // ],
         lengthMenu: [50, 100, 200, 500]
      });

      $(".select2_single").select2();

      grupPelangganList();

      $(".datepicker").datepicker({
         changeMonth: true,
         changeYear: true,
         dateFormat: 'd/m/yy',
         yearRange: '1950:<?php echo (date('Y') - 17); ?>',

      });
   });

   function back() {
      window.open("?t=grup", "_self");
   }

   function grupPelangganList() {
      $.ajax({
         type: "POST",
         url: "ajax/grupPelangganList.php",
         data: {
            'gID': '<?php echo enkripsi($grup_id); ?>'
         },
         beforeSend: function() {
            $.blockUI({
               message: '<h5><img src="images/loading.gif" width="50px" /> Please wait</h5>'
            });
         },
         success: function(data) {
            $("#ajaxGrupPelanggan").html(data);

         },
         complete: function() {
            $.unblockUI();
         }
      });
   }

   $("#frmSave").submit(function(e) {
      e.preventDefault(e);
      var frm = $('#frmSave')[0];
      var formData = new FormData(frm);
      $.ajax({
         type: "POST",
         url: "ajax/grupPelangganSave.php",
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
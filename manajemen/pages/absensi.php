<?php

$sPegawai = "  SELECT * FROM pegawai 
              WHERE status_hapus='0'
              ORDER BY nama asc";
$qPegawai = mysqli_query($conn, $sPegawai) or die(mysqli_error($conn));
?>

<div class="midde_cont">
   <div class="container-fluid">
      <div class="row column_title">
         <div class="col-md-12">
            <div class="page_title">
               <h2>Absensi Pegawai</h2>
            </div>
         </div>
      </div>
      <!-- row -->
      <div class="row column1">
         <div class="col-md-12 col-lg-12">
            <div class="full white_shd margin_bottom_30">
               <div class="table_section padding_infor_info">
                  <form id="frmSave" name="frmSave" method="post">
                     <div class="row form-group">
                        <div class="col-md-6 form-group">
                           <label>TANGGAL</label><br />
                           <input name="tanggal" value="<?php echo date('d/m/Y') ?>" class="form-control form-group" disabled>
                        </div>
                        <div class="col-md-6 form-group">
                           <label>PILIH PEGAWAI</label><br />
                           <select name="pID" class="form-control select2_single">
                              <?php while ($rPegawai = mysqli_fetch_array($qPegawai)) { ?>
                                 <option value="<?php echo enkripsi($rPegawai['pegawai_id']); ?>"><?php echo $rPegawai['nama'] ?></option>
                                 <?php } ?>
                           </select>
                           &nbsp;
                           <br />
                        </div>
                        <div class="col-md-12 form-group">
                           <button class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>

            <div id="ajaxAbsensi"></div>


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
   $("#frmSave").submit(function(e) {
      e.preventDefault(e);
      var frm = $('#frmSave')[0];
      var formData = new FormData(frm);
      $.ajax({
         type: "POST",
         url: "ajax/absensiSave.php",
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

   absensiList();

   function absensiList() {
      $.ajax({
         type: "POST",
         url: "ajax/absensiList.php", 
         processData: false,
         contentType: false,
         beforeSend: function() {
            $.blockUI({
               message: '<h5><img src="images/loading.gif" width="50px" /> Please wait</h5>'
            });
         },
         success: function(data) {
            //  $("#modalInfo").modal('show');
            $("#ajaxAbsensi").html(data);
         },
         complete: function() {
            $.unblockUI();
         }
      });
   }
</script>
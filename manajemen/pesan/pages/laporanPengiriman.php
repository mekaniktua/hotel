<div class="row">
   <div class="col-lg-12">
      <h1 class="page-header">Laporan Pengiriman Whatsapp</h1>
   </div>
   <!-- /.col-lg-12 -->
</div>

<div class="row form-group">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-body">
            <form id="frmCari" name="frmCari" method="post">
               <label>PERIODE</label><br />
               <div class="form-inline">
                  <input name="tanggalAwal" class="form-control datepicker form-group" required> &nbsp; - &nbsp;<input name="tanggalAkhir" class="form-control datepicker" required>
                  &nbsp;<button class="btn btn-success"><i class="fa fa-search"></i> Cari</button>
               </div>
            </form>
            <br />
         </div>
      </div>
   </div>
</div>

<div id="ajaxLaporan"></div>
 

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
       $("#frmCari").submit(function(e) {
          e.preventDefault(e);
          var frm = $('#frmCari')[0];
          var formData = new FormData(frm);
          $.ajax({
             type: "POST",
             url: "ajax/laporanPengiriman.php",
             data: formData,
             processData: false,
             contentType: false,
             beforeSend: function() {
                $.blockUI({
                   message: '<h5><img src="images/loading.gif" width="50px" /> Please wait</h5>'
                });
             },
             success: function(data) {
                //  $("#modalInfo").modal('show');
                $("#ajaxLaporan").html(data);
             },
             complete: function() {
                $.unblockUI();
             }
          });
       });

       $(".datepicker").datepicker({
          changeMonth: true,
          changeYear: true,
          dateFormat: 'dd/m/yy',
          yearRange: '1950:<?php echo (date('Y') - 17); ?>',

       });
    </script>
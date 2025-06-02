<?php 

$sCabang = "  SELECT c.* FROM cabang c 
              WHERE c.status_hapus='0'";
$qCabang = mysqli_query($conn, $sCabang) or die(mysqli_error($conn));
?>

<div class="midde_cont">
   <div class="container-fluid">
      <div class="row column_title">
         <div class="col-md-12">
            <div class="page_title">
               <h2>Data Transaksi Laba Bersih</h2>
            </div>
         </div>
      </div>
      <!-- row -->
      <div class="row column1">
         <div class="col-md-12 col-lg-12">
            <div class="full white_shd margin_bottom_30">
               <div class="table_section padding_infor_info">
                  <form id="frmCari" name="frmCari" method="post">
                     <label>CABANG</label><br />
                     <select name="cID" class="form-control slect2_single">
                        <?php while ($rCabang = mysqli_fetch_array($qCabang)) { ?>
                           <option value="<?php echo enkripsi($rCabang['cabang_id']); ?>" <?php if ($rCabang['cabang_id'] == $rCabang['cabang_id']) echo "SELECTED"; ?>><?php echo $rCabang['nama_cabang'] ?></option>
                        <?php } ?>
                     </select><br />
                     <label>PERIODE</label><br />
                     <div class="form-inline">
                        <input name="tanggalAwal" class="form-control datepicker form-group" required> &nbsp; - &nbsp;<input name="tanggalAkhir" class="form-control datepicker" required>
                        &nbsp;<button class="btn btn-success"><i class="fa fa-search"></i> Cari</button>
                     </div>
                  </form>
               </div>
            </div>

            <div id="ajaxTransaksi"></div>


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
   $("#frmCari").submit(function(e) {
      e.preventDefault(e);
      var frm = $('#frmCari')[0];
      var formData = new FormData(frm);
      $.ajax({
         type: "POST",
         url: "ajax/laporanBersih.php",
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
            $("#ajaxTransaksi").html(data);
         },
         complete: function() {
            $.unblockUI();
         }
      });
   });
</script>
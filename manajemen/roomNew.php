 <div class="midde_cont">
    <div class="container-fluid">
       <div class="row column_title">
          <div class="col-md-12">
             <div class="page_title">
                <h2>Update Data Barang</h2>
             </div>
          </div>
       </div>
       <!-- row -->
       <div class="row column1">
          <div class="col-md-12 col-lg-12">
             <div class="full white_shd margin_bottom_10">
                <div class="table_section padding_infor_info">
                   <form id="frmSave" name="frmSave">
                      <div class="row form-group">
                         <div class="col-md-12 form-group">
                            <label>NAMA BARANG</label>
                            <input type="hidden" name="jenisInput" value="<?php echo enkripsi('New'); ?>">
                            <input type="text" name="name_barang" class="form-control" required>
                         </div>
                      </div>
                      <div class="row form-group">
                         <div class="col-md-6 form-group">
                            <label>STOK</label>
                            <input type="number" name="stok" id="stok" class="form-control" required>
                         </div>
                         <div class="col-md-6 form-group">
                            <label>HARGA JUAL</label>
                            <input type="text" name="harga_jual" id="harga_jual" class="form-control" required>
                            <small>tanpa koma dan titik</small>
                         </div>
                      </div>
                      <div class="row form-group">
                         <div class="col-md-6 form-group">
                            <label>HARGA BELI</label>
                            <input type="text" name="harga_beli" id="harga_beli" class="form-control" required>
                            <small>tanpa koma dan titik</small>
                         </div> 
                         <div class="col-md-6 form-group">
                            <label>MARGIN PENJUAL</label>
                            <input type="text" name="margin_penjual" value="<?php echo $rData['margin_penjual'] ?>" id="margin_penjual" class="form-control" required>
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
       window.open("?menu=barang", "_self");
    }

    $("#frmSave").submit(function(e) {
       e.preventDefault(e);
       var frm = $('#frmSave')[0];
       var formData = new FormData(frm);
       $.ajax({
          type: "POST",
          url: "ajax/barangSave.php",
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
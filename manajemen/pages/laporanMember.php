 <div class="midde_cont">
     <div class="container-fluid">
         <div class="row column_title">
             <div class="col-md-12">
                 <div class="page_title">
                     <h2>Member Report</h2>
                 </div>
             </div>
         </div>
         <!-- row -->
         <div class="row column1">
             <div class="col-md-12 col-lg-12">
                 <div class="full white_shd margin_bottom_30">
                     <div class="table_section padding_infor_info">
                         <form id="frmCari" name="frmCari" method="post">
                             <div class="row gx-2 align-items-end">
                                 <div class="col-md-2">
                                     <label for="criteria" class="form-label">Criteria</label>
                                     <select name="criteria" id="criteria" class="form-control select2_single">
                                         <option value="fullname">Fullname</option>
                                         <option value="mobile_number">Mobile Number</option>
                                         <option value="email">Email</option>
                                     </select>
                                 </div>

                                 <div class="col-md-6" style="margin-bottom: -5px;">
                                     <label for="value" class="form-label">Search Value</label>
                                     <input type="text" name="value" id="value" class="form-control"
                                         placeholder="Please input" required>
                                 </div>

                                 <div class="col-md-auto" style="margin-bottom: -5px;">
                                     <label class="form-label d-block">&nbsp;</label>
                                     <button type="submit" class="btn btn-success">
                                         <i class="fa fa-search"></i> Search
                                     </button>
                                     <button type="button" class="btn btn-warning" onclick="laporan()">
                                         <i class="fa fa-user"></i> Select All
                                     </button>
                                 </div>

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
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                         aria-hidden="true">&times;</span></button>

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
    $(".select2_single").select2();
 
});

function laporan(formData) {
    $.ajax({
        type: "POST",
        url: "ajax/laporanMember.php",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
            $.blockUI({
                message: '<h5><img src="images/loading.gif" width="50px" /> Please wait</h5>'
            });
        },
        success: function(data) {
            $("#ajaxTransaksi").html(data);
        },
        complete: function() {
            $.unblockUI();
        },
        error: function(xhr, status, error) {
            console.error('Ajax error:', error);
            $.unblockUI();
        }
    });
}

$("#frmCari").submit(function(e) {
    e.preventDefault();
    const frm = $('#frmCari')[0];
    const formData = new FormData(frm);
    laporan(formData);
});
 </script>
<div class="midde_cont">
   <div class="container-fluid">
      <div class="row column_title">
         <div class="col-md-12">
            <div class="page_title">
               <h2>FACILITY</h2>
            </div>
         </div>
      </div>
      <!-- row -->
      <div class="row column1">
         <div class="col-md-12 col-lg-12">
            <div class="full white_shd margin_bottom_30">
               <div class="table_section padding_infor_info">

                  <div class="card card-default">
                     <div class="card-body">
                        <h4>NEW FACILITY</h4>
                        <form id="frmSave" method="post">
                           <table class="table">
                              <tr>
                                 <td colspan="2"><label>Category</label><br />
                                    <input type="hidden" class="form-control" name="jenis" value="<?php echo enkripsi('New'); ?>">
                                    <select class="select2_single form-control" name="category">
                                       <option value="General">General</option>
                                       <option value="Public Facilities">Public Facilities</option>
                                       <option value="In-room Facilities">In-room Facilities</option>
                                       <option value="Connectivity">Connectivity</option>
                                       <option value="Amenities & Toiletries">Amenities & Toiletries</option>
                                    </select>
                                 </td>
                              </tr>
                              <tr>
                                 <td><label>Facility</label><br />
                                    <input type="text" class="form-control" name="facility">
                                 </td>
                              </tr>
                              <tr>
                                 <td colspan="2">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button> 
                                 </td>
                              </tr>
                           </table>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div id="facilityList"></div>
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
      $(".select2_single").select2();
      $('#datatable').DataTable({
         // dom: '<"container-fluid"<"row"<"col"B><"col"l><"col"f>>>rtip',
         // buttons: [
         //    'print', 'excel'
         // ],
         lengthMenu: [50, 100, 200, 500]
      });

      facilityList();
   });
 

   $("#frmSave").submit(function(e) {
      e.preventDefault(e);
      var frm = $('#frmSave')[0];
      var formData = new FormData(frm);
      $.ajax({
         type: "POST",
         url: "ajax/facilitySave.php",
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


   function facilityList() {
      $.ajax({
         type: 'POST',
         url: 'ajax/facilityList.php',
         data: {
            'prID': ''
         },
         beforeSend: function() {
            // setting a timeout
            $.blockUI({
               message: '<img src="images/loading.gif" width="50" /> Please wait...'
            });
         },
         success: function(data) {
            $("#facilityList").html(data);
         },
         complete: function() {
            $.unblockUI();
         },
      })
   }
</script>
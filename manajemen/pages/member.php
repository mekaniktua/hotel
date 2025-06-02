<div class="midde_cont">
   <div class="container-fluid">
      <div class="row column_title">
         <div class="col-md-12">
            <div class="page_title">
               <h2><i class='fa fa-users'></i> DATA MEMBER</h2>
            </div>
         </div>
      </div>
      <!-- row -->
      <div class="row column1">
         <div class="col-md-12 col-lg-12">
            <div class="full white_shd margin_bottom_30">
               <div class="table_section padding_infor_info">
                  <h4><i class="fa fa-search"></i> Search</h4>
                  <form method="post" id="frmSave" class="row g-2 align-items-center">
                     <div class="col-md-2 mb-2">
                        <select class="form-control select2_single" name="kriteria">
                           <option value="fullname">Name</option>
                           <option value="email">Email</option>
                           <option value="mobile_number">Mobile</option>
                           <option value="city">City</option>
                        </select>
                     </div>
                     <div class="col-md-6 mb-2">
                        <input type="text" class="form-control" name="keyword" placeholder="Masukkan keyword" required>
                     </div>
                     <div class="col-md-4 mb-2 d-flex gap-1">
                        <button type="submit" class="btn btn-primary" value="search">Cari</button> &nbsp;
                        <button type="button" class="btn btn-danger" onclick="memberList()">Show All</button>
                     </div>
                  </form>
               </div>
            </div>


            <div id="memberList"></div>


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
      $(".select2_single").select2();

   });

   $("#frmSave").submit(function(e) {
      e.preventDefault();
      var frm = $('#frmSave')[0];
      var formData = new FormData(frm);

      $.ajax({
         type: "POST",
         url: "ajax/memberList.php",
         data: formData,
         processData: false,
         contentType: false,
         beforeSend: function() {
            $.blockUI({
               message: '<h5><img src="images/loading.gif" width="50px" /> Please wait</h5>'
            });
         },
         success: function(data) {
            $("#memberList").html(data);
         },
         complete: function() {
            $.unblockUI();
         }
      });
   });

   function memberList() {
      $.ajax({
         type: "POST",
         url: "ajax/memberList.php",
         beforeSend: function() {
            $.blockUI({
               message: '<h5><img src="images/loading.gif" width="50px" /> Please wait</h5>'
            });
         },
         success: function(data) {
            $("#memberList").html(data);
         },
         complete: function() {
            $.unblockUI();
         }
      });
   }
</script>
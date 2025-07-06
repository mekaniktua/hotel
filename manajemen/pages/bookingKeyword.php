<div class="midde_cont">
   <div class="container-fluid">
      <div class="row column_title">
         <div class="col-md-12">
            <div class="page_title">
               <h2><i class='fa fa-users'></i> BOOKING BY KEYWORD</h2>
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
                           <option value="b.booking_id">Booking ID</option>
                           <option value="m.email">Email</option>
                           <option value="m.fullname">Fullname</option>
                        </select>
                     </div>
                     <div class="col-md-6 mb-2">
                        <input type="text" class="form-control" name="bookingValue" placeholder="Masukkan keyword" required>
                     </div>
                     <div class="col-md-4 mb-2 d-flex gap-1">
                        <button type="submit" class="btn btn-primary" id="btnCari" value="search"><i class="fa fa-search"></i> Search</button>
                     </div>
                  </form>
               </div>
            </div>


            <div id="bookingList"></div>


         </div>
      </div>
   </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          
         <div class="modal-body">
            <div id="ajaxInfo"></div>
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
         url: "ajax/bookingList.php",
         data: formData,
         processData: false,
         contentType: false,
         beforeSend: function() {
            $.blockUI({
               message: '<h5><img src="images/loading.gif" width="50px" /> Please wait</h5>'
            });
         },
         success: function(data) {
            $("#bookingList").html(data);
         },
         complete: function() {
            $.unblockUI();
         }
      });
   });

   function bookingList() {
      $.ajax({
         type: "POST",
         url: "ajax/bookingList.php",
         beforeSend: function() {
            $.blockUI({
               message: '<h5><img src="images/loading.gif" width="50px" /> Please wait</h5>'
            });
         },
         success: function(data) {
            $("#bookingList").html(data);
         },
         complete: function() {
            $.unblockUI();
         }
      });
   }
</script>
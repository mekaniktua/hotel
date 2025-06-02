<?php
$user_id = amankan(dekripsi($_GET['uID']));
$sData = "  SELECT * 
            FROM users 
            WHERE user_id='" . $user_id . "' and (status_hapus is null or status_hapus='0')";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
$rData = mysqli_fetch_array($qData);

?>

<div class="midde_cont">
   <div class="container-fluid">
      <div class="row column_title">
         <div class="col-md-12">
            <div class="page_title">
               <h2>UPDATE DATA USER</h2>
            </div>
         </div>
      </div>
      <!-- row -->
      <div class="row column1">
         <div class="col-md-12 col-lg-12">
            <div class="full white_shd margin_bottom_10">
               <div class="table_section padding_infor_info">
                  <form id="frmSave" name="frmSave" enctype="multipart/form-data">
                     <div class="row form-group">
                        <div class="col-md-4 form-group text-center">
                           <img src="<?php echo (!empty($rData['user_url']) ? "../".$rData['user_url'] : "images/no_image.png"); ?>" width="50%" class="img-thumbnail form-group">
                           <input type="file" name="upload_file" id="upload_file">

                           <br />

                           <small style="color:red">Max. 500kb (jpg/png)</small>
                        </div>
                        <div class="col-md-8 form-group">
                           <div class="row form-group">
                              <div class="col-md-12 form-group">
                                 <label>NAME</label>
                                 <input type="hidden" name="uID" value="<?php echo enkripsi($user_id); ?>">
                                 <input type="hidden" name="jenisInput" value="<?php echo enkripsi('Edit'); ?>">
                                 <input type="text" name="name" class="form-control" value="<?php echo $rData['name'] ?>">
                              </div>
                              <div class="col-md-6 form-group">
                                 <label>USERNAME</label>
                                 <input type="text" name="uname" value="<?php echo $rData['username'] ?>" class="form-control" required>
                              </div>
                              <div class="col-md-6 form-group">
                                 <label>PASSWORD</label>
                                 <input type="password" name="upass" id="upass" class="form-control" placeholder="kosongi jika tidak ingin merubah" style="display: inline-block;">
                                 <i class="fa fa-eye" id="togglePassword" style="margin-left: -30px;cursor: pointer;"></i>
                              </div>
                              <div class="col-md-6 form-group">
                                 <label>EMAIL</label>
                                 <input type="email" name="email" value="<?php echo $rData['email'] ?>" class="form-control" required>
                              </div>
                              <div class="col-md-6 form-group">
                                 <label>USER TYPE</label>
                                 <select name="user_type" class="form-control select2_single" style="width: 100%;" required>
                                    <option value="Admin" <?php if ($rData['user_type'] == 'Admin') echo "SELECTED"; ?>>Admin</option>
                                    <option value="User" <?php if ($rData['user_type'] == 'User') echo "SELECTED"; ?>>User</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                     <hr />
                     <div class="row form-group">
                        <div class="col-md-12 form-group text-center">
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
   $(".select2_single").select2();
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
      window.open("?menu=user", "_self");
   }

   $("#frmSave").submit(function(e) {
      e.preventDefault(e);
      var frm = $('#frmSave')[0];
      var formData = new FormData(frm);
      $.ajax({
         type: "POST",
         url: "ajax/userSave.php",
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
</script>
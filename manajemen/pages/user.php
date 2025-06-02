<?php
$sData = "  SELECT u.*
            FROM users u 
            WHERE (u.status_hapus is null or u.status_hapus='0')";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));

?>

<div class="midde_cont">
   <div class="container-fluid">
      <div class="row column_title">
         <div class="col-md-12">
            <div class="page_title">
               <h2>Data User</h2>
            </div>
         </div>
      </div>
      <!-- row -->
      <div class="row column1">
         <div class="col-md-12 col-lg-12">
            <div class="full white_shd margin_bottom_30">
               <div class="table_section padding_infor_info">
                  <div class="pull-right" style="padding-bottom: 10px;">
                     <!-- <button type="button" onclick="baru()" class="btn btn-primary"><i class="fa fa-user-plus"></i> Tambah New</button> -->
                  </div>


                  <table class="table table-striped" id="datatable">
                     <thead>
                        <tr>
                           <th>NO</th>
                           <th>PHOTO</th>
                           <th>USERNAME</th>
                           <th>NAME</th>
                           <th>EMAIL</th>
                           <th>USER TYPE</th>
                           <th width="10%">&nbsp;</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php while ($rData = mysqli_fetch_array($qData)) {
                           $i++;; ?>
                           <tr>
                              <td width="3%"><?php echo $i; ?>.</td>
                              <td style="width: 100px;"><img src="<?php echo (!empty($rData['user_url']) ? "../".$rData['user_url'] : "images/no_image.png"); ?>" height="50px"></td>
                              <td><?php echo $rData['username']; ?></td>
                              <td><?php echo $rData['name']; ?></td>
                              <td><?php echo $rData['email']; ?></td>
                              <td><?php echo $rData['user_type']; ?></td>
                              <td>
                                 <a href="#" class="btn btn-info" onclick="edit('<?php echo enkripsi($rData['user_id']); ?>')"><i class="fa fa-pencil"></i></a>
                                 <a href="#" class="btn btn-danger" onclick="hapus('<?php echo enkripsi($rData['user_id']); ?>')"><i class="fa fa-trash"></i></a>
                              </td>
                           </tr>
                        <?php }; ?>
                     </tbody>
                  </table>
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

   function baru(x) {
      window.open("?menu=userNew", "_self");
   }

   function edit(x) {
      window.open("?menu=userEdit&uID=" + x, "_self");
   }

   function hapus(x) {
      if (confirm("Are you sure you want to delete this data?")) {
         $.ajax({
            type: 'POST',
            url: 'ajax/userDelete.php',
            data: {
               'uID': x
            },
            beforeSend: function() {
               // setting a timeout
               $.blockUI({
                  message: '<img src="images/loading.gif" width="50" /> Please wait...'
               });
            },
            success: function(data) {
               $("#modalInfo").modal('show');
               $("#ajaxInfo").html(data);
            },
            complete: function() {
               $.unblockUI();
            },
         })
      }
   }
</script>
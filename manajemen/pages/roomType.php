<?php
$property_id = dekripsi(amankan($_GET['prID'] ?? ''));

$stmt = $conn->prepare("SELECT property_name, address FROM property WHERE property_id = ?");
$stmt->bind_param("s", $property_id);
$stmt->execute();

// Bind hasil ke variabel (sesuaikan kolom di tabel property)
$stmt->bind_result($property_name, $address); 

// Anda bisa simpan hasil ke array, misalnya:
if ($stmt->fetch()) {   
   $rData = [
       'property_name' => $property_name,
       'address'       => $address,
   ];
} else {
   $pesan = "No data found.";
}

$stmt->close();


if(!empty($pesan)){
   echo "<script>alert('No data found.');</script>";
}else{
?>

<div class="midde_cont">
   <div class="container-fluid">
      <div class="row column_title">
         <div class="col-md-12">
            <div class="page_title">
               <h2>ROOM TYPE</h2>
            </div>
         </div>
      </div>
      <!-- row -->
      <div class="row column1">
         <div class="col-md-12 col-lg-12">
            <div class="full white_shd margin_bottom_30">
               <div class="table_section padding_infor_info">

                  <div style="margin-bottom: -20px;">
                     <table class="table table-striped">
                        <tr>
                           <th>PROPERTY NAME</th>
                           <td><?php echo $rData['property_name'] ?? ''; ?></td>
                        </tr>
                        <tr>
                           <th>ADDRESS</th>
                              <td><?php echo $rData['address'] ?? ''; ?></td>
                        </tr>
                     </table>
                  </div>
                  <hr />

                  <div class="card card-default">
                     <div class="card-body">
                        <form id="frmSave" method="post">
                           <table class="table">
                              <tr>
                                 <td colspan="2"><label>Tipe Room New</label><br />
                                    <input type="hidden" class="form-control" name="prID" value="<?php echo enkripsi($property_id); ?>">
                                    <input type="hidden" class="form-control" name="jenis" value="<?php echo enkripsi('New'); ?>">
                                    <input type="text" class="form-control" name="room_type">
                                 </td>
                              </tr>
                              <tr>
                              <td><label>Price</label><br />
                                 <input type="text" class="form-control" name="price">
                                 <small style="color: orange;">* diisi angka tanpa titik dan koma</small>
                              </td>
                              <td><label>Space (m2)</label><br />
                                 <input type="text" class="form-control" name="space">
                                 <small style="color: orange;">* diisi angka tanpa titik dan koma</small>
                              </td>
                              </tr>
                              <tr>
                                 <td colspan="2">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                                    <button type="button" onclick="back()" class="btn btn-danger"><i class="fa fa-chevron-left"></i> Back</button>
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

      <div id="roomTypeList"></div>
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

<?php }?>


<script>
   $(document).ready(function() {
      $('#datatable').DataTable({
         // dom: '<"container-fluid"<"row"<"col"B><"col"l><"col"f>>>rtip',
         // buttons: [
         //    'print', 'excel'
         // ],
         lengthMenu: [50, 100, 200, 500]
      });

      roomTypeList();
   });

   function back() {
      window.open("?menu=property", "_self");
   }

   $("#frmSave").submit(function(e) {
      e.preventDefault(e);
      var frm = $('#frmSave')[0];
      var formData = new FormData(frm);
      $.ajax({
         type: "POST",
         url: "ajax/roomTypeSave.php",
         data: formData,
         processData: false,
         contentType: false,
         beforeSend: function() {
            $.blockUI({
               message: '<h3><img src="images/loading.gif" /> Please wait</h3>'
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


   function roomTypeList() {
      $.ajax({
         type: 'POST',
         url: 'ajax/roomTypeList.php',
         data: {
            'prID': '<?php echo enkripsi($property_id); ?>'
         },
         beforeSend: function() {
            // setting a timeout
            $.blockUI({
               message: '<img src="images/loading.gif" width="50" /> Please wait...'
            });
         },
         success: function(data) {
            $("#roomTypeList").html(data);
         },
         complete: function() {
            $.unblockUI();
         },
      })
   } 
</script>
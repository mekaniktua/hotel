<?php
$property_id = dekripsi(amankan($_GET['prID']));
$room_type_id = dekripsi(amankan($_GET['tkID']));
 
$stmt = $conn->prepare("SELECT p.property_name,p.address,tk.room_type 
                        FROM property p
                        JOIN room_type tk ON p.property_id=tk.property_id 
                        WHERE p.property_id=? and tk.room_type_id = ?");
$stmt->bind_param("ss", $property_id, $room_type_id);
$stmt->execute();

// Bind hasil ke variabel
$stmt->bind_result($property_name, $address, $room_type);


// Ambil hasil
if ($stmt->fetch()) {
   // Simpan ke array (jika dibutuhkan untuk diproses lebih lanjut)
   $row = [
       'property_name' => $property_name,
       'address'       => $address,
       'room_type'     => $room_type
   ];
 
} else {
   echo "No data found.";
}
$stmt->close();

$sFasilitas  = " SELECT *
            FROM facility 
            WHERE status_hapus='0'
            ORDER BY category,facility_name";
$qFasilitas = mysqli_query($conn, $sFasilitas) or die(mysqli_error($conn));

?>

<div class="midde_cont">
   <div class="container-fluid">
      <div class="row column_title">
         <div class="col-md-12">
            <div class="page_title">
               <h2>ROOM FACILITY</h2>
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
                           <td><?php echo $row['property_name']; ?></td>
                        </tr>
                        <tr>
                           <th>ADDRESS</th>
                           <td><?php echo $row['address']; ?></td>
                        </tr>
                        <tr>
                           <th>ROOM TYPE</th>
                           <td><?php echo $row['room_type']; ?></td>
                        </tr>
                     </table>
                  </div>
                  <hr />
                  <div class="card card-default">
                     <div class="card-body">
                        <h4>NEW ROOM FACILITY</h4>
                        <form id="frmSave" method="post">
                           <table class="table">
                              <tr>
                                 <td colspan="2"><label>FACILITY</label><br />
                                    <input type="hidden" name="tkID" value="<?php echo enkripsi($room_type_id); ?>">
                                    <select class="select2_single form-control" name="fID">
                                       <?php while ($rFasilitas = mysqli_fetch_array($qFasilitas)) { ?>
                                          <option value="<?php echo enkripsi($rFasilitas['facility_id']) ?>"><?php echo $rFasilitas['facility_name'] . " (" . $rFasilitas['category'] . ")" ?></option>
                                       <?php } ?>
                                    </select>
                                 </td>
                              </tr>
                              <tr>
                                 <td colspan="2">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                                    <button type="button" class="btn btn-danger" onclick="back()"><i class="fa fa-chevron-left"></i> Back</button>
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

      <div id="roomFacilityList"></div>
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

      roomFacilityList();
   });

   function back() {
      window.open("?menu=roomType&prID=<?php echo enkripsi($property_id); ?>", "_self");
   }

   $("#frmSave").submit(function(e) {
      e.preventDefault(e);
      var frm = $('#frmSave')[0];
      var formData = new FormData(frm);
      $.ajax({
         type: "POST",
         url: "ajax/roomFacilitySave.php",
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


   function roomFacilityList() {
      $.ajax({
         type: 'POST',
         url: 'ajax/roomFacilityList.php',
         data: {
            'prID': '<?php echo enkripsi($property_id); ?>',
            'tkID': '<?php echo enkripsi($room_type_id); ?>',
         },
         beforeSend: function() {
            // setting a timeout
            $.blockUI({
               message: '<img src="images/loading.gif" width="50" /> Please wait...'
            });
         },
         success: function(data) {
            $("#roomFacilityList").html(data);
         },
         complete: function() {
            $.unblockUI();
         },
      })
   }
</script>
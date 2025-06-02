<?php
$property_id = dekripsi(amankan($_GET['prID']));
$room_type_id = dekripsi(amankan($_GET['tkID']));

$stmt = $conn->prepare(" SELECT p.property_name,p.address,tk.room_type FROM property p
                        JOIN room_type tk ON tk.property_id=p.property_id WHERE tk.property_id = ? and tk.room_type_id = ?
                        and tk.status_hapus='0'");

// Bind parameters (2 strings = 'ss')
$stmt->bind_param("ss", $property_id, $room_type_id);

// Execute the statement
$stmt->execute();

// Bind hasil ke variabel
$stmt->bind_result($property_name, $address, $room_type);


if (!$stmt->fetch()) {
   echo "No data found.";
}

?>

<div class="midde_cont">
   <div class="container-fluid">
      <div class="row column_title">
         <div class="col-md-12">
            <div class="page_title">
               <h2>DATA ROOM</h2>
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
                           <td><?php echo $property_name; ?></td>
                        </tr>
                        <tr>
                           <th>ADDRESS</th>
                           <td><?php echo $address; ?></td>
                        </tr>
                        <tr>
                           <th>ROOM TYPE</th>
                           <td><?php echo $room_type; ?></td>
                        </tr>
                     </table>
                  </div>
                  <hr />

                  <div class="card card-default">
                     <div class="card-body">
                        <form id="frmSave" method="post">
                           <table class="table">
                              <tr>
                                 <td colspan="4"><label>NAMA ROOM BARU</label><br />
                                    <input type="hidden" class="form-control" name="prID" value="<?php echo enkripsi($property_id); ?>">
                                    <input type="hidden" class="form-control" name="tkID" value="<?php echo enkripsi($room_type_id); ?>">
                                    <input type="hidden" class="form-control" name="jenis" value="<?php echo enkripsi('New'); ?>">
                                    <input type="text" class="form-control" name="room_name">
                                 </td>
                              </tr>
                              <tr>
                                 <td style="width: 25%;"><label>STATUS</label><br />
                                    <select name="status" class="select2_single form-control" style="width: 100%;">
                                       <option value="Publish">Publish</option>
                                       <option value="Draft">Draft</option>
                                    </select>
                                 </td>
                                 <td style="width: 25%;"><label>BREAKFAST?</label><br />
                                    <select name="is_breakfast" class="select2_single form-control" style="width: 100%;">
                                       <option value="0">Not Include</option>
                                       <option value="1">Included</option>
                                    </select>
                                 </td>
                                 <td style="width: 25%;"><label>SMOKING?</label><br />
                                    <select name="is_smoking" class="select2_single form-control" style="width: 100%;">
                                       <option value="0">Not Smoking Room</option>
                                       <option value="1">Smoking Room</option>
                                    </select>
                                 </td>
                                 <td style="width: 25%;"><label>WIFI?</label><br />
                                    <select name="is_wifi" class="select2_single form-control" style="width: 100%;">
                                       <option value="0">No Wifi</option>
                                       <option value="1">Free Wifi</option>
                                    </select>
                                 </td>
                              </tr>
                              <tr>
                                 <td><label>FITNESS?</label><br />
                                    <select name="is_fitness" class="select2_single form-control" style="width: 100%;">
                                       <option value="0">Not Included</option>
                                       <option value="1">Free Access Fitness</option>
                                    </select>
                                 </td>
                                 <td><label>PARKING?</label><br />
                                    <select name="is_parking" class="select2_single form-control" style="width: 100%;">
                                       <option value="0">Pay Parking</option>
                                       <option value="1">Free Parking</option>
                                    </select>
                                 </td>
                                 <td><label>ADULT</label><br />
                                    <select name="adult" class="select2_single form-control" style="width: 100%;">
                                       <option value="1">1 adult</option>
                                       <option value="2">2 adult</option>
                                       <option value="3">3 adult</option>
                                       <option value="4">4 adult</option>
                                       <option value="5">5 adult</option>
                                    </select>
                                 </td>
                                 <td><label>CHILD</label><br />
                                    <select name="child" class="select2_single form-control" style="width: 100%;">
                                       <option value="0">No Child</option>
                                       <option value="1">1 Child</option>
                                       <option value="2">2 Child(s)</option>
                                       <option value="3">3 Child(s)</option>
                                    </select>
                                 </td>
                              </tr>
                              <tr>

                                 <td colspan="2"><label>KETERANGAN</label><br />
                                    <input type="text" class="form-control" name="Please wait">
                                 </td>
                                 <td><label>BED TYPE</label><br />
                                    <select name="bed" class="select2_single form-control" style="width: 100%;">
                                       <option value="King">King</option>
                                       <option value="Queen">Queen</option>
                                       <option value="Twin">Twin</option>
                                    </select>
                                 </td>
                                 <td><label>JUMLAH</label><br />
                                    <input type="text" class="form-control" name="jumlah">
                                 </td>
                              <tr>
                                 <td colspan="4">
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

      <div id="roomList"></div>
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

      roomList();
   });

   function back() {
      window.open("?menu=roomType&prID=<?php echo enkripsi($property_id) ?>", "_self");
   }

   $("#frmSave").submit(function(e) {
      e.preventDefault(e);
      var frm = $('#frmSave')[0];
      var formData = new FormData(frm);
      $.ajax({
         type: "POST",
         url: "ajax/roomSave.php",
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


   function roomList() {
      $.ajax({
         type: 'POST',
         url: 'ajax/roomList.php',
         data: {
            'prID': '<?php echo enkripsi($property_id); ?>',
            'tkID': '<?php echo enkripsi($room_type_id); ?>'
         },
         beforeSend: function() {
            // setting a timeout
            $.blockUI({
               message: '<img src="images/loading.gif" width="50" /> Please wait...'
            });
         },
         success: function(data) {
            $("#roomList").html(data);
         },
         complete: function() {
            $.unblockUI();
         },
      })
   }
</script>
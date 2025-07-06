<?php
$property_id = dekripsi(amankan($_GET['prID']));
$room_type_id = dekripsi(amankan($_GET['tkID']));
$room_id = dekripsi(amankan($_GET['kID']));

$stmt = $conn->prepare("SELECT p.property_name, p.address, tk.room_type, k.room_name, k.status, k.description, k.total, k.bed, k.adult, k.child, k.is_breakfast, k.is_smoking, k.is_wifi, k.is_fitness, k.is_parking 
                        FROM property p
                        JOIN room_type tk ON tk.property_id = p.property_id 
                        JOIN room k ON tk.room_type_id = k.room_type_id 
                        WHERE tk.property_id = ? AND tk.room_type_id = ? AND k.room_id = ?
                        AND tk.status_hapus = '0'");

$stmt->bind_param("sss", $property_id, $room_type_id, $room_id);
$stmt->execute();

// Bind hasil ke variabel
$stmt->bind_result($property_name, $address, $room_type, $room_name, $status, $description, $total, $bed, $adult, $child, $is_breakfast, $is_smoking, $is_wifi, $is_fitness, $is_parking);
$stmt->fetch();

// Simpan hasil dalam array (seperti fetch_assoc)
$row = [
    'property_name' => $property_name,
    'address'       => $address,
    'room_type'     => $room_type,
    'room_name'     => $room_name,
    'status'        => $status,
    'description'   => $description,
    'total'         => $total,
    'bed'           => $bed,
    'adult'         => $adult,
    'child'         => $child,
    'is_breakfast'  => $is_breakfast,
    'is_smoking'    => $is_smoking,
    'is_wifi'       => $is_wifi,
    'is_fitness'    => $is_fitness,
    'is_parking'    => $is_parking
];

$stmt->close();


?>

<div class="midde_cont">
   <div class="container-fluid">
      <div class="row column_title">
         <div class="col-md-12">
            <div class="page_title">
               <h2>UPDATE DATA ROOM</h2>
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
                        <form id="frmSave" method="post">
                           <table class="table">
                              <tr>
                                 <td colspan="4"><label>ROOM NAME</label><br />
                                 <input type="hidden" class="form-control" name="prID" value="<?php echo enkripsi($property_id); ?>">
                                    <input type="hidden" class="form-control" name="tkID" value="<?php echo enkripsi($room_type_id); ?>">
                                    <input type="hidden" class="form-control" name="kID" value="<?php echo enkripsi($room_id); ?>">
                                    <input type="hidden" class="form-control" name="jenis" value="<?php echo enkripsi('Edit'); ?>">
                                    <input type="text" class="form-control" name="room_name" value="<?php echo $row['room_name']; ?>">
                                 </td>
                              </tr>
                              <tr>
                                 <td style="width: 25%;"><label>STATUS</label><br />
                                    <select name="status" class="select2_single form-control" style="width: 100%;">
                                       <option value="Publish" <?php echo ($row['status'] == 'Publish' ? 'selected' : ''); ?>>Publish</option>
                                       <option value="Draft" <?php echo ($row['status'] == 'Draft' ? 'selected' : ''); ?>>Draft</option>
                                    </select>
                                 </td>
                                 <td style="width: 25%;"><label>BREAKFAST?</label><br />
                                    <select name="is_breakfast" class="select2_single form-control" style="width: 100%;">
                                       <option value="0" <?php echo ($row['is_breakfast'] == '0' ? 'selected' : ''); ?>>Not Include</option>
                                       <option value="1" <?php echo ($row['is_breakfast'] == '1' ? 'selected' : ''); ?>>Included</option>
                                    </select>
                                 </td>
                                 <td style="width: 25%;"><label>SMOKING?</label><br />
                                    <select name="is_smoking" class="select2_single form-control" style="width: 100%;">
                                       <option value="0" <?php echo ($row['is_smoking'] == '0' ? 'selected' : ''); ?>>Not Smoking Room</option>
                                       <option value="1" <?php echo ($row['is_smoking'] == '1' ? 'selected' : ''); ?>>Smoking Room</option>
                                    </select>
                                 </td>
                                 <td style="width: 25%;"><label>WIFI?</label><br />
                                    <select name="is_wifi" class="select2_single form-control" style="width: 100%;">
                                       <option value="0" <?php echo ($row['is_wifi'] == '0' ? 'selected' : ''); ?>>No Wifi</option>
                                       <option value="1" <?php echo ($row['is_wifi'] == '1' ? 'selected' : ''); ?>>Free Wifi</option>
                                    </select>
                                 </td>
                              </tr>
                              <tr>
                                 <td><label>FITNESS?</label><br />
                                    <select name="is_fitness" class="select2_single form-control" style="width: 100%;">
                                       <option value="0" <?php echo ($row['is_fitness'] == '0' ? 'selected' : ''); ?>>Not Included</option>
                                       <option value="1" <?php echo ($row['is_fitness'] == '1' ? 'selected' : ''); ?>>Free Access Fitness</option>
                                    </select>
                                 </td>
                                 <td><label>PARKING?</label><br />
                                    <select name="is_parking" class="select2_single form-control" style="width: 100%;">
                                       <option value="0" <?php echo ($row['is_parking'] == '0' ? 'selected' : ''); ?>>Pay Parking</option>
                                       <option value="1" <?php echo ($row['is_parking'] == '1' ? 'selected' : ''); ?>>Free Parking</option>
                                    </select>
                                 </td>
                                 <td><label>ADULT</label><br />
                                    <select name="adult" class="select2_single form-control" style="width: 100%;">
                                       <option value="1" <?php echo ($row['adult'] == '1' ? 'selected' : ''); ?>>1 adult</option>
                                       <option value="2" <?php echo ($row['adult'] == '2' ? 'selected' : ''); ?>>2 adult</option>
                                       <option value="3" <?php echo ($row['adult'] == '3' ? 'selected' : ''); ?>>3 adult</option>
                                       <option value="4" <?php echo ($row['adult'] == '4' ? 'selected' : ''); ?>>4 adult</option>
                                       <option value="5">5 adult</option>
                                    </select>
                                 </td>
                                 <td><label>CHILD</label><br />
                                    <select name="child" class="select2_single form-control" style="width: 100%;">
                                       <option value="0" <?php echo ($row['child'] == '0' ? 'selected' : ''); ?>>No Child</option>
                                       <option value="1" <?php echo ($row['child'] == '1' ? 'selected' : ''); ?>>1 Child</option>
                                       <option value="2" <?php echo ($row['child'] == '2' ? 'selected' : ''); ?>>2 Child(s)</option>
                                       <option value="3" <?php echo ($row['child'] == '3' ? 'selected' : ''); ?>>3 Child(s)</option>
                                    </select>
                                 </td>
                              </tr>
                              <tr>

                                 <td colspan="2"><label>DESCRIPTION</label><br />
                                    <input type="text" class="form-control" name="description" value="<?php echo $row['description']; ?>">
                                 </td>
                                 <td><label>BED TYPE</label><br />
                                    <select name="bed" class="select2_single form-control" style="width: 100%;">
                                       <option value="King" <?php echo ($row['bed'] == 'King' ? 'selected' : ''); ?>>King</option>
                                       <option value="Queen" <?php echo ($row['bed'] == 'Queen' ? 'selected' : ''); ?>>Queen</option>
                                       <option value="Twin" <?php echo ($row['bed'] == 'Twin' ? 'selected' : ''); ?>>Twin</option>
                                    </select>
                                 </td>
                                 <td><label>Total</label><br />
                                    <input type="text" class="form-control" name="total" value="<?php echo $row['total']; ?>" required>
                                 </td>
                              </tr>
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
      window.open("?menu=room&prID=<?php echo enkripsi($property_id); ?>&tkID=<?php echo enkripsi($room_type_id); ?>", "_self");
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
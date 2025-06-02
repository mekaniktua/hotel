<?php
$property_id = dekripsi(amankan($_GET['prID']));
$room_type_id = dekripsi(amankan($_GET['tkID']));

$stmt = $conn->prepare("SELECT p.property_id, p.address, p.property_name, 
                               tk.room_type_id, tk.property_id, tk.room_name, tk.capacity, tk.price
                        FROM property p
                        JOIN room_type tk ON tk.property_id = p.property_id
                        WHERE tk.room_type_id = ?");

$stmt->bind_param("s", $room_type_id);
$stmt->execute();

// Bind hasil query ke variabel
$stmt->bind_result($property_id, $address, $property_name, $room_type_id_out, $property_id_out, $room_name, $capacity, $price);

// Ambil hasil
$stmt->fetch();

// Simpan ke array (jika ingin struktur sama seperti fetch_assoc)
$row = [
    'property_id'     => $property_id,
    'address'         => $address,
    'property_name'   => $property_name,
    'room_type_id'    => $room_type_id_out,
    'room_property_id'=> $property_id_out,
    'room_name'       => $room_name,
    'capacity'        => $capacity,
    'price'           => $price
];

// Jangan lupa close statement
$stmt->close();


?>

<div class="midde_cont">
   <div class="container-fluid">
      <div class="row column_title">
         <div class="col-md-12">
            <div class="page_title">
               <h2>UPDATE ROOM TYPE</h2>
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
                     </table>
                  </div>
                  <hr />

                  <div class="card card-default">
                     <div class="card-body">
                        <form id="frmSave" method="post">
                           <table class="table">
                              <tr>
                                 <td colspan="2"><label>Tipe Room</label><br />
                                    <input type="hidden" class="form-control" name="prID" value="<?php echo enkripsi($property_id); ?>">
                                    <input type="hidden" class="form-control" name="tkID" value="<?php echo enkripsi($room_type_id); ?>">
                                    <input type="hidden" class="form-control" name="jenis" value="<?php echo enkripsi('Edit'); ?>">
                                    <input type="text" class="form-control" name="room_type" value="<?php echo $row['room_type'] ?>">
                                 </td>
                              </tr>
                              <td><label>Price</label><br />
                                 <input type="text" class="form-control" name="price" value="<?php echo $row['price'] ?>">
                                 <small style="color: orange;">* diisi angka tanpa titik dan koma</small>
                              </td>
                              <td><label>Space (m2)</label><br />
                                 <input type="text" class="form-control" name="space" value="<?php echo $row['space'] ?>">
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
      window.open("?menu=roomType&prID=<?php echo enkripsi($property_id); ?>", "_self");
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
               message: '<h3><img src="images/loading.gif" width="50" /> Please wait</h3>'
            });
         },
         success: function(data) {
            $("#modalInfo").modal('show');
            $("#modalInfo").on("hidden.bs.modal", function() {
               back();
            });
            $("#ajaxInfo").html(data);

         },
         complete: function() {
            $.unblockUI();
         }
      });
   });
</script>
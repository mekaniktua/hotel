<?php
$property_id = dekripsi(amankan($_GET['prID']));
$room_type_id = dekripsi(amankan($_GET['tkID']));


$stmt = $conn->prepare("SELECT p.property_name,p.address,tk.room_type FROM property p
                        JOIN room_type tk ON tk.property_id=p.property_id WHERE tk.property_id = ? and tk.room_type_id = ?
                        and tk.status_hapus='0'");
$stmt->bind_param("ss", $property_id, $room_type_id);
$stmt->execute();

// Bind hasil ke variabel
$stmt->bind_result($property_name, $address, $room_type);

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
 
?>

<style>
   #drop-area {
      border: 2px dashed #ccc;
      border-radius: 20px;
      width: 100%;
      height: 200px;
      text-align: center;
      padding: 30px;
      font-family: Arial;
      margin: 20px auto;
   }

   #drop-area.hover {
      border-color: #333;
   }

   #preview img {
      max-width: 100%;
      max-height: 100px;
      margin-top: 10px;
   }
</style>

<div class="midde_cont">
   <div class="container-fluid">
      <div class="row column_title">
         <div class="col-md-12">
            <div class="page_title">
               <h2>ROOM TYPE GALLERY</h2>
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
                        <div id="drop-area">
                           <p>Drag & Drop Image Here or <button id="browseBtn" class="btn btn-success">Browse (750x500)</button></p>
                           <input type="file" id="fileElem" accept="image/*" style="display:none">
                           <div id="preview"></div>
                        </div>
                        <hr />
                        <div class="text-center">
                           <button onclick="back()" class="btn btn-danger"><i class="fa fa-chevron-left"></i> Back</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div id="galleryList"></div>
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
   $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox();
   });
   
   function back(){
      window.open("?menu=roomType&prID=<?php echo enkripsi($property_id)?>","_self" );
   }
   
   $(document).ready(function() {
      galleryList();
      const dropArea = $('#drop-area');
      const fileInput = $('#fileElem');

      // Click to browse
      $('#browseBtn').click(e => {
         e.preventDefault();
         fileInput.click();
      });

      // Drag events
      dropArea.on('dragenter dragover', e => {
         e.preventDefault();
         dropArea.addClass('hover');
      });

      dropArea.on('dragleave drop', e => {
         e.preventDefault();
         dropArea.removeClass('hover');
      });

      // Handle drop
      dropArea.on('drop', e => {
         let files = e.originalEvent.dataTransfer.files;
         handleFiles(files);
      });

      // Handle file selection
      fileInput.on('change', function() {
         handleFiles(this.files);
      });

      function handleFiles(files) {
         if (files.length > 0) {
            const file = files[0];
            const fileName = file.name.toLowerCase();
            const maxSize = 500000; // 500 KB in bytes

            if (!file.type.startsWith('image/jpeg') || !fileName.endsWith('.jpg')) {
               alert('File harus jpg');
               return;
            }

            if (file.size > maxSize) {
               alert('Ukuran maksimal 500kb');
               return;
            }

            // Preview
            const reader = new FileReader();
            reader.onload = function(e) {
               $('#preview').html(`<img src="${e.target.result}" alt="Preview">`);
            };
            reader.readAsDataURL(file);

            // Upload
            const formData = new FormData();
            formData.append('image', file);
            formData.append('tkID', '<?php echo enkripsi($room_type_id); ?>');

            $.ajax({
               url: 'ajax/gallerySave.php',
               type: 'POST',
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
         }
      }
   });

   function back() {
      window.open("?menu=roomType&prID=<?php echo enkripsi($property_id) ?>", "_self");
   }


   function galleryList() {
      $.ajax({
         type: 'POST',
         url: 'ajax/galleryList.php',
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
            $("#galleryList").html(data);
         },
         complete: function() {
            $.unblockUI();
         },
      })
   }
</script>
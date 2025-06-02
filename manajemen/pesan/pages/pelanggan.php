<?php
$sData = "  SELECT * FROM pelanggan 
            WHERE (status_hapus is null or status_hapus='0')";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));

?>

<div class="row">
   <div class="col-lg-12">
      <h1 class="page-header">Pelanggan</h1>
   </div>
   <!-- /.col-lg-12 -->
</div>
<div class="row">
   <div class="col-md-12">
      <div class="table-responsive">
         <table class="table table-striped" id="datatable">
            <thead>
               <tr>
                  <th>NO</th>
                  <th>NAMA</th>
                  <th>NO HP</th>
                  <th>EMAIL</th>
                  <th>TANGGAL LAHIR</th>
                  <th>ADDRESS</th>
                  <th width="10%">&nbsp;</th>
               </tr>
            </thead>
            <tbody>
               <?php while ($rData = mysqli_fetch_array($qData)) {
                  $i++;; ?>
                  <tr>
                     <td width="3%"><?php echo $i; ?>.</td>
                     <td><?php echo $rData['nama']; ?></td>
                     <td><?php echo $rData['no_hp']; ?></td>
                     <td><?php echo $rData['email']; ?></td>
                     <td><?php echo normalTanggal($rData['tanggal_lahir']); ?></td>
                     <td><?php echo $rData['address']; ?></td>
                     <td>
                        <a href="#" class="btn btn-info" onclick="edit('<?php echo enkripsi($rData['pelanggan_id']); ?>')"><i class="fa fa-pencil"></i></a>
                        <a href="#" class="btn btn-danger" onclick="hapus('<?php echo enkripsi($rData['pelanggan_id']); ?>')"><i class="fa fa-trash"></i></a>
                     </td>
                  </tr>
               <?php }; ?>
            </tbody>
         </table>
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
      window.open("?t=pelangganNew", "_self");
   }

   function edit(x) {
      window.open("?t=pelangganEdit&pID=" + x, "_self");
   }

   function hapus(x) {
      if (confirm("Are you sure you want to delete this data?")) {
         $.ajax({
            type: 'POST',
            url: 'ajax/pelangganDelete.php',
            data: {
               'pID': x
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
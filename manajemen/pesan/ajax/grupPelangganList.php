<?php
session_start();
include("../database.php");

$grup_id = dekripsi(amankan($_POST['gID']));
//Data di tabel user apakah sudah ada?
$sData  = " SELECT p.*,gd.grup_detail_id
            FROM grup_detail gd
            JOIN pelanggan p ON p.pelanggan_id=gd.pelanggan_id 
            WHERE gd.status_hapus='0' and grup_id='".$grup_id."'
            order by p.nama";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));

?>
 <hr />
<div class="row">
  <div class="col-lg-12">
    <table class="table table-striped" id="datatable">
      <thead>
        <tr> 
          <th>NAMA PELANGGAN</th>
          <th>NO HP</th>
          <th width="10%">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($rData  = mysqli_fetch_array($qData)) { ?>
          <tr class="text-nowrap">
            <td><?php echo $rData['nama']; ?></td>
            <td><?php echo ($rData['no_hp']); ?></td>
            <td>
              <button class="btn btn-danger" onclick="hapus('<?php echo enkripsi($rData['grup_detail_id']) ?>')"><i class="fa fa-trash"></i></button>
            </td>
          </tr>
        <?php }; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#datatable').DataTable({
      dom: '<"container-fluid"<"row"<"col"B><"col"l><"col"f>>>rtip',
      buttons: [
        // 'print', 'excel'
      ],
      lengthMenu: [50, 100, 200, 500],
      order: [
        [1, 'desc']
      ]
    });
  });

  function hapus(x) {
    if (confirm("Do you want to delete this data?")) {
      $.ajax({
        type: "POST",
        url: "ajax/grupPelangganDelete.php",
        data: {
          'gdID': x
        },
        beforeSend: function() {
          $.blockUI({
            message: '<h5><img src="images/loading.gif" width="50px" /> Please wait</h5>'
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
</script>
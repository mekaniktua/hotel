<?php
session_start();
include("../database.php");

//Data di tabel user apakah sudah ada?
$sData  = " SELECT *
            FROM pengeluaran 
            WHERE status_hapus='0'
            order by tanggal";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));

?>
<div class="full white_shd margin_bottom_30">
  <div class="table_section padding_infor_info">
    <h5>DAFTAR PENGELUARAN</h5>
    <br />
    <div class="table-responsive">
      <table class="table table-striped" id="datatable">
        <thead>
          <tr>
            <th>TANGGAL</th>
            <th>PENGELUARAN</th>
            <th>JUMLAH</th>
            <th width="10%">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($rData  = mysqli_fetch_array($qData)) { ?>
            <tr class="text-nowrap">
              <td><?php echo normalTanggal($rData['tanggal']); ?></td>
              <td><?php echo $rData['nama_pengeluaran']; ?></td>
              <td><?php echo angka($rData['jumlah']);?>,-</td>
              <td>
                <?php if($rData['tanggal']==date("Y-m-d")){?>
                <button class="btn btn-danger" onclick="hapus('<?php echo enkripsi($rData['pengeluaran_id']) ?>')"><i class="fa fa-trash"></i></button>
                <?php }?>
              </td>
            </tr>
          <?php }; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#datatable').DataTable({
      // dom: '<"container-fluid"<"row"<"col"B><"col"l><"col"f>>>rtip',
      // buttons: [
      //   'print', 'excel'
      // ],
      lengthMenu: [50, 100, 200, 500],
      order: [
        [0, 'desc']
      ]
    });
  });

  function hapus(x) {
    if (confirm("Do you want to delete this data?")) {
      $.ajax({
        type: "POST",
        url: "ajax/pengeluaranDelete.php",
        data: {
          'pID': x
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
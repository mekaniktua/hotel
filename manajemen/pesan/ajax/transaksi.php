<?php
session_start();
include("../database.php");

$transaksi_id = amankan(dekripsi($_POST['tID']));

$sTransaksi  = " SELECT *
            FROM transaksi
            WHERE transaksi_id='" . $transaksi_id . "' and status_hapus='0'";
$qTransaksi = mysqli_query($conn, $sTransaksi) or die(mysqli_error($conn));
$rTransaksi = mysqli_fetch_array($qTransaksi);

if ($rTransaksi['is_lunas'] == 1) { ?>
  <script>
    window.open("?menu=perawatanLihat&tID=<?php echo enkripsi($rTransaksi['transaksi_id']) ?>", "_self");
  </script>
<?php }

//Data di tabel user apakah sudah ada?
$sData  = " SELECT *
            FROM detail_transaksi
            WHERE transaksi_id='" . $transaksi_id . "' and status_hapus='0'";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
$nData = mysqli_num_rows($qData);
?>
<div class="table-responsive">
  <table class="table table-striped" id="datatable">
    <thead>
      <tr>
        <th width="10%">NO</th>
        <th>LAYANAN</th>
        <th width="20%">BIAYA (Rp.)</th>
        <th width="5%">&nbsp;</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($rData  = mysqli_fetch_array($qData)) {
        $i++;;
        $total += $rData['harga_layanan'] + $rData['harga_tambahan_layanan'];
      ?>
        <tr class="text-nowrap">
          <td width="3%"><?php echo $i; ?>.</td>
          <td><?php echo $rData['nama_layanan']; ?></td>
          <td style="text-align: right;"><?php echo (!empty($rData['harga_layanan']) ? angka($rData['harga_layanan'] + $rData['harga_tambahan_layanan']) . ",-" : "0,-"); ?></td>
          <td>
            <a href="#" class="btn btn-danger" onclick="hapus('<?php echo enkripsi($rData['detail_transaksi_id']); ?>')"><i class="fa fa-trash"></i></a>
          </td>
        </tr>
      <?php }; ?>
    </tbody>
  </table>
</div>
  <br /><br />

  <?php

  if (empty($total)) {
    $total = 0;
  }
  //Update total
  $sUpdate  = " UPDATE transaksi
                SET total = " . $total . "
                WHERE transaksi_id='" . $transaksi_id . "' and status_hapus='0'";
  $qUpdate = mysqli_query($conn, $sUpdate) or die(mysqli_error($conn));
  ?>

  <div class="row">
    <div class="col-md-6 form-group">
      <label>Pembayaran Via</label>
      <select id="via" name="via" class="form-control">
        <option value="">Silahkan Pilih</option>
        <option value="Cash">Cash</option>
        <option value="BCA">BCA</option>
        <option value="Mandiri">Mandiri</option>
        <option value="BRI">BRI</option>
        <option value="BNI">BNI</option>
      </select>
    </div>
    <div class="col-md-6">
      <h4 style="text-align: right;">
        TOTAL: Rp. <?php echo angka($total); ?>,-
      </h4>
    </div>
  </div>
  <hr />
  <div class="text-center">
    <button class="btn btn-danger" onclick="back()"><i class="fa fa-chevron-left"></i> Back</button>
    <?php if ($nData > 0) { ?>
      <button class="btn btn-success" onclick="checkout()"><i class="fa fa-shopping-cart"></i> Checkout</button>
    <?php } ?>
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
      window.open("?menu=perawatan", "_self");
    }

    function hapus(x) {
      if (confirm("Apakah anda yakin?")) {
        $.ajax({
          type: "POST",
          url: "ajax/transaksiDelete.php",
          data: {
            dtID: x,
          },
          beforeSend: function() {
            $.blockUI({
              message: '<h5><img src="images/loading.gif" width="50px" /> Please wait</h5>'
            });
          },
          success: function(data) {
            $("#ajaxTransaksi").html(data);
            transaksi();
          },
          complete: function() {
            $.unblockUI();
          }
        });
      }
    }

    function checkout() {

      if ($('#via').val() !== '') {
        if (confirm("Apakah ingin checkout transaksi ini?")) {
          $.ajax({
            type: "POST",
            url: "ajax/transaksiCheckout.php",
            data: {
              'tID': '<?php echo enkripsi($transaksi_id); ?>',
              'via': $('#via').val(),
            },
            beforeSend: function() {
              $.blockUI({
                message: '<h5><img src="images/loading.gif" width="50px" /> Please wait</h5>'
              });
            },
            success: function(data) {
              //  $("#modalInfo").modal('show');
              $("#ajaxInfo").html(data);
              transaksi();
            },
            complete: function() {
              $.unblockUI();
            }
          });
        }
      } else {
        alert("Anda belum memilih tipe pembayaran");
      }
    }
  </script>
<style>
  .scan-me {
    font-family: 'Poppins', sans-serif;
    font-size: 20px;
    font-weight: 600;
    color: #ff7f00;
    margin-bottom: 10px;
  }

  .qr-print-area {
    border: 4px solid #ff7f00;
    padding: 20px;
    border-radius: 12px;
    display: inline-block;
    background-color: #fff;
  }

  .qr-powered {
    margin-top: 10px;
    font-size: 14px;
    color: #666;
    text-align: center;
  }

  .print-button {
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #ff7f00;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
  }

  @media print {

    html,
    body {
      margin: 0 !important;
      padding: 0 !important;
      height: 100%;
      overflow: hidden;
      background: white !important;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    body * {
      visibility: hidden !important;
    }

    #printSection,
    #printSection * {
      visibility: visible !important;
    }

    #printSection {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      padding: 0;
      margin: 0 auto;
      background: white !important;
      text-align: center;
      page-break-after: avoid;
      page-break-before: avoid;
      page-break-inside: avoid;
    }

    .modal-backdrop,
    .print-button {
      display: none !important;
    }
  }

  .voucher-title {
    font-family: 'Poppins', sans-serif;
    font-size: 24px;
    font-weight: 700;
    color: #333;
    margin-bottom: 15px;
    text-align: center;
  }
</style>

<?php
session_start();
include("../manajemen/database.php");

$voucher_id = dekripsi(amankan($_POST['v']));

// Query untuk active voucher
$sQuery = " SELECT v.*,m.name merchant_name
            FROM voucher v
            JOIN merchant m ON m.merchant_id=v.merchant_id
            WHERE v.status = 'Publish' and v.voucher_id='" . $voucher_id . "'
            ORDER BY end_date DESC";

$qQuery = mysqli_query($conn, $sQuery);
$r = mysqli_fetch_array($qQuery);
?>

<div id="printSection" class="modal-body mb-3 text-center">
  <div class="qr-print-area">
    <div class="voucher-title"><?php echo $r['voucher_title']; ?></div> <!-- Judul voucher -->
    <div class="scan-me">Scan Me</div>
    <div class="text-center">
      <img src="<?php echo $r['qrcode_url'] ?>" class="img-thumbnail" width="350px"><br />
      <small><?php echo $r['merchant_name']; ?></small>
    </div>
    <div class="qr-powered">Powered by <strong>Orangesky</strong></div>
  </div>
</div>
<div class="text-center mb-3">
  <button type="button" class="print-button" onclick="window.print()"><i class="fa fa-print"></i> Print</button>

</div>
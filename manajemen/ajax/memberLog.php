<?php
session_start();
include("../database.php");

// Validasi post data
if (empty($_POST['mID'])) {
  die("ID member tidak valid.");
}

// Amankan input
$member_id = amankan(dekripsi($_POST['mID']));

// Cek koneksi database
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Pakai prepared statement untuk keamanan
$sData = mysqli_prepare($conn, "SELECT * FROM member_log WHERE member_id = ? ORDER BY created_date DESC");
mysqli_stmt_bind_param($sData, "s", $member_id);
mysqli_stmt_execute($sData);
$qData = mysqli_stmt_get_result($sData);
?>
<div class="table-responsive">
  <table class="table table-striped" id="datatable">
    <thead>
      <tr>
        <th>DATE</th>
        <th>TYPE</th>
        <th>POINT</th>
        <th>DESCRIPTION</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($rData = mysqli_fetch_array($qData)) { ?>
        <tr>
          <td><?php echo normalTanggalJam($rData['created_date']); ?></td>
          <td><?php echo htmlspecialchars($rData['tyoe']); ?></td>
          <td><?php echo angka($rData['point']); ?></td>
          <td><?php echo ($rData['description']); ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<?php
mysqli_stmt_close($sData);
?>
<?php
session_start();
include("../database.php");

$user_id = amankan(dekripsi($_SESSION['orangesky_user_id']));
$member_id = amankan(dekripsi($_POST['mID']));

//Cari di tabel user apakah sudah ada?
$stmt = mysqli_prepare($conn, "SELECT * FROM member WHERE member_id = ? AND status_hapus = '0'");
        mysqli_stmt_bind_param($stmt, "s", $member_id);
        mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$rCari = mysqli_fetch_array($result);

if (empty($rCari['member_id'])) {
  $pesan = "<i class='fa fa-times'></i> Member not found";
}

mysqli_stmt_close($stmt);

if (empty($pesan)) {

  $sTipe = mysqli_query($conn, "SELECT member_type FROM member_type ORDER BY urutan ASC");
  $listTipe = [];
  while ($row = mysqli_fetch_assoc($sTipe)) {
    $listTipe[] = $row['member_type'];
  }

  // 2. Cari posisi member_type saat ini
  $currentTipe = $rCari['member_type'];
  $indexNow = array_search($currentTipe, $listTipe);

  // 3. Cari member_type berikutnya (level berikutnya)
  if ($indexNow !== false && isset($listTipe[$indexNow + 1])) {
    $newTipe = $listTipe[$indexNow + 1]; // Ini member_type baru
  } else {
    $newTipe = ''; // Sudah level tertinggi
  }

  if (!empty($newTipe)) {
    // 4. Ambil point dari member_type baru
    $stmt = mysqli_prepare($conn, " SELECT point 
                                    FROM member_type 
                                    WHERE member_type = ?");
    mysqli_stmt_bind_param($stmt, "s", $newTipe);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rTipe = mysqli_fetch_assoc($result);
    $poinUpgrade = (int)$rTipe['point'];
    mysqli_stmt_close($stmt);

    // 5. Update member
    $stmtUpdate = mysqli_prepare($conn, " UPDATE member 
                                          SET point = (point + ?), member_type = ? 
                                          WHERE member_id = ?");
    mysqli_stmt_bind_param($stmtUpdate, "iss", $poinUpgrade, $newTipe, $member_id);
    mysqli_stmt_execute($stmtUpdate);

    if (mysqli_stmt_affected_rows($stmtUpdate) > 0) {
      // 6. Insert log
      $description = "Member successfully upgraded to <b>$newTipe</b>. 500 points added ";
      $member_log_id = randomText(10);
      $stmtLog = mysqli_prepare($conn, "  INSERT INTO member_log 
                                          SET member_log_id = ?, created_date = ?, member_id = ?, user_id = ?, type = 'Upgrade', point = ?,description =?");
      $tanggal = date("Y-m-d H:i:s");
      mysqli_stmt_bind_param($stmtLog, "ssssis", $member_log_id, $tanggal, $member_id, $user_id, $poinUpgrade, $description);
      mysqli_stmt_execute($stmtLog);
      mysqli_stmt_close($stmtLog);

      $pesanSukses = "<i class='fa fa-check'></i> Member successfully upgraded to <b>$newTipe</b>. 500 points added.";
    } else {
      $pesan = "<i class='fa fa-times'></i> Upgrade failed, please try again.";
    }

    mysqli_stmt_close($stmtUpdate);
  } else {
    $pesan = "<i class='fa fa-times'></i> The member is already at the highest level and cannot be upgraded further.";
  }
}
?>
<div class="pesanku">
  <?php if (!empty($pesan)) { ?>
    <div class="alert alert-danger">
      <?php echo $pesan; ?>
    </div>
  <?php }
  if (!empty($pesanSukses)) { ?>
    <div class="alert alert-success">
      <?php echo $pesanSukses; ?>
    </div>
    <script>
      memberList();
    </script>
  <?php } ?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
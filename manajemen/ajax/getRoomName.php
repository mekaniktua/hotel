<?php
session_start();
include "../database.php"; // koneksi database

$rtID =  dekripsi(amankan($_POST['rtID'] ?? '')); 

if ($rtID != "") {
  $stmt = $conn->prepare("SELECT room_id, room_name FROM room WHERE room_type_id = ?");
  $stmt->bind_param("s", $rtID);
  $stmt->execute();
  $result = $stmt->get_result();
    
  while ($r = $result->fetch_assoc()) {
    echo "<option value='" . enkripsi($r['room_id']) . "'>" . $r['room_name'] . "</option>";
  }
  $stmt->close();
} else {
  echo "<option value=''>No Room Found</option>";
}
?>

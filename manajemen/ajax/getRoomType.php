<?php
session_start();
include "../database.php"; // koneksi database

$property_id =  dekripsi(amankan($_POST['pID'] ?? '')); 

if ($property_id != "") {
  $stmt = $conn->prepare("SELECT room_type_id, room_type FROM room_type WHERE property_id = ?");
  $stmt->bind_param("s", $property_id);
  $stmt->execute();
  $result = $stmt->get_result();
    
  while ($r = $result->fetch_assoc()) {
    echo "<option value='" . enkripsi($r['room_type_id']) . "'>" . $r['room_type'] . "</option>";
  }
  $stmt->close();
} else {
  echo "<option value=''>No Room Type Found</option>";
}
?>

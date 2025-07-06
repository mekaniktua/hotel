<?php
header('Content-Type: application/json');
include("../database.php");

$rate = array();

$room_type_id = dekripsi(amankan($_POST['rtID']));
$room_id = dekripsi(amankan($_POST['rID']));

$q = mysqli_query($conn, "
    SELECT * 
    FROM rate_plans  
    WHERE status_hapus = '0' 
      AND room_type_id = '$room_type_id' 
      AND room_id = '$room_id'
");

$rate = [];

while ($row = mysqli_fetch_assoc($q)) {
    // Cek jumlah booking pada tanggal rate_date
    $rateDate = $row['rate_date'];
    $check = mysqli_query($conn, "
        SELECT COUNT(*) as total_booking 
        FROM booking 
        WHERE status_hapus = '0' 
          AND '$rateDate' BETWEEN start_date AND end_date
          AND room_id = '$room_id' 
          AND status IN ('Booked', 'Completed')
    ");
    $booking = mysqli_fetch_assoc($check);
    $booked = $booking['total_booking'];

    // Default color
    $colorMap = [
        'Regular'     => '#4CAF50',
        'Promo'       => '#FF9800',
        'Weekend'     => '#c0a751',
        'HighSeason'  => '#9C27B0',
        'Closed'      => '#F44336',
    ];
    $bgColor = $colorMap[$row['rate_type']] ?? '#2196F3';

    // Tentukan status kamar
    if ($booked < $row['total_room']) {
        $title = ($row['rate_type'] == 'Closed') 
            ? 'Closed' 
            : "Rp. " . angka($row['price']) . "\nRooms: " . $row['total_room'] . "\nBooked: " . $booked;
    } else {
        $title = "Full Booked";
        $bgColor = '#CCCCCC';
    }

    $rate[] = [
        'id' => $row['rate_plans_id'],
        'title' => $title,
        'start' => $row['rate_date'],
        'backgroundColor' => $bgColor,
        'textColor' => '#FFFFFF',
        'price' => $row['price'],
        'total_room' => $row['total_room'],
        'rate_type' => $row['rate_type'],
        'booked' => $booked,
    ];
}

echo json_encode($rate);
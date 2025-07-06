<?php
session_start();
include("../database.php");

$property_id = dekripsi(amankan($_POST['pID'] ?? ''));
$room_type_id = dekripsi(amankan($_POST['rtID'] ?? ''));
$room_id = dekripsi(amankan($_POST['rID'] ?? ''));
$price = amankan($_POST['price'] ?? '');
$total_room = amankan($_POST['total_room'] ?? '');
$rate_type = amankan($_POST['rate_type'] ?? '');
$rate_date = amankan($_POST['eventDate'] ?? '');
$end_date =amankan($_POST['end_date'] ?? '');
$rate_plans_id = amankan($_POST['rpID'] ?? ''); 
$input_type = dekripsi(amankan($_POST['input_type'] ?? ''));

if($input_type=='Bulk'){
  

   if($rate_date > $end_date){
       $pesan = "<i class='fa fa-times'></i> End date cannot be earlier than start date"; 
   }else{ 
        $current_date = strtotime($rate_date);
        $end_date_ts = strtotime($end_date);

        $select_stmt = $conn->prepare("SELECT 1 FROM rate_plans WHERE rate_date=? AND room_id=? AND room_type_id=? AND status_hapus='0'");
        $insert_stmt = $conn->prepare("INSERT INTO rate_plans (rate_plans_id, rate_date, property_id, room_id, room_type_id, price, total_room, rate_type, status_hapus) VALUES (?, ?, ?, ?, ?, ?, ?, ?, '0')");

        while ($current_date <= $end_date_ts) {
            $date_str = date('Y-m-d', $current_date);

            $select_stmt->bind_param("sss", $date_str, $room_id, $room_type_id);
            $select_stmt->execute();
            $result = $select_stmt->get_result();

            if ($result->num_rows == 0) {
                $rate_plans_id = randomText(20);
                $insert_stmt->bind_param("ssssssss", $rate_plans_id, $date_str, $property_id, $room_id, $room_type_id, $price, $total_room, $rate_type);
                $insert_stmt->execute();
            }

            $current_date = strtotime('+1 day', $current_date);
        }

        $select_stmt->close();
        $insert_stmt->close();
        $conn->close();
        $pesanSukses = "<i class='fa fa-check'></i> Rate plan has been saved";

    }
}else{

  if(empty($rate_plans_id)){
    $sCari = "SELECT 1 FROM rate_plans WHERE rate_date='$rate_date' AND room_id='$room_id' AND room_type_id='$room_type_id' AND status_hapus='0' LIMIT 1";
    $qCari = mysqli_query($conn, $sCari);

    if (!$qCari) {
        die(mysqli_error($conn));
    }

    if (mysqli_num_rows($qCari) > 0) {
        $pesan = "<i class='fa fa-times'></i> Rate plan for this date already exists.";
    } else {
        $rate_plans_id = randomText(20);
        $sInsert = "INSERT INTO rate_plans (rate_plans_id, rate_date, property_id, room_id, room_type_id, price, total_room, rate_type, status_hapus) VALUES (?, ?, ?, ?, ?, ?, ?, ?, '0')";
        $stmt = mysqli_prepare($conn, $sInsert);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssssss", 
                $rate_plans_id, 
                $rate_date, 
                $property_id, 
                $room_id, 
                $room_type_id, 
                $price, 
                $total_room, 
                $rate_type
            );
            
            if (mysqli_stmt_execute($stmt)) {
                $pesanSukses = "<i class='fa fa-check'></i> Rate plan has been saved";
            } else {
                die(mysqli_error($conn));
            }
            mysqli_stmt_close($stmt);
        } else {
            die(mysqli_error($conn));
        }
    }
  }else{
    $sUpdate = "UPDATE rate_plans 
                SET rate_date=?, 
                    property_id=?, 
                    room_id=?, 
                    room_type_id=?, 
                    price=?, 
                    total_room=?, 
                    rate_type=? 
                WHERE rate_plans_id=?";
    
    $stmt = mysqli_prepare($conn, $sUpdate);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssssss", 
            $rate_date, 
            $property_id, 
            $room_id, 
            $room_type_id, 
            $price, 
            $total_room, 
            $rate_type, 
            $rate_plans_id
        );
        
        if (mysqli_stmt_execute($stmt)) {
            $pesanSukses = "<i class='fa fa-check'></i> Rate plan has been updated";
        } else {
            die(mysqli_error($conn));
        }
        mysqli_stmt_close($stmt);
    } else {
        die(mysqli_error($conn));
    }
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
    $("#modalInfo").on("hidden.bs.modal", function() {
        $("#addEventModal").modal("hide");
        // $("#btnSearch").click();
    });

    $("#addEventModal").on("hidden.bs.modal", function() {
        $("#btnSearch").click();
    });
    </script>
    <?php } ?>
</div>
<?php
session_start();
include("../manajemen/database.php");

$global_member_id = dekripsi(amankan($_SESSION['osg_member_id'] ?? ''));
$type = dekripsi(amankan($_POST['type'] ?? ''));

$pesan = "";
$pesanSukses = "";

if ($type == 'avatar') {
    $file = $_FILES['avatar'] ?? null;
    if($file){
        $fileName = $file['name'];
        $fileTmpPath = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];
        $path = "uploads/member/";
        $fileName = $global_member_id . "." . pathinfo($fileName, PATHINFO_EXTENSION);
        $fileDestination = $path . $fileName;
        if(move_uploaded_file($fileTmpPath, "../".$fileDestination)){
            $sQuery = "UPDATE member SET avatar = '$fileDestination' WHERE member_id = '" . $global_member_id . "'";
            $qData = mysqli_query($conn, $sQuery);
            $pesanSukses = "<i class='fa fa-check-circle text-success'></i> avatar has been changed";
        }else{
            $pesan = "<i class='fa fa-times-circle text-danger'></i> avatar has been changed";
        }
    } else {
        $pesan = "<i class='fa fa-times-circle text-danger'></i> image is required";
    }
}else if($type == 'password'){
    $oldPassword = (amankan($_POST['oldPassword'] ?? ''));
    $newPassword = (amankan($_POST['newPassword'] ?? ''));
    $confirmPassword = (amankan($_POST['confirmPassword'] ?? ''));
    
    if($oldPassword == $newPassword){
        $pesan = "<i class='fa fa-times-circle text-danger'></i> old password and new password cannot be the same";
    }else if($newPassword != $confirmPassword){
        $pesan = "<i class='fa fa-times-circle text-danger'></i> new password and confirm password are not the same";
    }else{
        $sQuery = " UPDATE member SET password = '".md5($newPassword)."' 
                    WHERE member_id = '" . $global_member_id . "'";
        $qData = mysqli_query($conn, $sQuery);
        $pesanSukses = "<i class='fa fa-check-circle text-success'></i> password has been changed";
    }
}

if($pesanSukses){
    echo "<div class='alert alert-success'>".$pesanSukses."</div>";
}elseif($pesan){
    echo "<div class='alert alert-danger'>".$pesan."</div>";
}

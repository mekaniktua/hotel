<?php
if(empty($t)){
    include("pages/memberProfile.php");
}else if($t=="myBooking"){
    include("pages/memberMyBooking.php");
}else if($t=="myPoint"){
    include("pages/memberMyPoint.php");
}else if($t=="signOut"){
    include("pages/memberSignOut.php");
}else if($t=="setting"){
    include("pages/memberSetting.php");
}else{
    include("pages/memberProfile.php");
}
?>
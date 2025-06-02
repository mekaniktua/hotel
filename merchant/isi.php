<?php
if(empty($menu)){
    include("pages/login.php");
}else if ($menu == 'resend') {
    include("pages/resend.php");
}else if ($menu == 'forgot') {
    include("pages/forgot.php");
}else if ($menu == 'reset') {
    include("pages/reset.php");
}else if ($menu == 'reset') {
    include("pages/reset.php");
}else{
    header("Location: ../404.php");
}
?>
<?php
if(empty($menu)){
    include("pages/search.php");
} else if ($menu == "merchant") {
    include("pages/merchant.php");
}else if($menu=="member"){
    include("pages/member.php");
}else if($menu=="search"){
    include("pages/search.php");
}else if($menu=="detail"){
    include("pages/detail.php");
}else if($menu=="booking"){
    include("pages/booking.php");
}else if($menu=="confirmation"){
    include("pages/confirmation.php");
}else if($menu=="completed"){
    include("pages/completed.php");
}else if($menu=="error"){
    include("pages/error.php");
}else if($menu=="voucher"){
    include("pages/voucher.php");
}else if($menu=="contactUs"){
    include("pages/contactUs.php");
}else{
    header("Location: ./404.php");
}
?>
<?php
session_destroy();
setcookie('osg_member_id', enkripsi($member_id), time() - (86400 * 7), "/");
setcookie('osg_member_email', ($rCari['email']), time() - (86400 * 7), "/");
header("Location: ./");
?>
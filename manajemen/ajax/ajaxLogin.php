<?php
session_start();
include("../database.php");

$username = amankan($_POST['uname'] ?? '');
$password = amankan($_POST['upass'] ?? '');


//Cari di tabel user apakah sudah ada?
$sCari  = " SELECT u.* 
      FROM users u 
      WHERE username='".$username."' and password='".md5($password)."' and u.status_hapus='0'"; 
$qCari = mysqli_query($conn,$sCari)or die(mysqli_error($conn));
$nCari  = mysqli_num_rows($qCari);
$rCari  = mysqli_fetch_array($qCari);
if($nCari<1){// Jika tidak ketemu keluar notif
  $pesan = "<i class='fa fa-times'></i> Username atau password salah";
}if(empty($pesan)){
   
  $_SESSION['orangesky_user_id']= enkripsi($rCari['user_id'] ?? ''); 
  $_SESSION['orangesky_username']=($rCari['username'] ?? ''); 
  $_SESSION['orangesky_tipe_user']=($rCari['tipe'] ?? ''); 
  $pesanSukses = "<i class='fa fa-done'></i> You have successfully logged in.";
   
}
?>
<div class="pesanku">
  <?php if(!empty($pesan)){?>
    <div class="alert alert-danger">
      <?php echo $pesan;?>
    </div>
  <?php }if(!empty($pesanSukses)){?>
    <script>
      window.open("./","_self");
    </script>
  <?php }?>
</div>
<script>
  //$('.pesanku').delay(2000).fadeOut();
</script>
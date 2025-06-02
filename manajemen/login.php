<!DOCTYPE html>
<html lang="en">

<head>
   <!-- basic -->
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- mobile metas -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="viewport" content="initial-scale=1, maximum-scale=1">
   <!-- site metas -->
   <title>Hotel - Halaman Admin</title>
   <meta name="keywords" content="">
   <meta name="description" content="">
   <meta name="author" content="">
   <!-- site icon -->
   <link rel="icon" href="images/logo/favicon.ico" />
   <!-- bootstrap css -->
   <link rel="stylesheet" href="css/bootstrap.min.css" />
   <!-- site css -->
   <link rel="stylesheet" href="style.css" />
   <!-- responsive css -->
   <link rel="stylesheet" href="css/responsive.css" />
   <!-- select bootstrap -->
   <link rel="stylesheet" href="css/bootstrap-select.css" />
   <!-- scrollbar css -->
   <link rel="stylesheet" href="css/perfect-scrollbar.css" />
   <!-- custom css -->
   <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->

   <!-- jQuery -->
   <script src="js/jquery.min.js"></script>
   <script src="js/jquery-1.1.js"></script>
   <script src="js/popper.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
   <!-- wow animation -->
   <script src="js/animate.js"></script>
   <!-- select country -->
   <script src="js/bootstrap-select.js"></script>
   <!-- nice scrollbar -->
   <script src="js/blockUI.js"></script>
</head>

<body class="inner_page login">
   <div class="full_container">
      <div class="container">
         <div class="center verticle_center full_height">
            <div class="login_section">
               <div class="logo_login">
                  <div class="center">
                     <img width="210" src="images/logo/hotel.png" alt="#" />
                  </div>
               </div>
               <div class="login_form">
                  <form id="frmLogin" method="post">
                     <fieldset>
                        <div class="field">
                           <label class="label_field">Username</label>
                           <input type="text" name="uname" placeholder="Username" />
                        </div>
                        <div class="field">
                           <label class="label_field">Password</label>
                           <input type="password" name="upass" placeholder="Password" />
                        </div>
                        <div class="field">
                           <label class="label_field hidden">hidden label</label>
                           <label class="form-check-label"><input type="checkbox" class="form-check-input"> Remember Me</label>
                           <a class="forgot" href="">Forgotten Password?</a>
                        </div>
                        <div class="field margin_0">
                           <label class="label_field hidden">hidden label</label>
                           <button class="main_bt">Login</button>
                        </div>
                     </fieldset>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>

   <!-- Modal -->
   <div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title" id="myModalLabel"><i class="fa fa-info"></i> Information</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">
               <div id="ajaxInfo"></div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Tutup</button>
            </div>
         </div>
      </div>
   </div>

   <script>
      $("#frmLogin").submit(function(e) {
         e.preventDefault();
         var formData = $("#frmLogin").serialize();

         $.ajax({
            type: 'POST',
            url: 'ajax/ajaxLogin.php',
            data: formData,
            beforeSend: function() {
               // setting a timeout
               $.blockUI({
                  message: '<img src="images/loading.gif" width="50" /> Please wait...'
               });
            },
            success: function(data) {
               $("#modalInfo").modal('show');
               $("#ajaxInfo").html(data);
            },
            complete: function() {
               $.unblockUI();
            },
         })
      })
   </script>
</body>

</html>
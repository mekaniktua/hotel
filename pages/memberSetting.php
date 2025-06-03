<?php
$global_member_id = dekripsi(amankan($_SESSION['osg_member_id']));

?>

<style>
  .transition-icon {
    transition: transform 0.3s ease;
  }
  .rotate-90 {
    transform: rotate(90deg);
  }.hover-card:hover { 
  color: #fff !important;
}

.password-toggle {
    position: relative;
  }
  .password-toggle .toggle-eye {
    position: absolute;
    top: 75%;
    right: 1rem;
    transform: translateY(-50%);
    cursor: pointer;
    color: #6c757d;
  }
</style>

<div class="card" style="box-shadow: 0 0 45px rgba(0, 0, 0, .08);">
<div class="card-header">
      <h5 class="mb-0"><i class="fa fa-cog"></i> Setting</h5>
    </div>
    <div class="card-body">

      <!-- Change Avatar -->
        <div class="mb-3">
            <div 
                class="w-100 btn-outline-primary border rounded px-4 py-3 mb-2 d-flex justify-content-between align-items-center shadow-sm hover-card"
                role="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#collapseAvatar" 
                aria-expanded="false" 
                aria-controls="collapseAvatar"
                style="cursor: pointer;">
                <span><i class="bi bi-person-circle me-2"></i>Change Avatar</span>
                <i class="bi bi-chevron-right transition-icon" id="iconAvatar"></i>
            </div>
            <div class="collapse mt-2" id="collapseAvatar">
                <div class="card card-body p-4 shadow-sm border border-primary-subtle">
                <form id="frmAvatar" method="post" enctype="multipart/form-data">
                    <div class="mb-3 text-center">
                        <img src="<?php echo (!$global_member_avatar) ? 'img/user.png' : $global_member_avatar; ?>" alt="Avatar" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px;"> 
                    <input type="hidden" name="type" value="<?php echo enkripsi('avatar'); ?>">
                    <input type="file" class="form-control" id="avatar" accept="image/*" name="avatar">
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                </form>
                </div>
            </div>
        </div>

            <!-- Change Password -->
        <div class="mb-3">
            <div 
                class="w-100 btn-outline-primary border rounded px-4 py-3 mb-2 d-flex justify-content-between align-items-center shadow-sm hover-card"
                role="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#collapsePassword" 
                aria-expanded="false" 
                aria-controls="collapsePassword"
                style="cursor: pointer;">
                <span><i class="fa fa-lock me-2"></i>Change Password</span>
                <i class="bi bi-chevron-right transition-icon" id="iconPassword"></i>
            </div>
            <div class="collapse mt-2" id="collapsePassword">
                <div class="card card-body p-4 shadow-sm border border-primary-subtle">
                <form id="frmPassword" method="post">
                    <div class="mb-3 password-toggle">
                        <input type="hidden" name="type" value="<?php echo enkripsi('password'); ?>">
                        <label for="oldPassword" class="form-label">Old Password<sup class="text-danger">*</sup></label>
                        <input type="password" class="form-control" id="oldPassword" name="oldPassword" required>
                        <i class="bi bi-eye toggle-eye" toggle="#oldPassword"></i>
                    </div>

                    <div class="mb-3 password-toggle">
                        <label for="newPassword" class="form-label">New Password<sup class="text-danger">*</sup></label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                        <i class="bi bi-eye toggle-eye" toggle="#newPassword"></i>
                    </div>

                    <div class="mb-3 password-toggle">
                        <label for="confirmPassword" class="form-label">Confirm Password<sup class="text-danger">*</sup></label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                        <i class="bi bi-eye toggle-eye" toggle="#confirmPassword"></i>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                </form>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div id="ajaxInfo"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>

            </div>
        </div>
    </div>
</div>

<script> 

    document.querySelectorAll('.toggle-eye').forEach(function (eyeIcon) {
        eyeIcon.addEventListener('click', function () {
        const input = document.querySelector(this.getAttribute('toggle'));
        const isPassword = input.getAttribute('type') === 'password';
        input.setAttribute('type', isPassword ? 'text' : 'password');
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
        });
    });

    $("#frmAvatar").submit(function(e) {
        e.preventDefault(e);
        var frm = $('#frmAvatar')[0];
        var formData = new FormData(frm);
        $.ajax({
            type: "POST",
            url: "ajax/memberSetting.php",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                // setting a timeout
                $.blockUI({
                    message: '<img src="img/loading.gif" width="50" /> Please wait...'
                });
            },
            success: function(data) {
                $("#ajaxInfo").html(data);
                $("#modalInfo").modal("show");
            },
            complete: function() {
                $.unblockUI();
            },
        })
    });

    $("#frmPassword").submit(function(e) {
        e.preventDefault(e);
        var frm = $('#frmPassword')[0];
        var formData = new FormData(frm);
        $.ajax({
            type: "POST",   
            url: "ajax/memberSetting.php",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $.blockUI({
                    message: '<img src="img/loading.gif" width="50" /> Please wait...'  
                });
            },
            success: function(data) {
                $("#ajaxInfo").html(data);
                $("#modalInfo").modal("show");
            },
            complete: function() {
                $.unblockUI();
            },
        })
    });
    
</script>

<script>
  const avatarCollapse = document.getElementById('collapseAvatar');
  const passwordCollapse = document.getElementById('collapsePassword');
  const iconAvatar = document.getElementById('iconAvatar');
  const iconPassword = document.getElementById('iconPassword');

  // Toggle ikon dan tutup lainnya saat salah satu dibuka
  avatarCollapse.addEventListener('show.bs.collapse', () => {
    passwordCollapse.classList.remove('show');
    iconAvatar.classList.add('rotate-90');
    iconPassword.classList.remove('rotate-90');
  });

  avatarCollapse.addEventListener('hide.bs.collapse', () => {
    iconAvatar.classList.remove('rotate-90');
  });

  passwordCollapse.addEventListener('show.bs.collapse', () => {
    avatarCollapse.classList.remove('show');
    iconPassword.classList.add('rotate-90');
    iconAvatar.classList.remove('rotate-90');
  });

  passwordCollapse.addEventListener('hide.bs.collapse', () => {
    iconPassword.classList.remove('rotate-90');
  });
</script>
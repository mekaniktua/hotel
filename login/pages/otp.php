<?php
$email = dekripsi(amankan($_GET['e']));
$code = dekripsi(amankan($_GET['c']));
$redirect_uri = (amankan($_GET['redirect_uri']));

$sCari  = " SELECT *
            FROM member
            WHERE email='" . $email . "' and confirmation_code='" . $code . "' and status_hapus='0'";
$qCari = mysqli_query($conn, $sCari) or die(mysqli_error($conn));
$rCari  = mysqli_fetch_array($qCari);

if (empty($rCari['email'])) {
    $pesan = "Sorry, the OTP link was not found";
} elseif ($rCari['confirmation_code_expired'] < date("Y-m-d H:i:s")) {
    $pesan = "Sorry, the OTP link has expired";
}
if (empty($pesan)) {
?>

<style>
     .otp-input {
      width: 3rem;
      height: 3rem;
      text-align: center;
      font-size: 1.5rem;
      margin: 0 0.3rem;
      border-radius: 0.5rem;
    }
</style>
    <div class="container-xxl mt-5">
        <div class="container">
            <div class="text-center wow fadeInUp" style="margin-bottom: 20px;" data-wow-delay="0.1s">
            <div class="alert alert-info">We have sent you a 6-digit OTP code to email <?php echo maskEmail($email); ?>. Please check your email and enter the code below.</div>
                <h6 class="section-title text-center text-primary text-uppercase">OTP VERIFICATION</h6>
            </div>
            <div class="row g-5">
                <div class="col-lg-12">
                    <div class="wow fadeInUp" data-wow-delay="0.2s">
                        <form id="frmOTP" name="frmOTP" method="post">
                            <div class="row g-3">
                                <div class="col-md-12 mb-3">
                                    <input type="hidden" class="form-control" name="umail" value="<?php echo enkripsi($email) ?>">
                                    <div class="form-floating">
                                    <div class="d-flex justify-content-center mb-3">
                                        <input type="text" class="form-control otp-input" maxlength="1">
                                        <input type="text" class="form-control otp-input" maxlength="1">
                                        <input type="text" class="form-control otp-input" maxlength="1">
                                        <input type="text" class="form-control otp-input" maxlength="1">
                                        <input type="text" class="form-control otp-input" maxlength="1">
                                        <input type="text" class="form-control otp-input" maxlength="1">
                                    </div>
                                         
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <button class="btn btn-primary w-100 py-3">Send</button>
                                </div>
                                <hr />
                                <p>
                                    Already have account? <a href="./">Login here</a><br />
                                    Don't have an account? <a href="?menu=signup">Sign up here</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }
if (!empty($pesan)) { ?>
    <div class="container-xxl mt-5 mb-5">
        <div class="container">
            <div class="text-center wow fadeInUp mb-3" data-wow-delay="0.1s">
                <h6 class="section-title text-center text-primary text-uppercase"><?php echo $pesan; ?></h6>
            </div>
            <div class="text-center">
                <button class="btn btn-danger" onclick="login()"><i class="fa fa-chevron-left"></i> Back</button>
                <p>&nbsp;</p>
            </div>
        </div>
    </div>
<?php } ?>


<!-- Modal -->
<div class="modal fade" id="modalInfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div id="ajaxInfo"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const inputs = document.querySelectorAll('.otp-input');

    inputs.forEach((input, index) => {
        // Saat mengetik
        input.addEventListener('input', () => {
            if (input.value && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        });

        // Navigasi dengan keyboard
        input.addEventListener('keydown', (e) => {
            const key = e.key;

            // Jika tekan Backspace atau Delete
            if (key === "Backspace" || key === "Delete") {
                e.preventDefault();

                if (input.value !== "") {
                    // Hapus karakter kalau masih ada
                    input.value = "";
                } else if (index > 0) {
                    // Pindah ke input sebelumnya dan hapus juga isinya
                    inputs[index - 1].focus();
                    inputs[index - 1].value = "";
                }
            }

            // Navigasi kiri
            if (key === "ArrowLeft" && index > 0) {
                inputs[index - 1].focus();
            }

            // Navigasi kanan
            if (key === "ArrowRight" && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        });


        // Jika user paste 6 digit sekaligus
        input.addEventListener('paste', (e) => {
            const pasteData = e.clipboardData.getData('text');
            if (/^\d{6}$/.test(pasteData)) {
                e.preventDefault();
                pasteData.split('').forEach((char, i) => {
                    if (inputs[i]) {
                        inputs[i].value = char;
                    }
                });
                inputs[5].focus();
            }
        });
    });

    // Autofocus ke input pertama saat halaman dimuat
    if (inputs.length > 0) {
        inputs[0].focus();
    }
});


    function login() {
        window.open("./", "_self");
    }

    $("#frmOTP").submit(function(e) {
        e.preventDefault(e);

        let otp = '';
        $('.otp-input').each(function() {
            otp += $(this).val();
        });

        var frm = $('#frmOTP')[0];
        var formData = new FormData(frm);
        formData.append('otp', otp);
        formData.append('redirect_uri', '<?php echo $redirect_uri; ?>');
        $.ajax({
            type: "POST",
            url: "ajax/otp.php",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $.blockUI({
                    message: '<h6><img src="../img/loading.gif" width="50" /> Please Wait</h6>'
                });
            },
            success: function(data) {
                $("#modalInfo").modal('show');
                $("#ajaxInfo").html(data);

            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
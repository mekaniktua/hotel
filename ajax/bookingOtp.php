 
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
<div class="text-center mb-4">
<div class="alert alert-info">We have sent you a 6-digit OTP code to email <?php echo maskEmail($email); ?>. Please check your email and enter the code below.</div>
<h6 class="section-title text-center text-primary text-uppercase">OTP VERIFICATION</h6>
</div>
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
    </div>
</form>

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


    $("#frmOTP").submit(function(e) {
        e.preventDefault(e);

        let otp = '';
        $('.otp-input').each(function() {
            otp += $(this).val();
        });

        var frm = $('#frmOTP')[0];
        var formData = new FormData(frm);
        formData.append('otp', otp); 
        formData.append('bID', '<?php echo enkripsi($booking_id); ?>');
        $.ajax({
            type: "POST",
            url: "ajax/bookingOtpVerification.php",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $.blockUI({
                    message: '<h6><img src="../img/busy.gif" width="50" /> Please Wait</h6>'
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
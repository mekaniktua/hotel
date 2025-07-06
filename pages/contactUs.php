<?php
$t = amankan($_GET['t'] ?? "");

?>

<!-- Service Start -->
<div class="container-xxl py-5" style="margin-bottom: 100px;">
    <div class="container">
        <div class="text-center wow fadeInUp mb-5" data-wow-delay="0.1s">
            <h6 class="section-title text-center text-primary text-uppercase">Contact Us</h6> 
        </div>
        <div class="row">
            <div class="col-md-6 panel-primary">
                <form id="frmContact" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="pesan" class="form-label">Message:</label>
                        <textarea class="form-control" id="pesan" name="pesan" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
            </div>
            <div class="col-md-6">
                <div class="info">
                    <h3>OrangeSky Management Co.</h3>
                    <p><i class="fas fa-store"></i> Kompleks Centre Park, Jl. Ahmad Yani No.1, Teluk Tering, Batam Kota, Batam City, Riau Islands</p>
                    <p><i class="fas fa-phone"></i> Telp: 0811-6687-008</p>
                    <p><i class="fas fa-envelope"></i> Email: booknow@orangeskygroup.co.id</p>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.054177882502!2d104.04887437403106!3d1.1213860988678768!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d9896a6c235da9%3A0x24c9025d0f2325ad!2sOrange%20Sky%20Management%20Co.!5e0!3m2!1sen!2sid!4v1751266903300!5m2!1sen!2sid" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
    $(document).ready(function(){
        $('#frmContact').submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: 'ajax/contactUs.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function(){
                    $('#frmContact button[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                },
                success: function(response){
                    $('#modalInfo').modal('show');
                    $('#ajaxInfo').html(response);
                },
                complete: function(){
                    $('#frmContact button[type="submit"]').prop('disabled', false).html('Send');
                },
                error: function(xhr, status, error){
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>

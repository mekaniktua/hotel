<?php $pesan = str_replace("+", " ", dekripsi($_GET['errmsg'])); ?>
<!-- Booking Start -->
<div class="container-fluid booking pb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-bottom: 100px;">
    <div class="px-3" style="margin-top: 120px;">
        <div class="bg-white shadow" style="padding: 35px;">
            <div class="g-2 text-center">
                <img src="img/something.jpg" class="img-fluid rounded">
                <h1>Oops...!!</h1>
                <h4><i class='fa fa-info-circle'></i> <?php echo $pesan; ?></h4>
                <button onclick="kembali()" class="btn btn-danger"><i class='fa fa-home'></i> Home</button>
            </div>
        </div>
    </div>
</div>
<script>
    function kembali(){
        window.open("./","_self");
    }
</script>
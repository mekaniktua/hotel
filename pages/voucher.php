<?php
$sVoucher  = "SELECT v.*, m.merchant_type,m.name 
              FROM voucher v
              JOIN merchant m ON v.merchant_id = m.merchant_id
              WHERE v.status_hapus='0' 
              LIMIT 6";
$qVoucher  = mysqli_query($conn, $sVoucher) or die(mysqli_error($conn));

$types = [];
$vList = '';

while ($rVoucher = mysqli_fetch_array($qVoucher)) {
    $merchantType = ($rVoucher['merchant_type']);
    $merchant_name = $rVoucher['name'] ??'';
    $title = $rVoucher['voucher_title'] ??'';
    $description = $rVoucher['description'] ??'';

    // Kumpulkan merchant_type unik untuk tombol filter
    if (!in_array($merchantType, $types)) {
        $types[] = $merchantType;
    }
    $start_date = $rVoucher['start_date']  ??  '';
    $end_date = $rVoucher['end_date']  ?? '';

    $vList .= "
    <div class='col-md-4 mb-4 portfolio-item' data-category='{$merchantType}'>
        <div class='card shadow-sm border-0' style='height:350px;'>
            <img src='" . ($rVoucher['voucher_url']) . "' 
                 class='card-img-top' 
                 alt='" . ($rVoucher['voucher_title']) . "' 
                 style='height: 150px; object-fit: cover;'>

            <div class='card-body' style='margin-top:-15px'>
                <div class='text-muted text-end mb-1'>By ".$merchant_name."</div>

                <h6 class='card-title'>".$title."</h6>

                <div class='card-text small text-muted' style='height:70px; overflow: hidden;'>
                ".$description."
                </div>

                <div class='d-flex justify-content-between mt-3'>
                    <div>
                        <span class='text-muted small'>Valid From</span>
                        <p class='mb-0'><strong>".normalTanggal($start_date)."</strong></p>
                    </div>
                    <div>
                        <span class='text-muted small'>Valid Until</span>
                        <p class='mb-0'><strong>".normalTanggal($end_date)."</strong></p>
                    </div>
                </div>
            </div>

</div>
</div>";
}
?>

<style>
.portfolio-item {
    transition: all 0.8s ease-in-out;
}

.portfolio-item.hide {
    display: none !important;
}
</style>


<!-- Filter Buttons -->
<div class="container mt-5" style="margin-bottom: 150px;">
    <div class="text-center mb-4">
        <button class="btn btn-outline-primary me-1 filter-btn" data-filter="all">All</button>
        <?php
        foreach ($types as $type) {
            echo "<button class='btn btn-outline-primary me-1 filter-btn' data-filter='{$type}'>{$type}</button> ";
        }
        ?>
    </div>

    <!-- Portfolio Items -->
    <div class="row" id="portfolio-items">
        <?php echo $vList; ?>
    </div>
</div>

<script>
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const filter = btn.getAttribute('data-filter');
        document.querySelectorAll('.portfolio-item').forEach(item => {
            if (filter === 'all' || item.getAttribute('data-category') === filter) {
                item.classList.remove('hide');
            } else {
                item.classList.add('hide');
            }
        });
    });
});
</script>
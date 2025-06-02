<style>
    /* Custom tab style */
    .custom-tabs .nav-link {
        color: #555;
        font-weight: 500;
        padding: 12px 24px;
        /* py-3 px-4 */
        border-radius: 0.5rem 0.5rem 0 0;
        transition: all 0.3s ease;
    }

    .custom-tabs .nav-link:hover {
        background-color: #e9ecef;
        color: #000;
    }

    .custom-tabs .nav-link.active {
        background-color: #FEA116;
        color: #fff;
        font-weight: bold;
    }

    .point-card {
        border-radius: 1rem;
        transition: transform 0.2s ease;
    }

    .point-header {
        font-weight: 600;
        font-size: 1.2rem;
        color: #6c757d;
    }

    .point-value {
        font-weight: 700;
        font-size: 1.2rem;
        color: #0d6efd;
    }



    .point-card:hover {
        transform: translateY(-5px);
    }

    .card-body p {
        font-size: 1.1rem;
        font-weight: 500;
    }

    .card-body small {
        color: #6c757d;
        display: block;
        margin-bottom: 1rem;
    }
</style>

<div class="">
    <div class="row">
        <!-- Card 1 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg point-card card-rounded p-3">
                <div class="card-body text-center">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="point-header"><i class="fas fa-solid fa-coins"></i> My Points</h5>
                        <div class="point-value"><?php echo $global_member_point ?></div>
                    </div>
                    <hr>
                    <p class="card-text">🔍 Discover more about your points</p>
                    <small>See how many points you've earned and how to redeem them for great rewards.</small>
                    <button class="btn btn-outline-primary mt-2 px-4 rounded-pill">Learn More</button>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg point-card p-3">
                <div class="card-body text-center">


                    <h5 class="card-title text-primary mb-3">🎉 Maximize Your Rewards!</h5>
                    <p class="card-text">
                        <strong>Keep booking rooms and enjoy even more stays!</strong> 🌟
                        The more you book, the more points you <span class="fw-bold text-success">earn</span>, and the bigger your <span class="fw-bold text-danger">discounts</span> get on future bookings!
                    </p>
                    <a href="./" class="btn btn-outline-primary outline mt-3 rounded-pill">Start Booking</a>
                </div>
            </div>
        </div>
    </div>


</div>

<h5><i class="fas fa-solid fa-coins mt-5 me-2"></i>Points History</h5>

<!-- Tab Navigation -->
<ul class="nav nav-tabs custom-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity"
            type="button" role="tab" aria-controls="activity" aria-selected="true">
            Activity
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="expired-tab" data-bs-toggle="tab" data-bs-target="#expired"
            type="button" role="tab" aria-controls="expired" aria-selected="false">
            Expired
        </button>
    </li>
</ul>

<!-- Tab Content -->
<div class="tab-content p-4 border border-top-0 rounded-bottom" style="box-shadow: 0 0 45px rgba(0, 0, 0, .08);" id="myTabContent">
    <div class="tab-pane fade show active" id="activity" role="tabpanel" aria-labelledby="activity-tab">
        <!-- Data will be dynamically loaded here -->
    </div>
    <div class="tab-pane fade" id="expired" role="tabpanel" aria-labelledby="expired-tab">
        <!-- Data will be dynamically loaded here -->
    </div>

</div>

<script>
    $(document).ready(function() {


        function loadFilteredData() {
            var activeTab = $('#myTab .nav-link.active').attr('id').split('-')[0]; // 'activity', 'expired', 'cancelled'

            $.ajax({
                url: 'ajax/memberMyPoint.php',
                method: 'POST',
                data: {
                    tab: activeTab
                },
                success: function(response) {
                    $('#' + activeTab).html(response);
                }
            });
        }

        // Trigger saat form disubmit
        $("#filterForm").submit(function(event) {
            event.preventDefault();
            loadFilteredData();
        });

        // Trigger saat tab berubah
        $('#myTab button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            loadFilteredData();
        });

        loadFilteredData();

    });
</script>
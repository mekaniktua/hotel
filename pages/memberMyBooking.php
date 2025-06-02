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
</style>

<!-- Filter Form -->
<div class="card mb-3" style="box-shadow: 0 0 45px rgba(0, 0, 0, .08);">
    <div class="card-body">
        <form id="filterForm" class="mb-4">
            <div class="row">
                <div class="col-md-4 mb-1">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date">
                </div>
                <div class="col-md-6 mb-1">
                    <label for="booking_id" class="form-label">Booking ID</label>
                    <input type="text" class="form-control" id="booking_id" name="booking_id">
                </div>
                <div class="col-md-2 d-flex align-items-end mb-1">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> </button> &nbsp;
                    <button type="button" class="btn btn-danger" id="btnRefresh"><i class="fa fa-refresh"></i> </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Tab Navigation -->
<ul class="nav nav-tabs nav-justified custom-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming"
            type="button" role="tab" aria-controls="upcoming" aria-selected="true">
            Upcoming
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed"
            type="button" role="tab" aria-controls="completed" aria-selected="false">
            Completed
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
    <div class="tab-pane fade show active" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
        <!-- Data will be dynamically loaded here -->
    </div>
    <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
        <!-- Data will be dynamically loaded here -->
    </div>
    <div class="tab-pane fade" id="expired" role="tabpanel" aria-labelledby="expired-tab">
        <!-- Data will be dynamically loaded here -->
    </div>
</div>

<script>
    $(document).ready(function() {
        // Refresh button
        $("#btnRefresh").click(function() {
            $('#filterForm')[0].reset(); // Reset form fields
            $("#filterForm").submit(); // Trigger filter again with empty fields
        });

        function loadFilteredData() {
            var startDate = $('#start_date').val();
            var bookingId = $('#booking_id').val();
            var activeTab = $('#myTab .nav-link.active').attr('id').split('-')[0]; // 'upcoming', 'completed', 'expired'

            $.ajax({
                url: 'ajax/memberMybooking.php',
                method: 'POST',
                data: {
                    start_date: startDate,
                    booking_id: bookingId,
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

        // Trigger otomatis saat halaman pertama kali dimuat
        $("#filterForm").submit(); // <--- Ini trigger otomatis saat document ready
    });
</script>
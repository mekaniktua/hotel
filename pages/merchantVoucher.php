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

<div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
           
            <div id="ajaxInfo"></div>
                 
        </div>
    </div>
</div>


<!-- Filter Form -->
<div class="card mb-3" style="box-shadow: 0 0 45px rgba(0, 0, 0, .08);">
    <div class="card-body">
        <form id="filterForm" class="mb-4">
            <div class="row">
                <div class="col-md-4 mb-1">
                    <label for="end_date" class="form-label">Valid Until</label>
                    <input type="date" class="form-control" id="end_date" name="end_date">
                </div>
                <div class="col-md-6 mb-1">
                    <label for="voucher_title" class="form-label">Voucher Title</label>
                    <input type="text" class="form-control" id="voucher_title" name="voucher_title">
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
<ul class="nav nav-tabs custom-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active"
            type="button" role="tab" aria-controls="active" aria-selected="true">
            Active
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
    <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
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
            var end_date = $('#end_date').val();
            var voucherTitle = $('#voucher_title').val();
            var activeTab = $('#myTab .nav-link.active').attr('id').split('-')[0]; // 'active', 'completed', 'expired'

            $.ajax({
                url: 'ajax/merchantVoucher.php',
                method: 'POST',
                data: {
                    end_date: end_date,
                    voucher_title: voucherTitle,
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

    function qrcode(x) {
        $.ajax({
            type: "POST",
            url: "ajax/merchantQrcode.php",
            data: {
                "v": x
            },
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
    }
</script>
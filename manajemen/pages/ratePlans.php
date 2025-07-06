<?php
$sProperty = "SELECT p.property_id, p.property_name
          FROM property p
          WHERE p.status_hapus='0'
          ORDER BY p.property_name ASC";
$qProperty = mysqli_query($conn, $sProperty) or die(mysqli_error($conn));



$sData = "  SELECT rt.room_type_id,rt.room_type
               FROM room_type rt
              WHERE rt.status_hapus='0'
              ORDER BY room_type asc";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));
?>

<div class="midde_cont">
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title">
                    <h2>Room Rate & Room Avability</h2>
                </div>
            </div>
        </div>
        <!-- row -->
        <div class="row column1">
            <div class="col-md-12 col-lg-12">
                <div class="full white_shd">
                    <div class="table_section padding_infor_info">
                        <form id="frmSearch" name="frmSearch" method="post"
                            class="form-inline mb-3 d-flex align-items-end flex-wrap gap-2">
                            <div class="form-group col-md-3">
                                <label class="mr-2">Property</label>
                                <select class="form-control select2_single" style="width:100%" name="pID" id="pID"
                                    required>
                                    <option value="">Select Property</option>
                                    <?php while ($rProperty = mysqli_fetch_array($qProperty)) { ?>
                                    <option value="<?php echo enkripsi($rProperty['property_id']); ?>">
                                        <?php echo $rProperty['property_name'];?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="mr-2">Room Type</label>
                                <select class="form-control select2_single" style="width:100%" name="rtID" id="rtID"
                                    required>
                                    <option value="">Select Room Type</option>
                                    
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="mr-2">Rate Type</label>
                                <select class="form-control select2_single" style="width:100%" id="rID" name="rID"
                                    required>
                                    <option value="">Select Rate Type</option>
                                </select>
                            </div>


                            <div class="form-group col-md-3">
                                <button type="submit" class="btn btn-success mr-2" id="btnSearch">
                                    <i class="fa fa-search"></i> Search
                                </button>
                                <button type="button" class="btn btn-primary" id="btnBulk">
                                    <i class="fa fa-edit"></i> Bulk Edit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="col-md-12 col-lg-12 mt-2">
                <div id="ajaxCalendar" class="mb-4"></div>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>

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
$(document).ready(function() {
    $(".select2_single").select2();

    // Helper function to load room names
    function loadRoomNames(rtID, targetElement) {
        if (!rtID) {
            $(targetElement).html('<option value="">Select Room</option>');
            return;
        }
        
        $(targetElement).html('<option>Loading...</option>');
        
        $.ajax({
            type: 'POST',
            url: 'ajax/getRoomName.php',
            data: { rtID: rtID },
            success: function(response) {
                $(targetElement).html(response);
            },
            error: function() {
                $(targetElement).html('<option value="">Error loading data</option>');
            }
        });
    }

    // Property change handler
    $('#pID').on('change', function() {
        var pID = $(this).val();
        
        if (!pID) {
            $('#rtID').html('<option value="">Select Room Type</option>');
            $('#rID').html('<option value="">Select Room</option>');
            return;
        }
        
        $('#rtID').html('<option>Loading...</option>');
        $('#rID').html('<option value="">Select Room</option>');

        $.ajax({
            type: 'POST',
            url: 'ajax/getRoomType.php',
            data: { pID: pID },
            success: function(response) {
                $('#rtID').html(response);
                // Load room names for the first room type if available
                var firstRtID = $('#rtID option:first').val();
                if (firstRtID && firstRtID !== '') {
                    loadRoomNames(firstRtID, '#rID');
                }
            },
            error: function() {
                $('#rtID').html('<option value="">Error loading data</option>');
                $('#rID').html('<option value="">Select Room</option>');
            }
        });
    });

    // Room type change handler
    $('#rtID').on('change', function() {
        var rtID = $(this).val();
        loadRoomNames(rtID, '#rID');
    });
});

$("#frmSearch").submit(function(e) {
    e.preventDefault();
    getCalendar();
});

$("#btnBulk").click(function(e) {
    var pID = $('#pID').val();
    var rtID = $('#rtID').val();
    var rID = $('#rID').val();
    
    // Validate rtID and rID
    if (!pID || pID === '') {
        alert('Please select property');
        return false;
    }
    if (!rtID || rtID === '') {
        alert('Please select room type');
        return false;
    }
    
    if (!rID || rID === '') {
        alert('Please select room');
        return false;
    }
    
    $.ajax({
        url: 'ajax/ratePlansBulk.php',
        type: 'POST',
        data: {
            rtID: rtID,
            rID: rID
        },
        beforeSend: function() {
            $.blockUI({
                message: '<h5><img src="images/loading.gif" width="50px" /> Please wait</h5>'
            });
        },
        success: function(data) {
            $("#ajaxCalendar").html(data);
        },
        complete: function() {
            $.unblockUI();
        }
    });
});


// Error itu biasanya muncul dari FullCalendar saat memanggil failureCallback tanpa parameter error object.
// Perbaiki bagian error callback di events agar mengirim error object ke failureCallback.

function initCalendar() {
    var calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            editable: true,
            events: function(fetchInfo, successCallback, failureCallback) {
                $.ajax({
                    url: 'ajax/getRatePlans.php',
                    type: 'POST',
                    data: {
                        rtID: $('#rtID').val(),
                        rID: $('#rID').val()
                    },
                    success: function(data) {
                        successCallback(data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        failureCallback({
                            message: errorThrown || textStatus
                        });
                    }
                });
            },
            selectable: true,
            headerToolbar: {
                left: 'title',
                right: 'prevYear,prev,next,nextYear,today'
            },
            buttonText: {
                listMonth: 'List Month',
                listYear: 'List Year'
            },
            select: function(info) {
                var existingEvents = calendar.getEvents().filter(function(event) {
                    return event.startStr === info.startStr;
                });

                if (existingEvents.length === 0) {
                    $("#frmSave")[0].reset();
                    $("#eventDate").val(info.startStr);
                    $("#addEventModal").modal('show');
                }
            },
            eventClick: function(info) {
                if (!info.jsEvent.target.classList.contains('delete-event-icon')) {
                    var selectedDate = info.event.startStr;
                    var rate_plan_id = info.event.id;
                    var price = info.event.extendedProps.price;
                    var total_room = info.event.extendedProps.total_room;
                    var rate_type = info.event.extendedProps.rate_type;
                    var booked = info.event.extendedProps.booked;
                    $("#rpID").val(rate_plan_id);
                    $("#eventDate").val(selectedDate);
                    $("#price").val(price);
                    $("#total_room").val(total_room);
                    $("#rate_type").val(rate_type);
                    $("#booked").val(booked);
                    $("#addEventModal").modal('show');
                }
            },
            eventDrop: function(info) {
                if (confirm("Are you sure about to move this event?")) {
                    $.post("editevent.php", {
                        event_id: info.event.id,
                        start: info.event.startStr
                    }, function() {
                        calendar.refetchEvents();
                        $("#event-action-response").text("Event moved Successfully").show();
                    });
                } else {
                    info.revert();
                }
            }
        });
        calendar.render();
    }
}





function getCalendar() {
    $.ajax({
        url: 'ajax/ratePlans.php',
        type: 'POST',
        data: {
            rtID: $('#rtID').val(),
            rID: $('#rID').val()
        },
        beforeSend: function() {
            $.blockUI({
                message: '<h5><img src="images/loading.gif" width="50px" /> Please wait</h5>'
            });
        },
        success: function(data) {
            $("#ajaxCalendar").html(data);
            initCalendar(); // inisialisasi calendar setelah konten dimuat
        },
        complete: function() {
            $.unblockUI();
        }
    });
}
</script>
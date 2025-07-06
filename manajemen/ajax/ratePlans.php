<?php
session_start();
include("../database.php");

$room_type_id = dekripsi(amankan($_POST['rtID']));
$room_id = dekripsi(amankan($_POST['rID'])); 

// Use prepared statements to prevent SQL injection and optimize queries
$stmt = mysqli_prepare($conn, "SELECT rt.room_type, r.room_name,rt.property_id 
                               FROM room_type rt 
                               JOIN room r ON r.room_type_id = rt.room_type_id 
                               WHERE rt.status_hapus = '0' 
                               AND r.status_hapus = '0' 
                               AND rt.room_type_id = ? 
                               AND r.room_id = ?");
mysqli_stmt_bind_param($stmt, "ss", $room_type_id, $room_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$rType = mysqli_fetch_assoc($result);
$room_type = $rType['room_type'];
$room_name = $rType['room_name'];
$property_id = $rType['property_id'];
mysqli_stmt_close($stmt);

?>



    <style>
        h1#demo-title {
            margin: 30px 0px 80px 0px;
            text-align: center;
        }

        table tr {
            position: relative;
        }

        #event-action-response {
            background-color: #c4c6fb;
            border: #0ab53f 1px solid;
            padding: 10px 20px;
            border-radius: 3px;
            margin-bottom: 15px;
            color: #333;
            display: none;
        }

        .fc-day-grid-event .fc-content {
            background: #617cff;
            color: #FFF;
            margin-bottom: 4px;
            padding: 3px;
            border-radius: 5px;

        }

        /* .fc-event,
        .fc-event-dot {
            background-color: #586e75;
        } */

        .fc-event,
        .fc-event-dot {
            background-color: #ededed;
        }

        .fc-event {
            border: 1px solid #fff;
        }

        .delete-event-icon {
            position: absolute;
            top: 1px;
            right: 3px;
            cursor: pointer;
            z-index: 9;
            color: white;
            background: #ff5252;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            text-align: center;
            line-height: 20px;
        }

        /*Right modal*/
        .modal.left_modal .modal-dialog,
        .modal.right_modal .modal-dialog {
            position: fixed;
            margin: auto;
            width: 32%;
            height: 100vh;
            -webkit-transform: translate3d(0%, 0, 0);
            -ms-transform: translate3d(0%, 0, 0);
            -o-transform: translate3d(0%, 0, 0);
            transform: translate3d(0%, 0, 0);
        }

        .right_modal .modal-content {
            height: 100%;
        }
        .modal.right_modal.fade .modal-dialog {
            right: -50%;
            -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
            -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
            -o-transition: opacity 0.3s linear, right 0.3s ease-out;
            transition: opacity 0.3s linear, right 0.3s ease-out;
        }
        .modal.right_modal.fade.show .modal-dialog {
            right: 0;
            box-shadow: 0px 0px 19px rgba(0, 0, 0, .5);
        }

        /* ----- MODAL STYLE ----- */
        .modal-content {
            border-radius: 0;
            border: none;
        }

        .modal-header.left_modal,
        .modal-header.right_modal {

            padding: 10px 15px;
            border-bottom-color:
                #EEEEEE;
            background-color:
                #FAFAFA;
        }
        .modal_outer .modal-body {
            /*height:90%;*/
            overflow-y: auto;
            overflow-x: hidden;
            height: 91vh;
        }

        .fc-event-desc,
        .fc-event-title {
        white-space: break-spaces;
        }
    </style>  



    <div class="full white_shd">
        <div class="container mt-4 mb-4" style="width:100%"> 
            <div id="event-action-response"></div>
            <div id="calendar"></div>
            <b>Information</b>
            <div id="calendarLegend" style="margin-top:10px;">
                <span style="background:#4CAF50; color:#FFF; padding:5px 10px; border-radius:4px; margin-right:5px;">Regular</span> 
                <span style="background:#FF9800; color:#FFF; padding:5px 10px; border-radius:4px; margin-right:5px;">Promo</span>
                <span style="background:#c0a751; color:#FFF; padding:5px 10px; border-radius:4px; margin-right:5px;">Weekend</span>  
                <span style="background:#9C27B0; color:#FFF; padding:5px 10px; border-radius:4px; margin-right:5px;">High Season</span> 
                <span style="background:#F44336; color:#FFF; padding:5px 10px; border-radius:4px; margin-right:5px;">Closed</span>
                <span style="background:#CCCCCC; color:#FFF; padding:5px 10px; border-radius:4px; margin-right:5px;">Full Booked</span>
            </div>
        </div>
    </div> 




    <!-- Display event details in a modal -->
    
    <div class="modal modal_outer right_modal fade " id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEventModalLabel">SET NEW PRICE</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmSave" method="post">
                        <div class="form-group">
                            <label for="price">Room Type</label>
                            <input type="hidden" class="form-control" id="rpID" name="rpID"><!--Ambil dari event click-->
                            <input type="hidden" value="<?php echo enkripsi($property_id)?>" class="form-control" id="pID" name="pID">
                            <input type="hidden" value="<?php echo enkripsi($room_type_id)?>" class="form-control" id="rtID" name="rtID">
                            <input type="text" value="<?php echo $room_type;?>" class="form-control" id="room_type" name="room_type" disabled>
                        </div>
                        <div class="form-group">
                            <label for="price">Room Name</label>
                            <input type="hidden" value="<?php echo enkripsi($room_id)?>" class="form-control" id="rID" name="rID">
                            <input type="text" value="<?php echo $room_name;?>" class="form-control" id="room_name" name="room_name" disabled>
                        </div>
                        <div class="form-group">
                            <label for="eventDate">Date</label>
                            <input type="date" class="form-control" id="eventDate" name="eventDate" required>
                        </div>

                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>

                        <div class="form-group">
                            <label for="total_room">Total Room</label>
                            <input type="number" class="form-control" id="total_room" name="total_room" required>
                        </div>

                        <div class="form-group">
                            <label for="total_room">Total Booked</label>
                            <input type="number" class="form-control" id="booked" name="booked" disabled>
                        </div>

                        <div class="form-group">
                            <label for="rate_type">Rate Type</label>
                            <select name="rate_type" id="rate_type" class="form-control select2_single">
                                <option value="Regular">Regular</option>
                                <option value="Promo">Promo</option>
                                <option value="Weekend">Weekend</option>
                                <option value="HighSeason">High Season</option>
                                <option value="Closed">Closed</option>
                            </select>
                        </div>
                       
                        <button type="submit" class="btn btn-success"><i class='fa fa-save'></i> Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

 
    
    <script>
    $("#frmSave").submit(function(e) {
        e.preventDefault();
        var frm = $('#frmSave')[0];
        var formData = new FormData(frm);

        $.ajax({
            type: "POST",
            url: "ajax/ratePlanSave.php",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $.blockUI({
                message: '<h5><img src="images/loading.gif" width="50px" /> Please wait</h5>'
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

 
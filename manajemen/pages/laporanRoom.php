<?php 

$sProperty = "  SELECT p.* FROM property p 
              WHERE p.status_hapus='0'";
$qProperty = mysqli_query($conn, $sProperty) or die(mysqli_error($conn));

$sRoomType = "  SELECT r.* FROM room_type r 
              WHERE r.status_hapus='0'";
$qRoomType = mysqli_query($conn, $sRoomType) or die(mysqli_error($conn));

$sRoom = "  SELECT r.* FROM room r 
              WHERE r.status_hapus='0'";
$qRoom = mysqli_query($conn, $sRoom) or die(mysqli_error($conn));

?>

<div class="midde_cont">
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title">
                    <h2>Room Report</h2>
                </div>
            </div>
        </div>
        <!-- row -->
        <div class="row column1">
            <div class="col-md-12 col-lg-12">
                <div class="full white_shd margin_bottom_30">
                    <div class="table_section padding_infor_info">
                        <form id="frmCari" name="frmCari" method="post">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="pID" class="form-label">PROPERTY</label><br />
                                    <select name="pID" id="pID" class="form-control select2_single">
                                        <option value="">Select Property</option>
                                        <?php while ($rProperty = mysqli_fetch_array($qProperty)) { ?>
                                        <option value="<?php echo enkripsi($rProperty['property_id']); ?>">
                                            <?php echo $rProperty['property_name'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="roomTypeID" class="form-label">Room Type</label><br />
                                    <select name="roomTypeID" id="roomTypeID" class="form-control select2_single">
                                        <option value="">Select Room Type</option>
                                         
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="roomID" class="form-label">Room Name</label><br />
                                    <select name="roomID" id="roomID" class="form-control select2_single">
                                        <option value="">Select Room</option>
                                         
                                    </select>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">PERIODE</label>
                                    <div class="row gx-2 align-items-end">
                                        <div class="col-md-5">
                                            <input type="text" name="tanggalAwal" class="form-control datepicker"
                                                placeholder="Tanggal Awal" required>
                                        </div>
                                        <div class="col-auto d-flex align-items-center">
                                            <span>-</span>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" name="tanggalAkhir" class="form-control datepicker"
                                                placeholder="Tanggal Akhir" required>
                                        </div>
                                        <div class="col-md-auto">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fa fa-search"></i> Search
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

                <div id="ajaxTransaksi"></div>


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

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });

    // Property change event - load room types
    $("#pID").change(function() {
        var propertyID = $(this).val();
        
        // Reset room type and room selects
        $("#roomTypeID").html('<option value="">Select Room Type</option>');
        $("#roomID").html('<option value="">Select Room</option>');
        
        if (propertyID != "") {
            $.ajax({
                type: "POST",
                url: "ajax/getRoomType.php",
                data: { pID: propertyID },
                success: function(data) {
                    $("#roomTypeID").html('<option value="">Select Room Type</option>' + data);
                    $("#roomTypeID").trigger('change');
                }
            });
        }
    });

    // Room Type change event - load rooms
    $("#roomTypeID").change(function() {
        var roomTypeID = $(this).val();
        
        // Reset room select
        $("#roomID").html('<option value="">Select Room</option>');
        
        if (roomTypeID != "") {
            $.ajax({
                type: "POST",
                url: "ajax/getRoomName.php",
                data: { rtID: roomTypeID },
                success: function(data) {
                    $("#roomID").html('<option value="">Select Room</option>' + data);
                }
            });
        }
    });
});
$("#frmCari").submit(function(e) {
    e.preventDefault(e);
    var frm = $('#frmCari')[0];
    var formData = new FormData(frm);
    $.ajax({
        type: "POST",
        url: "ajax/laporanRoom.php",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
            $.blockUI({
                message: '<h5><img src="images/loading.gif" width="50px" /> Please wait</h5>'
            });
        },
        success: function(data) {
            //  $("#modalInfo").modal('show');
            $("#ajaxTransaksi").html(data);
        },
        complete: function() {
            $.unblockUI();
        }
    });
});
</script>
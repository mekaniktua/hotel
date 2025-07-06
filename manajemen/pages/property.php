<?php
$sData = "  SELECT * FROM property 
            WHERE (status_hapus is null or status_hapus='0')";
$qData = mysqli_query($conn, $sData) or die(mysqli_error($conn));

?>

<div class="midde_cont">
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title">
                    <h2>Data Properties</h2>
                </div>
            </div>
        </div>
        <!-- row -->
        <div class="row column1">
            <div class="col-md-12 col-lg-12">
                <div class="full white_shd margin_bottom_30">
                    <div class="table_section padding_infor_info">
                        <div class="pull-right" style="padding-bottom: 10px;">
                            <!-- <button type="button" onclick="baru()" class="btn btn-primary"><i class="fa fa-building-plus"></i> Tambah New</button> -->
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped" id="datatable">
                                <thead>
                                    <tr>
                                        <th width="5%">&nbsp;</th>
                                        <th>PHOTO</th>
                                        <th>PROPERTY</th>
                                        <th>TELP</th>
                                        <th>EMAIL</th>
                                        <th>CITY</th>
                                        <th>ADDRESS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  $i = 0; while ($rData = mysqli_fetch_array($qData)) {
                                        $i++ ?>
                                    <tr>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-success dropdown-toggle" type="button"
                                                    id="menuProperti" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="menuProperti">
                                                    <a class="dropdown-item"
                                                        onclick="edit('<?php echo enkripsi($rData['property_id']); ?>')"
                                                        href="#">Property Edit</a>
                                                    <a class="dropdown-item"
                                                        onclick="roomType('<?php echo enkripsi($rData['property_id']); ?>')"
                                                        href="#">Room Type</a>
                                                    <a class="dropdown-item" href="#"
                                                        onclick="hapus('<?php echo enkripsi($rData['property_id']); ?>')">Delete
                                                        Property</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 100px;"><img
                                                src="<?php echo (!empty($rData['property_url']) ? "../".$rData['property_url'] : "images/no_image.png"); ?>"
                                                height="50px"></td>
                                        <td><?php echo $rData['property_name']; ?></td>
                                        <td><?php echo $rData['telp']; ?></td>
                                        <td><?php echo $rData['email']; ?></td>
                                        <td><?php echo $rData['city']; ?></td>
                                        <td><?php echo $rData['address']; ?></td>
                                    </tr>
                                    <?php }; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
    $('#datatable').DataTable({
        // dom: '<"container-fluid"<"row"<"col"B><"col"l><"col"f>>>rtip',
        // buttons: [
        //    'print', 'excel'
        // ],
        lengthMenu: [50, 100, 200, 500]
    });
});

function roomType(x) {
    window.open("?menu=roomType&prID=" + x, "_self");
}

function dataRoom(x) {
    window.open("?menu=room&prID=" + x, "_self");
}

function edit(x) {
    window.open("?menu=propertyEdit&prID=" + x, "_self");
}

function hapus(x) {
    if (confirm("Are you sure you want to delete this data?")) {
        $.ajax({
            type: 'POST',
            url: 'ajax/propertyDelete.php',
            data: {
                'prID': x
            },
            beforeSend: function() {
                // setting a timeout
                $.blockUI({
                    message: '<img src="images/loading.gif" width="50" /> Please wait...'
                });
            },
            success: function(data) {
                $("#modalInfo").modal('show');
                $("#ajaxInfo").html(data);
            },
            complete: function() {
                $.unblockUI();
            },
        })
    }
}
</script>
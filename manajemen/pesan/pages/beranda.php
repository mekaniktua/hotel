<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Dashboard</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge" id="ajaxHitungPesan"></div>
                        <div>Pesan terkirim</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">Lihat Detail</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge" id="ajaxHitungPelanggan"></div>
                        <div>Pelanggan</div>
                    </div>
                </div>
            </div>
            <a href="?t=pelanggan">
                <div class="panel-footer">
                    <span class="pull-left">Lihat Detail</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge" id="ajaxHitungGrup"></div>
                        <div>Grup Pelanggan</div>
                    </div>
                </div>
            </div>
            <a href="?t=grup">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-8">

        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-envelope fa-fw"></i> 10 Pesan Terakhir

            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="ajaxPesanTerakhir"></div>
                    </div>

                </div>
                <!-- /.row -->
            </div>
            <!-- /.panel-body -->
        </div>

        <!-- /.panel -->
    </div>
    <!-- /.col-lg-8 -->
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bell fa-fw"></i> 10 Pelanggan Terakhir
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div id="ajaxPelangganTerakhir"> </div>
                <!-- /.list-group -->
                <a href="?t=pelanggan" class="btn btn-default btn-block">Lihat Semua</a>
            </div>
            <!-- /.panel-body -->
        </div>

    </div>
    <!-- /.col-lg-4 -->
</div>
<!-- /.row -->

<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            dom: '<"container-fluid"<"row"<"col"B><"col"l><"col"f>>>rtip',
            buttons: [
                // 'print', 'excel'
            ],
            lengthMenu: [50, 100, 200, 500],
            order: [
                [1, 'desc']
            ]
        });

        hitungPelanggan();
        hitungGrup();
        hitungPesan();
        pesanTerakhir();
        pelangganTerakhir();
    });

    function hitungPesan() {
        $.ajax({
            type: "POST",
            url: "ajax/hitungPesan.php",
            data: {
                'gID': '<?php echo enkripsi($grup_id); ?>'
            },
            beforeSend: function() {
                $.blockUI({
                    message: '<h5><img src="images/loading.gif" width="50px" /> Please wait</h5>'
                });
            },
            success: function(data) {
                $("#ajaxHitungPesan").html(data);

            },
            complete: function() {
                $.unblockUI();
            }
        });
    }

    function hitungPelanggan() {
        $.ajax({
            type: "POST",
            url: "ajax/hitungPelanggan.php",
            data: {
                'gID': '<?php echo enkripsi($grup_id); ?>'
            },
            beforeSend: function() {
                $.blockUI({
                    message: '<h5><img src="images/loading.gif" width="50px" /> Please wait</h5>'
                });
            },
            success: function(data) {
                $("#ajaxHitungPelanggan").html(data);

            },
            complete: function() {
                $.unblockUI();
            }
        });
    }

    function hitungGrup() {
        $.ajax({
            type: "POST",
            url: "ajax/hitungGrup.php",
            data: {
                'gID': '<?php echo enkripsi($grup_id); ?>'
            },
            beforeSend: function() {
                $.blockUI({
                    message: '<h5><img src="images/loading.gif" width="50px" /> Please wait</h5>'
                });
            },
            success: function(data) {
                $("#ajaxHitungGrup").html(data);

            },
            complete: function() {
                $.unblockUI();
            }
        });
    }

    function pesanTerakhir() {
        $.ajax({
            type: "POST",
            url: "ajax/pesanTerakhir.php",
            data: {
                'gID': '<?php echo enkripsi($grup_id); ?>'
            },
            beforeSend: function() {
                $.blockUI({
                    message: '<h5><img src="images/loading.gif" width="50px" /> Please wait</h5>'
                });
            },
            success: function(data) {
                $("#ajaxPesanTerakhir").html(data);

            },
            complete: function() {
                $.unblockUI();
            }
        });
    }

    function pelangganTerakhir() {
        $.ajax({
            type: "POST",
            url: "ajax/pelangganTerakhir.php",
            data: {
                'gID': '<?php echo enkripsi($grup_id); ?>'
            },
            beforeSend: function() {
                $.blockUI({
                    message: '<h5><img src="images/loading.gif" width="50px" /> Please wait</h5>'
                });
            },
            success: function(data) {
                $("#ajaxPelangganTerakhir").html(data);

            },
            complete: function() {
                $.unblockUI();
            }
        });
    }
</script>
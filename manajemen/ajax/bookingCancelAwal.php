<?php
session_start();
include("../database.php");

$booking_id = amankan(dekripsi($_POST['bID']));
?>

<form id="frmCancel" method="post">
  <div class="row">

    <div class="col-md-12 mb-3">
      <input type="hidden" class="form-control" id="bID" name="bID" value="<?php echo enkripsi($booking_id) ?>" required>
      <label for="description" class="form-label">Description/ Reason</label>
      <input type="text" class="form-control" id="description" name="description" required>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-success">
        <i class="fa fa-save"></i> Save
      </button>
    </div>
  </div>
</form>

<script>
  $(document).ready(function() {
    $("#frmCancel").on("submit", function(e) {
      e.preventDefault();
      var formData = new FormData(this);

      $.ajax({
        type: "POST",
        url: "ajax/bookingCancel.php",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
          $.blockUI({
            message: '<h5><img src="images/loading.gif" width="50px" /> Please wait</h5>'
          });
        },
        success: function(data) {
          $("#ajaxInfo").html(data);

        },
        complete: function() {
          $.unblockUI();
        },
      });
    });
  });
</script>
<div class="container-xxl my-4">
   <h2 class="mb-4">Dashboard</h2>
   <div id="ajaxDashboardCard" class="mb-3"></div>

   <div class="row g-4 mb-3">
      <div class="col-md-9">
         <div id="ajaxUpcomingBook"></div>
      </div>
      <div class="col-md-3">
         <div id="ajaxSideCard"></div>
      </div>
   </div>
   <div class="row g-4 mb-3">
      <div class="col-md-12">
         <div id="ajaxDashboardLine"></div>
      </div>
   </div>
</div>

<script>
   $(document).ready(function() {
      card();
      upcoming();
      dashboardLine();
   });

   function card() {
      $.ajax({
         type: "POST",
         url: "ajax/dashboardCard.php",
         data: {
            "id": ""
         },
         beforeSend: function() {
            $.blockUI({
               message: '<p><img src="images/loading.gif" width="50" /> Please wait</p>'
            });
         },
         success: function(data) {
            $("#ajaxDashboardCard").html(data);

         },
         complete: function() {
            $.unblockUI();
         }
      });
   }

   function upcoming() {
      $.ajax({
         type: "POST",
         url: "ajax/upcomingBook.php",
         data: {
            "id": ""
         },
         processData: false,
         contentType: false,
         beforeSend: function() {
            $.blockUI({
               message: '<p><img src="images/loading.gif" width="50" /> Please wait</p>'
            });
         },
         success: function(data) {
            $("#ajaxUpcomingBook").html(data);

         },
         complete: function() {
            $.unblockUI();
         }
      });
   }

   function dashboardLine() {
      $.ajax({
         type: "POST",
         url: "ajax/dashboardLine.php",
         data: {
            "id": ""
         },
         processData: false,
         contentType: false,
         beforeSend: function() {
            $.blockUI({
               message: '<p><img src="images/loading.gif" width="50" /> Please wait</p>'
            });
         },
         success: function(data) {
            $("#ajaxDashboardLine").html(data);

         },
         complete: function() {
            $.unblockUI();
         }
      });
   }
</script>
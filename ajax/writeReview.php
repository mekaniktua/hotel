<?php
session_start();
include("../manajemen/database.php");

$booking_id = dekripsi(amankan($_POST['bID']));
$member_id = dekripsi(amankan($_POST['mID']));
?>

<style>
  .star {
    font-size: 4rem;
    color: gray;
    cursor: pointer;
  }
  .star.selected {
    color: gold;
  }
</style>

<div class="container mt-2 text-center"> 
  <input type="hidden" id="mID" value="<?php echo amankan($_POST['mID']); ?>">
  <input type="hidden" id="bID" value="<?php echo amankan($_POST['bID']); ?>">
  <div id="stars" class="mb-3">
    <span class="star" data-value="1">&#9733;</span>
    <span class="star" data-value="2">&#9733;</span>
    <span class="star" data-value="3">&#9733;</span>
    <span class="star" data-value="4">&#9733;</span>
    <span class="star" data-value="5">&#9733;</span>
  </div>
  <textarea class="form-control mb-1" id="reviewText" rows="4" placeholder="Write a review..." maxlength="500"></textarea>
  <div class="text-end mb-3"><small id="charCount">0/500</small></div>
  <button class="btn btn-primary" onclick="submitReview()">Send</button>
</div>

<script>
  $(document).ready(function() {
    let rating = 0;

    $('.star').click(function() {
      rating = $(this).data('value');
      updateStars(rating);
    });

    function updateStars(rating) {
      $('.star').removeClass('selected');
      $('.star').each(function() {
        if ($(this).data('value') <= rating) {
          $(this).addClass('selected');
        }
      });
    }

    $('#reviewText').on('input', function() {
      const len = $(this).val().length;
      $('#charCount').text(len + '/500');
    });

    window.submitReview = function() {
      let reviewText = $('#reviewText').val();
      if (reviewText.length > 500) {
        alert('Review maksimal 500 karakter');
        return;
      }

      if(confirm("Are you sure want to send this review?")){
        $.ajax({
          type: 'POST',
          url: 'ajax/writeReviewSave.php',
          data: {
            mID: $('#mID').val(),
            bID: $('#bID').val(),
            stars: rating,
            reviewText: reviewText
          },
          beforeSend: function() {
            $.blockUI({
              message: "<img src='img/loading.gif' width='50' /> Please wait..."
            });
          },
          success: function(data) {
            $('#ajaxReview').html(data);
          },
          complete: function() {
            $.unblockUI();
          }
        });
      }
    }
  });
</script>

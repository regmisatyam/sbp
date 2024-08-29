$(document).ready(function() {
    var offset = 3;
    var limit = 3; // Number of posts to load per request

    // Load more posts when "Load More" button is clicked
    $("#loadMoreBtn").click(function() {
         // Disable the button to prevent multiple clicks
        $(this).prop('disabled', true);

        $.ajax({
            url: "sbp-contents/load-more.php",
            method: "GET",
            data: { offset: offset, limit: limit },
            success: function(response) {
                $("#postList").append(response);
                offset += limit; // Update offset for next request

                 // Re-enable the button after posts are loaded
                $("#loadMoreBtn").prop('disabled', false);
            }
        });
    });
});

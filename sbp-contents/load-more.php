<?php

// Database connection and functions for getting interval and time ago
include '../sbp-admin/credentials.php';
include 'globalVar.php';

// Retrieve offset and limit from AJAX request or set default values
$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
$limit = isset($_GET['limit']) ? $_GET['limit'] : 3;

// Sanitize input to prevent SQL injection
$offset = intval($offset); // Convert to integer
$limit = intval($limit); // Convert to integer

// Retrieve additional posts from the database based on offset and limit
$sql_bp = "SELECT * FROM sbp_posts ORDER BY id DESC LIMIT $offset, $limit";

$result_bp = $conn->query($sql_bp);
if ($result_bp) {
    if ($result_bp->num_rows > 0) {
        // Loop through each additional trending post
        while ($row_bp = $result_bp->fetch_assoc()) {

            echo '<div class="col-lg-4">';
            echo '<div class="single-bottom mb-35">';
            echo '<div class="trend-bottom-img mb-30"><img src="'.$imgUploads.'/' . $row_bp['image'] . ' "  alt="'. $row_bp['post_title'] .'"> </div>';
            echo '<div class="trend-bottom-cap">';
            echo '<span class="color1"><a href="'.$website.'/'.'category/' . $row_bp['post_category'] . '/">' . $row_bp['post_category'] . '</a></span> <span class="color3"><a href="'.$website.'/'.'author/' . $row_bp['author'] . '/"><i class="fas fa-user"></i> ' . $row_bp['author'] . '</a></span>';
            echo ' <h4><a href="'.$website.'/' . $row_bp['post_category'] . '/' . $row_bp['slug'] . '/">' . $row_bp['post_title'] . '</a></h4>';
            echo '  </div> ';
            echo ' </div>';
            echo ' </div>';
        }
    } else {
        echo "<script>alert('All Caught Up!')</script>";
    }
} else {
    // Handle query execution error
    echo "Error: " . $conn->error;
}
?>

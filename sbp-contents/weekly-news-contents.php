<div class="weekly-news-area pt-50">
    <div class="container">
        <div class="weekly-wrapper">
            <!-- section Tittle -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-tittle mb-30">
                        <h3>Weekly Top Posts</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="weekly-news-active dot-style d-flex dot-style">

                     <?php
                        // Retrieve data from the database 
                        $sql_wnc = "SELECT * FROM sbp_posts ORDER BY RAND() LIMIT 5";
                        $result_wnc = $conn->query($sql_wnc);
                        if ($result_wnc->num_rows > 0) {
                            $first = true; // Flag to track the first iteration
                            // Loop through each additional trending post
                            while ($row_wnc = $result_wnc->fetch_assoc()) {
                                echo '<div class="weekly-single' . ($first ? ' active' : '') . '">';
                                echo '<div class="weekly-img">';
                                echo '<img src="'.$imgUploads.'/' . $row_wnc['image'] . ' "  alt="'. $row_wnc['post_title'] .'"> </div>';
                                echo '<div class="weekly-caption">';
                                echo '<span class="color2"><a href="'.$website.'/'.'category/' . $row_wnc['post_category'] . '/">' . $row_wnc['post_category'] . '</a></span>';
                                echo ' <h4><a href="'.$website.'/' . $row_wnc['post_category'] . '/' . $row_wnc['slug'] . '/">' . $row_wnc['post_title'] . '</a></h4>';
                                echo '</div>';
                                echo '</div>';
                                $first = false; // Set the flag to false after the first iteration
                            }
                        } else {
                            echo "";
                        }
                        ?>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-50">
        
                            <!-- Trending Bottom -->
                        <div class="trending-bottom">
                        <div class="section-title mb-30">
                        <h3>All Posts</h3>
                        </div>
                            <div class="row">
                                
 <?php
                            // Retrieve data from the database 
                            $sql_bp = "SELECT * FROM sbp_posts";
                            $result_bp = $conn->query($sql_bp);
                            if ($result_bp->num_rows > 0) {
                                // Loop through each additional trending post
                                while ($row_bp = $result_bp->fetch_assoc()) {
                                    $interval = getInterval($row_bp["post_date"]);
                                    $timeAgo = getTimeAgo($interval);

                                    echo '<div class="col-lg-4">';
                                    echo '<div class="single-bottom mb-35">';
                                    echo '<div class="trend-bottom-img mb-30"><img src="assets/img/trending/digital twin.jpeg" alt=""> </div>';
                                    echo '<div class="trend-bottom-cap">';
                                    echo '<span class="color1"><a href="/category/' . $row_bp['post_category'] . '/">' . $row_bp['post_category'] . '</a></span> <span class="color3"><a href="/author/' . $row_bp['author'] . '/"><i class="fas fa-user"></i> ' . $row_bp['author'] . '</a></span>';
                                    echo ' <h4><a href="/' . $row_bp['post_category'] . '/' . $row_bp['slug'] . '/">' . $row_bp['post_title'] . '</a></h4>';
                                    echo '  </div> ';
                                    echo ' </div>';
                                    echo ' </div>';
                                }
                            } else {
                                echo "<div class='col-lg-12'>No additional posts available. Start with writing Blog Post!</div>";
                            }
                            ?>
                            </div>
                        </div>
</div>

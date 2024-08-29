<div class="trending-area fix">
    <div class="container">
        <div class="trending-main">
            <!-- Trending Tittle -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="trending-tittle">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <!-- Trending Top -->
                    <div class="trending-top mb-30">
                        <div class="trend-top-img">
                            <?php
                            
                            // Retrieve data from the database
                            $sql_main = "SELECT * FROM sbp_posts ORDER BY RAND() LIMIT 1";
                            $result_main = $conn->query($sql_main);
                            if ($result_main->num_rows > 0) {
                                

                                // Output data of the main trending post
                                $row_main = $result_main->fetch_assoc();
                                $mainPostDate = new DateTime($row_main["date"]);
                                $mainPostNow = new DateTime();
                                $mainPostInterval = $mainPostNow->diff($mainPostDate);
                                $mainPostTimeAgo = getTimeAgo($mainPostInterval);
                                
                                
                                echo '<img src="'.$imgUploads.'/' . $row_main['image'] . '" alt=""> <div class="trend-top-cap">
                                        <span>' . $row_main['post_category'] . '</span>
                                        <h2><a href="'. $website .'/' . $row_main['post_category'] . '/' . $row_main['slug'] . '/">' . $row_main['post_title'] . '</a></h2>
                                        <span class="authorSpan"><a href="'. $website .'/'.'author/' . $row_main['author'] . '/"><i class="fas fa-user"></i> ' . $row_main['author'] . '</a></span> <span class="authorSpan"><i class="fas fa-calendar"></i> &nbsp;' . $mainPostTimeAgo . '</span>
                                    </div>';
                            } else {
                                echo "No post available. Start with writing Blog!";
                            }
                            ?>
                        </div>
                    </div>
                    <!-- Trending Bottom -->
                    <div class="trending-bottom">
                        <div class="row">
                            <?php
                            // Retrieve data from the database 
                            $sql_additional = "SELECT * FROM sbp_posts";
                            if (isset($row_main['id'])) {
                                $sql_additional .= " WHERE id != {$row_main['id']}";
                            }
                            $sql_additional .= " ORDER BY RAND() LIMIT 3"; // Exclude the main trending post and order randomly
                            $result_additional = $conn->query($sql_additional);
                            if ($result_additional->num_rows > 0) {
                                // Loop through each additional trending post
                                while ($row_additional = $result_additional->fetch_assoc()) {
                                    $interval = getInterval($row_additional["date"]);
                                    $timeAgo = getTimeAgo($interval);

                                    echo '<div class="col-lg-4">';
                                    echo '<div class="single-bottom mb-35">';
                                    echo '<div class="trend-bottom-img mb-30"><img src="'.$imgUploads.'/' . $row_additional['image'] . ' "  alt="'. $row_additional['post_title'] .'"> </div>';
                                    echo '<div class="trend-bottom-cap">';
                                    echo '<span class="color2"><a href="'. $website .'/'.'category/' . $row_additional['post_category'] . '/">' . $row_additional['post_category'] . '</a></span> <span class="color3"><a href="'. $website .'/'.'author/' . $row_additional['author'] . '/"><i class="fas fa-user"></i> ' . $row_additional['author'] . '</a></span>';
                                    echo ' <h4><a href="'. $website .'/' . $row_additional['post_category'] . '/' . $row_additional['slug'] . '/">' . $row_additional['post_title'] . '</a></h4>';
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

                <!-- Right content -->
                <div class="col-lg-4">
                    <?php

                    $sql_trnd = "SELECT * FROM sbp_posts";
                    if (isset($row_main['id'])) {
                        $sql_trnd .= " WHERE id != {$row_main['id']}";
                    }
                    $sql_trnd .= " ORDER BY RAND() LIMIT 5"; // Order randomly and exclude the main trending post

                    // Execute the new query for the right content
                    $result_trnd = $conn->query($sql_trnd);

                    if ($result_trnd->num_rows > 0) {
                        while ($row_trnd = $result_trnd->fetch_assoc()) {
                            echo '<div class="trand-right-single d-flex">';
                            echo '<div class="trand-right-img">';
                            echo '<img src="'.$imgUploads.'/' . $row_trnd['image'] . ' "  alt="'. $row_trnd['post_title'] .'">';
                            echo '</div>';
                            echo '<div class="trand-right-cap">';
                            echo '<span class="color4"><a href="'. $website .'/'.'category/' . $row_trnd['post_category'] . '/">' . $row_trnd['post_category'] . '</a></span> <span class="color3"><a href="'. $website .'/'.'author/' . $row_trnd['author'] . '/"><i class="fas fa-user"></i> ' . $row_trnd['author'] . '</a></span>';
                            echo ' <h4><a href="'. $website .'/' . $row_trnd['post_category'] . '/' . $row_trnd['slug'] . '/">' . $row_trnd['post_title'] . '</a></h4>';
                            echo '</div>';
                            echo '</div>';
                          
                        }
                    } else {
                        echo '<div class="trand-right-single d-flex"><p>No trending posts available. Start with writing Blog Post!</p></div>';
                        // Close connection
                        $conn->close();
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>
</div>

                        <?php 
                            function getInterval($date)
                                {
                                    $postDate = new DateTime($date);
                                    $now = new DateTime();
                                    return $now->diff($postDate);
                                }

                                function getTimeAgo($interval)
                                {
                                    if ($interval->y > 0) {
                                        return $interval->format('%y y ago');
                                    } elseif ($interval->m > 0) {
                                        return $interval->format('%m months ago');
                                    } elseif ($interval->d > 0) {
                                        return $interval->format('%d d ago');
                                    } elseif ($interval->h > 0) {
                                        return $interval->format('%h h ago');
                                    } elseif ($interval->i > 0) {
                                        return $interval->format('%i min ago');
                                    } else {
                                        return '30s ago';
                                    }
                                }
                                ?>
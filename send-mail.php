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
                            <img src="assets/img/trending/green-h2.jpeg" alt="">
                            <?php
                            // Retrieve data from the database for category 'Websites'
                            $sql = "SELECT * FROM sbp_posts LIMIT 1";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while ($row = $result->fetch_assoc()) {

                                    $date = new DateTime($row["post_date"]);
                                    $now = new DateTime();
                                    $interval = $now->diff($date);

                                    if ($interval->y > 0) {
                                        $timeAgo = $interval->format('%y yrs ago');
                                    } elseif ($interval->m > 0) {
                                        $timeAgo = $interval->format('%m months ago');
                                    } elseif ($interval->d > 0) {
                                        $timeAgo = $interval->format('%d days ago');
                                    } elseif ($interval->h > 0) {
                                        $timeAgo = $interval->format('%h hrs ago');
                                    } elseif ($interval->i > 0) {
                                        $timeAgo = $interval->format('%i min ago');
                                    } else {
                                        $timeAgo = '30s ago';
                                    }
                                    echo '<div class="trend-top-cap">
                                            <span>' . $row['post_category'] . '</span>
                                            <h2><a href="/' . $row['post_category'] . '/' . $row['slug'] . '/">' . $row['post_title'] . '</a></h2>
                                            <span class="authorSpan"><a href="/author/' . $row['author'] . '/"><i class="fas fa-user"></i> ' . $row['author'] . '</a></span> <span class="authorSpan"><i class="fas fa-calendar"></i> &nbsp;' . $timeAgo . '</span>
                                        </div>';
                                }
                            } else {
                                echo "All caught up!";
                            }
                            ?>

                        </div>
                    </div>
                    <!-- Trending Bottom -->
                    <div class="trending-bottom">
                        <div class="row">
                            <?php
                            // Retrieve data from the database for category 'Websites'
                            $sql = "SELECT * FROM sbp_posts LIMIT 3";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while ($row = $result->fetch_assoc()) {

                                    $date = new DateTime($row["post_date"]);
                                    $now = new DateTime();
                                    $interval = $now->diff($date);

                                    if ($interval->y > 0) {
                                        $timeAgo = $interval->format('%y y ago');
                                    } elseif ($interval->m > 0) {
                                        $timeAgo = $interval->format('%m m ago');
                                    } elseif ($interval->d > 0) {
                                        $timeAgo = $interval->format('%d d ago');
                                    } elseif ($interval->h > 0) {
                                        $timeAgo = $interval->format('%h h ago');
                                    } elseif ($interval->i > 0) {
                                        $timeAgo = $interval->format('%i min ago');
                                    } else {
                                        $timeAgo = '30s ago';
                                    }
                                    echo '<div class="col-lg-4">';

                                    echo '<div class="single-bottom mb-35">';
                                    echo '<div class="trend-bottom-img mb-30"><img src="assets/img/trending/digital twin.jpeg" alt=""> </div>';
                                    echo '<div class="trend-bottom-cap">';
                                    echo '<span class="color2"><a href="/category/' . $row['post_category'] . '/">' . $row['post_category'] . '</a></span> <span class="color3"><a href="/author/' . $row['author'] . '/"><i class="fas fa-user"></i> ' . $row['author'] . '</a></span>';
                                    echo ' <h4><a href="/' . $row['post_category'] . '/' . $row['slug'] . '/">' . $row['post_title'] . '</a></h4>';

                                    echo '  </div> ';
                                    echo ' </div>';
                                    echo ' </div>';
                                }
                            } else {
                                echo "All caught up!";
                            }
                            ?>


                        </div>
                    </div>
                </div>
                <!-- Riht content -->
                <div class="col-lg-4">
                    <div class="trand-right-single d-flex">
                        <div class="trand-right-img">
                            <img src="assets/img/trending/truth-social-ipo.png" alt="">
                        </div>
                        <div class="trand-right-cap">
                            <span class="color1">Concert</span>
                            <h4><a href="details.html">Welcome To The Best Model Winner Contest</a></h4>
                        </div>
                    </div>
                    <div class="trand-right-single d-flex">
                        <div class="trand-right-img">
                            <img src="assets/img/trending/digital twin.jpeg" alt="">
                        </div>
                        <div class="trand-right-cap">
                            <span class="color3">sea beach</span>
                            <h4><a href="details.html">Welcome To The Best Model Winner Contest</a></h4>
                        </div>
                    </div>
                    <div class="trand-right-single d-flex">
                        <div class="trand-right-img">
                            <img src="assets/img/trending/right3.jpg" alt="">
                        </div>
                        <div class="trand-right-cap">
                            <span class="color2">Bike Show</span>
                            <h4><a href="details.html">Welcome To The Best Model Winner Contest</a></h4>
                        </div>
                    </div>
                    <div class="trand-right-single d-flex">
                        <div class="trand-right-img">
                            <img src="assets/img/trending/right4.jpg" alt="">
                        </div>
                        <div class="trand-right-cap">
                            <span class="color4">See beach</span>
                            <h4><a href="details.html">Welcome To The Best Model Winner Contest</a></h4>
                        </div>
                    </div>
                    <div class="trand-right-single d-flex">
                        <div class="trand-right-img">
                            <img src="assets/img/trending/right5.jpg" alt="">
                        </div>
                        <div class="trand-right-cap">
                            <span class="color1">Skeping</span>
                            <h4><a href="details.html">Welcome To The Best Model Winner Contest</a></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
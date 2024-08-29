           
<div class="weekly2-news-area  weekly2-pading gray-bg">
    <div class="container">
        <div class="weekly2-wrapper">
                <!-- section Tittle -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle mb-30">
                            <h3>Weekly Top News</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="weekly2-news-active dot-style d-flex dot-style">

                             <?php
            
                            // Retrieve data from the database 
                            $sql = "SELECT * FROM sbp_posts";
                            
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                // Loop through each additional trending post
                                while ($row = $result->fetch_assoc()) {
                                    $interval = getInterval($row["post_date"]);
                                    $timeAgo = getTimeAgo($interval);

                                     echo '<div class="weekly2-single">';
                                     echo '<div class="weekly2-img">';
                                     echo '<img src="'.$website.'/assets/img/news/weekly2News4.jpg" alt="">';
                                     echo '</div>';
                                     echo '<div class="weekly2-caption">';
                                     echo '<span class="color1"><a href="'.$website.'/'.'category/' . $row['post_category'] . '/">' . $row['post_category'] . '</a></span>';
                                     echo '<span class="color2"><a href="'.$website.'/'.'author/' . $row['author'] . '/">' . $row['author'] . '</a></span>';
                                     echo '<p>'.$timeAgo.'</p>';
                                     echo '<h4><a href="#">' . $row['post_title'] . '</a></h4>';
                                     echo '</div>';
                                     echo '</div> ';

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
           

                                   


                                   
                                        
                               
                                    
                                        
                                        
                                        
                     
<?php
// session_start(); 
include 'sbp-admin/credentials.php';
include 'sbp-admin/globalVar.php';
// Retrieve the category parameter from the URL
$url_category = $_GET['category'];

// Query the database to fetch blog posts under the given category
$sql = "SELECT * FROM sbp_posts WHERE post_category = '$url_category' ";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Check for errors
if (!$result) {
    echo "Error executing the query: " . $stmt->error;
    exit();
}
// Check if the user exists
if ($result->num_rows > 0) {
    // User found, display details
    $row = $result->fetch_assoc();
    $category = $url_category;
    // Add more details as needed
    ?>


    <!doctype html>
    <html class="no-js" lang="zxx">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo $category; ?> - Category | Satyam Blogs </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="manifest" href="site.webmanifest">
        <link rel="shortcut icon" type="image/x-icon" href="/assets/img/favicon.ico">

        <!-- CSS here -->
        <?php include_once __DIR__ . '/sbp-contents/importCss.php'; ?>
    </head>

    <body>

        <header>
            <!-- Header Start -->
            <?php include_once __DIR__ . '/sbp-contents/top-header.php'; ?>
            <!-- Header End -->
        </header>

        <main>
            <!-- Category Start -->
            <section class="whats-news-area pt-50 pb-20">
                <div class="container">
                    <div class="row">
                        <div class="col-lg">
                            <div class="row d-flex justify-content-between">
                                <div class="col-lg-3 col-md-3">
                                    <div class="section-tittle mb-30">
                                        <?php

                                        // Fetch unique categories from the database
                                        $sql = "SELECT DISTINCT post_category FROM sbp_posts";
                                        $result = $conn->query($sql);

                                        // Check if there are any categories
                                        if ($result->num_rows > 0) {
                                            $categories = array();
                                            // Fetching each category and storing them in an array
                                            while ($row = $result->fetch_assoc()) {
                                                $categories[] = $row['post_category'];
                                            }
                                            ?>
                                            <h3>Category -
                                                <?php $currentCategory = isset($_GET['category']) ? $_GET['category'] : '';
                                                echo $currentCategory; ?>
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="col-lg-9 col-md-9">
                                        <div class="properties__button">
                                            <!--Nav Button  -->

                                            <nav>
                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                    <?php
                                                    // Get the current category from the URL or any other source
                                                    $currentCategory = isset($_GET['category']) ? $_GET['category'] : '';

                                                    foreach ($categories as $category) {
                                                        // Check if the current category matches the loop category
                                                        $isActive = ($currentCategory == $category) ? 'active' : '';

                                                        echo '<a class="nav-item nav-link ' . $isActive . '" id="nav-home-tab" href="'.$website.'/'.'category/' . $category . '/" aria-controls="nav-home" aria-selected="' . ($isActive ? 'true' : 'false') . '">' . $category . '</a>';
                                                    }
                                                    ?>
                                                </div>
                                            </nav>
                                            <?php
                                        } else {
                                            echo "Uncategorised";
                                        }

                                        ?>
                                        <!--End Nav Button  -->
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <!-- Nav Card -->
                                    <div class="tab-content" id="nav-tabContent">

                                        <!-- card one -->
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                            aria-labelledby="nav-home-tab">
                                            <div class="whats-news-caption">
                                                <div class="row">
                                                    <?php
                                                    // Check the database connection
                                                    if ($conn->connect_error) {
                                                        die("Connection failed: " . $conn->connect_error);
                                                    }

                                                    // Check the category variable
                                                    $currentCategory = isset($_GET['category']) ? $_GET['category'] : '';

                                                    // Prepare the SQL query
                                                    $sql = "SELECT * FROM sbp_posts WHERE post_category = ?";
                                                    $stmt = $conn->prepare($sql);

                                                    if ($stmt === false) {
                                                        die("Prepare failed: " . $conn->error);
                                                    }

                                                    // Bind the parameter
                                                    if (!$stmt->bind_param('s', $currentCategory)) {
                                                        die("Binding parameters failed: " . $stmt->error);
                                                    }

                                                    // Execute the statement
                                                    if (!$stmt->execute()) {
                                                        die("Execute failed: " . $stmt->error);
                                                    }

                                                    // Get the result
                                                    $result = $stmt->get_result();

                                                    if ($result->num_rows > 0) {
                                                        // Output data of each row
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo '<div class="s-col-lg-6 col-md-6">';
                                                            echo '<div class="single-what-news mb-100">';
                                                            echo '<div class="what-img"><img src="'.$imgUploads.'/' . $row['image'] . ' "  alt="'. $row['post_title'] .'"> </div>';
                                                            echo '<div class="what-cap"><span class="color1">' . $row['post_category'] . '</span> <span class="color2"><i class="fas fa-user"></i> ' . $row['author'] . '</span>';
                                                            echo ' <h4><a href="'.$website.'/' . $row['post_category'] . '/' . $row['slug'] . '/">' . $row['post_title'] . '</a></h4>';
                                                            echo ' </div>';
                                                            echo '  </div>';
                                                            echo ' </div>';
                                                        }
                                                    } else {
                                                        echo "All caught up!";
                                                    }

                                                    // Close the statement
                                                   
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- End Nav Card -->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
            <!-- Category End -->

        </main>

        <footer>
            <?php include_once __DIR__ . '/sbp-contents/footer.php'; ?>
        </footer>

        <!-- JS here -->

       <?php include_once __DIR__ . '/sbp-contents/importJs.php'; ?>

    </body>

    </html>
    <?php
} else {
    // If User not found redirect to error 404 
    header("HTTP/1.0 404 Not Found");
    include ('404.php');
}

// Close database connection
$stmt->close();
$conn->close();
?>
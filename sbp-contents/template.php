<?php
ob_start(); // Start output buffering
// Display errors
//   error_reporting(E_ALL);
// ini_set('display_errors', 1);
include_once '../sbp-admin/credentials.php';
include_once 'globalVar.php';

// Retrieve data from the database based on the provided slug
if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];
    $sql = "SELECT * FROM sbp_posts WHERE slug = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $result = $stmt->get_result();


    // Check if there is a matching blog entry
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row['id'];
        $title = $row['post_title'];
        $tags = $row['post_tags'];
        $contents = $row['post_contents'];
        $category = $row['post_category'];
        $author = $row['author'];
        $date = $row['date'];
        $image = $row['image'];


        $date = new DateTime($row["date"]);
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
        ?>

        <!doctype html>
        <html class="no-js" lang="zxx">
        <?php include 'globalVar.php'; ?>

        <head>
            <meta charset="utf-8">
            <meta http-equiv="x-ua-compatible" content="ie=edge">
            <title> <?php echo $title; ?> | Satyam Blogs</title>
            <meta name="description" content=" <?php echo $title; ?> ">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <link rel="manifest" href="site.webmanifest">
            <link rel="shortcut icon" type="image/x-icon" href="<?php echo $website; ?>/assets/img/favicon.ico">

            <!-- CSS here -->
            <link rel="stylesheet" href="<?php echo $website; ?>/assets/css/bootstrap.min.css">
            <link rel="stylesheet" href="<?php echo $website; ?>/assets/css/owl.carousel.min.css">

            <link rel="stylesheet" href="<?php echo $website; ?>/assets/css/ticker-style.css">

            <link rel="stylesheet" href="<?php echo $website; ?>/assets/css/flaticon.css">

            <link rel="stylesheet" href="<?php echo $website; ?>/assets/css/slicknav.css">
            <link rel="stylesheet" href="<?php echo $website; ?>/assets/css/animate.min.css">
            <link rel="stylesheet" href="<?php echo $website; ?>/assets/css/magnific-popup.css">
            <link rel="stylesheet" href="<?php echo $website; ?>/assets/css/fontawesome-all.min.css">
            <link rel="stylesheet" href="<?php echo $website; ?>/assets/css/themify-icons.css">
            <link rel="stylesheet" href="<?php echo $website; ?>/assets/css/slick.css">
            <link rel="stylesheet" href="<?php echo $website; ?>/assets/css/nice-select.css">
            <link rel="stylesheet" href="<?php echo $website; ?>/assets/css/style.css">
            <link rel="stylesheet" href="<?php echo $website; ?>/assets/css/responsive.css">
        </head>

        <body>

            <!-- Preloader Start -->
            <?php /** include_once __DIR__ . '/preloader.php'; */ ?>
            <!-- Preloader Start -->

            <header>
                <!-- Header Start -->
                <?php include_once __DIR__ . '/top-header.php'; ?>
                <!-- Header End -->
            </header>

            <main>
                <!-- About US Start -->
                <div class="about-area">
                    <div class="container">
                        <!-- Hot Aimated News Tittle-->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="trending-tittle">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <!-- Trending Tittle -->
                                <div class="about-right mb-30">
                                    <div class="about-img br-6">
                                        <img src="<?php echo $imgUploads; ?>/<?php echo $image; ?>" alt="<?php echo $title; ?>">
                                    </div>
                                    <div class="section-tittle mb-30 pt-30">
                                        <h3> <?php echo $title; ?> </h3>
                                    </div>
                                    <div class="about-area textEditor">
                                        <?php echo $contents; ?>
                                    </div>




                                    <div class="social-share pt-30">
                                        <div class="section-tittle">
                                            <h3 class="mr-20">Share:</h3>
                                            <ul>
                                                <li><a href="#"><img src="<?php echo $website; ?>/assets/img/news/icon-ins.png"
                                                            alt=""></a></li>
                                                <li><a href="#"><img src="<?php echo $website; ?>/assets/img/news/icon-fb.png"
                                                            alt=""></a></li>
                                                <li><a href="#"><img src="<?php echo $website; ?>/assets/img/news/icon-tw.png"
                                                            alt=""></a></li>
                                                <li><a href="#"><img src="<?php echo $website; ?>/assets/img/news/icon-yo.png"
                                                            alt=""></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!--Comments Form -->
                                <?php include_once __DIR__ . '/comments_template.php'; ?>

                                <div class="row">
                                    <div class="col-lg-8">
                                        <form class="form-contact contact_form mb-80" action="" method="post" id="contactForm"
                                            novalidate="novalidate">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <textarea class="form-control w-100 error" name="comment" id="comment"
                                                            cols="30" rows="6" onfocus="this.placeholder = ''"
                                                            onblur="this.placeholder = 'Enter Comments'"
                                                            placeholder="Comments"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <input class="form-control error" name="name" id="name" type="text"
                                                            onfocus="this.placeholder = ''"
                                                            onblur="this.placeholder = 'Enter your name'"
                                                            placeholder="Enter your name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <input class="form-control error" name="email" id="email" type="email"
                                                            onfocus="this.placeholder = ''"
                                                            onblur="this.placeholder = 'Enter email address'"
                                                            placeholder="Email">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <input class="form-control error" name="website" id="website"
                                                            type="text" onfocus="this.placeholder = ''"
                                                            onblur="this.placeholder = 'Enter Website'"
                                                            placeholder="Enter Website">
                                                    </div>
                                                </div>
                                                <span>*Your email will not be published!</span>
                                            </div>
                                            <div class="form-group mt-3">
                                                <button type="submit" class="button button-contactForm boxed-btn">Post
                                                    Comment</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <?php


                                // Display errors
                                error_reporting(E_ALL);
                                ini_set('display_errors', 1);

                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    // Validate input fields
                                    $name = htmlspecialchars(trim($_POST["name"]));
                                    $email = htmlspecialchars(trim($_POST["email"]));
                                    $website = htmlspecialchars(trim($_POST["website"]));
                                    $comment = htmlspecialchars(trim($_POST["comment"]));
                                    $post_slug = $_GET['slug'];
                                    // Get IP address of the device
                                    $ip_address = $_SERVER['REMOTE_ADDR'];
                                    // Prepare and bind SQL statement
                                    $stmt = $conn->prepare("INSERT INTO sbp_comments (name, email, website, comment, device_ip, post_slug) VALUES (?, ?, ?, ?, ?, ?)");
                                    $stmt->bind_param("ssssss", $name, $email, $website, $comment, $ip_address, $post_slug);

                                    // Execute the statement
                                    if ($stmt->execute() === TRUE) {

                                        header("Refresh:0");
                                        exit;

                                    } else {
                                        echo "Error: " . $stmt->error;
                                    }
                                }
                                ?>

                            </div>
                            <!-- Sidebar -->
                            <?php include_once __DIR__ . '/sidebar.php'; ?>
                            <!-- Sidebar -->
                        </div>
                    </div>
                </div>
                <!-- About US End -->
            </main>

            <footer>
                <?php include_once __DIR__ . '/footer.php'; ?>
            </footer>

            <!-- JS here -->
            <?php include_once __DIR__ . '/importJs.php'; ?>

        </body>

        </html>

        <?php
    } else {
        // If Blogs is not found redirect to error 404 
        header("HTTP/1.0 404 Not Found");
        include __DIR__ . ('/404.php');
    }

    // Close prepared statement and result set
    $stmt->close();
    $result->close();
}
ob_end_flush();
// Close connection
// $conn->close();
?>
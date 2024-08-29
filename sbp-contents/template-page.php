<?php include_once '../sbp-admin/credentials.php';
include_once 'globalVar.php';


// Retrieve data from the database based on the provided slug
if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];
    $sql = "SELECT * FROM sbp_pages WHERE slug = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $result = $stmt->get_result();


    // Check if there is a matching blog entry
    if ($result->num_rows > 0) {
       
        $row = $result->fetch_assoc();
        $title = $row['page_title'];

        $contents = $row['page_contents'];

        $author = $row['author'];
        $date = $row['date'];


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
                           <?php
// Include your database credentials file
include 'credentials.php';


// Define variables and initialize with empty values
$name = $email = $subject = $website = $message = "";
$name_err = $email_err = $message_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email address.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate message
    if (empty(trim($_POST["message"]))) {
        $message_err = "Please enter your message.";
    } else {
        $message = trim($_POST["message"]);
    }

    // Assign subject and website
    $subject = trim($_POST["subject"]);
    $website = trim($_POST["website"]);

    // Check input errors before inserting into database
    if (empty($name_err) && empty($email_err) && empty($message_err)) {
        // Insert data into database
        $sql = "INSERT INTO contact_submissions (name, email, message, subject, website) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $email, $message, $subject, $website);

        if ($stmt->execute()) {
            echo '<style>.top-30{top:30%} .right-0{right:0px} .z-i-2{z-index:2}</style>';
            echo ' <div class="alert alert-success alert-dismissible fade show position-absolute top-30 right-0 z-i-2" role="alert">
                <strong>Success! </strong> Your Request has been Submitted! We will soon get back to you!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div> ';
            // Clear form fields after successful submission
            $name = $email = $message = $subject = $website ="";
        } else {
            echo ' <div class="alert alert-danger alert-dismissible fade show position-absolute top-30 right-0 z-i-2" role="alert">
                <strong>Error! </strong>Error: '. $sql . '<br>' . $conn->error .'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div> '; 
        }

        // Close statement
        $stmt->close();
    }
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
            <?php include_once __DIR__ . '/preloader.php'; ?>
            <!-- Preloader Start -->

            <header>
                <!-- Header Start -->
                <?php include_once __DIR__ . '/top-header.php'; ?>
                <!-- Header End -->
            </header>

            <main>
                <!-- Blog Contents Area Start -->
                <section>
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
 
                                
                                    <div class="contact-tittle mb-5 pt-5">
                                        <h3> <?php echo $title; ?> </h3>
                                    </div>
                                    <div class="col-12 link-primary">
                                        <?php echo $contents; ?>
                                    </div>

                                    <div class="social-share pt-30">
                                        <div class="section-tittle">
                                            <h3 class="mr-20">Share:</h3>
                                            <ul>
                                                <li><a href="#"><img src="<?php echo $website; ?>/assets/img/news/icon-ins.png" alt=""></a></li>
                                                <li><a href="#"><img src="<?php echo $website; ?>/assets/img/news/icon-fb.png" alt=""></a></li>
                                                <li><a href="#"><img src="<?php echo $website; ?>/assets/img/news/icon-tw.png" alt=""></a></li>
                                                <li><a href="#"><img src="<?php echo $website; ?>/assets/img/news/icon-yo.png" alt=""></a></li>
                                            </ul>
                                        </div>
                                    </div>
                              

                            </div>
                           
                        </div>
                    </div>
                </section>
                <!-- Blog Contents Area End -->
            </main>

            <footer>
                <?php include_once __DIR__ . '/footer.php'; ?>
            </footer>

            <!-- JS here -->
<?php include_once  'importJs.php'; ?>

        </body>

        </html>

        <?php
    } else {
        // If Blogs is not found redirect to error 404 
        header("HTTP/1.0 404 Not Found");
        include ('../404.php');
    }

    // Close prepared statement and result set
    $stmt->close();
    $result->close();
}

// Close connection
$conn->close();
?>
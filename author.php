<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL); 

include 'sbp-admin/credentials.php';
// Retrieve the author parameter from the URL
$author = $_GET['author'];

// Query the database to fetch user details
$sql = "SELECT * FROM sbp_posts WHERE author = '$author'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();


// Check if the user exists
if ($result->num_rows > 0) {
    // User found, display details
    $row = $result->fetch_assoc();
    // $authorName = $row['authorName'];
    // Add more details as needed

    ?>

    <!doctype html>
    <html class="no-js" lang="zxx">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo $author; ?> | Satyam Blogs</title>
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
            <?php echo $author; ?>
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
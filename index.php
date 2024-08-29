<?php include_once 'sbp-admin/credentials.php';
 include_once 'sbp-contents/globalVar.php';
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);  ?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Satyam Blogs</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <!-- CSS here -->
   <?php include_once __DIR__ . '/sbp-contents/importCss.php'; ?>
</head>

<body>

    <!-- Preloader Start -->
    <?php include_once __DIR__ . '/sbp-contents/preloader.php'; ?>
    <!-- Preloader Start -->

    <header>
        <!-- Header Start -->
        <?php include_once __DIR__ . '/sbp-contents/top-header.php'; ?>
        <!-- Header End -->
    </header>

    <main>

        <!-- Trending Area Start -->
        <?php include_once 'sbp-contents/trending-area.php'; ?>
        <!-- Trending Area End -->

        <!--   Weekly-News start -->
        <?php include_once 'sbp-contents/weekly-news-contents.php'; ?>
        <!-- End Weekly-News -->

        <!-- Whats New Start -->
        <?php /** Include If Necessary! sbp-contents/whats-news-area.php */  ?>
        <!-- Whats New End -->

        <!--   Weekly-Top News start -->
         <?php  /** include_once 'sbp-contents/w-top-news.php';*/ ?>
        <!-- End Weekly-News -->

        <!--  Recent Articles With Pagination start -->
       <?php /** Include if Necessary! sbp-contents/w-recent-articles-pagination.php*/ ?>
        <!--Recent Articles With Pagination End -->

        <?php include 'sbp-contents/bottom-post-lm.php'; ?>
    </main>
<script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>
<div class="elfsight-app-1b943927-41f8-4d3d-be97-8caa795a50c5" data-elfsight-app-lazy></div>
    <footer>
        <?php include_once __DIR__ . '/sbp-contents/footer.php'; ?>
    </footer>

    <!-- JS here -->
    <?php include_once  'sbp-contents/importJs.php'; ?>

</body>

</html>
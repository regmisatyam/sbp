<!doctype html>
<html class="no-js" lang="zxx">
<?php 
include 'sbp-contents/globalVar.php';
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>404 | Satyam Blogs</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $website ?>/assets/img/favicon.ico">

    <!-- CSS here -->
    <?php include 'sbp-contents/importCss.php'; ?>
   
</head>

<body>

    <header>
        <!-- Header Start -->
        <?php include_once __DIR__ . '/sbp-contents/top-header.php'; ?>
        <!-- Header End -->
    </header>

    <main>

        <div class="d-flex align-items-center justify-content-center vh-100 m-5">
            <div class="text-center row">
                <div class=" col-md-6">
                    <img src="https://cdn.pixabay.com/photo/2017/03/09/12/31/error-2129569__340.jpg" alt=""
                        class="img-fluid">
                </div>
                <div class=" col-md-6 mt-5">
                    <p class="fs-3"> <span class="text-danger">Opps!</span> Page not found.</p>
                    <p class="lead">
                        The page you’re looking for doesn’t exist.
                    </p>
                    <a href="<?php echo $website ?>/" class="btn">Go Home</a>
                </div>

            </div>
        </div>

    </main>

    <footer>
        <?php include_once __DIR__ . '/sbp-contents/footer.php'; ?>
    </footer>

    <!-- JS here -->
    <?php include 'sbp-contents/importJs.php'; ?>

</body>

</html>
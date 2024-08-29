<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
    header("location: login");
    exit;
}

$username = $_SESSION['username']; // Assuming the username is stored in the session
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Upload Page | Satyam Blogs</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="">
    <link rel="shortcut icon" type="image/x-icon" href="/assets/img/favicon.ico">
    <?php include './components/importCss.php'; ?>
</head>

<body>

    <!-- ======= Header ======= -->
    <?php include './components/header.php'; ?>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <?php include './components/asidebar.php'; ?>
    <!-- End Sidebar-->

    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="container my-5">
                        <h2>Upload Page</h2>
                        <form class="needs-validation" novalidate
                        action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"
                        enctype="multipart/form-data">

                            <div class="row mb-3">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" name="title" id="validationTooltip01" required>
                            </div>

                            <div class="row mb-3">
                                <label for="contents">Contents:</label>
                                <textarea class="tinymce-editor" name="contents" id="contents" rows="10"
                                    required></textarea>
                            </div>

                            <input type="hidden" name="author" value="<?php echo htmlspecialchars($username); ?>">

                            <input type="submit" class="btn btn-primary" name="submit" value="Upload">
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <?php
        include '../credentials.php'; // database credentials file
        
        function generateUniqueSlug($title, $conn)
        {
            // Convert title to lowercase
            $slug = strtolower($title);
            // Replace spaces with hyphens
            $slug = str_replace(' ', '-', $slug);
            // Remove special characters
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', $slug);

            // Check if the slug already exists in the database using prepared statements
            $original_slug = $slug;
            $suffix = 1;
            while (true) {
                $stmt = $conn->prepare("SELECT slug FROM sbp_pages WHERE slug = ?");
                $stmt->bind_param("s", $slug);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows == 0) {
                    break;
                } else {
                    $slug = $original_slug . '-' . $suffix;
                    $suffix++;
                }
            }
            $stmt->close();

            return $slug;
        }

        if (isset($_POST["submit"])) {
            $title = $_POST['title'];
            $contents = $_POST['contents'];
            $slug = generateUniqueSlug($title, $conn);
            $author = $_POST['author'];

            // Insert image file name into database using prepared statements
            $sql = "INSERT INTO sbp_pages (page_title, page_contents, slug, author) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            // Check if the prepare() succeeded
            if ($stmt) {
                $stmt->bind_param("ssss", $title, $contents, $slug, $author);
                if ($stmt->execute()) {
                    echo "Page uploaded successfully.";
                } else {
                    echo "Error executing the statement: " . $stmt->error;
                }
                $stmt->close();
            } else {
                // Print the SQL error
                echo "Error preparing the statement: " . $conn->error;
            }
        }
        // Close connection
        $conn->close();
        ?>

    </main>

    <footer>
        <?php include_once './components/footer.php'; ?>
    </footer>

    <!-- JS here -->
    <?php include './components/importJs.php'; ?>

</body>

</html>

<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
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
    <title>Upload Post | Satyam Blogs</title>
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
                    <h5 class="card-title">Upload Post</h5>
                    <form class="needs-validation" novalidate
                        action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"
                        enctype="multipart/form-data">

                        <div class="row mb-3">
                            <label for="image">Select Image:</label>
                            <input type="file" class="form-control" accept="image/*" name="image" id="formFile" required>
                        </div>

                        <div class="row mb-3">
                            <label for="validationTooltip01" class="form-label">Title</label>
                            <input type="text" class="form-control" id="validationTooltip01" name="title" required>
                        </div>

                        <div class="row mb-3">
                            <label for="validationTooltip01" class="form-label">Contents</label>
                            <!-- TinyMCE Editor -->
                            <textarea class="tinymce-editor" name="contents" id="contents" rows="10"
                                required></textarea><!-- End TinyMCE Editor -->
                        </div>

                        <input type="hidden" class="form-control" name="author" id="author"
                            value="<?php echo htmlspecialchars($username); ?>" required>

                            <div class="row mb-3">
                                <label for="category">Category:</label><br>
                                <select class="form-control" name="category" id="category" onchange="checkCategory(this)"
                                    required>
                                    <option value="Uncategorized">SELECT CATEGORY</option>
                                    <option value="Gadgets">Gadgets</option>
                                    <option value="Technology">Technology</option>
                                    <option value="Updates">Updates</option>
                                    <option value="FunFacts">FunFacts</option>
                                    <option id="add_new" value="" >Add New Category</option>
                                </select>
                                <div id="newCategory" style="display:none;" class="mt-2">
                                    <label for="newCategoryInput">Type a new category:</label>
                                    <input type="text" class="form-control" id="newCategoryInput" name="newCategory" oninput="updateNewCategoryValue()">
                                </div>
                                <script>
                                    function checkCategory(select) {
                                        var newCategoryDiv = document.getElementById('newCategory');
                                        var newCategoryInput = document.getElementById('newCategoryInput');
                                        if (select.value === '') {
                                            newCategoryDiv.style.display = 'block';
                                            newCategoryInput.required = true;
                                        } else {
                                            newCategoryDiv.style.display = 'none';
                                            newCategoryInput.required = false;
                                        }
                                    }

                                    function updateNewCategoryValue() {
                                        var newCategoryInput = document.getElementById('newCategoryInput');
                                        var addNewOption = document.getElementById('add_new');
                                        addNewOption.value = newCategoryInput.value;
                                    }
                                </script>
                        </div>

                        <div class="row mb-3">
                            <label for="tags">Tags:</label>
                            <input type="text" class="form-control" name="tags" id="tags">
                        </div>

                        <button type="submit" class="btn btn-primary" name="submit">Upload</button>
                    </form>



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

            // Check if the slug already exists in the database
            $original_slug = $slug;
            $suffix = 1;
            while (true) {
                $result = $conn->query("SELECT slug FROM sbp_posts WHERE slug = '$slug'");
                if ($result->num_rows == 0) {
                    break;
                } else {
                    $slug = $original_slug . '-' . $suffix;
                    $suffix++;
                }
            }

            return $slug;
        }

        // If the form is submitted
        if (isset($_POST["submit"])) {
            $title = $_POST['title'];
            $contents = $_POST['contents'];
            $category = $_POST['category'];
            $slug = generateUniqueSlug($title, $conn);
            $author = $_POST['author'];
            $tags = $_POST['tags'];

            // Create excerpt
            $excerpt = substr($contents, 0, 100) . '...'; // Truncate content to 100 characters for excerpt
        
            // File upload path
            $targetDir = "../../assets/uploads/";
            $fileName = basename($_FILES["image"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            // Allow certain file formats
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');

            if (in_array($fileType, $allowTypes)) {
                // Upload file to server
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                    // Insert image file name into database
                    $sql = "INSERT INTO sbp_posts (post_title, post_contents, slug, post_category, author, post_tags, post_excerpt, `image`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssssssss", $title, $contents, $slug, $category, $author, $tags, $excerpt, $fileName);
                    if ($stmt->execute()) {
                        echo ' <div class="alert c-alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                Post uploaded successfully.
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
                    } else {
                        echo "Error: " . $stmt->error;
                    }
                } else {
                    echo '<div class="alert c-alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                Sorry, there was an error uploading your Post.
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
                }
            } else {
                echo '<div class="alert c-alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
               Sorry, only JPG, JPEG, PNG, GIF, WEBP files are allowed to upload.
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
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
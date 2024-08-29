<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Satyam Blogs</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="">
    <link rel="shortcut icon" type="image/x-icon" href="/assets/img/favicon.ico">

    <!-- CSS here -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/css/ticker-style.css">
    <link rel="stylesheet" href="/assets/css/flaticon.css">
    <link rel="stylesheet" href="/assets/css/slicknav.css">
    <link rel="stylesheet" href="/assets/css/animate.min.css">
    <link rel="stylesheet" href="/assets/css/magnific-popup.css">
    <link rel="stylesheet" href="/assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="/assets/css/themify-icons.css">
    <link rel="stylesheet" href="/assets/css/slick.css">
    <link rel="stylesheet" href="/assets/css/nice-select.css">
    <link rel="stylesheet" href="/assets/css/style.css">

</head>

<body>

    <header>
        <!-- Header Start -->
        <?php 
      
        include '../sbp-contents/globalVar.php';
        include_once ROOT . '/sbp-contents/top-header.php';
         ?>
        <!-- Header End -->
    </header>

    <main>

        <div class="container my-5">
            <h2>Upload Post</h2>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"
                enctype="multipart/form-data">
                <div class="form-group">
                    <label for="image">Select Image:</label>
                    <input type="file" class="form-control-file" name="image" id="image" required>
                </div>

                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" name="title" id="title" required>
                </div>

                <div class="form-group">
                    <label for="contents">Contents:</label>
                    <textarea class="form-control" name="contents" id="contents" rows="10"></textarea>
                </div>

                <div class="form-group">
                    <label for="authorName">Author Name:</label>
                    <input type="text" class="form-control" name="authorName" id="authorName" value="Satyam Regmi"
                        required>
                </div>

                <div class="form-group">
                    <label for="author">Author Link:</label>
                    <input type="text" class="form-control" name="author" id="author" value="satyamregmi" required>
                </div>

                <div class="form-group">
                    <label for="category">Category:</label><br>
                    <select class="form-control" name="category" id="category" onchange="checkCategory(this)" required>
                        <option value="Uncategorized">SELECT CATEGORY</option>
                        <option value="Gadgets">Gadgets</option>
                        <option value="Technology">Technology</option>
                        <option value="Updates">Updates</option>
                        <option value="FunFacts">FunFacts</option>
                        <option value="add_new">Add New Category</option>
                    </select>
                    <div id="newCategory" style="display:none;" class="mt-2">
                        <label for="newCategoryInput">Type a new category:</label>
                        <input type="text" class="form-control" id="newCategoryInput" name="newCategory">
                    </div>
                </div><br><br>

                <div class="form-group">
                    <label for="tags">Tags:</label>
                    <input type="text" class="form-control" name="tags" id="tags">
                </div>

                <button type="submit" class="btn" name="submit">Upload</button>
            </form>

            <!-- TinyMCE initialization script -->
            <script
                src="https://cdn.tiny.cloud/1/0kl5l33c89bex4zk7r65pvotwt9rf7zm1zghsqx8ejlgract/tinymce/6/tinymce.min.js"
                referrerpolicy="origin"></script>
            <script>
                tinymce.init({
                    selector: 'textarea',
                    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                    tinycomments_mode: 'embedded',
                    tinycomments_author: 'Author name',
                    mergetags_list: [
                        { value: 'First.Name', title: 'First Name' },
                        { value: 'Email', title: 'Email' },
                    ],
                    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
                });

                function checkCategory(select) {
                    var newCategoryDiv = document.getElementById('newCategory');
                    var newCategoryInput = document.getElementById('newCategoryInput');

                    if (select.value === 'add_new') {
                        newCategoryDiv.style.display = 'block';
                        newCategoryInput.required = true;
                    } else {
                        newCategoryDiv.style.display = 'none';
                        newCategoryInput.required = false;
                    }
                }
            </script>
        </div>

        <?php
          ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
        include 'credentials.php'; // database credentials file

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
            $targetDir = "../assets/uploads/";
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
                        echo "Blog uploaded successfully.";
                    } else {
                        echo "Error: " . $stmt->error;
                    }
                } else {
                    echo "Sorry, there was an error uploading your Blog.";
                }
            } else {
                echo 'Sorry, only JPG, JPEG, PNG, GIF, WEBP files are allowed to upload.';
            }
        }
        
        // Close connection
        $conn->close();
        
        ?>

    </main>

    <footer>
        <?php include_once '../sbp-contents/footer.php'; ?>
    </footer>

    <!-- JS here -->

    <!-- All JS Custom Plugins Link Here here -->
    <script src="/assets/js/vendor/modernizr-3.5.0.min.js"></script>
    <!-- Jquery, Popper, Bootstrap -->
    <script src="/assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <!-- Jquery Mobile Menu -->
    <script src="/assets/js/jquery.slicknav.min.js"></script>

    <!-- Jquery Slick , Owl-Carousel Plugins -->
    <script src="/assets/js/owl.carousel.min.js"></script>
    <script src="/assets/js/slick.min.js"></script>
    <!-- Date Picker -->
    <script src="/assets/js/gijgo.min.js"></script>
    <!-- One Page, Animated-HeadLin -->
    <script src="/assets/js/wow.min.js"></script>
    <script src="/assets/js/animated.headline.js"></script>
    <script src="/assets/js/jquery.magnific-popup.js"></script>

    <!-- Breaking New Pluging -->
    <script src="/assets/js/jquery.ticker.js"></script>
    <script src="/assets/js/site.js"></script>

    <!-- Scrollup, nice-select, sticky -->
    <script src="/assets/js/jquery.scrollUp.min.js"></script>
    <script src="/assets/js/jquery.nice-select.min.js"></script>
    <script src="/assets/js/jquery.sticky.js"></script>

    <!-- contact js -->
    <script src="/assets/js/contact.js"></script>
    <script src="/assets/js/jquery.form.js"></script>
    <script src="/assets/js/jquery.validate.min.js"></script>
    <script src="/assets/js/mail-script.js"></script>
    <script src="/assets/js/jquery.ajaxchimp.min.js"></script>

    <!-- Jquery Plugins, main Jquery -->
    <script src="/assets/js/plugins.js"></script>
    <script src="/assets/js/main.js"></script>

</body>

</html>
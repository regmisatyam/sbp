
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Edit | Satyam Blogs</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="/assets/img/favicon.ico">

    <!-- CSS here -->
     <?php include '../sbp-contents/importCss.php'; ?>
   
</head>

<body>

    <header>
        <!-- Header Start -->
        <?php include '../sbp-contents/top-header.php'; ?>
        <!-- Header End -->
    </header>

    <main>

   <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    include '../sbp-contents/globalVar.php';
    include 'credentials.php'; // Include database credentials file

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
        $id = $_POST['id'];

        // Update blog fields in the database using prepared statements
        $update_sql = "UPDATE sbp_posts SET post_title=?, post_contents=?, slug=?, author=?, authorName=?, date=?, post_category=?, post_tags=?, image=? WHERE id=?";
        $stmt = $conn->prepare($update_sql);

        // Check if an image file has been uploaded
        if (!empty($_FILES['image']['name'])) {
            // Handle image upload
            $target_dir = "../assets/uploads/";
            $fileName = basename($_FILES["image"]["name"]);
            $target_file = $target_dir . $fileName;
            $fileType = pathinfo($target_file, PATHINFO_EXTENSION);

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    // File uploaded successfully, set $image to the file name
                    $image = $fileName;
                } else {
                    echo "Error uploading file.";
                    exit; // Exit script if file upload fails
                }
            } else {
                echo "File is not an image.";
                exit; // Exit script if file is not an image
            }
        } else {
            // No image file has been uploaded, set $image to NULL
            $image = NULL;
        }

        // Prepare and bind parameters for the SQL statement
        if (!empty($_FILES['image']['name'])) {
            $stmt = $conn->prepare("UPDATE sbp_posts SET post_title=?, post_contents=?, slug=?, author=?, authorName=?, date=?, post_category=?, post_tags=?, image=? WHERE id=?");
            $stmt->bind_param("sssssssssi", $_POST['title'], $_POST['contents'], $_POST['slug'], $_POST['author'], $_POST['authorName'], $_POST['date'], $_POST['category'], $_POST['tags'], $image, $_POST['id']);
        } else {
            $stmt = $conn->prepare("UPDATE sbp_posts SET post_title=?, post_contents=?, slug=?, author=?, authorName=?, date=?, post_category=?, post_tags=? WHERE id=?");
            $stmt->bind_param("ssssssssi", $_POST['title'], $_POST['contents'], $_POST['slug'], $_POST['author'], $_POST['authorName'], $_POST['date'], $_POST['category'], $_POST['tags'], $_POST['id']);
        }

        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "Blog updated successfully";
            // Redirect back to the previous page (assuming it's the page with the table)
            // header("location: tables.php");
            echo '<br><br><a href="/">Go Back</a> ';
        } else {
            echo "Error updating blog: " . $stmt->error;
        }
    }

                    if (isset ($_GET['id'])) {
                        $id = $_GET['id'];

                        // Query to retrieve blog details based on ID
                        $sql = "SELECT post_title, post_contents, slug, author, authorName, date, post_category, post_tags, image FROM sbp_posts WHERE id=?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows == 1) {
                            $row = $result->fetch_assoc();
                            // Display the form to edit blog details
                            echo '<head>';
                            echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.0/skins/ui/oxide/skin.min.css">';
                            echo '<style>';
                            echo 'form { max-width: 1200px; margin: 0 auto; padding: 20px; }';
                            echo 'input[type="text"], textarea { width: 100%; padding: 10px; margin: 5px; }';
                            echo 'input[type="submit"] { background-color: #4e73df; color: white; padding: 10px 20px; border: none; cursor: pointer; margin-top:10px; border-radius:7px;}';
                            echo 'input[type="submit"]:hover { background-color: #4e73dfab;}';
                            echo 'input[type="text"]:focus-visible { outline: 0px;}';
                            echo '</style>';
                            echo '</head>';
                            echo '<body>';
                            echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '"  enctype="multipart/form-data">';
                            echo '<input type="hidden" name="id" value="' . $id . '">';
                            echo '<label for="title">Title:</label><br>';
                            echo '<input type="text" name="title" value="' . $row["post_title"] . '"><br>';
                            echo '<label for="contents">Contents:</label><br>';
                            echo '<textarea name="contents" id="editor" rows="20" cols="50">' . $row["post_contents"] . '</textarea><br>';
                            echo '<label for="slug">Slug:</label><br>';
                            echo '<input type="text" name="slug" value="' . $row["slug"] . '"><br>';
                            echo '<label for="author">Author:</label><br>';
                            echo '<input type="text" name="author" value="' . $row["author"] . '"><br>';
                            echo '<label for="date">Author Name:</label><br>';
                            echo '<input type="text" name="authorName" value="' . $row["authorName"] . '"><br>';
                            echo '<label for="date">Date:</label><br>';
                            echo '<input type="text" name="date" value="' . $row["date"] . '"><br>';
                            echo '<label for="category">Category:</label><br>';
                            echo '<input type="text" name="category" value="' . $row["post_category"] . '"><br>';
                            echo '<label for="tags">Tags:</label><br>';
                            echo '<input type="text" name="tags" value="' . $row["post_tags"] . '"><br>';
                            echo '<label for="image">Image:</label><br>';
                            echo '<input type="file" name="image" id="image"><br>';
                            echo '<input type="submit" value="Save Changes">';
                            
                            echo '</form>';
                            echo '<script src="https://cdn.tiny.cloud/1/0kl5l33c89bex4zk7r65pvotwt9rf7zm1zghsqx8ejlgract/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>';
                            echo '<script>';
                            echo 'tinymce.init({
    selector: "textarea",
    plugins: "anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker",
    toolbar: "undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat",
    tinycomments_mode: "embedded",
    tinycomments_author: "Author name",
    mergetags_list: [
      { value: "First.Name", title: "First Name" },
      { value: "Email", title: "Email" },
    ],
  });';
                            echo '</script>';
                            echo '</body>';

                        } else {
                            echo 'Blog not found';
                        }
                    } else {
                        echo 'Invalid request';
                    }

                    // Close connection
                    // $conn->close();
                    ?>




    </main>

    <footer>
        <?php include_once '../sbp-contents/footer.php'; ?>
    </footer>

    <!-- JS here -->
 <?php include '../sbp-contents/importJs.php'; ?>
</body>

</html>
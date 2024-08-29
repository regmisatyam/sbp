<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login");
    exit;
}

$author = $_SESSION['username'];
$role = $_SESSION['role']; 

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>EditPost - Satyam Blogs</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

<!-- Css Files -->
<?php include './components/importCss.php';?>

</head>

<body>

  <!-- ======= Header ======= -->
 <?php include './components/header.php';?>
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <?php include './components/asidebar.php';?>
  <!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Edit Post</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo $website ?>/sbp-admin/dashboard/">Home</a></li>
          <li class="breadcrumb-item active">Edit Post</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <?php 
        include '../credentials.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
            $id = $_POST['id'];

            // Update blog fields in the database using prepared statements
            $update_sql = "UPDATE sbp_posts SET post_title=?, post_contents=?, post_excerpt=?, slug=?, author=?, date=?, post_category=?, post_tags=?, image=? WHERE id=?";
            $stmt = $conn->prepare($update_sql);
            // Check if an image file has been uploaded
            if (!empty($_FILES['image']['name'])) {
                // Handle image upload
                $target_dir = "../../assets/uploads/";
                $fileName = basename($_FILES["image"]["name"]);
                $target_file = $target_dir . $fileName;
                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if ($check !== false) {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        $image = $target_file;
                    } else {
                        echo "Error uploading file.";
                    }
                } else {
                    echo "File is not an image.";
                }
            } else {
                // No image file has been uploaded, set $image to NULL
                $image = NULL;
            }
            // Prepare and bind parameters for the SQL statement
            if (!empty($_FILES['image']['name'])) {
                $stmt = $conn->prepare("UPDATE sbp_posts SET post_title=?, post_contents=?, post_excerpt=?, slug=?, author=?, date=?, post_category=?, post_tags=?, image=? WHERE id=?");
                $stmt->bind_param("sssssssssi", $_POST['post_title'], $_POST['post_contents'], $_POST['post_excerpt'], $_POST['slug'], $_POST['author'], $_POST['date'], $_POST['post_category'], $_POST['post_tags'], $image, $_POST['id']);
            } else {
                $stmt = $conn->prepare("UPDATE sbp_posts SET post_title=?, post_contents=?, post_excerpt=?, slug=?, author=?, date=?, post_category=?, post_tags=? WHERE id=?");
                $stmt->bind_param("ssssssssi", $_POST['post_title'], $_POST['post_contents'], $_POST['post_excerpt'], $_POST['slug'], $_POST['author'], $_POST['date'], $_POST['post_category'], $_POST['post_tags'], $_POST['id']);
            }

            // Execute the prepared statement
            if ($stmt->execute()) {
                echo "Blog updated successfully";
                echo '<br><br><a href="posts-table.php">Go Back</a> ';
                exit(); // Ensure script execution stops here after redirecting
            } else {
                echo "Error updating blog: " . $stmt->error;
            }

        }

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Query to retrieve blog details based on ID
            $sql = "SELECT post_title, post_contents, post_excerpt, slug, author, date, post_category, post_tags, image FROM sbp_posts WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();

                // Check if the user is authorized to edit the post
                if ($role === 'superadmin' || $row['author'] === $author) {
                    // Display the form to edit blog details
                    echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" class="needs-validation" enctype="multipart/form-data">';
                    echo '<input type="hidden" name="id" value="' . $id . '">';
                    echo '<label for="title">Title:</label><br>';
                    echo '<input type="text" class="form-control" name="post_title" value="' . $row["post_title"] . '"><br>';
                    echo '<label for="contents">Contents:</label><br>';
                    echo '<textarea name="post_contents" class="tinymce-editor" id="editor" rows="20" cols="50">' . $row["post_contents"] . '</textarea><br>';
                    echo '<label for="excerpt">Excerpt:</label><br>';
                    echo '<input type="text" class="form-control" name="post_excerpt" value="' . $row["post_excerpt"] . '"><br>';
                    echo '<label for="slug">Slug:</label><br>';
                    echo '<input type="text" class="form-control"  name="slug" value="' . $row["slug"] . '"><br>';
                    echo '<label for="author">Author:</label><br>';
                    echo '<input type="text" class="form-control" disabled  name="author" value="' . $row["author"] . '"><br>';
                    echo '<label for="date">Date:</label><br>';
                    echo '<input type="text" class="form-control"  name="date" value="' . $row["date"] . '"><br>';
                    echo '<label for="category">Category:</label><br>';
                    echo '<input type="text" class="form-control"  name="post_category" value="' . $row["post_category"] . '"><br>';
                    echo '<label for="tags">Tags:</label><br>';
                    echo '<input type="text" class="form-control"  name="post_tags" value="' . $row["post_tags"] . '"><br>';

                    echo '<div class="row mb-3">
                                <label for="image">Select Image:</label>
                                <input type="file" accept="image/*" class="form-control" name="image" id="formFile">
                            </div>';

                    echo '<input type="submit" class="btn btn-primary" value="Save Changes">'; 
                    echo '<a href="posts-table.php" class="btn btn-primary mx-5">Go Back</a>';

                    echo '</form>';
                } else {
                    echo 'You are not authorized to edit this post.';
                }

            } else {
                echo 'Post not found.';
            }
        } else {
            echo 'Invalid request.';
        }

        ?>
    </section>


  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php include './components/footer.php';?>
<!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Js Files Here -->
<?php include './components/importJs.php';?>

</body>

</html>

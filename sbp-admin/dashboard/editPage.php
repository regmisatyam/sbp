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

  <title>Edit Page - Satyam Blogs</title>
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
      <h1>Edit Page</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo $website ?>/sbp-admin/dashboard/">Home</a></li>
          <li class="breadcrumb-item active">Edit Page</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <?php 
        include '../credentials.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
            $id = $_POST['id'];
            $page_title = $_POST['page_title'];
            $page_contents = $_POST['page_contents'];
            $slug = $_POST['slug'];
            $date = $_POST['date'];
            $displayInNav = $_POST['displayInNav'];

            // Update page fields in the database using prepared statements
            $update_sql = "UPDATE sbp_pages SET page_title=?, page_contents=?, slug=?, date=?, displayInNav=? WHERE id=?";
            $stmt = $conn->prepare($update_sql);
            
            // Check if prepare() returned false
            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($conn->error));
            }

            // Bind parameters for the SQL statement
            $stmt->bind_param("sssssi", $page_title, $page_contents, $slug, $date, $displayInNav, $id);

            // Execute the prepared statement
            if ($stmt->execute()) {
                echo "Page updated successfully";
                echo '<br><br><a href="pages-table.php">Go Back</a> ';
                exit(); // Ensure script execution stops here after redirecting
            } else {
                echo "Error updating page: " . htmlspecialchars($stmt->error);
            }

            $stmt->close(); // Close statement
        }

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Query to retrieve page details based on ID
            $sql = "SELECT page_title, page_contents, slug, author, date, displayInNav FROM sbp_pages WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();

                // Check if the user is authorized to edit the page
                if ($role === 'superadmin' || $row['author'] === $author) {
                    // Display the form to edit page details
                    echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" class="needs-validation" enctype="multipart/form-data">';
                    echo '<input type="hidden" name="id" value="' . htmlspecialchars($id) . '">';
                    echo '<label for="title">Title:</label><br>';
                    echo '<input type="text" class="form-control" name="page_title" value="' . htmlspecialchars($row["page_title"]) . '"><br>';
                    echo '<label for="displayInNav">Display in nav:</label><br>';
                    echo '<input type="text" class="form-control" name="displayInNav" value="' . htmlspecialchars($row["displayInNav"]) . '"><br>';
                    echo '<label for="contents">Contents:</label><br>';
                    echo '<textarea name="page_contents" class="tinymce-editor" id="editor" rows="20" cols="50">' . htmlspecialchars($row["page_contents"]) . '</textarea><br>';
                    echo '<label for="slug">Slug:</label><br>';
                    echo '<input type="text" class="form-control" name="slug" value="' . htmlspecialchars($row["slug"]) . '"><br>';
                    echo '<label for="date">Date:</label><br>';
                    echo '<input type="text" class="form-control" name="date" value="' . htmlspecialchars($row["date"]) . '"><br>';

                    echo '<input type="submit" class="btn btn-primary" value="Save Changes">'; 
                    echo '<a href="pages-table.php" class="btn btn-primary mx-5">Go Back</a>';

                    echo '</form>';
                } else {
                    echo 'You are not authorized to edit this page.';
                }

            } else {
                echo 'Page not found.';
            }

            $stmt->close(); // Close statement
        } else {
            echo 'Invalid request.';
        }

        $conn->close(); // Close connection
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

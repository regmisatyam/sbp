<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login");
    exit;
}
include '../credentials.php';
$author = $_SESSION['username'];
$role = $_SESSION['role']; // Assuming role is stored in the session
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Posts - Satyam Blogs</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Css Files -->
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

        <div class="pagetitle">
            <h1>Posts</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/sbp-admin/dashboard/">Home</a></li>
                    <li class="breadcrumb-item active">Posts</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">All Posts</h5>
                            <p>Showing all posts :</p>

                            <?php
                            ini_set('display_errors', 1);
                            ini_set('display_startup_errors', 1);
                            error_reporting(E_ALL);
                            
                            include '../credentials.php';

                            // Check if delete button is clicked
                            if (isset($_POST["delete_id"])) {
                                $delete_id = $_POST["delete_id"];
                                
                                // Delete the post from the database
                                $delete_sql = "DELETE FROM sbp_posts WHERE id=?";
                                $stmt = $conn->prepare($delete_sql);
                                $stmt->bind_param("i", $delete_id);

                                if ($stmt->execute()) {
                                    echo '<div class="alert c-alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                                            Blog deleted successfully
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                          </div>';
                                } else {
                                    echo '<div class="alert c-alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                                            Error deleting blog: ' . $stmt->error . '
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                          </div>';
                                }
                            }

                            // Query to retrieve blogs from the database
                            if ($role === 'superadmin') {
                                $sql = "SELECT post_title, post_excerpt, slug, id, date, post_category FROM sbp_posts";
                                $stmt = $conn->prepare($sql);
                            } else {
                                $sql = "SELECT post_title, post_excerpt, slug, id, date, post_category FROM sbp_posts WHERE author=?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("s", $author);
                            }

                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                echo '<table class="table datatable">';
                                echo '<thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Title</th>
                                            <th>Contents</th>
                                            <th>Category</th>
                                            <th data-type="date" data-format="YYYY/DD/MM">Date</th>
                                            <th>Actions</th>
                                        </tr>
                                      </thead>';
                                echo '<tbody>';

                                while ($row = $result->fetch_assoc()) {
                                    // Limit title to 20 words
                                    $post_title = implode(' ', array_slice(explode(' ', $row['post_title']), 0, 20));
                                    if (count(explode(' ', $row['post_title'])) > 20) {
                                        $post_title .= '...';
                                    }
                                    echo '<tr>';
                                    echo '<td><a href="editPost.php?id=' . $row["id"] . '">' . $row["id"] . '</a></td>';
                                    echo '<td>' . $post_title . '</td>';
                                    echo '<td>' . $row["post_excerpt"] . '</td>';
                                    echo '<td>' . $row["post_category"] . '</td>';
                                    echo '<td>' . $row["date"] . '</td>';
                                    echo '<td>
                                            <a class="btn btn-primary m-1" href="editPost.php?id=' . $row["id"] . '">Edit</a>
                                            <form method="post" onsubmit="return confirm(\'Are you sure you want to delete this post?\');" style="display:inline;">
                                                <input type="hidden" name="delete_id" value="' . $row["id"] . '">
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                          </td>';
                                    echo '</tr>';
                                }

                                echo '</tbody>';
                                echo '</table>';
                            } else {
                                echo '<p>No posts found</p>';
                            }
                           
                            ?>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php include './components/footer.php'; ?>
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Js Files Here -->
    <?php include './components/importJs.php'; ?>
</body>

</html>

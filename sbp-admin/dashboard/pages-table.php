<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login");
    exit;
}
include '../credentials.php';
$author = $_SESSION['username'];
$role = $_SESSION['role']; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Pages - Satyam Blogs</title>
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
            <h1>Pages</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/sbp-admin/dashboard/">Home</a></li>
                    <li class="breadcrumb-item active">Pages</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">All Pages</h5>
                            <p>Showing all Pages :</p>

                            <?php
                            ini_set('display_errors', 1);
                            ini_set('display_startup_errors', 1);
                            error_reporting(E_ALL);
                            
                            include '../credentials.php';

                            // Check if delete button is clicked
                            if (isset($_POST["delete_id"])) {
                                $delete_id = $_POST["delete_id"];
                                
                                // Delete the page from the database
                                $delete_sql = "DELETE FROM sbp_pages WHERE id=?";
                                $stmt = $conn->prepare($delete_sql);
                                $stmt->bind_param("i", $delete_id);

                                if ($stmt->execute()) {
                                    echo '<div class="alert c-alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                                            Page deleted successfully
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                          </div>';
                                } else {
                                    echo '<div class="alert c-alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                                            Error deleting page: ' . $stmt->error . '
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                          </div>';
                                }
                            }

                            // Query to retrieve pages from the database
                            if ($role === 'superadmin') {
                                $sql = "SELECT page_title, displayInNav, slug, id, date FROM sbp_pages";
                                $stmt = $conn->prepare($sql);
                            } else {
                                $sql = "SELECT page_title, displayInNav, slug, id, date FROM sbp_pages WHERE author=?";
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
                                            <th>Display In Navbar</th>
                                            <th data-type="date" data-format="YYYY/DD/MM">Date</th>
                                            <th>Actions</th>
                                        </tr>
                                      </thead>';
                                echo '<tbody>';

                                while ($row = $result->fetch_assoc()) {
                                    // Limit title to 20 words
                                    $page_title = implode(' ', array_slice(explode(' ', $row['page_title']), 0, 20));
                                    if (count(explode(' ', $row['page_title'])) > 20) {
                                        $page_title .= '...';
                                    }
                                    echo '<tr>';
                                    echo '<td><a href="editPage.php?id=' . $row["id"] . '">' . $row["id"] . '</a></td>';
                                    echo '<td>' . $page_title . '</td>';
                                    echo '<td>' . $row["displayInNav"] . '</td>';
                                  
                                    echo '<td>' . $row["date"] . '</td>';
                                    echo '<td>
                                            <a class="btn btn-primary m-1" href="editPage.php?id=' . $row["id"] . '">Edit</a>
                                            <form method="post" onsubmit="return confirm(\'Are you sure you want to delete this page?\');" style="display:inline;">
                                                <input type="hidden" name="delete_id" value="' . $row["id"] . '">
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                          </td>';
                                    echo '</tr>';
                                }

                                echo '</tbody>';
                                echo '</table>';
                            } else {
                                echo '<p>No Page found</p>';
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

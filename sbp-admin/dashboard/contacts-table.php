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

    <title>Contacts - Satyam Blogs</title>
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
            <h1>Contacts</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/sbp-admin/dashboard/">Home</a></li>
                    <li class="breadcrumb-item active">Contacts</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">All Contacts</h5>
                            <p>Showing all Contacts :</p>

                            <?php
                            // ini_set('display_errors', 1);
                            // ini_set('display_startup_errors', 1);
                            // error_reporting(E_ALL);
                            
                            include '../credentials.php';

                            // Check if delete button is clicked
                            if (isset($_POST["delete_id"])) {
                                $delete_id = $_POST["delete_id"];
                                
                                // Delete the page from the database
                                $delete_sql = "DELETE FROM contact_submissions WHERE id=?";
                                $stmt = $conn->prepare($delete_sql);
                                $stmt->bind_param("i", $delete_id);

                                if ($stmt->execute()) {
                                    echo '<div class="alert c-alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                                            Contact list deleted successfully
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                          </div>';
                                } else {
                                    echo '<div class="alert c-alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                                            Error deleting contact: ' . $stmt->error . '
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                          </div>';
                                }
                            }

                            // Query to retrieve contacts from the database
                            if ($role === 'superadmin' || $role === 'admin') {
                                $sql = "SELECT name, email, message, id, created_at, subject, website FROM contact_submissions";
                                $stmt = $conn->prepare($sql);
                            } else {
                                echo "";
                            }

                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                echo '<table class="table datatable">';
                                echo '<thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            <th>Website</th>
                                            <th data-type="date" data-format="YYYY/DD/MM">Date</th>
                                            <th>Actions</th>
                                        </tr>
                                      </thead>';
                                echo '<tbody>';

                                while ($row = $result->fetch_assoc()) {
                                    // Limit title to 20 words
                                    // $message = implode(' ', array_slice(explode(' ', $row['message']), 0, 20));
                                    // if (count(explode(' ', $row['message'])) > 20) {
                                    //     $message .= '...';
                                    // }
                                    echo '<tr>';
                                    echo '<td><a href="#id=' . $row["id"] . '">' . $row["id"] . '</a></td>';
                                    echo '<td>' . $row["name"] . '</td>';
                                    echo '<td>' . $row["email"] . '</td>';
                                    echo '<td>' . $row["subject"] . '</td>';
                                    echo '<td>' . $row["message"] . '</td>';
                                    echo '<td>' . $row["website"] . '</td>';
                                  
                                    echo '<td>' . $row["created_at"] . '</td>';
                                    echo '<td>
                                            <a class="btn btn-primary m-1" href="#reply?id=' . $row["id"] . '">Reply</a>
                                            <form method="post" onsubmit="return confirm(\'Are you sure you want to delete this list?\');" style="display:inline;">
                                                <input type="hidden" name="delete_id" value="' . $row["id"] . '">
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                          </td>';
                                    echo '</tr>';
                                }

                                echo '</tbody>';
                                echo '</table>';
                            } else {
                                echo '<p>No Contact Forms found</p>';
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

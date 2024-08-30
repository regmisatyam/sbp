<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login");
    exit;
}
include '../credentials.php';
include '../../sbp-contents/globalVar.php';
$author = $_SESSION['username'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Users - Satyam Blogs</title>
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
            <h1>Users</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $website ?>/sbp-admin/dashboard/">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">All Users</h5>
                            <p>Showing all Users :</p>

                            <?php
                            // ini_set('display_errors', 1);
                            // ini_set('display_startup_errors', 1);
                            // error_reporting(E_ALL);
                            
                            include '../credentials.php';
                            include '../../sbp-contents/globalVar.php';
                            // Default image path
                            $default_image = $website . 'assets/img/profile-img.jpg';

                            // Determine user image
                            $user_image = !empty($user['image']) ? 'assets/img/usr/' . htmlspecialchars($user['image']) : $default_image;


                            // Check if delete button is clicked
                            if (isset($_POST["delete_id"])) {
                                $delete_id = $_POST["delete_id"];

                                // Delete the user from the database
                                $delete_sql = "DELETE FROM sbp_users WHERE id=?";
                                $stmt = $conn->prepare($delete_sql);
                                $stmt->bind_param("i", $delete_id);

                                if ($stmt->execute()) {
                                    echo '<div class="alert c-alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                                            User deleted successfully
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                          </div>';
                                } else {
                                    echo '<div class="alert c-alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                                            Error deleting user: ' . $stmt->error . '
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                          </div>';
                                }
                            }

                            // Query to retrieve users from the database
                            if ($role === 'superadmin') {
                                $sql = "SELECT firstName, lastName, username, email, role, image, id, date FROM sbp_users";
                                $stmt = $conn->prepare($sql);
                            } else {
                                echo " ";
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
                                            <th>Username</th>
                                            <th>Image</th>
                                            <th>Role</th>
                                            <th data-type="date" data-format="YYYY/DD/MM">Date</th>
                                            <th>Actions</th>
                                        </tr>
                                      </thead>';
                                echo '<tbody>';

                                while ($row = $result->fetch_assoc()) {

                                    echo '<tr>';
                                    echo '<td><a href="editUser.php?id=' . $row["id"] . '">' . $row["id"] . '</a></td>';
                                    echo '<td>' . $row["firstName"] . ' ' . $row["lastName"] . '</td>';
                                    echo '<td>' . $row["email"] . '</td>';
                                    echo '<td>' . $row["username"] . '</td>';

                                    echo '<td><img src="assets/img/usr/' . $row["image"] . '" alt="' . $row["image"] . '" class="small-profile-img"/></td>';
                                    echo '<td>' . $row["role"] . '</td>';
                                    echo '<td>' . $row["date"] . '</td>';
                                    echo '<td>
                                            <a class="btn btn-primary m-1" href="editUser.php?id=' . $row["id"] . '">Edit</a>
                                            <form method="post" onsubmit="return confirm(\'Are you sure you want to delete this user?\');" style="display:inline;">
                                                <input type="hidden" name="delete_id" value="' . $row["id"] . '">
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                          </td>';
                                    echo '</tr>';
                                }

                                echo '</tbody>';
                                echo '</table>';
                            } else {
                                echo '<p>No User found</p>';
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

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Js Files Here -->
    <?php include './components/importJs.php'; ?>
</body>

</html>
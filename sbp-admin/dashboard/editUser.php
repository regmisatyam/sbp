<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login");
    exit;
}
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
$author = $_SESSION['username'];
$role = $_SESSION['role'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Edit User - Satyam Blogs</title>
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
            <h1>Edit User</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $website ?>/sbp-admin/dashboard/">Home</a></li>
                    <li class="breadcrumb-item active">Edit User</li>
                </ol>
            </nav>
        </div><!-- End User Title -->
        <section class="section">
            <?php if ($error): ?>
                <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                    <?php echo $error; ?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if ($password_error): ?>
                <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                    <?php echo $password_error; ?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['password_error']); ?>
            <?php endif; ?>
            <?php if ($password_success): ?>
                <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                    <?php echo $password_success; ?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['password_success']); ?>
            <?php endif; ?>

            <?php
            include '../credentials.php';
            
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
                $id = $_POST['id'];
                $firstName = $_POST['firstName'];
                $lastName = $_POST['lastName'];

                $email = $_POST['email'];
                $role = $_POST['role'];
                $date = $_POST['date'];
                $address = $_POST['address'];
                $phone = $_POST['phone'];
                $image = $_POST['image'];
                $password = $_POST['password'];

                // Update page fields in the database using prepared statements
                $update_sql = "UPDATE sbp_users SET firstName=?, lastName=?, password=?, email=?, role=?, date=?, address=?, phone=?, image=? WHERE id=?";
                $stmt = $conn->prepare($update_sql);


                // Check if image file is a actual image or fake image
                if ($image) {
                    $check = getimagesize($_FILES['image']['tmp_name']);
                    if ($check === false) {
                        $_SESSION['error'] = "File is not an image.";
                        header("Location: editUser.php");
                        exit;
                    }
                    // Check file size
                    if ($_FILES['image']['size'] > 500000) {
                        $_SESSION['error'] = "Sorry, your image file is too large.";
                        header("Location: editUser.php");
                        exit;
                    }
                    // Allow certain file formats
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                        $_SESSION['error'] = "Sorry, only JPG, JPEG, & PNG files are allowed.";
                        header("Location: editUser.php");
                        exit;
                    }

                    if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                        $_SESSION['error'] = "Sorry, there was an error uploading your file.";
                        header("Location: editUser.php");
                        exit;
                    }
                } else {
                    $sql = "SELECT image FROM sbp_users WHERE username=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $username);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $user = $result->fetch_assoc();
                        $image = $user['image'];

                    }
                }
                // Check if an image file has been uploaded
                if (!empty($_FILES['image']['name'])) {
                    // Handle image upload
                    $image = $_FILES['image']['name'];
                    $target_dir = "assets/img/usr";
                    $target_file = basename($image);
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

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

                 // Hash the password
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                // Prepare and bind parameters for the SQL statement
                if (!empty($_FILES['image']['name'])) {
                    $stmt = $conn->prepare("UPDATE sbp_users SET firstName=?, lastName=?, password=?, email=?, role=?, date=?, address=?, phone=?, image=? WHERE id=?");
                    $stmt->bind_param("sssssssssi", $_POST['firstName'], $_POST['lastName'], $_POST['password'], $_POST['email'], $_POST['role'], $_POST['date'], $_POST['address'], $_POST['phone'], $image, $_POST['id']);
                } else {
                    $stmt = $conn->prepare("UPDATE sbp_users SET firstName=?, lastName=?, password=?, email=?, role=?, date=?, address=?, phone=? WHERE id=?");
                    $stmt->bind_param("ssssssssi", $_POST['firstName'], $_POST['lastName'], $hashedPassword, $_POST['email'], $_POST['role'], $_POST['date'], $_POST['address'], $_POST['phone'], $_POST['id']);
                }
                // Execute the prepared statement
                if ($stmt->execute()) {
                    echo "User updated successfully";
                    echo '<br><br><a href="users.php">Go Back</a> ';
                    exit(); // Ensure script execution stops here after redirecting
                } else {
                    echo "Error updating page: " . htmlspecialchars($stmt->error);
                }

                $stmt->close(); // Close statement
            }

            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                // Query to retrieve page details based on ID
                $sql = "SELECT firstName, lastName, username, email, role, image, id, date, address, phone FROM sbp_users WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();

                    // Check if the user is authorized to edit the page
                    if ($role === 'superadmin') {
                        // Display form to edit user details
            
                        echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" class="needs-validation" enctype="multipart/form-data">';
                        echo '<input type="hidden" name="id" value="' . $id . '">';
                        echo '<img src="assets/img/usr/' . $row["image"] . '" class="medium-profile-image" /><br>';
                        echo '<label for="FirstName">First Name:</label><br>';
                        echo '<input type="text" class="form-control" name="firstName" value="' . $row["firstName"] . '"><br>';
                        echo '<label for="lastName">Last Name:</label><br>';
                        echo '<input type="text" class="form-control" name="lastName" value="' . $row["lastName"] . '"><br>';
                        echo '<label for="username">Username:</label><br>';
                        echo '<input type="text" class="form-control" name="username" value="' . $row["username"] . '" disabled /><br>';
                        echo '<label for="email">Email:</label><br>';
                        echo '<input type="text" class="form-control"  name="email" value="' . $row["email"] . '"><br>';
                        echo '<label for="role">Role:</label><br>';
                        echo '<input type="text" class="form-control" name="role" value="' . $row["role"] . '"><br>';
                        echo '<label for="date">Date:</label><br>';
                        echo '<input type="text" class="form-control"  name="date" value="' . $row["date"] . '"><br>';
                        echo '<label for="address">Address:</label><br>';
                        echo '<input type="text" class="form-control"  name="address" value="' . $row["address"] . '"><br>';
                        echo '<label for="phone">Phone:</label><br>';
                        echo '<input type="text" class="form-control"  name="phone" value="' . $row["phone"] . '"><br>';
                        echo '<label for="password">New Password:</label><br>';
                        echo '<input type="text" class="form-control" name="password"><br>';

                        echo '<div class="row mb-3">
                                <label for="image">Select Image:</label>
                                <input type="file" accept="image/*" class="form-control" name="image" id="formFile">
                            </div>';

                        echo '<input type="submit" class="btn btn-primary" value="Save Changes">';
                        echo '<a href="users.php" class="btn btn-primary mx-5">Go Back</a>';

                        echo '</form>';
                    } else {
                        echo 'You are not authorized to edit this page.';
                    }

                } else {
                    echo 'User not found.';
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
    <?php include './components/footer.php'; ?>
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Js Files Here -->
    <?php include './components/importJs.php'; ?>

</body>

</html>
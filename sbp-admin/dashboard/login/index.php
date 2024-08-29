<?php

session_start(); // Start the session at the beginning of the script
include '../../../sbp-contents/globalVar.php';

// Check if the user is already logged in
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
  header("location: $website/sbp-admin/dashboard/"); // Redirect to index page
    exit(); // Exit to prevent further execution of the script
}


$login = false;
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../../credentials.php';


    $username = $_POST["username"];
    $password = $_POST["password"];

    // Query to fetch the user's hashed password, email, and full name from the database
    $sql = "SELECT username, password, email, firstName, lastName, date, role FROM sbp_users WHERE username = ?";
    $stmt = mysqli_stmt_init($conn);

    // Prepare and execute a SQL query to retrieve the hashed password for the provided username
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            // Verify the password
            if (password_verify($password, $row['password'])) {
                // Password is correct, set login status to true and start session
                $login = true;
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['firstName'] = $row['firstName'];
                $_SESSION['lastName'] = $row['lastName'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['date'] = $row['date'];
                header("location: $website/sbp-admin/dashboard/");
                exit(); // Exit to prevent further execution of the script
            } else {
                // Password is incorrect
                $showError = "Invalid Password";
            }
        } else {
            // Username not found
            $showError = "Invalid Credentials";
        }
    } else {
        // Error preparing SQL statement
        $showError = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - Satyam Blogs</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

<!-- Css Files -->
<?php include '../components/importCss.php';?>

</head>

<body>

<main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="<?php echo $website ?>" class="logo d-flex align-items-center w-auto">
                  <img src="<?php echo $website ?>/assets/img/favicon.ico" alt="">
                  <span class="d-none d-lg-block">Satyam Blogs</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your username & password to login</p>
                  </div>

                  <form class="row g-3 needs-validation" action="" method="post" novalidate>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="username" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Don't have account? <a href="<?php echo $website ?>/new/register/">Create an account</a></p>
                    </div>
                  </form>
                  <?php
    if($login){
    echo ' <div class="alert c-alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> You are logged in
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div> ';
    }
    if($showError){
    echo '<div class="alert c-alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
   <strong>Error!</strong> '. $showError.'
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
    }
    ?>
                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Js Files Here -->
<?php include '../components/importJs.php';?>

</body>

</html>
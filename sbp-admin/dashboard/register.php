<?php
 error_reporting(E_ALL);
 ini_set('display_errors', 1);
$showAlert = false;
$showError = false;
$register = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../credentials.php';
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $role = $_POST["role"];

    // Check if username or email already exists
    $existsSql = "SELECT * FROM `sbp_users` WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($conn, $existsSql);
    $numExistsRow = mysqli_num_rows($result);

    if ($numExistsRow > 0) {
        $showError = "Username or Email already exists";
    } else {
      include '../../sbp-contents/globalVar.php';
        if ($password === $cpassword) {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user into the database
            $sql = "INSERT INTO `sbp_users` (`firstName`, `lastName`, `username`, `email`, `password`, `role`, `date`) VALUES ('$firstName', '$lastName', '$username', '$email', '$hashedPassword', '$role', current_timestamp())";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $register = "Registration Successful! Go to Login";
                $showAlert = true;
                header("location: $website/sbp-admin/dashboard/");
            } else {
                $showError = "Error during registration. Please try again.";
            }
        } else {
            $showError = "Passwords do not match";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Register - Satyam Blogs</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Css Files -->
  <?php include './components/importCss.php';?>
  <?php include '../../sbp-contents/globalVar.php';?>

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
                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                    <p class="text-center small">Enter your details to create account</p>
                  </div>

                  <form class="row g-3 needs-validation" method="post" action="" novalidate>
                    <div class="col-12">
                      <label for="yourName" class="form-label">First Name</label>
                      <input type="text" name="firstName" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Please, enter your First name!</div>
                    </div>
                    <div class="col-12">
                      <label for="yourName" class="form-label">Surname Name</label>
                      <input type="text" name="lastName" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Please, enter your Last name!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Your Email</label>
                      <input type="email" name="email" class="form-control" id="yourEmail" required>
                      <div class="invalid-feedback">Please enter a valid Email address!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="username" name="username" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please choose a username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="role" class="form-label">Role</label>
                      <input type="text" name="role" class="form-control" id="role" value="author">
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>
                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Confirm Password</label>
                      <input type="password" name="cpassword" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please confirm your password!</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required>
                        <label class="form-check-label" for="acceptTerms">I agree and accept the <a href="<?php echo $website ?>/privacy-policy/">terms and conditions</a></label>
                        <div class="invalid-feedback">You must agree before submitting.</div>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Create Account</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="login">Log in</a></p>
                    </div>
                  </form>

                </div>
              </div>
              <?php
              if($register){
                  echo '<div class="alert c-alert alert-success alert-dismissible fade show" role="alert">
                      <strong>Success!</strong> '. $register .'
                      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">×</span>
                      </button>
                  </div>';
                  
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

      </section>

    </div>
  </main>

  <!-- Js Files Here -->
  <?php include './components/importJs.php';?>

</body>

</html>

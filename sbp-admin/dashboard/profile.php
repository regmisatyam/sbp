<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login");
    exit;
}

$author = $_SESSION['username'];

include '../credentials.php';
include '../../sbp-contents/globalVar.php';


$sql = "SELECT id, firstName, lastName, email, username, password, role, date, image, address, about, job_title, country, phone, facebook, x, linkedin, instagram FROM sbp_users WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $author);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
$password_error = isset($_SESSION['password_error']) ? $_SESSION['password_error'] : '';
$password_success = isset($_SESSION['password_success']) ? $_SESSION['password_success'] : '';

function get_field_value($field_name, $default) {
    global $form_data, $user;
    return isset($form_data[$field_name]) ? $form_data[$field_name] : $default;
}
// Default image path
$default_image = $website.'assets/img/profile-img.jpg';

// Determine user image
$user_image = !empty($user['image']) ? 'assets/img/usr/' . htmlspecialchars($user['image']) : $default_image;

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Profile - Satyam Blogs</title>
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
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo $website; ?>/sbp-admin/dashboard/">Home</a></li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
              <img src="<?php echo $user_image; ?>" alt="Profile" class="rounded-circle">
              <h2><?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?></h2>
              <h3><?php echo htmlspecialchars($user['job_title']); ?></h3>
              <div class="social-links mt-2">
                <a href="https://x.com/<?php echo htmlspecialchars($user['x']); ?>" class="twitter" target="_blank"><i class="bi bi-twitter"></i></a>
                <a href="https://facebook.com/<?php echo htmlspecialchars($user['facebook']); ?>" class="facebook" target="_blank"><i class="bi bi-facebook"></i></a>
                <a href="https://instagram.com/<?php echo htmlspecialchars($user['instagram']); ?>" class="instagram" target="_blank"><i class="bi bi-instagram"></i></a>
                <a href="https://linkedin.com/in/<?php echo htmlspecialchars($user['linkedin']); ?>" class="linkedin" target="_blank"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
               <?php if ($error): ?>
                <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                <?php echo $error; ?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php endif; ?>
              <?php if ($password_error): ?>
                <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                <?php echo $password_error; ?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
                <?php unset($_SESSION['password_error']); ?>
              <?php endif; ?>
              <?php if ($password_success): ?>
                <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                <?php echo $password_success; ?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
                <?php unset($_SESSION['password_success']); ?>
              <?php endif; ?>
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">About</h5>
                  <p class="small fst-italic"><?php echo htmlspecialchars($user['about']); ?></p>

                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Job</div>
                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($user['job_title']); ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Country</div>
                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($user['country']); ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Address</div>
                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($user['address']); ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Phone</div>
                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($user['phone']); ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($user['email']); ?></div>
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form action="updateProfile.php" method="post" enctype="multipart/form-data">
                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                      <div class="col-md-8 col-lg-9">
                        <img src="<?php echo $user_image; ?>" alt="Profile">
                        <div class="pt-2">
                          <input type="file" name="image" class="form-control">
                        </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="firstName" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="firstName" type="text" class="form-control" id="firstName" value="<?php echo htmlspecialchars($user['firstName']); ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="lastName" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="lastName" type="text" class="form-control" id="lastName" value="<?php echo htmlspecialchars($user['lastName']); ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                      <div class="col-md-8 col-lg-9">
                        <textarea name="about" class="form-control" id="about" style="height: 100px"><?php echo htmlspecialchars($user['about']); ?></textarea>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Job" class="col-md-4 col-lg-3 col-form-label">Job</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="job_title" type="text" class="form-control" id="Job" value="<?php echo htmlspecialchars($user['job_title']); ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Country" class="col-md-4 col-lg-3 col-form-label">Country</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="country" type="text" class="form-control" id="Country" value="<?php echo htmlspecialchars($user['country']); ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="address" type="text" class="form-control" id="Address" value="<?php echo htmlspecialchars($user['address']); ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="phone" type="text" class="form-control" id="Phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="email" type="email" class="form-control" id="Email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook Username</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="facebook" type="text" class="form-control" id="Facebook" value="<?php echo htmlspecialchars($user['facebook']); ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram Username</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="instagram" type="text" class="form-control" id="Instagram" value="<?php echo htmlspecialchars($user['instagram']); ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Linkedin" class="col-md-4 col-lg-3 col-form-label">Linkedin Username</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="linkedin" type="text" class="form-control" id="Linkedin" value="<?php echo htmlspecialchars($user['linkedin']); ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="X" class="col-md-4 col-lg-3 col-form-label">X Username</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="x" type="text" class="form-control" id="x" value="<?php echo htmlspecialchars($user['x']); ?>">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-settings">

                  <!-- Settings Form -->
                  <form>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                      <div class="col-md-8 col-lg-9">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="changesMade" checked>
                          <label class="form-check-label" for="changesMade">
                            Changes made to your account
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="newProducts" checked>
                          <label class="form-check-label" for="newProducts">
                            Information on new products and services
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="proOffers">
                          <label class="form-check-label" for="proOffers">
                            Marketing and promo offers
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="securityNotify" checked disabled>
                          <label class="form-check-label" for="securityNotify">
                            Security alerts
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form><!-- End settings Form -->

                </div>

            <div class="tab-pane fade pt-3" id="profile-change-password">
                <!-- Change Password Form -->
                <form action="changePassword.php" method="post">
                    <div class="row mb-3">
                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                    <div class="col-md-8 col-lg-9">
                        <input name="password" type="password" class="form-control" id="currentPassword">
                    </div>
                    </div>

                    <div class="row mb-3">
                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                    <div class="col-md-8 col-lg-9">
                        <input name="newpassword" type="password" class="form-control" id="newPassword">
                    </div>
                    </div>

                    <div class="row mb-3">
                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                    <div class="col-md-8 col-lg-9">
                        <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                    </div>
                    </div>

                    <div class="text-center">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                </form><!-- End Change Password Form -->
            </div>


              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main>
  
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php include './components/footer.php';?>
<!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Js Files Here -->
<?php include './components/importJs.php';?>

</body>

</html>

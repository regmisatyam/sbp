<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login");
    exit;
}

include '../credentials.php';

$username = $_SESSION['username'];

// Function to sanitize inputs
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$firstName = sanitize_input($_POST['firstName']);
$lastName = sanitize_input($_POST['lastName']);
$about = sanitize_input($_POST['about']);
$job_title = sanitize_input($_POST['job_title']);
$country = sanitize_input($_POST['country']);
$address = sanitize_input($_POST['address']);
$phone = sanitize_input($_POST['phone']);
$facebook = sanitize_input($_POST['facebook']);
$instagram = sanitize_input($_POST['instagram']);
$linkedin = sanitize_input($_POST['linkedin']);
$x = sanitize_input($_POST['x']);

$image = $_FILES['image']['name'];
$target_dir = "assets/img/usr/";
$target_file = $target_dir . basename($image);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Store form data in session
$_SESSION['form_data'] = $_POST;
if ($image) {
    $_SESSION['form_data']['image'] = $image;
}

// Check if image file is a actual image or fake image
if ($image) {
    $check = getimagesize($_FILES['image']['tmp_name']);
    if($check === false) {
        $_SESSION['error'] = "File is not an image.";
        header("Location: profile.php");
        exit;
    }
    // Check file size
    if ($_FILES['image']['size'] > 500000) {
        $_SESSION['error'] = "Sorry, your image file is too large.";
        header("Location: profile.php");
        exit;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $_SESSION['error'] = "Sorry, only JPG, JPEG, & PNG files are allowed.";
        header("Location: profile.php");
        exit;
    }

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $_SESSION['error'] = "Sorry, there was an error uploading your file.";
        header("Location: profile.php");
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

$sql = "UPDATE sbp_users SET firstName=?, lastName=?, about=?, job_title=?, country=?, address=?, phone=?, facebook=?, instagram=?, linkedin=?, x=?, image=? WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssssssss", $firstName, $lastName, $about, $job_title, $country, $address, $phone, $facebook, $instagram, $linkedin, $x, $image, $username);

if ($stmt->execute()) {
    unset($_SESSION['form_data']);
    unset($_SESSION['error']);
    header("Location: profile.php");
} else {
    $_SESSION['error'] = "Error: " . $stmt->error;
    header("Location: profile.php");
}
$stmt->close();
$conn->close();
?>

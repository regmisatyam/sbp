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
$currentPassword = $_POST['password'];
$newPassword = $_POST['newpassword'];
$renewPassword = $_POST['renewpassword'];

// Function to sanitize inputs
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Sanitize inputs
$currentPassword = sanitize_input($currentPassword);
$newPassword = sanitize_input($newPassword);
$renewPassword = sanitize_input($renewPassword);

// Check if new passwords match
if ($newPassword !== $renewPassword) {
    $_SESSION['password_error'] = "New passwords do not match.";
    header("Location: profile.php");
    exit;
}

// Retrieve the current password hash from the database
$sql = "SELECT password FROM sbp_users WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (password_verify($currentPassword, $user['password'])) {
    // Hash the new password
    $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the password in the database
    $sql = "UPDATE sbp_users SET password=? WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $newPasswordHash, $username);

    if ($stmt->execute()) {
        $_SESSION['password_success'] = "Password changed successfully.";
        header("Location: profile.php");
    } else {
        $_SESSION['password_error'] = "Error: " . $stmt->error;
        header("Location: profile.php");
    }
} else {
    $_SESSION['password_error'] = "Current password is incorrect.";
    header("Location: profile.php");
}

$stmt->close();
$conn->close();
?>

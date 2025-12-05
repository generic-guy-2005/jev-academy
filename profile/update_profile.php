<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../connection.php';
error_log("Database connection established.");

$user_id = $_SESSION['id'];

$sql = "SELECT user_image FROM users WHERE user_id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$oldData = $stmt->get_result()->fetch_assoc();
error_log("Fetched old user data: " . print_r($oldData, true));

$old_pfp = $oldData['user_image'];
$new_pfp_name = $old_pfp;

if (!empty($_FILES['user_image']['name'])) {
    error_log("New profile picture uploaded.");
    $img = $_FILES['user_image'];

    // File checks
    $allowed_ext = ['jpg', 'jpeg', 'png'];
    $ext = strtolower(pathinfo($img['name'], PATHINFO_EXTENSION));
    error_log("Uploaded image extension: " . $ext);

    if (!in_array($ext, $allowed_ext)) {
        error_log("Invalid image format: " . $ext);
        die("Invalid image format.");
    }

    if ($img['size'] > 2 * 1024 * 1024) {
        error_log("Image size too large: " . $img['size']);
        die("Image size too large (max 2MB).");
    }

    // New image name
    $new_pfp_name = "pfp_" . $user_id . "_" . time() . "." . $ext;
    $upload_dir = "../upload/profile/";
    $upload_path = $upload_dir . $new_pfp_name;
    error_log("Uploading new profile picture to: " . $upload_path);

    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
        error_log("Created directory: " . $upload_dir);
    }

    if (move_uploaded_file($img['tmp_name'], $upload_path)) {
        error_log("Profile picture uploaded successfully.");
    } else {
        error_log("Failed to move uploaded file to: " . $upload_path);
        die("Failed to upload image.");
    }

    if ($old_pfp && file_exists($upload_dir . $old_pfp)) {
        unlink($upload_dir . $old_pfp);
        error_log("Old profile picture removed: " . $old_pfp);
    }
}

$username = $_POST['username'];

$update = "UPDATE users SET
    user_name = ?,
    user_image = ?
    WHERE user_id = ?
";

$stmt = $connection->prepare($update);
$stmt->bind_param(
    "ssi",
    $username,
    $new_pfp_name,
    $user_id
);
error_log("Executing profile update for user_id: " . $user_id);

if ($stmt->execute()) {
    echo "success";

    $_SESSION['user_image'] = $new_pfp_name;
    $_SESSION['username'] = $username;
    error_log("Profile updated successfully for user_id: " . $user_id);
} else {
    if ($new_pfp_name !== $old_pfp && file_exists($upload_dir . $new_pfp_name)) {
        unlink($upload_dir . $new_pfp_name);
        error_log("Rolled back: Removed newly uploaded profile picture: " . $new_pfp_name);
    }
    echo "error";
    error_log("Error updating profile for user_id " . $user_id . ": " . $stmt->error);
}

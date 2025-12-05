<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
require '../connection.php';
error_log("Password update script accessed.");

if (!isset($_SESSION['id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "You must be logged in."
    ]);
    error_log("Unauthorized access attempt to password update.");
    exit;
}

$user_id = $_SESSION['id'];

// Get input
$old_password = $_POST['old_password'] ?? '';
$new_password = $_POST['new_password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Check empty fields
if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
    echo json_encode([
        "status" => "error",
        "message" => "All fields are required."
    ]);
    error_log("Password update failed: Missing fields.");
    exit;
}

// New password match
if ($new_password !== $confirm_password) {
    echo json_encode([
        "status" => "error",
        "message" => "New password and confirmation do not match."
    ]);
    error_log("Password update failed: Passwords do not match.");
    exit;
}

// Fetch old password from DB
$sql = "SELECT user_password FROM users WHERE user_id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        "status" => "error",
        "message" => "User not found."
    ]);
    error_log("Password update failed: User not found.");
    exit;
}

$row = $result->fetch_assoc();
$current_hashed_password = $row['user_password'];

// Verify old password
if (md5($old_password) !== $current_hashed_password) {
    echo json_encode([
        "status" => "error",
        "message" => "Old password is incorrect."
    ]);
    error_log("Password update failed: Incorrect old password.");
    exit;
}

// Hash new password
$new_hashed_password = md5($new_password);

// Update query
$update_sql = "UPDATE users SET user_password = ? WHERE user_id = ?";
$update_stmt = $connection->prepare($update_sql);
$update_stmt->bind_param("si", $new_hashed_password, $user_id);

if ($update_stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Password updated successfully."
    ]);
    error_log("Password updated successfully for user ID: $user_id.");
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to update password. Try again."
    ]);
    error_log("Password update failed for user ID: $user_id. Database error.");
}

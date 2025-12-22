<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "error";
    exit;
}

$user_id = $_SESSION['id'];

// Get user data
$sql = "SELECT user_image, user_role FROM users WHERE user_id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$user_image = $result['user_image'] ?? null;
$user_role = $result['user_role'] ?? null;

// Admin kebal hukum
if ($user_role === 'admin') {
    echo "forbidden";
    error_log("Admin account cannot be deleted: " . $user_id);
    exit;
}

error_log("Attempting to delete account for user_id: " . $user_id);

$connection->begin_transaction();

try {
    // Get wallet ID
    $sql = "SELECT wallet_id FROM wallet WHERE wallet_user_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $wallet_result = $stmt->get_result()->fetch_assoc();
    $wallet_id = $wallet_result['wallet_id'] ?? null;

    if ($wallet_id) {
        // Delete payments
        $sql = "DELETE FROM payment WHERE payment_wallet = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $wallet_id);
        $stmt->execute();
        error_log("Deleted payments for wallet_id: " . $wallet_id);

        // Delete topups
        $sql = "DELETE FROM topup WHERE topup_wallet_id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $wallet_id);
        $stmt->execute();
        error_log("Deleted topups for wallet_id: " . $wallet_id);
    }

    // Delete wallet
    $sql = "DELETE FROM wallet WHERE wallet_user_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    error_log("Deleted wallet for user_id: " . $user_id);

    // Delete enrollments (student saja)
    $sql = "DELETE FROM enrollment WHERE enrollment_student_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    error_log("Deleted enrollments for user_id: " . $user_id);

    // Delete user
    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    error_log("Deleted user: " . $user_id);

    $connection->commit();

    if ($user_image && file_exists("../upload/profile/" . $user_image)) {
        if (unlink("../upload/profile/" . $user_image)) {
            error_log("Deleted profile picture: " . $user_image);
        }
    }

    session_destroy();
    echo "success";
    error_log("Account successfully deleted for user_id: " . $user_id);
} catch (Exception $e) {
    $connection->rollback();
    error_log("Error deleting account for user_id " . $user_id . ": " . $e->getMessage());
    echo "error";
}
$connection->close();
exit();
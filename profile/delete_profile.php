<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request method');
}

$user_id = $_SESSION['id'];

$sql = "SELECT user_image FROM users WHERE user_id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$user_image = $result['user_image'];

error_log("Attempting to delete account for user_id: " . $user_id);

$connection->begin_transaction();

try {
    $sql = "SELECT wallet_id FROM wallet WHERE wallet_user_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $wallet_result = $stmt->get_result()->fetch_assoc();
    $wallet_id = $wallet_result['wallet_id'] ?? null;

    if ($wallet_id) {
        $sql = "DELETE FROM payment WHERE payment_wallet = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $wallet_id);
        $stmt->execute();
        error_log("Deleted payments for wallet_id: " . $wallet_id);
    }

    $sql = "DELETE FROM wallet WHERE wallet_user_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    error_log("Deleted wallet for user_id: " . $user_id);

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
    header('Location: ../login.php');
    exit();
} catch (Exception $e) {
    $connection->rollback();
    error_log("Error deleting account for user_id " . $user_id . ": " . $e->getMessage());
    echo "error";
}
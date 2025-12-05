<?php
session_start();
include '../connection.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SESSION['role'] !== 'admin') {
    echo "unauthorized";
    error_log("Unauthorized access attempt to user_delete.php by user ID: " . $_SESSION['id']);
    exit;
}


if (!isset($_POST['id'])) {
    echo "error";
    error_log("No user ID provided for deletion.");
    exit;
}

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $userQuery = "SELECT user_role FROM users WHERE user_id = $id";
    $userResult = mysqli_query($connection, $userQuery);


    if (mysqli_num_rows($userResult) === 0) {
        echo "error";
        error_log("User ID $id not found for deletion.");
        exit;
    }

    $userData = mysqli_fetch_assoc($userResult);
    $userRole = $userData['user_role'];

    if ($userRole === "admin") {
        echo "forbidden";
        error_log("Attempt to delete admin user ID $id blocked.");
        exit;
    }

    mysqli_begin_transaction($connection);
    try {

        if ($userRole === "student") {

            // Get wallet ID (if any)
            $walletQ = "SELECT wallet_id FROM wallet WHERE wallet_user_id = $id";
            $walletR = mysqli_query($connection, $walletQ);
            error_log("Wallet query for user ID $id: " . $walletQ);

            if (mysqli_num_rows($walletR) > 0) {
                $walletData = mysqli_fetch_assoc($walletR);
                $walletID = $walletData['wallet_id'];

                // Delete payments referencing wallet
                mysqli_query($connection, "DELETE FROM payment WHERE payment_wallet = $walletID");
                error_log("Deleted payments for wallet ID $walletID");

                // Delete topups referencing wallet
                mysqli_query($connection, "DELETE FROM topup WHERE topup_wallet_id = $walletID");
                error_log("Deleted topups for wallet ID $walletID");

                // Delete wallet
                mysqli_query($connection, "DELETE FROM wallet WHERE wallet_id = $walletID");
                error_log("Deleted wallet ID $walletID");
            }

            // Delete student enrollments
            mysqli_query($connection, "DELETE FROM enrollment WHERE enrollment_student_id = $id");
            error_log("Deleted enrollments for student ID $id");
        }

        if ($userRole === "instructor") {
            $walletQ = "SELECT wallet_id FROM wallet WHERE wallet_user_id = $id";
            $walletR = mysqli_query($connection, $walletQ);
            error_log("Wallet query for user ID $id: " . $walletQ);

            if (mysqli_num_rows($walletR) > 0) {
                $walletData = mysqli_fetch_assoc($walletR);
                $walletID = $walletData['wallet_id'];
                error_log("Found wallet ID $walletID for instructor ID $id");

                mysqli_query($connection, "DELETE FROM payment WHERE payment_wallet = $walletID");
                error_log("Deleted payments for wallet ID $walletID");

                mysqli_query($connection, "DELETE FROM topup WHERE topup_wallet_id = $walletID");
                error_log("Deleted topups for wallet ID $walletID");

                mysqli_query($connection, "DELETE FROM wallet WHERE wallet_id = $walletID");
                error_log("Deleted wallet ID $walletID");
            }

            $courseQ = "SELECT course_id FROM courses WHERE course_instruct_id = $id";
            $courseR = mysqli_query($connection, $courseQ);
            error_log("Course query for instructor ID $id: " . $courseQ);

            while ($course = mysqli_fetch_assoc($courseR)) {
                $courseID = $course['course_id'];

                $sectionQ = "SELECT section_id FROM sections WHERE section_course_id = $courseID";
                $sectionR = mysqli_query($connection, $sectionQ);
                error_log("Section query for course ID $courseID: " . $sectionQ);

                while ($section = mysqli_fetch_assoc($sectionR)) {
                    $sectionID = $section['section_id'];
                    error_log("Deleting lessons for section ID $sectionID");

                    mysqli_query($connection, "DELETE FROM lessons WHERE lesson_section_id = $sectionID");
                    error_log("Deleted lessons for section ID $sectionID");

                    mysqli_query($connection, "DELETE FROM sections WHERE section_id = $sectionID");
                    error_log("Deleted section ID $sectionID");
                }

                mysqli_query($connection, "DELETE FROM enrollment WHERE enrollment_course_id = $courseID");
                error_log("Deleted enrollments for course ID $courseID");

                mysqli_query($connection, "DELETE FROM payment WHERE payment_item = $courseID");
                error_log("Deleted payments for course ID $courseID");

                mysqli_query($connection, "DELETE FROM courses WHERE course_id = $courseID");
                error_log("Deleted course ID $courseID");
            }
        }

        // Delete from users last
        mysqli_query($connection, "DELETE FROM users WHERE user_id = $id");
        error_log("Deleted user ID $id");

        // Commit transaction
        mysqli_commit($connection);
        echo "success";
        error_log("User ID $id deletion successful.");
    } catch (Exception $e) {
        mysqli_rollback($connection);
        error_log("Error deleting user ID $id: " . $e->getMessage());
        echo "error";
    }
    exit;
} else {
    echo "error";
    exit;
}

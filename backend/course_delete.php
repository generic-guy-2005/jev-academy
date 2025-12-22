<?php
session_start();
include '../connection.php';

error_reporting(E_ALL);
ini_set('display errors', 1);

ob_start();

if ($connection->connect_error) {
    $error_msg = 'Connection failed: ' . $connection->connect_error;
    error_log("DB Connection Error: " . $error_msg);
    echo json_encode(['success' => false, 'message' => $error_msg]);
    ob_end_flush();
    exit();
}

error_log("Delete request received for course ID: " . ($_GET['id'] ?? 'not set'));

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $error_msg = 'Invalid course ID: ' . ($_GET['id'] ?? 'null');
    error_log("Invalid ID error: " . $error_msg);
    echo json_encode(['success' => false, 'message' => $error_msg]);
    ob_end_flush();
    exit;
}

$course_id = intval($_GET['id']);
$user_id = $_SESSION['id'];

error_log("Processing delete for Course ID: $course_id by User ID: $user_id");

if (!$user_id) {
    error_log("User not logged in");
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    ob_end_flush();
    exit;
}

try {
    // Check if current user is the instructor of this course
    $check_sql = "SELECT course_instruct_id, course_name FROM courses WHERE course_id = $course_id";
    error_log("Check SQL: " . $check_sql);

    $check_result = $connection->query($check_sql);

    if ($check_result->num_rows === 0) {
        throw new Exception('Course not found');
    }

    $course_data = $check_result->fetch_assoc();
    error_log("Course data: " . print_r($course_data, true));

    if ($course_data['course_instruct_id'] != $user_id) {
        throw new Exception('You are not authorized to delete this course');
    }

    // Begin transaction
    $connection->begin_transaction();
    error_log("Transaction started");

    // Delete lessons 
    $delete_lessons_sql = "DELETE FROM lessons 
        WHERE lesson_section_id IN (
        SELECT section_id FROM sections WHERE section_course_id = $course_id
    )";
    if (!$connection->query($delete_lessons_sql)) {
        throw new Exception('Failed to delete lessons: ' . $connection->error);
    }
    error_log("Lessons deleted successfully");

    // Delete sections 
    $delete_sections_sql = "DELETE FROM sections WHERE section_course_id = $course_id";
    error_log("Deleting sections SQL: " . $delete_sections_sql);

    if (!$connection->query($delete_sections_sql)) {
        throw new Exception('Failed to delete sections: ' . $connection->error);
    }
    error_log("Sections deleted successfully");

    // Delete enrollments 
    $delete_enrollments_sql = "DELETE FROM enrollment WHERE enrollment_course_id = $course_id";
    error_log("Deleting enrollments SQL: " . $delete_enrollments_sql);

    if (!$connection->query($delete_enrollments_sql)) {
        throw new Exception('Failed to delete enrollments: ' . $connection->error);
    }
    error_log("Enrollments deleted successfully");

    // Delete the course
    $delete_course_sql = "DELETE FROM courses WHERE course_id = $course_id";
    error_log("Deleting course SQL: " . $delete_course_sql);

    if (!$connection->query($delete_course_sql)) {
        throw new Exception('Failed to delete course: ' . $connection->error);
    }
    error_log("Course deleted successfully");

    // Commit transaction
    $connection->commit();
    error_log("Transaction committed");

    $response_data = ['success' => true, 'message' => 'Course deleted successfully'];
    error_log("Response: " . print_r($response_data, true));

    ob_clean();
    echo json_encode($response_data);
} catch (Exception $e) {
    if ($connection) {
        $connection->rollback();
        error_log("Transaction rolled back due to error");
    }

    $error_msg = $e->getMessage();
    error_log("Exception caught: " . $error_msg);

    $response = ['success' => false, 'message' => $error_msg];
    error_log("Error response: " . print_r($response, true));

    ob_clean();
    echo json_encode($response);
}

ob_end_flush();

if ($connection) {
    $connection->close();
}

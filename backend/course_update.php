<?php
session_start();
$current_user = $_SESSION['id'];

error_log("keep_current_image value: " . ($_POST['keep_current_image'] ?? 'not set'));
error_log("image_type value: " . ($_POST['image_type'] ?? 'not set'));
error_log("course_image file: " . (isset($_FILES['course_image']) ? 'set' : 'not set'));

include '../connection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($connection->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $connection->connect_error]));
}

$connection->begin_transaction();

try {
    error_log("POST data: " . print_r($_POST, true));
    error_log("FILES data: " . print_r($_FILES, true));

    // Course Info
    $course_id = intval($_POST['update_id']);
    $course_name = $connection->real_escape_string($_POST['course_name']);
    $course_field = $connection->real_escape_string($_POST['course_field']);
    $course_cost = floatval($_POST['course_cost']);
    $course_desc = $connection->real_escape_string($_POST['course_desc']);

    error_log("Course info parsed successfully");

    // El gambarnya - FIXED: Compare with string '0'
    $update_image = false;
    $course_image = '';

    // FIXED: Check if keep_current_image is set and equals string '0'
    if (isset($_POST['keep_current_image']) && $_POST['keep_current_image'] == '0') {
        error_log("Keep current image is 0, processing image update");

        // First check if uploading a file
        if (isset($_FILES['course_image']) && $_FILES['course_image']['error'] === UPLOAD_ERR_OK) {
            error_log("Processing image upload");

            $target_dir = "../upload/courses/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
                error_log("Created directory: " . $target_dir);
            }

            $file_extension = pathinfo($_FILES['course_image']['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '_' . time() . '.' . $file_extension;
            $course_image = 'upload/courses/' . $filename;
            $target_file =  '../upload/courses/' . $filename;

            if (!move_uploaded_file($_FILES['course_image']['tmp_name'], $target_file)) {
                throw new Exception('Failed to upload course image');
            }

            $update_image = true;
            error_log("Image uploaded successfully: " . $course_image);
        }
        // Check if using default image (from image_type parameter)
        else if (isset($_POST['image_type']) && $_POST['image_type'] === 'default') {
            $course_image = 'assets/default-course-image.jpg';
            $update_image = true;
            error_log("Using default image");
        }
        // If no file and not default, keep current image (don't update image field)
        else {
            error_log("No new image selected, keeping current image");
            // Don't update the image field
        }
    } else {
        error_log("Keeping current image (keep_current_image = " . $_POST['keep_current_image'] . ")");
        // Don't update the image field
    }

    // Build SQL query - FIXED: Only include course_image if we're updating it
    $sql = "UPDATE courses SET 
            course_name = '$course_name', 
            course_field = '$course_field', 
            course_instruct_id = '$current_user', 
            course_cost = $course_cost, 
            course_desc = '$course_desc'";

    if ($update_image && !empty($course_image)) {
        $sql .= ", course_image = '$course_image'";
    }

    $sql .= " WHERE course_id = $course_id;";

    error_log("SQL Query: " . $sql);

    if (!$connection->query($sql)) {
        throw new Exception('Failed to update course: ' . $connection->error);
    }

    error_log("Course updated successfully!");

    // ... rest of the code remains the same ...

    // Commit transaction
    $connection->commit();
    error_log("Transaction committed successfully");
    echo json_encode(['success' => true, 'message' => 'Course updated successfully']); // Changed from 'created' to 'updated'
} catch (Exception $e) {
    // Rollback on error
    $connection->rollback();
    error_log("Error occurred: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$connection->close();

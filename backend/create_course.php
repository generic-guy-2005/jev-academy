<?php
session_start();
$current_user = $_SESSION['id'];

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
    $course_token = $_POST['course_token'];
    $course_name = $connection->real_escape_string($_POST['course_name']);
    $course_field = $connection->real_escape_string($_POST['course_field']);
    $course_cost = floatval($_POST['course_cost']);
    $course_desc = $connection->real_escape_string($_POST['course_desc']);

    error_log("Step 1: Course info parsed successfully");

    // El gambarnya
    $course_image = '';
    if (isset($_POST['image_type']) && $_POST['image_type'] === 'upload' && isset($_FILES['course_image'])) {
        error_log("Step 2a: Processing image upload");

        $target_dir = "../upload/courses/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
            error_log("Created directory: " . $target_dir);
        }

        if ($_FILES['course_image']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('File upload error code: ' . $_FILES['course_image']['error']);
        }

        $file_extension = pathinfo($_FILES['course_image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '_' . time() . '.' . $file_extension;
        $course_image = 'upload/courses/' . $filename;
        $target_file =  '../upload/courses/' . $filename;

        error_log("Attempting to move file to: " . $target_file);

        if (!move_uploaded_file($_FILES['course_image']['tmp_name'], $target_file)) {
            throw new Exception('Failed to upload course image');
        }

        error_log("Image uploaded successfully: " . $course_image);
    } else if (isset($_POST['image_type']) && $_POST['image_type'] === 'default') {
        error_log("Step 2b: Using default image");
        $course_image = 'assets/default-course-image.jpg';
    } else {
        error_log("Step 2c: No image specified, using empty string");
    }

    // MASOKKKANNN
    $sql = "INSERT INTO courses (course_name, course_field, course_instruct_id, course_cost, course_desc, course_token, course_image) 
            VALUES ('$course_name', '$course_field', '$current_user', $course_cost, '$course_desc', '$course_token', '$course_image')";

    error_log("SQL Query: " . $sql);

    if (!$connection->query($sql)) {
        throw new Exception('Failed to insert course: ' . $connection->error);
    }

    $course_id = $connection->insert_id;
    error_log("Step 4: Course inserted with ID: " . $course_id);

    if (!isset($_POST['section_titles']) || !isset($_POST['section_files_indexes'])) {
        throw new Exception('Missing section data');
    }

    $section_titles = json_decode($_POST['section_titles'], true);
    $section_files_indexes = json_decode($_POST['section_files_indexes'], true);

    error_log("Step 5: Processing " . count($section_titles) . " sections");
    error_log("Files indexes: " . print_r($section_files_indexes, true));

    foreach ($section_titles as $index => $section_title) {
        error_log("Processing section $index: $section_title");
        $section_title = $connection->real_escape_string($section_title);

        // Section
        $sql = "INSERT INTO sections (section_name, sort_order, section_course_id) 
                VALUES ('$section_title', " . ($index + 1) . ", $course_id)";

        error_log("Section SQL: " . $sql);

        if (!$connection->query($sql)) {
            throw new Exception('Failed to insert section: ' . $connection->error);
        }

        $section_id = $connection->insert_id;
        error_log("Section inserted with ID: " . $section_id);

        // Handle markdown file upload
        if (in_array($index, $section_files_indexes) && isset($_FILES["section_file_$index"])) {
            error_log("Processing file for section $index");

            $md_file = $_FILES["section_file_$index"];
            if ($md_file['error'] !== UPLOAD_ERR_OK) {
                throw new Exception('Section file upload error code: ' . $md_file['error']);
            }

            $target_dir = "../upload/lessons/";

            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
                error_log("Created lessons directory: " . $target_dir);
            }

            $lesson_filename = $course_id . '_section' . ($index + 1) . '_' . time() . '.md';
            $lesson_file = 'upload/lessons/' . $lesson_filename;
            $target_file = '../upload/lessons/' . $lesson_filename;

            error_log("Attempting to move lesson file to: " . $target_file);

            if (!move_uploaded_file($md_file['tmp_name'], $target_file)) {
                throw new Exception('Failed to upload lesson file for section: ' . $section_title);
            }

            error_log("Lesson file uploaded: " . $lesson_file);

            // Insert lesson
            $sql = "INSERT INTO lessons (lesson_content, lesson_section_id) 
                    VALUES ('$lesson_file', $section_id)";
            error_log("Lesson SQL: " . $sql);

            if (!$connection->query($sql)) {
                throw new Exception('Failed to insert lesson: ' . $connection->error);
            }
            error_log("Lesson inserted successfully");
        } else {
            error_log("No file for section $index (in_array: " . (in_array($index, $section_files_indexes) ? 'true' : 'false') . ", file exists: " . (isset($_FILES["section_file_$index"]) ? 'true' : 'false') . ")");
        }
    }

    // Commit transaction
    $connection->commit();
    error_log("Transaction committed successfully");
    echo json_encode(['success' => true, 'message' => 'Course created successfully']);
} catch (Exception $e) {
    // Rollback on error
    $connection->rollback();
    error_log("Error occurred: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$connection->close();

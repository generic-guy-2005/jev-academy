<?php
session_start();
$current_user = $_SESSION['id'];

include '../connection.php';

if ($connection->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $connection->connect_error]));
}

$connection->begin_transaction();

try {
    // Course Info
    $course_token = $_POST['course_token'];
    $course_name = $connection->real_escape_string($_POST['course_name']);
    $course_field = $connection->real_escape_string($_POST['course_field']);
    $course_cost = floatval($_POST['course_cost']);
    $course_desc = $connection->real_escape_string($_POST['course_desc']);

    // El gambarnya
    $course_image = '';
    if ($_POST['image_type'] === 'upload' && isset($_FILES['course_image'])) {
        $target_dir = "../upload/courses/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_extension = pathinfo($_FILES['course_image']['name'], PATHINFO_EXTENSION);
        $course_image = 'upload/courses/' . $course_id . '_' . time() . '.' . $file_extension;
        $target_file = $target_dir . $course_image;

        if (!move_uploaded_file($_FILES['course_image']['tmp_name'], $target_file)) {
            throw new Exception('Failed to upload course image');
        }
    } else if ($_POST['image_type'] === 'default') {
        $course_image = 'assets/default-course-image.jpg';
    }

    // MASOKKKANNN
    $sql = "INSERT INTO courses (course_name, course_field, course_instruct_id, course_cost, course_desc, course_token, course_image) 
            VALUES ('$course_name', '$course_field', '$current_user', $course_cost, '$course_desc', '$course_token', '$course_image')";

    if (!$connection->query($sql)) {
        throw new Exception('Failed to insert course: ' . $connection->error);
    }

    $course_id = $connection->insert_id;

    $section_titles = json_decode($_POST['section_titles'], true);
    $section_files_indexes = json_decode($_POST['section_files_indexes'], true);

    foreach ($section_titles as $index => $section_title) {
        $section_title = $connection->real_escape_string($section_title);

        // Section
        $sql = "INSERT INTO sections (section_name, sort_order, section_course_id) 
                VALUES ('$section_title', " . ($index + 1) . ", $course_id)";

        if (!$connection->query($sql)) {
            throw new Exception('Failed to insert section: ' . $connection->error);
        }

        $section_id = $connection->insert_id;

        // Handle markdown file upload
        if (in_array($index, $section_files_indexes) && isset($_FILES["section_file_$index"])) {
            $md_file = $_FILES["section_file_$index"];
            $target_dir = "../upload/lessons/";

            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $lesson_file = 'upload/lesson/' . $course_id . '_section' . ($index + 1) . '_' . time() . '.md';
            $target_file = $target_dir . $lesson_file;

            if (!move_uploaded_file($md_file['tmp_name'], $target_file)) {
                throw new Exception('Failed to upload lesson file for section: ' . $section_title);
            }

            // Insert lesson
            $sql = "INSERT INTO lessons (lesson_content, lesson_section_id) 
                    VALUES ('$lesson_file', $section_id)";

            if (!$connection->query($sql)) {
                throw new Exception('Failed to insert lesson: ' . $connection->error);
            }
        }
    }

    // Commit transaction
    $connection->commit();
    echo json_encode(['success' => true, 'message' => 'Course created successfully']);
} catch (Exception $e) {
    // Rollback on error
    $connection->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$connection->close();

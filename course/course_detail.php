<?php
if (!isset($_SESSION['id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

include 'connection.php';

$current_course = $_GET['id'];
$current_user = $_SESSION['id'];
$query_course = "SELECT * FROM courses WHERE course_id='$current_course'";
$query_section = "SELECT * FROM sections WHERE section_course_id='$current_course'";
$query_enrollment = "SELECT * FROM enrollment WHERE enrollment_student_id='$current_user' AND enrollment_course_id='$current_course'";
$exec_course = $connection->query($query_course);
$exec_section = $connection->query($query_section);
$exec_enrollment = $connection->query($query_enrollment);
$data_course = $exec_course->fetch_assoc();
?>

<section class="p-16 bg-gray-50">
    <div class="grid grid-cols-[1fr_2fr] gap-6">
        <div class="bg-white p-0 rounded-xl shadow aspect-video">
            <img class="block w-full h-full p-0 m-0 object-cover [border-top-left-radius:10px] [border-top-right-radius:10px]" src="<?= $data_course['course_image'] ?>" alt="Course Image">
            <div class="p-6">
                <h1 class="text-3xl"><?= $data_course['course_name'] ?></h1>
                <p class="pt-2"><?= $data_course['course_desc'] ?></p>

                <div class="flex gap-2">
                    <?php
                    if ($exec_enrollment->num_rows === 0) {
                    ?>
                        <a href="index.php?page=payment&id=<?= $current_course ?>"><button class="px-6 py-2 mt-2 rounded-full bg-blue-600 text-white hover:bg-blue-400">Enroll</button></a>
                    <?php
                    } else {
                    ?>
                        <a href="index.php?page=work/view"><button class="px-6 py-2 mt-2 rounded-full bg-blue-600 text-white hover:bg-blue-400">To Study</button></a>
                    <?php
                    }
                    ?>

                    <a href="javascript:history.back()"><button class="px-6 py-2 mt-2 rounded-full bg-gray-600 text-white hover:bg-gray-400">Back</button></a>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <h1 class="text-xl">Content Preview</h1>

            <?php
            while ($data_section = $exec_section->fetch_assoc()) {
            ?>

                <div class="bg-oklch(43.9% 0 0) p-6 rounded-xl shadow grid grid-cols-[2fr_1fr]">
                    <p class="flex items-center"><?= $data_section['section_name'] ?></p>

                    <?php
                    if ($exec_enrollment->num_rows > 0) {
                    ?>

                        <button class="px-6 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-400" onclick="window.location.href='index.php?page=course/material&id=<?= $current_course ?>&section=<?= $data_section['section_id'] ?>'">View</button>

                    <?php
                    }
                    ?>

                </div>

            <?php
            }
            ?>

        </div>
    </div>
</section>
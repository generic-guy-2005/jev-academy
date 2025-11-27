<?php
include 'connection.php';

$current_course = $_GET['id'];
$query_course = "SELECT * FROM courses WHERE course_id='$current_course'";
$exec_course = $connection -> query($query_course);
$data_course = $exec_course -> fetch_assoc();
?>

<section class="p-16 bg-gray-50">
    <div class="grid grid-cols-2 gap-6">
        <div class="bg-white p-0 rounded-xl shadow aspect-video">
            <img class="block w-full h-full p-0 m-0 object-cover [border-top-left-radius:10px] [border-top-right-radius:10px]" src="<?= $data_course['course_image'] ?>" alt="Course Image">
            <div class="p-6">
                <h1 class="text-3xl"><?= $data_course['course_name'] ?></h1>
                <p class="pt-2"><?= $data_course['course_desc'] ?></p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <div class="bg-oklch(43.9% 0 0) p-6 rounded-xl shadow">

            </div>
        </div>
    </div>
</section>
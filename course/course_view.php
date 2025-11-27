<?php
include 'connection.php';
$latest = (new DateTime())->modify('-7 days')->format('Y-m-d H:i:s');

$course_query = "SELECT *, CASE WHEN course_added > '$latest' THEN 1 ELSE 0 END AS course_latest FROM courses";
$exec_course = $connection->query($course_query);
?>

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">Our Most Popular Course</h2>
            <div class="flex space-x-4">
                <button class="px-6 py-2 rounded-full bg-blue-600 text-white font-semibold shadow-md">All Course</button>
                <button class="px-6 py-2 rounded-full bg-white text-gray-700 border border-gray-300 hover:bg-gray-100">Featured Courses</button>
                <button class="px-6 py-2 rounded-full bg-white text-gray-700 border border-gray-300 hover:bg-gray-100">Popular Courses</button>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <?php
            while ($data = $exec_course->fetch_assoc()) {
            ?>
                <a href="index.php?page=course/detail&id=<?= $data['course_id'] ?>">
                    <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition duration-300 overflow-hidden">
                        <div class="relative">
                            <img src="<?= $data['course_image'] ?>" alt="Course Image" class="w-full h-48 object-cover">
                            <?php
                            if ($data['course_latest']) {
                            ?>
                                <span class="absolute top-3 right-3 bg-blue-600 text-white text-sm px-3 py-1 rounded-full">New</span>
                            <?php
                            }
                            ?>
                            <button class="absolute bottom-3 left-3 bg-white p-2 rounded-full shadow-md text-gray-700 hover:text-red-500">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                        <div class="p-6">
                            <span class="text-sm text-gray-500"><?= $data['course_field'] ?></span>
                            <h3 class="text-xl font-semibold text-gray-800 mt-2 mb-3"><?= $data['course_name'] ?></h3>
                            <div class="flex items-center mb-4">
                                <img src="assets\WhatsApp Image 2025-11-05 at 02.26.39_eba48a16.jpg" alt="Instructor" class="w-8 h-8 rounded-full mr-3">
                                <span class="text-gray-700 text-sm"><?= $data['course_instruct_id'] ?></span>
                            </div>
                            <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                                <div class="text-xl font-bold text-blue-600">$<?= $data['course_cost'] ?></div>
                                <div class="flex items-center text-yellow-500">
                                    <i class="fas fa-star text-sm"></i>
                                    <span class="ml-1 text-gray-600 text-sm">(<?= $data['course_rating'] ?>)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

            <?php
            }

            if ($_GET['page'] === 'dashboard') {
            ?>

        </div>
        <div class="text-center mt-10">
            <button class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold shadow-lg hover:bg-blue-700 transition duration-300">
                View More Courses
            </button>
        </div>

    <?php
            }
    ?>

    </div>
</section>
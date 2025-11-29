<?php
include 'connection.php';
$latest = (new DateTime())->modify('-7 days')->format('Y-m-d H:i:s');
$search = isset($_GET['search']) ? $_GET['search'] : '';

if ($_GET['page'] === "dashboard") {
    $title = "Our Most Popular Course";
    $course_query = "SELECT *, user_name AS instructor, CASE WHEN course_added > '$latest' THEN 1 ELSE 0 END AS course_latest FROM courses c, users u WHERE c.course_instruct_id = u.user_id LIMIT 6";
    $exec_course = $connection->query($course_query);
} else {
    $title = "Discover Course";
    $course_query = "SELECT *, user_name AS instructor, CASE WHEN course_added > '$latest' THEN 1 ELSE 0 END AS course_latest FROM courses c, users u WHERE c.course_instruct_id = u.user_id";
    $exec_course = $connection->query($course_query);
}

if (!empty($search)) {
    $search = $connection->real_escape_string($search);
    $course_query .= " AND (course_name LIKE '%$search%' OR course_field LIKE '%$search%' OR user_name LIKE '%$search%' OR course_desc LIKE '%$search%')";
}

$exec_course = $connection->query($course_query);
?>

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0"><?= $title ?></h2>
            <div class="flex space-x-4">
                <!-- <button class="px-6 py-2 rounded-full bg-blue-600 text-white font-semibold shadow-md">All Course</button>
                <button class="px-6 py-2 rounded-full bg-white text-gray-700 border border-gray-300 hover:bg-gray-100">Featured Courses</button>
                <button class="px-6 py-2 rounded-full bg-white text-gray-700 border border-gray-300 hover:bg-gray-100">Popular Courses</button> -->
                <?php
                if ($_GET['page'] === "course/view") {
                ?>
                    <form method="GET" class="flex items-center">
                        <input type="hidden" name="page" value="<?= $_GET['page'] ?>">
                        <!-- <input type="text" placeholder="Search courses..." class="px-6 py-2 rounded-full border border-gray-300 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"> -->
                        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search courses..." class="px-6 py-2 rounded-full border border-gray-300 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition duration-300">
                            <i class="fas fa-search"><img src="assets\magnifying-glass.png" class="h-5" alt=""></i>
                        </button>
                        <?php
                        if (!empty($search)): ?>
                            <a href="index.php?page=course/view" class="ml-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-full hover:bg-gray-400 transition duration-300">Clear</a>
                        <?php endif; ?>
                    </form>
                <?php
                }
                ?>
            </div>
        </div>

        <?php if (!empty($search) && $_GET['page'] === "course/view"): ?>
            <div class="mb-6">
                <p class="text-gray-600">
                    Search results for: "<span class="font-semibold"><?= htmlspecialchars($search) ?></span>"
                    <?php
                    $result_count = $exec_course->num_rows;
                    echo " - Found {$result_count} course" . ($result_count !== 1 ? 's' : '');
                    ?>
                </p>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <?php
            if ($exec_course->num_rows > 0) {
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
                                    <span class="text-gray-700 text-sm"><?= $data['instructor'] ?></span>
                                </div>
                                <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                                    <div class="text-xl font-bold text-blue-600">Rp <?= number_format($data['course_cost'], 0, ',', '.') ?></div>
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
            } else {
                // No courses found message
                if (!empty($search)) {
                    echo '<div class="col-span-full text-center py-12">';
                    echo '<p class="text-gray-500 text-lg">No courses found for "<span class="font-semibold">' . htmlspecialchars($search) . '</span>"</p>';
                    echo '<p class="text-gray-400 mt-2">Try different search terms or <a href="index.php?page=course/view" class="text-blue-600 hover:underline">browse all courses</a></p>';
                    echo '</div>';
                } else {
                    echo '<div class="col-span-full text-center py-12">';
                    echo '<p class="text-gray-500 text-lg">No courses available at the moment.</p>';
                    echo '</div>';
                }
            }
            ?>

        </div>

        <?php
        if ($_GET['page'] === 'dashboard') {
        ?>
            <div class="text-center mt-10">
                <a href="index.php?page=course/view">
                    <button class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold shadow-lg hover:bg-blue-700 transition duration-300">
                        View More Courses
                    </button>
                </a>
            </div>

        <?php
        }
        ?>

    </div>
</section>
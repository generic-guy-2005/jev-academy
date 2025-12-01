<?php
include 'connection.php';
$today = date('Y-m-d');

if (!isset($_SESSION['daily_course']) || !isset($_SESSION['course_date']) !== $today|| $_SESSION['course_date'] !== $today) {
    $queryRandom = "SELECT course_id 
            FROM courses 
            ORDER BY RAND()
            LIMIT 1";
    $execRandom = $connection->query($queryRandom);

    if ($execRandom && $execRandom->num_rows > 0) {
        $dailyCourse = $execRandom->fetch_assoc();
        $_SESSION['daily_course'] = $dailyCourse['course_id'];
        $_SESSION['course_date'] = $today;
    }
}

if (isset($_SESSION['daily_course'])) {
    $dailyCourseId = $_SESSION['daily_course'];
    $queryDaily = "SELECT *
        FROM courses c
        WHERE c.course_id = ?
    ";

    $dailyState = $connection->prepare($queryDaily);
    $dailyState->bind_param("i", $dailyCourseId);
    $dailyState->execute();
    $dailyResult = $dailyState->get_result();

    if ($dailyResult->num_rows > 0) {
        $currentCourse = $dailyResult->fetch_assoc();
?>

        <section class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-gray-800 mb-4 md:mb-5">Today's Choice</h2>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">

                <div class="grid grid-cols-[1fr_2fr]">
                    <div>
                        <img src="<?= $currentCourse['course_image'] ?>"
                            alt="Course Thumbnail"
                            class="w-full h-64 object-cover">
                    </div>

                    <div class="flex flex-col justify-between p-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-3">
                                <?= $currentCourse['course_name'] ?>
                            </h3>
                            <p class="text-gray-600 leading-relaxed mb-4">
                                <?= $currentCourse['course_desc'] ?>
                            </p>
                        </div>

                        <div>
                            <a href="#"
                                class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300">
                                View Course
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php
    } else {
        echo '<p class="text-center text-gray-500">No course available for today\'s recommendation.</p>';
        echo $_SESSION['daily_course'];
    }
}
?>
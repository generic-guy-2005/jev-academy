<?php
if (!isset($_SESSION['id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

if ($_SESSION['role'] === 'student') {

?>
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">My Courses</h2>
            </div>

            <?php
            include 'connection.php';

            $currentUser = $_SESSION['id'];

            $queryStudy = "SELECT *
            FROM users u
            INNER JOIN enrollment e ON u.user_id = e.enrollment_student_id
            INNER JOIN courses c ON e.enrollment_course_id = c.course_id
            INNER JOIN users u_instructor ON c.course_instruct_id = u_instructor.user_id
            WHERE u.user_id = $currentUser;
        ";
            $execStudy = $connection->query($queryStudy);

            if ($execStudy->num_rows > 0) {
            ?>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php
                    while ($dataStudy = $execStudy->fetch_assoc()) {
                    ?>
                        <a href="index.php?page=course/detail&id=<?= $dataStudy['course_id'] ?>">
                            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition duration-300 overflow-hidden">
                                <div class="relative">
                                    <img src="<?= $dataStudy['course_image'] ?>" alt="Course Image" class="w-full h-48 object-cover">
                                    <button class="absolute bottom-3 left-3 bg-white p-2 rounded-full shadow-md text-gray-700 hover:text-red-500">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                                <div class="p-6">
                                    <span class="text-sm text-gray-500"><?= $dataStudy['course_field'] ?></span>
                                    <h3 class="text-xl font-semibold text-gray-800 mt-2 mb-3"><?= $dataStudy['course_name'] ?></h3>
                                    <div class="flex items-center mb-4">
                                        <img src="assets\WhatsApp Image 2025-11-05 at 02.26.39_eba48a16.jpg" alt="Instructor" class="w-8 h-8 rounded-full mr-3">
                                        <span class="text-gray-700 text-sm"><?= $dataStudy['user_name'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                <?php
                    }
                }
                ?>

                </div>
    </section>
<?php
} elseif ($_SESSION['id'] === 'instructor') {
?>
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">Manage Courses</h2>
            </div>

            <?php
            include 'connection.php';

            $currentUser = $_SESSION['id'];

            $queryOwnedCourse = "SELECT course_id, course_image, course_field, course_name
                FROM courses
                WHERE course_instruct_id = $currentUser;
            ";
            $execOwnedCourse = $connection->query($queryOwnedCourse);

            if ($execOwnedCourse->num_rows > 0) {
            ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php
                    while ($dataOwned = $execOwnedCourse->fetch_assoc()) {
                    ?>
                        <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition duration-300 overflow-hidden">
                            <div class="relative">
                                <img src="<?= $dataOwned['course_image'] ?>" alt="Course Image" class="w-full h-48 object-cover">
                                <button class="absolute bottom-3 left-3 bg-white p-2 rounded-full shadow-md text-gray-700 hover:text-red-500">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                            <div class="p-6">
                                <span class="text-sm text-gray-500"><?= $dataOwned['course_field'] ?></span>
                                <h3 class="text-xl font-semibold text-gray-800 mt-2 mb-3"><?= $dataOwned['course_name'] ?></h3>
                                <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                                    <div class="flex items-center text-yellow-500">
                                        <a href="index.php?page=work/stat&id=<?= $dataOwned['course_id'] ?>" class="px-6 py-2 mt-2 rounded-full bg-yellow-600 text-white hover:bg-yellow-400">Manage</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
                </div>
    </section>

    <section class="mb-5 pt-4 bg-gray-50">
        <div class="pt-6 pb-6 container mx-auto px-4">
            <div class="md:flex-row justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">Create Your Own Course</h2>
                <p class="text-gray-500">Let you're student explore freely with your aid!</p>
            </div>
            <a href="index.php?page=course/create"><button class="px-6 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-400">Create</button></a>
        </div>
    </section>
<?php
} else {
?>
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">Manage Users</h2>
            </div>
            <div class="w-full overflow-x-auto mb-3">
                <div class="bg-white shadow-sm rounded-xl p-4 border border-gray-100">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="py-3 px-4 text-sm font-medium text-gray-500">#</th>
                                <th class="py-3 px-4 text-sm font-medium text-gray-500">ID</th>
                                <th class="py-3 px-4 text-sm font-medium text-gray-500">Username</th>
                                <th class="py-3 px-4 text-sm font-medium text-gray-500">Role</th>
                                <th class="py-3 px-4 text-sm font-medium text-gray-500">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">

                            <?php
                            include 'connection.php';
                            $queryListStudent = "SELECT * FROM users";
                            $execListStudent = $connection->query($queryListStudent);

                            $no = 1;
                            while ($dataListStudent = $execListStudent->fetch_assoc()) {
                            ?>

                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3 px-4 text-gray-700"><?= $no++ ?></td>
                                    <td class="py-3 px-4 text-gray-700"><?= $dataListStudent['user_id'] ?></td>
                                    <td class="py-3 px-4 text-gray-700"><?= $dataListStudent['user_name'] ?></td>
                                    <td class="py-3 px-4 text-gray-700">
                                        <?php
                                        if ($dataListStudent['user_role'] === 'admin') {
                                            echo "<button class='px-6 py-2 rounded-full bg-green-600 text-white'>Administrator</button>";
                                        } elseif ($dataListStudent['user_role'] === 'instructor') {
                                            echo "<button class='px-6 py-2 rounded-full bg-cyan-600 text-white'>Instructor</button>";
                                        } else {
                                            echo "<button class='px-6 py-2 rounded-full bg-purple-600 text-white'>Student</button>";
                                        }
                                        ?>
                                    </td>
                                    <td class="py-3 px-4 text-gray-700">
                                        <button class="deleteUser delete-user-btn px-6 py-2 rounded-full bg-red-600 text-white hover:bg-red-400" data-id="<?= $dataListStudent['user_id'] ?>">
                                            Delete
                                        </button>
                                    </td>
                                </tr>

                            <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script src="backend/user_delete.js"></script>
    </section>

    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Manage Courses</h2>

            <div class="space-y-4">
                <?php
                include 'connection.php';

                $query = "SELECT *, user_name AS instruct_name
                    FROM courses c
                    LEFT JOIN users u
                    ON u.user_id = c.course_instruct_id
                    ORDER BY course_id DESC
                ";
                $result = mysqli_query($connection, $query);

                while ($course = mysqli_fetch_assoc($result)) {
                ?>

                    <div class="course-accordion-item bg-white shadow rounded-xl overflow-hidden">
                        <button class="w-full flex justify-between items-center px-6 py-4 text-left 
                               bg-white hover:bg-gray-100 transition font-semibold text-gray-800
                               accordion-toggle">
                            <span><?= $course['course_name'] ?></span>
                            <svg class="w-5 h-5 transform transition-transform rotate-0 accordion-icon"
                                fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div class="accordion-content hidden px-6 py-6 border-t bg-gray-50">

                            <div class="flex flex-col md:flex-row gap-6">

                                <div class="w-full md:w-1/2 p-4 bg-white rounded-lg shadow">
                                    <h3 class="font-semibold text-gray-800 mb-4 text-lg">Course Information</h3>

                                    <div class="space-y-3 text-gray-700 text-sm">

                                        <p>
                                            <span class="font-medium text-gray-900">Course ID:</span>
                                            <?= $course['course_id']; ?>
                                        </p>

                                        <p>
                                            <span class="font-medium text-gray-900">Course Field:</span>
                                            <?= $course['course_field']; ?>
                                        </p>

                                        <p>
                                            <span class="font-medium text-gray-900">Course Owner:</span>
                                            <?= $course['instruct_name'] ?? "Unknown"; ?>
                                        </p>

                                        <p>
                                            <span class="font-medium text-gray-900">Cost:</span>
                                            Rp <?= number_format($course['course_cost'], 0, ',', '.'); ?>
                                        </p>

                                        <p>
                                            <span class="font-medium text-gray-900">Description:</span><br>
                                            <span class="text-gray-600">
                                                <?= nl2br($course['course_desc']); ?>
                                            </span>
                                        </p>

                                        <p>
                                            <span class="font-medium text-gray-900">Created At:</span>
                                            <?= $course['course_added']; ?>
                                        </p>
                                        <div>
                                            <span class="font-medium text-gray-900">Course Token:</span>

                                            <div class="mt-1 flex items-center gap-2">
                                                <input
                                                    type="text"
                                                    value="<?= $course['course_token']; ?>"
                                                    readonly
                                                    class="w-full px-3 py-2 border rounded-lg bg-gray-100 text-gray-700 text-sm">

                                                <button
                                                    onclick="copyToken('<?= $course['course_token']; ?>')"
                                                    class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition">
                                                    Copy
                                                </button>
                                            </div>
                                            <button
                                                class="mt-4 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md shadow-sm transition delete-course-btn"
                                                data-course-id="<?= $course_id ?>">
                                                Delete Course
                                            </button>
                                        </div>

                                    </div>
                                </div>

                                <div class="w-full md:w-1/2 p-4 bg-white rounded-lg shadow">
                                    <h3 class="text-lg font-semibold mb-2">Course Sections</h3>

                                    <?php
                                    $sectionQuery = "SELECT * FROM sections WHERE section_course_id = " . $course['course_id'] . " ORDER BY sort_order ASC";
                                    $sectionResult = $connection->query($sectionQuery);

                                    if ($sectionResult->num_rows > 0) {
                                        while ($section = $sectionResult->fetch_assoc()) {
                                    ?>
                                            <div class="p-3 m-2 border rounded-lg bg-white shadow-sm">
                                                <p class="font-medium"><?= htmlspecialchars($section['section_name']) ?></p>
                                            </div>
                                    <?php
                                        }
                                    } else {
                                        echo '<p class="text-gray-500">No sections found for this course.</p>';
                                    }
                                    ?>
                                </div>

                            </div>

                        </div>
                    </div>

                <?php
                }
                ?>
            </div>

        </div>

        <script src="backend/accordion.js"></script>
        <script src="backend/admin_delete.js"></script>
        <script>
            function copyToken(token) {
                navigator.clipboard.writeText(token);
            }
        </script>
    </section>

<?php
}
?>
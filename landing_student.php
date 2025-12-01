<?php
$images = [
    "assets/ales-krivec-4miBe6zg5r0-unsplash.jpg",
    "assets/bailey-zindel-NRQV-hBF10M-unsplash.jpg",
    "assets/kalen-emsley-Bkci_8qcdvQ-unsplash.jpg",
    "assets/mark-harpur-K2s_YE031CA-unsplash.jpg",
    "assets/simon-twukN12EN7c-unsplash.jpg"
];

$background = $images[array_rand($images)];
?>

<section class="bg-blue-50 bg-local relative overflow-hidden bg-cover bg-center m-8 rounded-xl glassmorphism-element"
    style="background-image: url('<?= $background ?>'); background-size:cover">
    <div class="flex flex-col md:flex-row items-start justify-between py-20 px-20">
        <div class="md:w-1/2 text-center md:text-left mb-8 md:mb-0 p-6">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight mt-2 mb-4">
                Welcome Back! <span class="bg-linear-to-r from-cyan-500 to-blue-800 bg-clip-text text-5xl font-extrabold text-transparent"><?= $_SESSION['username'] ?></span>
            </h1>
        </div>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">Study</h2>
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
                                <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                                    <div class="text-xl font-bold text-blue-600">Rp <?= number_format($dataStudy['course_cost'], '0', ',', '.') ?></div>
                                    <div class="flex items-center text-yellow-500">
                                        <i class="fas fa-star text-sm"></i>
                                        <span class="ml-1 text-gray-600 text-sm">(<?= round($dataStudy['course_rating']) ?>)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php
                }
                ?>
            </div>

        <?php
        }
        ?>

    </div>
</section>

<section class="py-16 bg-gray-50">
<?php
include 'recommendation.php';
?>
</section>
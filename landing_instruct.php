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
            <h2 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">Manage Courses</h2>
        </div>

        <?php
        include 'connection.php';

        $currentUser = $_SESSION['id'];

        $queryOwnedCourse = "SELECT course_id, course_image, course_field, course_name
            FROM courses
            WHERE course_instruct_id = $currentUser
            LIMIT 3;
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
                                    <a href="index.php?page=work/stat" class="px-6 py-2 mt-2 rounded-full bg-yellow-600 text-white hover:bg-yellow-400">Manage</a>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
        <div class="text-center mt-10">
        <a href="index.php?page=work/view">
            <button class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold shadow-lg hover:bg-blue-700 transition duration-300">
                To Workstation
            </button>
        </a>
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
<?php
if(!$_SESSION['role'] || $_SESSION['role'] === 'admin') {
?>
<section class="bg-blue-50 bg-local bg-[url(assets/breathtaking-view-snowy-mountains-cloudy-sky-patagonia-chile.jpg)] relative overflow-hidden bg-cover bg-center m-8 rounded-xl">
    <div class="flex flex-col md:flex-row items-start justify-between py-20 px-20">
        <div class="glassmorphism-element md:w-1/2 text-center md:text-left mb-8 md:mb-0 p-6">
            <span class="text-sm font-semibold text-blue-600 uppercase tracking-wide">Sekali Masuk</span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight mt-2 mb-4">
                Langsung Jadi <span class="bg-linear-to-r from-cyan-500 to-blue-800 bg-clip-text text-5xl font-extrabold text-transparent">Elit Global</span>
            </h1>
            <p class="text-lg text-shadow-lg text-slate-950 mb-8">
                Jadilah sang penguasa se-ngawi semesta dan kontrol dunia dengan leluasa
            </p>
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 justify-center md:justify-start">
                <a class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold shadow-lg hover:bg-blue-700 transition duration-300" href="login.php">
                    Nak Ikot
                </a>
            </div>
        </div>
        <div class="md:w-1/2 absolute bottom-0 right-0">
            <img src="assets\pngegg.png" alt="Student learning" class="rounded-lg shadow-xl max-w-full h-auto">
        </div>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-gray-800 text-center mb-10">Featured Majors</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-blue-600 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1 text-center">
                <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-paint-brush text-blue-600 text-2xl">
                        <img src="assets\renewable-energy.png" alt="">
                    </i>
                </div>`
                <h3 class="text-xl font-semibold text-white mb-2">Electrical Engineering</h3>
                <p class="text-white text-sm">7 Programs | 200+ Courses</p>
            </div>

            <div class="bg-amber-600 text-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1 text-center">
                <div class="w-16 h-16 bg-amber-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-atom text-white text-2xl">
                        <img src="assets\engineering.png" alt="">
                    </i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Civil Engineering</h3>
                <p class="text-blue-100 text-sm">3 Programs | 100+ Courses</p>
            </div>

            <div class="bg-zinc-800 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1 text-center">
                <div class="w-16 h-16 bg-zinc-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-laptop-code text-purple-600 text-2xl">
                        <img src="assets\piston.png" alt="">
                    </i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Mechanical Engineering</h3>
                <p class="text-white text-sm">3 Programs | 100+ Courses</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1 text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-globe-americas text-green-600 text-2xl">
                        <img src="assets\it-department.png" alt="">
                    </i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Information Technology</h3>
                <p class="text-gray-600 text-sm">4 Programs | 300+ Courses</p>
            </div>

            <div class="bg-red-600 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1 text-center">
                <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-globe-americas text-green-600 text-2xl">
                        <img src="assets\document.png" alt="">
                    </i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Accounting</h3>
                <p class="text-white text-sm">3 Programs | 250+ Courses</p>
            </div>

            <div class="bg-violet-900 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1 text-center">
                <div class="w-16 h-16 bg-violet-800 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-globe-americas text-green-600 text-2xl">
                        <img src="assets\commerce.png" alt="">
                    </i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Commercial Administration</h3>
                <p class="text-white text-sm">5 Programs | 350+ Courses</p>
            </div>

            <div class="bg-green-700 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1 text-center">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-globe-americas text-green-600 text-2xl">
                        <img src="assets\translating.png" alt="">
                    </i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">English Department</h3>
                <p class="text-white text-sm">2 Programs | 100+ Courses</p>
            </div>

            <div class="bg-black p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1 text-center">
                <div class="w-16 h-16 bg-zinc-800 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-globe-americas text-green-600 text-2xl">
                        <img src="assets\application.png" alt="">
                    </i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Many More!</h3>
                <p class="text-white text-sm">Browse</p>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between">
        <div class="md:w-1/2 mb-8 md:mb-0">
            <img src="assets\children-studying-outdoors.jpg" alt="Students learning together" class="rounded-lg shadow-xl max-w-full h-auto">
        </div>
        <div class="md:w-1/2 md:pl-12 text-center md:text-left">
            <span class="text-sm font-semibold text-blue-600 uppercase tracking-wide">Kenapa</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight mt-2 mb-4">
                Pilih <span class="text-blue-600">Kami</span> ?
            </h2>
            <p class="text-lg text-gray-700 mb-6">
                Website ini sudah tersertifikasi Badan Riset Ngawi dan didukung penuh oleh Lembaga Senat Agung Ngawi yang akan dengan 100% menghintamkan anda
            </p>
            <p class="text-md text-gray-600 mb-8">
                Jam 8: Soto GAS!
            </p>
            <button class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold shadow-lg hover:bg-blue-700 transition duration-300">
                Read More About Us
            </button>
        </div>
    </div>
</section>

<?php
include 'course/course_view.php';
?>

<section class="bg-gradient-to-r from-blue-600 to-indigo-700 py-12">
    <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between text-white text-center md:text-left">
        <div class="mb-6 md:mb-0 md:w-1/2">
            <h2 class="text-3xl font-bold mb-2">Soto? Gas!!!</h2>
            <p class="text-lg text-blue-100">Mari mengidap penyakit soto gila</p>
        </div>
        <div class="md:w-1/2 flex flex-col sm:flex-row items-center justify-center md:justify-end space-y-4 sm:space-y-0 sm:space-x-4">
            <input type="email" placeholder="Enter your email" class="px-5 py-3 rounded-lg w-full sm:w-auto focus:outline-none focus:ring-2 focus:ring-blue-300 text-white border-4 border-white">
            <button class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold shadow-md hover:bg-gray-300 transition duration-300">
                Get Started
            </button>
        </div>
    </div>
</section>

<?php
} elseif($_SESSION['role'] === 'student') {
?>

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

<section>
    <p>Enrolled Course Section</p>
</section>

<section>
    <p>Recommendation Course Section</p>
</section>

<section>
    <p>Statistic Section</p>
</section>

<?php
}
?>
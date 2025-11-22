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
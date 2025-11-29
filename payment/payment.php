<?php
$images = [
    "assets/ABSTRACT MODERN MOSAIC WALLPAPER 4K.jpg",
    "assets/Modern tech background with geometric shapes_ vector illustration _ Premium Vector.jpg",
    "assets/pay1.jpg",
    "assets/pay2.jpg",
    "assets/pay3.jpg"
];

$background = $images[array_rand($images)];

include 'connection.php';
$current_course = $_GET['id'];
$current_user = $_SESSION['id'];
$query_course = "SELECT * FROM courses WHERE course_id='$current_course'";
$query_wallet = "SELECT * FROM wallet WHERE wallet_user_id='$current_user'";
$exec_course = $connection->query($query_course);
$exec_wallet = $connection->query($query_wallet);
$data_course = $exec_course->fetch_assoc();
$data_wallet = $exec_wallet->fetch_assoc();
?>

<section class="p-16 bg-gray-50">
    <div class="grid grid-cols-[1fr_2fr] gap-6">
        <div class="bg-white p-0 rounded-xl shadow aspect-video">
            <!-- <p>Wallet</p> -->
            <img class="block w-full h-40 p-0 m-0 object-cover [border-top-left-radius:10px] [border-top-right-radius:10px] bg-blue-600" src="<?= $background ?>">
            <a href="index.php?page=payment/topup"><button class="px-6 py-2 m-2 rounded-full bg-blue-600 text-white hover:bg-blue-400">Top Up</button></a>
            <p class="absolute top-55 left-20 text-white"><span class="text-2xl">Rp</span><span class="text-4xl"> <?= number_format($data_wallet['wallet_balance'], 0, ',', '.') ?></span></p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <h1 class="text-2xl">Payment Detail</h1> <hr>
            <h2 class="text-xl"><?= $data_course['course_name'] ?></h2>

            <div class="mt-5 text-center ml-20 mr-20 pl-10 pr-10">
                <p>Purchase this course for Rp<?= $data_course['course_cost'] ?>?</p>
                <div class="grid grid-cols-2">
                    <form action="backend/transaction.php" method="post">
                        <input type="hidden" name="course" value="<?= $data_course['course_id'] ?>">
                        <button type="submit" name="pay-course" class="px-6 py-2 mt-2 rounded-full bg-blue-600 text-white hover:bg-blue-400">Yes</button>
                    </form>
                    <a href="#"><button class="px-6 py-2 mt-2 rounded-full bg-gray-500 text-white hover:bg-blue-400">Cancel</button></a>
                </div>
            </div>
        </div>
    </div>
</section>
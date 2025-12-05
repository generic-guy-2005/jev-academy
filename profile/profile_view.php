<section class="min-h-screen bg-gray-50 py-12">

    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include 'connection.php';
    $current_user_id = $_SESSION['id'] ?? null;

    if (!$current_user_id) {
        echo "<script>window.location.href='login.php';</script>";
        exit;
    }

    $query_user = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $connection->prepare($query_user);
    $stmt->bind_param("i", $current_user_id);
    $stmt->execute();
    $result_user = $stmt->get_result();
    $user = $result_user->fetch_assoc();

    if (!$user) {
        echo "<script>window.location.href='login.php';</script>";
        exit;
    }
    ?>

    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md p-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-8">My Profile</h2>
        <div class="grid md:grid-cols-3 gap-8">

            <div class="col-span-1 flex flex-col items-center">
                <div class="w-32 h-32 rounded-full bg-gray-200 overflow-hidden shadow">
                    <img src="
                    <?php
                    if (!empty($user['user_image'])) {
                        echo 'upload/profile/' . htmlspecialchars($user['user_image']);
                    } else {
                        echo 'assets/user.png';
                    }
                    ?>"
                        class="w-full h-full object-cover" alt="User Avatar">
                </div>
                <h3 class="text-xl font-semibold mt-4"><?= htmlspecialchars($user['user_name']) ?></h3>
                <p class="text-sm text-gray-500">
                    <?php
                    if ($user['user_role'] === 'instructor') {
                        echo 'Instructor';
                    } else {
                        echo 'Student';
                    }
                    ?>
                </p>
            </div>

            <div class="col-span-2 space-y-6">
                <div>
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">Account Information</h4>
                    <div class="bg-gray-100 p-4 rounded-lg border">
                        <div class="flex items-center gap-3 mb-2">
                            <img src="assets/user_icon.png" alt="User Icon" class="w-5 h-5 text-gray-600">
                            <div>
                                <p class="text-sm text-gray-500">ID</p>
                                <p class="text-gray-800 font-medium"><?= htmlspecialchars($user['user_id']); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex flex-row w-full gap-2 justify-center">
                        <a href="index.php?page=profile/profile_update&id=<?= htmlspecialchars($user['user_id']) ?>" class="flex-1">
                            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-md transition">
                                Update Profile
                            </button>
                        </a>
                        <a href="index.php?page=profile/password_update" class="flex-1">
                            <button class="w-full bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-md transition">
                                Change Password
                            </button>
                        </a>
                        <div class="flex-1">
                            <button class="w-full bg-red-600 hover:bg-red-700 text-white p-2 rounded-md transition deleteUser" id="deleteUser">
                                Delete Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <script src="backend/delete_profile.js"></script>
</section>
<?php
include 'connection.php';
$current_user = $_GET['id'];
$query_user = "SELECT * FROM users WHERE user_id='$current_user'";
$result_user = mysqli_query($connection, $query_user);
$user = mysqli_fetch_assoc($result_user);
?>

<section class="mb-5 pt-4 bg-gray-50">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Update Profile</h2>
        <div class="grid grid-cols-1 lg:grid-cols-[1fr_2fr] gap-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h4 class="text-lg font-semibold text-gray-700 mb-4">Profile Picture</h4>

                <!-- Preview -->
                <img
                    src="
                    <?php
                    if (!empty($user['user_image'])) {
                        echo 'upload/profile/' . htmlspecialchars($user['user_image']);
                    } else {
                        echo 'assets/user.png';
                    }
                    ?>
                    "
                    class="w-32 h-32 rounded-full object-cover border mb-4 mx-auto block"
                    id="avatarPreview">

            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <form id="updateProfileForm" method="POST" action="update_profile.php" enctype="multipart/form-data" class="space-y-6">

                    <!-- Username -->
                    <div>
                        <label class="text-gray-700 font-medium">Username</label>
                        <input
                            type="text"
                            name="username"
                            value="<?= $user['user_name'] ?>"
                            class="w-full mt-1 p-3 border rounded-md focus:ring focus:ring-blue-300"
                            required>
                    </div>
                    <!-- File Input -->
                    <label class="mt-2 text-gray-600 text-sm mb-1">Change Picture</label>
                    <input
                        type="file"
                        name="user_image"
                        id="avatarInput"
                        accept="image/*"
                        class="w-full p-2 border bg-white rounded-md text-sm">
                    <div>

                    </div>

                    <!-- Save Button -->
                    <div class="pt-4">
                        <button
                            type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-lg transition mb-2">
                            Save Changes
                        </button>
                        <button
                            type="submit"
                            onclick="javascript:history.back()"
                            class="w-full bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 rounded-lg transition">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('avatarInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('avatarPreview').src = event.target.result;
            };
            reader.readAsDataURL(file);
        });
    </script>

    <script src="profile/update_profile.js"></script>
</section>
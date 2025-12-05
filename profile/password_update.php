<section class="mb-5 pt-4 bg-gray-50">
    <div class="max-w-md mx-auto bg-white shadow p-6 rounded-md">
        <h2 class="text-2xl font-semibold mb-4">Update Password</h2>

        <form id="updatePasswordForm" method="POST">
            <!-- Old Password -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">Old Password</label>
                <input type="password" name="old_password" class="w-full border-gray-800 p-2 rounded shadow" required>
            </div>

            <!-- New Password -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">New Password</label>
                <input type="password" name="new_password" class="w-full border-gray-800 p-2 rounded shadow" required>
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">Confirm Password</label>
                <input type="password" name="confirm_password" class="w-full border-gray-800 p-2 rounded shadow" required>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-3 mt-6">
                <a href="profile_view.php" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Update
                </button>
            </div>
        </form>
    </div>

    <script src="profile/password_update.js"></script>
</section>
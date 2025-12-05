document.addEventListener('DOMContentLoaded', function () {
    console.log('Delete profile script loaded');
    const deleteBtn = document.getElementById('deleteUser'); // Changed from deleteAccountBtn

    if (deleteBtn) {
        deleteBtn.addEventListener('click', function () {
            // Show confirmation dialog
            if (confirm('This action cannot be undone!\n\nAre you sure you want to delete your account?\n\n• All your data will be permanently deleted\n• Your profile picture will be removed\n• You will be logged out immediately')) {

                // Double confirmation
                if (confirm('This is your final warning!\n\nClick OK to permanently delete your account.')) {
                    deleteAccount();
                }
            }
        });
    } else {
        console.error('Delete button not found');
    }
});

function deleteAccount() {
    fetch('backend/delete_profile.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        }
    })
        .then(response => response.text())
        .then(data => {
            console.log('Response:', data); // Debug log

            // Clean the response (remove any whitespace)
            data = data.trim();

            if (data === 'success') {
                alert('Your account has been successfully deleted.');
                // Redirect to login page
                window.location.href = 'index.php?page=auth/login';
            } else if (data === 'forbidden') {
                alert('Admin accounts cannot be deleted.');
            } else {
                alert('Error deleting account. Please try again or contact support.');
                console.error('Delete failed:', data);
            }
        })
        .catch(error => {
            alert('An error occurred. Please try again.');
            console.error('Error:', error);
        });
}
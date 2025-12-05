document.addEventListener('DOMContentLoaded', function () {
    console.log('Delete profile script loaded');
    const deleteBtn = document.getElementById('deleteAccountBtn');

    if (deleteBtn) {
        deleteBtn.addEventListener('click', function () {
            // Show confirmation dialog
            if (confirm('Are you sure you want to delete your account?')) {

                // Double confirmation
                if (confirm('This is your final warning!\n\nClick OK to permanently delete your account.')) {
                    deleteAccount();
                }
            }
        });
    }
});

function deleteAccount() {
    fetch('profile/delete_profile.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        }
    })
        .then(response => response.text())
        .then(data => {
            if (data === 'success') {
                alert('Your account has been successfully deleted.');
                // Redirect to login or home page
                window.location.href = 'login.php';
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
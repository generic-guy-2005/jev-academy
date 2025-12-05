document.addEventListener('DOMContentLoaded', function () {
    // Add this with other variables at the top
    const deleteCourseBtn = document.getElementById('deleteCourseBtn');

    // Add this with other event listeners
    if (deleteCourseBtn) {
        deleteCourseBtn.addEventListener('click', function () {
            // Get course ID from URL
            const urlParams = new URLSearchParams(window.location.search);
            const courseId = urlParams.get('id');

            if (!courseId) {
                alert('Course ID not found');
                return;
            }

            // Confirm deletion
            if (!confirm('Are you sure you want to delete this course? This action cannot be undone.')) {
                return;
            }

            // Show loading state
            deleteCourseBtn.disabled = true;
            deleteCourseBtn.textContent = 'Deleting...';
            deleteCourseBtn.classList.add('opacity-50', 'cursor-not-allowed');

            // Send delete request
            fetch(`backend/course_delete.php?id=${courseId}`, {
                method: 'GET'
            })
                .then(response => {
                    // First, get the raw response text
                    return response.text().then(text => {
                        console.log('Raw response text:', text);
                        console.log('Response status:', response.status);
                        console.log('Response headers:', response.headers);

                        // Try to parse as JSON
                        try {
                            const data = JSON.parse(text);
                            console.log('Parsed JSON:', data);
                            return data;
                        } catch (e) {
                            console.error('JSON parse error:', e);
                            console.error('Invalid JSON text:', text);
                            throw new Error('Server returned invalid JSON. Check console for raw response.');
                        }
                    });
                })
                .then(data => {
                    if (data.success) {
                        alert('Course deleted successfully!');
                        window.location.href = 'index.php?page=work/view';
                    } else {
                        alert('Error: ' + data.message);
                        deleteCourseBtn.disabled = false;
                        deleteCourseBtn.textContent = 'Delete Course';
                        deleteCourseBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('An error occurred while deleting the course: ' + error.message);
                    deleteCourseBtn.disabled = false;
                    deleteCourseBtn.textContent = 'Delete Course';
                    deleteCourseBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                });
        });
    }
});
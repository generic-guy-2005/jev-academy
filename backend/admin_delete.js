document.addEventListener('DOMContentLoaded', function () {
    console.log("Admin delete script loaded.");

    document.querySelectorAll('.delete-course-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const courseId = this.dataset.courseId;

            if (!confirm("Are you sure you want to delete this course? This action cannot be undone.")) {
                return;
            }

            // send AJAX request to PHP
            fetch('backend/admin_delete.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'course_id=' + encodeURIComponent(courseId)
            })
                .then(res => res.text())
                .then(response => {
                    if (response.trim() === 'OK') {
                        // Remove the accordion element from the page
                        const accordionItem = this.closest('.course-accordion-item');
                        accordionItem.remove();
                        alert("Course deleted successfully.");
                    } else {
                        alert("Failed to delete course: " + response);
                    }
                })
                .catch(err => {
                    alert("Error communicating with server.");
                    console.error(err);
                });
        });
    }); 
});
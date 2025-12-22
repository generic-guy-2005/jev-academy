document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('updateCourseBtn').addEventListener('click', function () {
        // Validate form
        const courseName = document.getElementById('course_name').value.trim();
        const courseField = document.getElementById('course_field').value.trim();
        const courseCost = document.getElementById('course_cost').value;
        const courseDesc = document.getElementById('course_desc').value.trim();

        if (!courseName || !courseField || !courseCost || !courseDesc) {
            alert('Please fill in all course information fields');
            return;
        }

        // Validate sections
        const sectionTitles = document.querySelectorAll('input[name="section_title[]"]');
        let validSections = true;

        sectionTitles.forEach(input => {
            if (!input.value.trim()) {
                validSections = false;
            }
        });

        if (!validSections) {
            alert('Please fill in all section titles');
            return;
        }

        // Get course ID from URL
        const urlParams = new URLSearchParams(window.location.search);
        const courseId = urlParams.get('id');

        if (!courseId) {
            alert('Course ID not found');
            return;
        }

        // Prepare form data
        const formData = new FormData();
        formData.append('update_id', courseId);
        formData.append('course_name', courseName);
        formData.append('course_field', courseField);
        formData.append('course_cost', courseCost);
        formData.append('course_desc', courseDesc);

        // Handle image
        const keepCurrentImage = document.getElementById('keep_current_image').value;
        formData.append('keep_current_image', keepCurrentImage);

        if (keepCurrentImage === '0') {
            const imageFile = document.getElementById('course_image').files[0];
            if (imageFile) {
                formData.append('course_image', imageFile);
                formData.append('image_type', 'upload');
            } else if (imageName && imageName.textContent.includes('default')) {
                formData.append('image_type', 'default');
            } else {
                formData.append('image_type', 'keep');
            }
        }

        // Handle sections
        const sections = document.querySelectorAll('.section-item');
        const sectionTitlesArray = [];
        const sectionIdsArray = [];
        const sectionFilesIndexes = [];
        const keepCurrentFilesArray = [];
        let fileIndex = 0;

        sections.forEach((section, index) => {
            const title = section.querySelector('input[name="section_title[]"]').value.trim();
            const sectionId = section.querySelector('input[name="section_id[]"]').value;
            const fileInput = section.querySelector('.section-file-input');
            const keepCurrentFile = section.querySelector('.keep-current-file').value;

            sectionTitlesArray.push(title);
            sectionIdsArray.push(sectionId);
            keepCurrentFilesArray.push(parseInt(keepCurrentFile));

            // Validate
            if (fileInput.files.length > 0) {
                formData.append(`section_file_${index}`, fileInput.files[0]);
                sectionFilesIndexes.push(index);
            }
        });

        formData.append('section_titles', JSON.stringify(sectionTitlesArray));
        formData.append('section_ids', JSON.stringify(sectionIdsArray));
        formData.append('section_files_indexes', JSON.stringify(sectionFilesIndexes));
        formData.append('keep_current_files', JSON.stringify(keepCurrentFilesArray));

        const updateBtn = this;
        updateBtn.disabled = true;
        updateBtn.textContent = 'Updating...';
        updateBtn.classList.add('opacity-50', 'cursor-not-allowed');

        fetch('backend/course_update.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Course updated successfully!');
                    window.location.href = 'javascript:history.back()';
                } else {
                    alert('Error: ' + data.message);
                    updateBtn.disabled = false;
                    updateBtn.textContent = 'Update Course';
                    updateBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the course');
                updateBtn.disabled = false;
                updateBtn.textContent = 'Update Course';
                updateBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            });
    });
});
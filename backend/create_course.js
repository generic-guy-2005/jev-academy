document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('createCourseBtn').addEventListener('click', async function () {
        const btn = this;

        // Validate forms
        const courseInfoForm = document.getElementById('courseInfoForm');
        const courseContentForm = document.getElementById('courseContentForm');

        if (!courseInfoForm.checkValidity()) {
            alert('Please fill in all required fields in Course Information');
            return;
        }

        if (!courseContentForm.checkValidity()) {
            alert('Please fill in all required fields in Course Content');
            return;
        }

        // Prepare FormData
        const formData = new FormData();

        // Add Course Information
        formData.append('course_token', document.getElementById('course_token').value);
        formData.append('course_name', document.getElementById('course_name').value);
        formData.append('course_field', document.getElementById('course_field').value);
        formData.append('course_cost', document.getElementById('course_cost').value);
        formData.append('course_desc', document.getElementById('course_desc').value);

        // Add Course Image
        const courseImageInput = document.getElementById('course_image');
        const imagePreviewSrc = document.getElementById('imagePreview').src;

        if (courseImageInput.files.length > 0) {
            formData.append('course_image', courseImageInput.files[0]);
            formData.append('image_type', 'upload');
        } else if (imagePreviewSrc.includes('default-course-image.jpg')) {
            formData.append('image_type', 'default');
        } else {
            alert('Please upload or select a default course image');
            return;
        }

        // Add Course Sections and Files
        const sections = document.querySelectorAll('.section-item');
        const sectionTitles = [];
        const sectionFiles = [];

        sections.forEach((section, index) => {
            const titleInput = section.querySelector('input[name="section_title[]"]');
            const fileInput = section.querySelector('.section-file-input');

            sectionTitles.push(titleInput.value);

            if (fileInput.files.length > 0) {
                formData.append(`section_file_${index}`, fileInput.files[0]);
                sectionFiles.push(index);
            } else {
                alert(`Please upload a markdown file for Section ${index + 1}`);
                return;
            }
        });

        formData.append('section_titles', JSON.stringify(sectionTitles));
        formData.append('section_files_indexes', JSON.stringify(sectionFiles));

        // Disable button and show loading
        btn.disabled = true;
        btn.textContent = 'Creating Course...';

        try {
            const response = await fetch('backend/create_course.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                alert('Course created successfully!');
                window.location.href = 'index.php?page=course/view'; // Redirect to courses page
            } else {
                alert('Error: ' + result.message);
                btn.disabled = false;
                btn.textContent = 'Create Course';
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while creating the course. Please try again.');
            btn.disabled = false;
            btn.textContent = 'Create Course';
        }
    });
});
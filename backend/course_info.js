document.addEventListener('DOMContentLoaded', function () {
    // Token
    const generateBtn = document.getElementById('generateTokenBtn');

    generateBtn.addEventListener('click', async function () {
        try {
            const response = await fetch('token.php');
            const token = await response.text();
            document.getElementById('course_token').value = token.trim();
        } catch (error) {
            console.error('Error generating token:', error);
            alert('Failed to generate course ID. Please try again.');
        }
    });

    // Image
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('course_image');
    const previewArea = document.getElementById('previewArea');
    const imagePreview = document.getElementById('imagePreview');
    const imageName = document.getElementById('imageName');

    uploadArea.addEventListener('click', () => {
        fileInput.click();
    });

    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('border-blue-500', 'bg-blue-50');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('border-blue-500', 'bg-blue-50');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('border-blue-500', 'bg-blue-50');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFileSelect(files[0]);
        }
    });

    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            handleFileSelect(e.target.files[0]);
        }
    });

    function handleFileSelect(file) {
        // Validate file type
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!validTypes.includes(file.type)) {
            alert('Please select a valid image file (JPG, JPEG, or PNG)');
            return;
        }

        // Validate file size (5MB max)
        const maxSize = 5 * 1024 * 1024; // 5MB in bytes
        if (file.size > maxSize) {
            alert('File size must be less than 5MB');
            return;
        }

        // Display preview
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.src = e.target.result;
            imageName.textContent = `File: ${file.name} (${(file.size / 1024).toFixed(2)} KB)`;
            uploadArea.classList.add('hidden');
            previewArea.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }

    document.getElementById('resetImageBtn').addEventListener('click', () => {
        fileInput.value = '';
        imagePreview.src = '';
        imageName.textContent = '';
        previewArea.classList.add('hidden');
        uploadArea.classList.remove('hidden');
    });

    document.getElementById('defaultImageBtn').addEventListener('click', () => {
        const defaultImagePath = 'assets/default-course-image.jpg';
        imagePreview.src = defaultImagePath;
        imageName.textContent = 'Using default course image';
        uploadArea.classList.add('hidden');
        previewArea.classList.remove('hidden');
        fileInput.value = '';
    });

    let sectionCount = 1;
    const sectionsContainer = document.getElementById('sectionsContainer');
    const addSectionBtn = document.getElementById('addSectionBtn');

    addSectionBtn.addEventListener('click', () => {
        sectionCount++;

        const newSection = document.createElement('div');
        newSection.className = 'section-item border border-gray-200 rounded-lg p-4 bg-gray-50 mt-4';
        newSection.innerHTML = getSectionTemplate(sectionCount);
        sectionsContainer.appendChild(newSection);
    });

    sectionsContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-section-btn')) {
            if (sectionsContainer.children.length > 1) {
                e.target.closest('.section-item').remove();
                // Renumber sections
                const sections = sectionsContainer.querySelectorAll('.section-item');
                sections.forEach((section, index) => {
                    const heading = section.querySelector('h3');
                    heading.textContent = `Section ${index + 1}`;
                });
                sectionCount = sections.length;
            } else {
                alert('You must have at least one section');
            }
        }
    });

    sectionsContainer.addEventListener('click', (e) => {
        // Click upload area to trigger file input
        if (e.target.closest('.section-upload-area')) {
            const section = e.target.closest('.section-item');
            const fileInput = section.querySelector('.section-file-input');
            fileInput.click();
        }

        // Remove file button
        if (e.target.classList.contains('section-remove-file')) {
            const section = e.target.closest('.section-item');
            const fileInput = section.querySelector('.section-file-input');
            const uploadArea = section.querySelector('.section-upload-area');
            const previewArea = section.querySelector('.section-file-preview');

            fileInput.value = '';
            uploadArea.classList.remove('hidden');
            previewArea.classList.add('hidden');
        }
    });

    sectionsContainer.addEventListener('change', (e) => {
        if (e.target.classList.contains('section-file-input')) {
            const file = e.target.files[0];
            if (file) {
                handleMdFileSelect(file, e.target.closest('.section-item'));
            }
        }
    });

    sectionsContainer.addEventListener('dragover', (e) => {
        if (e.target.closest('.section-upload-area')) {
            e.preventDefault();
            e.target.closest('.section-upload-area').classList.add('border-blue-500', 'bg-blue-50');
        }
    });

    sectionsContainer.addEventListener('dragleave', (e) => {
        if (e.target.closest('.section-upload-area')) {
            e.target.closest('.section-upload-area').classList.remove('border-blue-500', 'bg-blue-50');
        }
    });

    sectionsContainer.addEventListener('drop', (e) => {
        const uploadArea = e.target.closest('.section-upload-area');
        if (uploadArea) {
            e.preventDefault();
            uploadArea.classList.remove('border-blue-500', 'bg-blue-50');

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const section = uploadArea.closest('.section-item');
                const fileInput = section.querySelector('.section-file-input');

                // Create a DataTransfer object to set files to the input
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(files[0]);
                fileInput.files = dataTransfer.files;

                handleMdFileSelect(files[0], section);
            }
        }
    });

    function handleMdFileSelect(file, sectionElement) {
        // Validate file type
        if (!file.name.endsWith('.md')) {
            alert('Please select a valid Markdown file (.md)');
            return;
        }

        // Validate file size (5MB max)
        const maxSize = 5 * 1024 * 1024;
        if (file.size > maxSize) {
            alert('File size must be less than 5MB');
            return;
        }

        // Display file preview
        const uploadArea = sectionElement.querySelector('.section-upload-area');
        const previewArea = sectionElement.querySelector('.section-file-preview');
        const fileName = sectionElement.querySelector('.section-file-name');

        fileName.textContent = `${file.name} (${(file.size / 1024).toFixed(2)} KB)`;
        uploadArea.classList.add('hidden');
        previewArea.classList.remove('hidden');
    }
});
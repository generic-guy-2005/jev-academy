<?php
include 'connection.php';
$currentCourse = $_GET['id'];

$queryCourse = "SELECT * FROM courses WHERE course_id = $currentCourse";
$execCourse = $connection->query($queryCourse);
$dataCourse = $execCourse->fetch_assoc();

// Fetch existing sections
$querySections = "SELECT * FROM sections WHERE section_course_id = $currentCourse ORDER BY sort_order ASC";
$execSections = $connection->query($querySections);
?>

<section class="mb-5 pt-4 bg-gray-50">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Update Course</h1>

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_2fr] gap-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-3">Course Information</h2>
                <form id="courseInfoForm" class="space-y-4">

                    <input type="hidden" id="update_id" name="update_id" value="<?= $dataCourse['course_id'] ?>">

                    <div>
                        <label for="course_name" class="block text-sm font-medium text-gray-700 mb-2">Course Name</label>
                        <input type="text" id="course_name" name="course_name" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            value="<?= htmlspecialchars($dataCourse['course_name']) ?>">
                    </div>

                    <div>
                        <label for="course_field" class="block text-sm font-medium text-gray-700 mb-2">Course Field</label>
                        <input type="text" id="course_field" name="course_field" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            value="<?= htmlspecialchars($dataCourse['course_field']) ?>">
                    </div>

                    <div>
                        <label for="course_cost" class="block text-sm font-medium text-gray-700 mb-2">Course Cost</label>
                        <input type="number" id="course_cost" name="course_cost" required min="0" step="0.01"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            value="<?= round($dataCourse['course_cost'], 2) ?>">
                    </div>

                    <div>
                        <label for="course_desc" class="block text-sm font-medium text-gray-700 mb-2">Course Description</label>
                        <textarea id="course_desc" name="course_desc" required rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition resize-vertical"><?= htmlspecialchars($dataCourse['course_desc']) ?></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Course Image</label>

                        <!-- Current Image Display -->
                        <?php if (!empty($dataCourse['course_image'])) { ?>
                            <div id="currentImageArea" class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                                <div class="relative">
                                    <img src="<?= htmlspecialchars($dataCourse['course_image']) ?>"
                                        alt="Current course image"
                                        class="w-full h-48 object-cover rounded-lg border border-gray-300">
                                    <div class="absolute top-2 right-2">
                                        <button type="button" id="changeImageBtn"
                                            class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded transition">
                                            Change Image
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <!-- Upload Area (hidden if image exists) -->
                        <div id="uploadArea" class="<?= !empty($dataCourse['course_image']) ? 'hidden' : '' ?> border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-blue-500 transition">
                            <p class="mt-2 text-sm text-gray-600">
                                <span class="font-semibold text-blue-600">Click to upload</span> or drag and drop
                            </p>
                            <p class="text-xs text-gray-500 mt-1">JPG, JPEG, PNG (MAX. 5MB)</p>
                        </div>

                        <input type="file" id="course_image" name="course_image" accept=".jpg,.jpeg,.png" class="hidden">
                        <input type="hidden" id="keep_current_image" name="keep_current_image" value="<?= !empty($dataCourse['course_image']) ? '1' : '0' ?>">

                        <!-- New Image Preview -->
                        <div id="previewArea" class="hidden mt-4">
                            <div class="relative">
                                <img id="imagePreview" src="" alt="Course preview" class="w-full h-48 object-cover rounded-lg border border-gray-300">
                                <div class="absolute top-2 right-2 flex gap-2">
                                    <button type="button" id="resetImageBtn" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded transition">
                                        Reset
                                    </button>
                                </div>
                            </div>
                            <p id="imageName" class="text-sm text-gray-600 mt-2"></p>
                        </div>

                        <button type="button" id="defaultImageBtn" class="mt-2 w-full px-3 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition">
                            Use Default Image
                        </button>
                    </div>
                </form>
            </div>

            <!-- Course Content Form -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-3">Course Content</h2>
                <form id="courseContentForm" class="space-y-6">

                    <div id="sectionsContainer">
                        <?php
                        if ($execSections->num_rows > 0) {
                            $sectionNumber = 1;
                            while ($dataSection = $execSections->fetch_assoc()) {
                                $sectionId = $dataSection['section_id'];
                                $queryLesson = "SELECT lesson_content FROM lessons WHERE lesson_section_id = $sectionId LIMIT 1";
                                $execLesson = $connection->query($queryLesson);
                                $lessonData = $execLesson->fetch_assoc();
                                $hasLesson = $execLesson->num_rows > 0;
                        ?>
                                <div class="section-item border border-gray-200 rounded-lg p-4 bg-gray-50 mb-4" data-section-id="<?= $sectionId ?>">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-semibold text-gray-700">Section <?= $sectionNumber ?></h3>
                                        <button type="button" class="remove-section-btn text-red-600 hover:text-red-700 text-sm font-medium">
                                            Remove Section
                                        </button>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Section Title</label>
                                        <input type="text" name="section_title[]" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                            value="<?= htmlspecialchars($dataSection['section_name']) ?>">
                                        <!-- FIXED: Added section_id input -->
                                        <input type="hidden" name="section_id[]" value="<?= $sectionId ?>">
                                    </div>

                                    <!-- File Upload -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Section Content (.md file)</label>

                                        <?php if ($hasLesson) { ?>
                                            <!-- Current File Display -->
                                            <div class="current-file-area mb-3 p-3 bg-green-50 border border-green-300 rounded-lg">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap-2">
                                                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <span class="text-sm text-gray-700 font-medium">Current file: <?= basename($lessonData['lesson_content']) ?></span>
                                                    </div>
                                                    <button type="button" class="change-file-btn text-blue-600 hover:text-blue-700 text-sm font-medium">
                                                        Change File
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- FIXED: Added class "keep-current-file" -->
                                            <input type="hidden" class="keep-current-file" name="keep_current_file[]" value="1">
                                        <?php } else { ?>
                                            <!-- FIXED: Added class "keep-current-file" -->
                                            <input type="hidden" class="keep-current-file" name="keep_current_file[]" value="0">
                                        <?php } ?>

                                        <!-- Upload Area -->
                                        <div class="section-upload-area <?= $hasLesson ? 'hidden' : '' ?> border-2 border-dashed border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:border-green-500 transition">
                                            <p class="mt-2 text-sm text-gray-600">
                                                <span class="font-semibold text-green-600">Click to upload</span> or drag and drop
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">Markdown file (.md only)</p>
                                        </div>

                                        <input type="file" class="section-file-input hidden" name="section_file[]" accept=".md">

                                        <!-- New File Preview -->
                                        <div class="section-file-preview hidden mt-3 p-3 bg-white border border-gray-300 rounded-lg">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-2">
                                                    <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    <span class="section-file-name text-sm text-gray-700"></span>
                                                </div>
                                                <button type="button" class="section-remove-file text-red-600 hover:text-red-700 text-sm font-medium">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                $sectionNumber++;
                            }
                        } else {
                            // No sections yet, show empty template
                            ?>
                            <div class="section-item border border-gray-200 rounded-lg p-4 bg-gray-50 mb-4">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold text-gray-700">Section 1</h3>
                                    <button type="button" class="remove-section-btn text-red-600 hover:text-red-700 text-sm font-medium">
                                        Remove Section
                                    </button>
                                </div>

                                <!-- Section Title -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Section Title</label>
                                    <input type="text" name="section_title[]" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                        placeholder="Enter section title">
                                    <!-- FIXED: Added section_id input -->
                                    <input type="hidden" name="section_id[]" value="">
                                </div>

                                <!-- File Upload Area -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Section Content (.md file)</label>

                                    <!-- Upload Area -->
                                    <div class="section-upload-area border-2 border-dashed border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:border-green-500 transition">
                                        <p class="mt-2 text-sm text-gray-600">
                                            <span class="font-semibold text-green-600">Click to upload</span> or drag and drop
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">Markdown file (.md only)</p>
                                    </div>

                                    <input type="file" class="section-file-input hidden" name="section_file[]" accept=".md">
                                    <!-- FIXED: Added keep-current-file input with class -->
                                    <input type="hidden" class="keep-current-file" name="keep_current_file[]" value="0">

                                    <!-- File Preview (Hidden by default) -->
                                    <div class="section-file-preview hidden mt-3 p-3 bg-white border border-gray-300 rounded-lg">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <span class="section-file-name text-sm text-gray-700"></span>
                                            </div>
                                            <button type="button" class="section-remove-file text-red-600 hover:text-red-700 text-sm font-medium">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <button type="button" id="addSectionBtn" class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 font-medium hover:border-blue-500 hover:text-blue-600 transition flex items-center justify-center gap-2">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Section
                    </button>
                </form>
            </div>
        </div>

        <!-- Submit -->
        <div class="mt-6 flex justify-end gap-3">
            <a href="javascript:history.back()">
                <button type="button" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-200">
                    Cancel
                </button>
            </a>
            <button type="button" id="updateCourseBtn" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-200">
                Update Course
            </button>
        </div>
    </div>

    <script src="backend/update_template.js"></script>
    <script src="backend/course_edit.js"></script>
    <script src="backend/course_update.js"></script>
</section>
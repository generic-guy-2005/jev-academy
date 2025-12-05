<?php
include 'connection.php';
$current_course = $_GET['id'];
$current_section = $_GET['section'];

$query_course = "SELECT * FROM courses WHERE course_id='$current_course'";
$query_section = "SELECT * FROM sections WHERE section_course_id='$current_course' ORDER BY sort_order ASC";
$exec_course = $connection->query($query_course);
$exec_section = $connection->query($query_section);
$data_course = $exec_course->fetch_assoc();

$lesson_file_url = null;
$section_title = null;

if ($current_section) {
    $query_lesson = "SELECT l.lesson_content, s.section_name 
        FROM lessons l 
        JOIN sections s ON l.lesson_section_id = s.section_id 
        WHERE s.section_id='$current_section'";

    $exec_lesson = $connection->query($query_lesson);
    if ($exec_lesson && $exec_lesson->num_rows > 0) {
        $data_lesson = $exec_lesson->fetch_assoc();
        $lesson_file_url = $data_lesson['lesson_content'];
        $section_title = $data_lesson['section_name'];
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>

<section class="p-16 mb-64 bg-gray-50">
    <div class="grid grid-cols-[1fr_2fr] gap-6">

        <div class="bg-white p-6 rounded-xl shadow sticky top-6 self-start">
            <div class="border-b border-gray-200 pb-4 mb-4">
                <h2 class="text-xl font-bold text-gray-800">Course Section</h2>
                <p class="text-sm text-gray-500 mt-1"><?= $exec_section->num_rows ?> sections</p>
            </div>

            <div class="space-y-2">
                <?php
                $section_number = 1;
                while ($data_section = $exec_section->fetch_assoc()) {
                    // Parani lessonnya
                    $section_id = $data_section['section_id'];
                    $query_lesson = "SELECT lesson_id FROM lessons WHERE lesson_section_id='$section_id' LIMIT 1";
                    $exec_lesson = $connection->query($query_lesson);
                    $has_content = $exec_lesson->num_rows > 0;
                ?>

                    <div class="border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer <?= $has_content ? 'hover:border-blue-400' : '' ?>"
                        <?php if ($has_content) { ?>
                        onclick="window.location.href='index.php?page=course/material&id=<?= $current_course ?>&section=<?= $data_section['section_id'] ?>'"
                        <?php } ?>>
                        <div class="p-4 flex items-center gap-3">
                            <!-- Buat aeelahh -->
                            <div class="flex-shrink-0 w-8 h-8 rounded-full <?= $has_content ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-400' ?> font-semibold flex items-center justify-center text-sm">
                                <?= $section_number ?>
                            </div>

                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium text-gray-800 text-sm truncate">
                                    <?= htmlspecialchars($data_section['section_name']) ?>
                                </h3>
                                <?php if (!$has_content) { ?>
                                    <p class="text-xs text-gray-400 mt-0.5">Coming soon</p>
                                <?php }
                                ?>
                            </div>

                            <!-- Powerful sekalee SVG jirr -->
                            <?php if ($has_content) { ?>
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            <?php } ?>
                        </div>
                    </div>

                <?php
                    $section_number++;
                }
                ?>
            </div>

            <!-- Antisipasi, mana tau anomali -->
            <?php if ($exec_section->num_rows === 0) { ?>
                <div class="text-center py-8">
                    <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-gray-500 text-sm mt-3">No sections yet</p>
                </div>
            <?php } ?>

            <div class="mt-6 pt-4 border-t border-gray-200">
                <a href="javascript:history.back()">
                    <button class="w-full px-4 py-2 rounded-lg bg-gray-200 text-gray-700 font-medium hover:bg-gray-300 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Courses
                    </button>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow">
            <?php if ($lesson_file_url !== null) { ?>
                <div class="border-b border-gray-200 p-6">
                    <h1 class="text-3xl font-bold text-gray-900"><?= htmlspecialchars($section_title) ?></h1>
                </div>

                <!-- Mengloading -->
                <div id="loading" class="flex items-center justify-center p-12">
                    <div class="text-center">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
                        <p class="text-gray-600 mt-4">Loading lesson content...</p>
                    </div>
                </div>

                <!-- Mengerror -->
                <div id="error" class="hidden p-8">
                    <div class="bg-red-50 border border-red-200 rounded-lg p-6 text-center">
                        <svg class="w-12 h-12 text-red-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-red-900">Failed to load lesson</h3>
                        <p class="text-red-700 mt-2">The lesson file could not be found or loaded.</p>
                    </div>
                </div>

                <!-- Inilah diee -->
                <div id="markdown-content" class="p-8 prose prose-lg max-w-none hidden"></div>

                <script>
                    marked.setOptions({
                        breaks: true,
                        gfm: true, // GitHub Flavored Markdown
                        headerIds: true,
                        mangle: false
                    });

                    fetch('<?= $lesson_file_url ?>')
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Failed to fetch markdown file');
                            }
                            return response.text();
                        })
                        .then(markdown => {
                            document.getElementById('loading').style.display = 'none';
                            const html = marked.parse(markdown);

                            const contentDiv = document.getElementById('markdown-content');
                            contentDiv.innerHTML = html;
                            contentDiv.classList.remove('hidden');

                            if (typeof hljs !== 'undefined') {
                                contentDiv.querySelectorAll('pre code').forEach((block) => {
                                    hljs.highlightElement(block);
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error loading markdown:', error);
                            document.getElementById('loading').style.display = 'none';
                            document.getElementById('error').classList.remove('hidden');
                        });
                </script>
            <?php } else { ?>
                <!-- Placeholder when no section selected -->
                <div class="flex items-center justify-center h-full min-h-[600px]">
                    <div class="text-center p-8">
                        <svg class="w-20 h-20 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-700 mt-4">Select a section to begin</h3>
                        <p class="text-gray-500 mt-2">Choose a section from the left to view the lesson content</p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
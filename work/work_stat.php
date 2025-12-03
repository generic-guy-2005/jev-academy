<?php
include 'connection.php';

$current_course = $_GET['id'];

$query_course = "SELECT * FROM courses WHERE course_id='$current_course'";
$query_enrolled = "SELECT user_name, enrollment_date
FROM users u, enrollment e
WHERE u.user_id = e.enrollment_student_id
AND e.enrollment_course_id = $current_course;
";

$exec_course = $connection->query($query_course);
$exec_enrolled = $connection->query($query_enrolled);

$data_course = $exec_course->fetch_assoc();
?>

<section class="p-16 bg-gray-50">
    <div class="grid grid-cols-[1fr_2fr] gap-6 mb-8">
        <div class="bg-white p-0 rounded-xl shadow aspect-video">
            <img class="block w-full h-full p-0 m-0 object-cover [border-top-left-radius:10px] [border-top-right-radius:10px]" src="<?= $data_course['course_image'] ?>" alt="Course Image">
            <div class="p-6">
                <h1 class="text-2xl font-semibold mb-4"><?= $data_course['course_name'] ?></h1>
                <div class="flex gap-2">
                    <a href="javascript:history.back()"><button class="px-6 py-2 mt-2 rounded-full bg-gray-600 text-white hover:bg-gray-400">Back</button></a>
                    <a href="index.php?page=work/edit&id=<?= $current_course ?>"><button class="px-6 py-2 mt-2 rounded-full bg-yellow-600 text-white hover:bg-yellow-400">Edit</button></a>
                    <button class="px-6 py-2 mt-2 rounded-full bg-red-600 text-white hover:bg-red-400" id="deleteCourseBtn">Delete</button>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <h1 class="text-2xl font-semibold mb-4">Enrolled Student</h1>
            <ul class="space-y-0">
                <?php
                while ($dataStudent = $exec_enrolled->fetch_assoc()) {
                ?>
                    <li class="p-4 bg-gray-50 rounded-xl flex items-center justify-between">
                        <span class="font-medium"><?= $dataStudent['user_name'] ?></span>
                        <span class="font-medium text-gray-500">Enrolled at: <?= $dataStudent['enrollment_date'] ?></span>
                        <button class="px-3 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-400">Remove</button>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-6">
        <div class="bg-white rounded-lg shadow-md aspect-video">
            <div class="p-6">
                <h1 class="text-2xl font-semibold mb-4">Course Contents</h1>
                <ul class="space-y-0">

                    <?php
                    $queryContent = "SELECT section_name FROM sections WHERE section_course_id = $current_course";
                    $execContent = $connection -> query($queryContent);

                    $num = 1;
                    while($dataContent = $execContent -> fetch_assoc()){
                    ?>

                    <li class="p-4 bg-gray-50 rounded-xl flex items-center justify-between">
                        <span class="font-medium text-gray-500"><?= $num++ ?></span>
                        <span class="font-medium"><?= $dataContent['section_name'] ?></span>
                    </li>

                    <?php
                    }
                    ?>

                </ul>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6">
                <h1 class="text-2xl font-semibold mb-4">Course Information</h1>
                <form id="copyForm">
                    <div class="flex gap-2 mb-4">
                        <input
                            type="text"
                            id="textToCopy"
                            class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            value="<?= $data_course['course_token'] ?>"
                            placeholder="Enter text to copy...">
                        <button
                            type="button"
                            id="copyButton"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200 whitespace-nowrap">
                            Copy
                        </button>
                    </div>
                    <div id="statusMessage" class="mb-4"></div>
                </form>
                <p class="pt-2"><?= $data_course['course_desc'] ?></p>
                <p class="text-gray-500">Created at <?= $data_course['course_added'] ?></p>
            </div>
        </div>
    </div>

    <script src="backend/course_delete.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const textInput = document.getElementById('textToCopy');
            const copyButton = document.getElementById('copyButton');
            const statusMessage = document.getElementById('statusMessage');

            copyButton.addEventListener('click', async function() {
                try {
                    textInput.select();
                    textInput.setSelectionRange(0, 99999);

                    await navigator.clipboard.writeText(textInput.value);

                    copyButton.textContent = 'Copied!';
                    copyButton.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                    copyButton.classList.add('bg-green-600', 'hover:bg-green-700');
                    statusMessage.innerHTML = '<p class="text-green-600 text-sm">✓ Text copied to clipboard!</p>';

                    setTimeout(() => {
                        copyButton.textContent = 'Copy';
                        copyButton.classList.remove('bg-green-600', 'hover:bg-green-700');
                        copyButton.classList.add('bg-blue-600', 'hover:bg-blue-700');
                        statusMessage.innerHTML = '';
                    }, 2000);

                } catch (err) {
                    const textArea = document.createElement('textarea');
                    textArea.value = textInput.value;
                    document.body.appendChild(textArea);
                    textArea.select();

                    try {
                        const successful = document.execCommand('copy');
                        if (successful) {
                            copyButton.textContent = 'Copied!';
                            copyButton.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                            copyButton.classList.add('bg-green-600', 'hover:bg-green-700');
                            statusMessage.innerHTML = '<p class="text-green-600 text-sm">✓ Text copied to clipboard!</p>';

                            setTimeout(() => {
                                copyButton.textContent = 'Copy';
                                copyButton.classList.remove('bg-green-600', 'hover:bg-green-700');
                                copyButton.classList.add('bg-blue-600', 'hover:bg-blue-700');
                                statusMessage.innerHTML = '';
                            }, 2000);
                        } else {
                            throw new Error('execCommand failed');
                        }
                    } catch (fallbackErr) {
                        statusMessage.innerHTML = '<p class="text-red-600 text-sm">Failed to copy text. Please try again.</p>';
                        setTimeout(() => {
                            statusMessage.innerHTML = '';
                        }, 3000);
                    }

                    document.body.removeChild(textArea);
                }
            });

            textInput.addEventListener('input', function() {
                if (copyButton.textContent === 'Copied!') {
                    copyButton.textContent = 'Copy';
                    copyButton.classList.remove('bg-green-600', 'hover:bg-green-700');
                    copyButton.classList.add('bg-blue-600', 'hover:bg-blue-700');
                }
                statusMessage.innerHTML = '';
            });

            document.getElementById('copyForm').addEventListener('submit', function(e) {
                e.preventDefault();
                copyButton.click();
            });
        });
    </script>
</section>
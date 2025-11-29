<template id="sectionTemplate">
    <div class="section-item mb-6 border border-gray-200 rounded-lg p-4 bg-gray-50">
        <div class="flex justify-between items-center mb-4">
            <h4 class="font-semibold text-gray-700 section-number">Section 1</h4>
            <button
                type="button"
                class="remove-section text-red-500 hover:text-red-700 focus:outline-none"
                title="Remove Section">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Section Title *
            </label>
            <input
                type="text"
                name="sectionTitle[]"
                placeholder="e.g., Advanced Topics"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Section Description
            </label>
            <textarea
                name="sectionDescription[]"
                placeholder="Brief description of what this section covers..."
                rows="2"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Course Material (.md only) *
            </label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-green-400 transition duration-200 cursor-pointer material-upload-area">
                <input
                    type="file"
                    name="sectionMaterial[]"
                    accept=".md,text/markdown"
                    class="hidden material-file-input"
                    required>
                <div class="flex flex-col items-center justify-center">
                    <i class="fas fa-file-alt text-2xl text-gray-400 mb-2"></i>
                    <p class="text-sm text-gray-600 mb-1">
                        <span class="text-green-600 font-medium">Click to upload</span> Markdown file
                    </p>
                    <p class="text-xs text-gray-500">.md files only (Max. 10MB)</p>
                </div>
            </div>
            <p class="file-name text-xs text-gray-600 mt-2 hidden"></p>
            <p class="material-error text-red-500 text-xs mt-2 hidden"></p>
        </div>

        <div class="text-right">
            <button
                type="button"
                class="add-material text-blue-600 text-sm hover:text-blue-800 focus:outline-none flex items-center ml-auto">
                <i class="fas fa-plus mr-1"></i>
                Add Another Material
            </button>
        </div>
    </div>
</template>
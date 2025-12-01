function getSectionTemplate(sectionNumber) {
    return `
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Section ${sectionNumber}</h3>
            <button type="button" class="remove-section-btn text-red-600 hover:text-red-700 text-sm font-medium">
                Remove Section
            </button>
        </div>
        
        <!-- Section Title -->
        <div class="mb-4">
            <label for="section_title_${sectionNumber}" class="block text-sm font-medium text-gray-700 mb-2">Section Title</label>
            <input type="text" id="section_title_${sectionNumber}" name="section_title[]" required 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                   placeholder="Enter section title">
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

            <!-- Hidden File Input -->
            <input type="file" class="section-file-input hidden" name="section_file[]" accept=".md">

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
    `;
}
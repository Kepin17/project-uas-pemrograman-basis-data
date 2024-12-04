<!-- Add Book Form -->
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" id="addBookModal">
    <div class="relative top-10 mx-auto p-5 border max-w-3xl shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="text-2xl leading-6 font-medium text-gray-900">Add New Book</h3>
                <button onclick="document.getElementById('addBookModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="addBookForm" class="mt-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="book_id">
                                Book ID
                            </label>
                            <input type="text" name="book_id" id="book_id" readonly
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-100"
                                value="BK001">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                                Book Name
                            </label>
                            <input type="text" name="title" id="title" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="publication_year">
                                Publication Year
                            </label>
                            <input type="number" name="publication_year" id="publication_year" required min="1900" max="<?php echo date('Y'); ?>"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="stock">
                                Stock
                            </label>
                            <input type="number" name="stock" id="stock" required min="0"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                    </div>
                    <!-- Right Column -->
                    <div class="space-y-6">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category">
                                Category
                            </label>
                            <select name="category" id="category" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">Select Category</option>
                                <?php
                                // Dummy category data - replace with database data later
                                $categories = [
                                    ['id' => 1, 'name' => 'Fiction'],
                                    ['id' => 2, 'name' => 'Non-Fiction'],
                                    ['id' => 3, 'name' => 'Science'],
                                    ['id' => 4, 'name' => 'Technology']
                                ];
                                foreach ($categories as $category) {
                                    echo "<option value='{$category['id']}'>{$category['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="shelf">
                                Book Shelf
                            </label>
                            <select name="shelf" id="shelf" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">Select Shelf</option>
                                <?php
                                // Dummy shelf data - replace with database data later
                                $shelves = [
                                    ['id' => 1, 'name' => 'Shelf A-1'],
                                    ['id' => 2, 'name' => 'Shelf A-2'],
                                    ['id' => 3, 'name' => 'Shelf B-1'],
                                    ['id' => 4, 'name' => 'Shelf B-2']
                                ];
                                foreach ($shelves as $shelf) {
                                    echo "<option value='{$shelf['id']}'>{$shelf['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                                Description
                            </label>
                            <textarea name="description" id="description" required rows="4"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-end mt-8 pt-4 border-t">
                    <button type="button" onclick="document.getElementById('addBookModal').classList.add('hidden')"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-4">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Add Book
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Function to generate next book ID
function generateNextBookId(currentId) {
    const numPart = parseInt(currentId.substring(2));
    const nextNum = numPart + 1;
    return `BK${String(nextNum).padStart(3, '0')}`;
}

document.getElementById('addBookForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Get form data
    const formData = new FormData(this);
    
    // For now, just log the data since we don't have database integration
    console.log('Book Data:', Object.fromEntries(formData));
    
    // Update book ID for next entry (simulating auto-increment)
    const currentId = document.getElementById('book_id').value;
    document.getElementById('book_id').value = generateNextBookId(currentId);
    
    // Clear other form fields
    document.getElementById('title').value = '';
    document.getElementById('description').value = '';
    document.getElementById('publication_year').value = '';
    document.getElementById('stock').value = '';
    document.getElementById('category').value = '';
    document.getElementById('shelf').value = '';
    
    // Hide modal
    document.getElementById('addBookModal').classList.add('hidden');
    
    // Show success message
    alert('Book added successfully!');
});
</script>
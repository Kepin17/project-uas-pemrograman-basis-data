<!-- Edit Book Form -->
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" id="editBookModal">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Book</h3>
                <button onclick="document.getElementById('editBookModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editBookForm" class="mt-4">
                <input type="hidden" name="book_id" id="edit_book_id">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit_title">
                        Title
                    </label>
                    <input type="text" name="title" id="edit_title" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit_author">
                        Author
                    </label>
                    <input type="text" name="author" id="edit_author" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit_isbn">
                        ISBN
                    </label>
                    <input type="text" name="isbn" id="edit_isbn" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit_category">
                        Category
                    </label>
                    <select name="category" id="edit_category" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Select Category</option>
                        <option value="fiction">Fiction</option>
                        <option value="non-fiction">Non-Fiction</option>
                        <option value="science">Science</option>
                        <option value="technology">Technology</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit_status">
                        Status
                    </label>
                    <select name="status" id="edit_status" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="available">Available</option>
                        <option value="borrowed">Borrowed</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit_cover">
                        Book Cover
                    </label>
                    <input type="file" name="cover" id="edit_cover" accept="image/*"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <div id="current_cover" class="mt-2">
                        <img id="cover_preview" src="" alt="Current cover" class="w-20 h-20 object-cover hidden">
                    </div>
                </div>
                <div class="flex items-center justify-between mt-6">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Save Changes
                    </button>
                    <button type="button" onclick="document.getElementById('editBookModal').classList.add('hidden')"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function populateEditForm(bookData) {
    const book = JSON.parse(bookData);
    document.getElementById('edit_title').value = book.title;
    document.getElementById('edit_author').value = book.author;
    document.getElementById('edit_isbn').value = book.isbn;
    document.getElementById('edit_category').value = book.category.toLowerCase();
    document.getElementById('edit_status').value = book.status.toLowerCase();
    
    // Show cover preview if exists
    const coverPreview = document.getElementById('cover_preview');
    if (book.cover) {
        coverPreview.src = book.cover;
        coverPreview.classList.remove('hidden');
    } else {
        coverPreview.classList.add('hidden');
    }
}

document.getElementById('editBookForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Get form data
    const formData = new FormData(this);
    
    // For now, just log the data since we don't have database integration
    console.log('Updated Book Data:', Object.fromEntries(formData));
    
    // Hide modal
    document.getElementById('editBookModal').classList.add('hidden');
    
    // Show success message (you can customize this)
    alert('Book updated successfully!');
});
</script>
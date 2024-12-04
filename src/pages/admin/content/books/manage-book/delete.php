<!-- Delete Book Confirmation -->
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" id="deleteBookModal">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Delete Book</h3>
                <button onclick="document.getElementById('deleteBookModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mt-4">
                <p class="text-gray-600">Are you sure you want to delete this book? This action cannot be undone.</p>
                <div class="mt-4">
                    <div class="flex items-center text-sm text-gray-600">
                        <span class="font-semibold">Title:</span>
                        <span id="delete_book_title" class="ml-2"></span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600 mt-1">
                        <span class="font-semibold">ISBN:</span>
                        <span id="delete_book_isbn" class="ml-2"></span>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-6">
                    <button onclick="confirmDelete()"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Delete
                    </button>
                    <button onclick="document.getElementById('deleteBookModal').classList.add('hidden')"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let deleteBookIsbn = '';

function showDeleteConfirmation(isbn, title) {
    deleteBookIsbn = isbn;
    document.getElementById('delete_book_title').textContent = title;
    document.getElementById('delete_book_isbn').textContent = isbn;
    document.getElementById('deleteBookModal').classList.remove('hidden');
}

function confirmDelete() {
    // For now, just log the deletion since we don't have database integration
    console.log('Deleting book with ISBN:', deleteBookIsbn);
    
    // Hide modal
    document.getElementById('deleteBookModal').classList.add('hidden');
    
    // Show success message (you can customize this)
    alert('Book deleted successfully!');
    
    // Reset the ISBN
    deleteBookIsbn = '';
}
</script>
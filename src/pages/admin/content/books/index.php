<div class="relative min-h-screen ">
    

    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800">Books Management</h2>
        <p class="text-gray-600">Manage your library books inventory</p>
    </div>
    
    <!-- Action Buttons and Search -->
    <div class="flex justify-between items-center mb-6">
        <button onclick="document.getElementById('addBookModal').classList.remove('hidden')" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i> Add New Book
        </button>
        <div class="relative">
            <input type="text" id="searchInput" onkeyup="searchBooks()" placeholder="Search books..." class="pl-10 pr-4 py-2 border rounded-lg w-64">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
        </div>
    </div>

    <!-- Books Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200" id="booksTable">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book Info</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php
                // Dummy data - replace with database data later
                $books = [
                    [
                        'title' => 'The Great Gatsby',
                        'author' => 'F. Scott Fitzgerald',
                        'isbn' => '978-0743273565',
                        'category' => 'Fiction',
                        'status' => 'Available'
                    ],
                    [
                        'title' => 'To Kill a Mockingbird',
                        'author' => 'Harper Lee',
                        'isbn' => '978-0446310789',
                        'category' => 'Fiction',
                        'status' => 'Borrowed'
                    ],
                    [
                        'title' => 'The Pragmatic Programmer',
                        'author' => 'Andrew Hunt',
                        'isbn' => '978-0201616224',
                        'category' => 'Technology',
                        'status' => 'Available'
                    ]
                ];


             

                foreach ($books as $book): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0">
                                    <img class="h-10 w-10 rounded" src="https://via.placeholder.com/40" alt="">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($book['title']); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo htmlspecialchars($book['author']); ?></div>
                                    <div class="text-xs text-gray-400">ISBN: <?php echo htmlspecialchars($book['isbn']); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                <?php echo htmlspecialchars($book['category']); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $book['status'] === 'Available' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                <?php echo htmlspecialchars($book['status']); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <button onclick="editBook('<?php echo htmlspecialchars(json_encode($book), ENT_QUOTES); ?>')" class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                            <button onclick="deleteBook('<?php echo htmlspecialchars($book['isbn']); ?>')" class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Include the modals -->
    <?php include 'manage-book/add.php'; ?>

    <script>
    function searchBooks() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toUpperCase();
        const table = document.getElementById('booksTable');
        const tr = table.getElementsByTagName('tr');

        for (let i = 1; i < tr.length; i++) {
            const td = tr[i].getElementsByTagName('td')[0];
            if (td) {
                const txtValue = td.textContent || td.innerText;
                tr[i].style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? '' : 'none';
            }
        }
    }

    function editBook(bookData) {
        const book = JSON.parse(bookData);
        // Populate edit form
        document.getElementById('editBookModal').classList.remove('hidden');
        // Add code to populate form fields
    }

    function deleteBook(isbn) {
        if (confirm('Are you sure you want to delete this book?')) {
            // Add delete logic here
            console.log('Deleting book with ISBN:', isbn);
        }
    }
    </script>

    <!-- Header -->
    <div class="mt-5 mb-8">
        <h2 class="text-2xl font-semibold text-gray-800">Categories Management</h2>
        <p class="text-gray-600">Manage your book categories</p>
    </div>

    <!-- Action Buttons and Search -->
    <div class="flex justify-between items-center mb-6">
        <button onclick="document.getElementById('addCategoryModal').classList.remove('hidden')" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i> Add Category
        </button>
        <div class="relative">
            <input type="text" placeholder="Search categories..." class="pl-10 pr-4 py-2 border rounded-lg w-64">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div id="addCategoryModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl w-[500px] p-6">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Add New Category</h2>
                <button onclick="toggleCategoryModal()" class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form id="addCategoryForm" class="space-y-4">
                <div>
                    <label for="categoryId" class="block text-sm font-medium text-gray-700">Category ID</label>
                    <input type="text" id="categoryId" name="categoryId" readonly 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 py-2 px-3" 
                        value="CT001">
                </div>
                
                <div>
                    <label for="categoryName" class="block text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" id="categoryName" name="categoryName" required
                        class="mt-1 block w-full border-2 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 py-2 px-3">
                </div>
               
                
                <div class="flex justify-end space-x-4 pt-4 border-t">
                    <button type="button" onclick="toggleCategoryModal()" 
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Add Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function toggleCategoryModal() {
        const modal = document.getElementById('addCategoryModal');
        modal.classList.toggle('hidden');
    }

    function generateNextCategoryId(currentId) {
        const numPart = parseInt(currentId.substring(3));
        const nextNum = numPart + 1;
        return `CAT${String(nextNum).padStart(3, '0')}`;
    }

    document.getElementById('addCategoryForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form data
        const formData = new FormData(this);
        const categoryData = Object.fromEntries(formData);
        
        console.log('Category Data:', categoryData);
        
        // Update category ID for next entry (simulating auto-increment)
        const currentId = document.getElementById('categoryId').value;
        document.getElementById('categoryId').value = generateNextCategoryId(currentId);
        
        // Clear form fields
        document.getElementById('categoryName').value = '';
        document.getElementById('categoryDescription').value = '';
        
        // Hide modal
        toggleCategoryModal();
        
        // Show success message
        alert('Category added successfully!');
    });
    </script>

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Category Card -->

        <?php 
               // dummy category data
               $categories = [
                ['id' => 1, 'name' => 'Fiction'],
                ['id' => 2, 'name' => 'Non-Fiction'],
                ['id' => 3, 'name' => 'Science'],
                ['id' => 4, 'name' => 'Technology']
            ];

            foreach ($categories as $cat) {
                echo '
                     <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Fiction</h3>
                    <p class="text-gray-600 text-sm mt-1">Novels and story books</p>
                </div>
                <div class="flex space-x-2">
                    <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-book mr-2"></i>
                    <span>150 Books</span>
                </div>
                <div class="flex items-center text-sm text-gray-500 mt-1">
                    <i class="fas fa-clock mr-2"></i>
                    <span>Last updated: 2 days ago</span>
                </div>
            </div>
        </div>
                ';
            }
        ?>
   
        <!-- Add more category cards here -->
    </div><!-- Header -->
    <div class="mb-8 mt-5 ">
        <h2 class="text-2xl font-semibold text-gray-800">Shelf Management</h2>
        <p class="text-gray-600">Manage your library shelves</p>
    </div>

    <!-- Action Buttons and Search -->
    <div class="flex justify-between items-center mb-6">
        <button onclick="document.getElementById('addShelfModal').classList.remove('hidden')" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i> Add Shelf
        </button>
        <div class="relative">
            <input type="text" placeholder="Search shelves..." class="pl-10 pr-4 py-2 border rounded-lg w-64">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
        </div>
    </div>

    <!-- Add Shelf Modal -->
    <div id="addShelfModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl w-[500px] p-6">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Add New Shelf</h2>
                <button onclick="toggleShelfModal()" class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form id="addShelfForm" class="space-y-4">
                <div>
                    <label for="shelfId" class="block text-sm font-medium text-gray-700">Shelf ID</label>
                    <input type="text" id="shelfId" name="shelfId" readonly 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 py-2 px-3" 
                        value="SL001">
                </div>
                
                <div>
                    <label for="shelfName" class="block text-sm font-medium text-gray-700">Shelf Name</label>
                    <input type="text" id="shelfName" name="shelfName" required
                        class="mt-1 block w-full border-2 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 py-2 px-3">
                </div>
                
                
                
                <div class="flex justify-end space-x-4 pt-4 border-t">
                    <button type="button" onclick="toggleShelfModal()" 
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Add Shelf
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function toggleShelfModal() {
        const modal = document.getElementById('addShelfModal');
        modal.classList.toggle('hidden');
    }

    function generateNextShelfId(currentId) {
        const numPart = parseInt(currentId.substring(3));
        const nextNum = numPart + 1;
        return `SL${String(nextNum).padStart(3, '0')}`;
    }

    document.getElementById('addShelfForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form data
        const formData = new FormData(this);
        const shelfData = Object.fromEntries(formData);
        
        console.log('Shelf Data:', shelfData);
        
        // Update shelf ID for next entry (simulating auto-increment)
        const currentId = document.getElementById('shelfId').value;
        document.getElementById('shelfId').value = generateNextShelfId(currentId);
        
        // Clear form fields
        document.getElementById('shelfName').value = '';
        document.getElementById('shelfSection').selectedIndex = 0;
        
        // Hide modal
        toggleShelfModal();
        
        // Show success message
        alert('Shelf added successfully!');
    });
    </script>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    <?php 
               // dummy shelf data
               $shelves = [
                ['id' => 1, 'name' => 'Shelf A-1'],
                ['id' => 2, 'name' => 'Shelf A-2'],
                ['id' => 3, 'name' => 'Shelf B-1'],
                ['id' => 4, 'name' => 'Shelf B-2']
            ];
            
            foreach ($shelves as $shelf) {
                echo '
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">' . $shelf['name'] . '</h3>
                    <p class="text-gray-600 text-sm mt-1">Fiction Section</p>
                </div>
                <div class="flex space-x-2">
                    <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center justify-between text-sm text-gray-500">
                    <span>Capacity:</span>
                    <span>200 books</span>
                </div>
                <div class="mt-2">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: 75%"></div>
                    </div>
                    <div class="text-xs text-gray-500 mt-1">150 books (75% full)</div>
                </div>
            </div>
        </div>
        ';
    }
    ?>

</div>

</div>
   


<!-- Header -->
<div class="mb-8">
    <h2 class="text-2xl font-semibold text-gray-800">Books Management</h2>
    <p class="text-gray-600">Manage your library books inventory</p>
</div>

<!-- Action Buttons and Search -->
<div class="flex justify-between items-center mb-6">
    <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
        <i class="fas fa-plus mr-2"></i> Add New Book
    </button>
    <div class="relative">
        <input type="text" placeholder="Search books..." class="pl-10 pr-4 py-2 border rounded-lg w-64">
        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
    </div>
</div>

<!-- Books Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book Info</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <!-- Sample Book Row -->
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="h-10 w-10 flex-shrink-0">
                            <img class="h-10 w-10 rounded" src="https://via.placeholder.com/40" alt="">
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">The Great Gatsby</div>
                            <div class="text-sm text-gray-500">F. Scott Fitzgerald</div>
                            <div class="text-xs text-gray-400">ISBN: 978-0743273565</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                        Fiction
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Available
                    </span>
                </td>
                <td class="px-6 py-4 text-sm font-medium">
                    <button class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                    <button class="text-red-600 hover:text-red-900">Delete</button>
                </td>
            </tr>
            <!-- Add more book rows here -->
        </tbody>
    </table>
</div>


<!-- Header -->
<div class="mt-5 mb-8">
    <h2 class="text-2xl font-semibold text-gray-800">Categories Management</h2>
    <p class="text-gray-600">Manage your book categories</p>
</div>

<!-- Action Buttons and Search -->
<div class="flex justify-between items-center mb-6">
    <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
        <i class="fas fa-plus mr-2"></i> Add Category
    </button>
    <div class="relative">
        <input type="text" placeholder="Search categories..." class="pl-10 pr-4 py-2 border rounded-lg w-64">
        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
    </div>
</div>

<!-- Categories Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Category Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Fiction</h3>
                <p class="text-gray-600 text-sm mt-1">Novels and story books</p>
            </div>
            <div class="flex space-x-2">
                <button class="text-blue-600 hover:text-blue-900"><i class="fas fa-edit"></i></button>
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
    <!-- Add more category cards here -->
</div><!-- Header -->
<div class="mb-8 mt-5 ">
    <h2 class="text-2xl font-semibold text-gray-800">Shelf Management</h2>
    <p class="text-gray-600">Manage your library shelves</p>
</div>

<!-- Action Buttons and Search -->
<div class="flex justify-between items-center mb-6">
    <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
        <i class="fas fa-plus mr-2"></i> Add Shelf
    </button>
    <div class="relative">
        <input type="text" placeholder="Search shelves..." class="pl-10 pr-4 py-2 border rounded-lg w-64">
        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
    </div>
</div>

<!-- Shelves Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Shelf Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Shelf A-1</h3>
                <p class="text-gray-600 text-sm mt-1">Fiction Section</p>
            </div>
            <div class="flex space-x-2">
                <button class="text-blue-600 hover:text-blue-900"><i class="fas fa-edit"></i></button>
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
</div> 

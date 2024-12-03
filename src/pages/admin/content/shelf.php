<!-- Header -->
<div class="mb-8">
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
    <!-- Add more shelf cards here -->
</div>
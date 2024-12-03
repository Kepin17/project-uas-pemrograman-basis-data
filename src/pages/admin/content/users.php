<!-- Header -->
<div class="mb-8">
    <h2 class="text-2xl font-semibold text-gray-800">Users Management</h2>
    <p class="text-gray-600">Manage library members</p>
</div>

<!-- Action Buttons and Search -->
<div class="flex justify-between items-center mb-6">
    <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
        <i class="fas fa-plus mr-2"></i> Add User
    </button>
    <div class="relative">
        <input type="text" placeholder="Search users..." class="pl-10 pr-4 py-2 border rounded-lg w-64">
        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
    </div>
</div>

<!-- Users Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Membership</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Books Borrowed</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <!-- Sample User Row -->
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="h-10 w-10 flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" src="https://via.placeholder.com/40" alt="">
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">Jane Smith</div>
                            <div class="text-sm text-gray-500">jane.smith@email.com</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gold-100 text-gold-800">
                        Premium
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-900">3 Books</div>
                    <div class="text-xs text-gray-500">2 due next week</div>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Active
                    </span>
                </td>
                <td class="px-6 py-4 text-sm font-medium">
                    <button class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                    <button class="text-red-600 hover:text-red-900">Delete</button>
                </td>
            </tr>
            <!-- Add more user rows here -->
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="flex items-center justify-between mt-6">
    <div class="text-sm text-gray-500">
        Showing 1 to 10 of 50 entries
    </div>
    <div class="flex space-x-2">
        <button class="px-3 py-1 border rounded hover:bg-gray-50">Previous</button>
        <button class="px-3 py-1 bg-blue-500 text-white rounded">1</button>
        <button class="px-3 py-1 border rounded hover:bg-gray-50">2</button>
        <button class="px-3 py-1 border rounded hover:bg-gray-50">3</button>
        <button class="px-3 py-1 border rounded hover:bg-gray-50">Next</button>
    </div>
</div>
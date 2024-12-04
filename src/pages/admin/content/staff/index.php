<!-- Header -->
<div class="mb-8">
    <h2 class="text-2xl font-semibold text-gray-800">Staff Management</h2>
    <p class="text-gray-600">Manage library staff members</p>
</div>

<!-- Action Buttons and Search -->
<div class="flex justify-between items-center mb-6">
    <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center" onclick="openAddStaffModal()">
        <i class="fas fa-plus mr-2"></i> Add Staff Member
    </button>
    <div class="relative">
        <input type="text" placeholder="Search staff..." class="pl-10 pr-4 py-2 border rounded-lg w-64">
        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
    </div>
</div>

<!-- Staff Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Staff Member</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <!-- Sample Staff Row -->
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="h-10 w-10 flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" src="https://via.placeholder.com/40" alt="">
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">John Doe</div>
                            <div class="text-sm text-gray-500">john.doe@library.com</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                        Librarian
                    </span>
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
        </tbody>
    </table>
</div>

<!-- Add Staff Modal -->
<div id="addStaffModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Add New Staff Member</h3>
            <form id="addStaffForm" onsubmit="handleAddStaff(event)">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="staffName">
                        Full Name
                    </label>
                    <input type="text" id="staffName" name="staffName" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="staffEmail">
                        Email
                    </label>
                    <input type="email" id="staffEmail" name="staffEmail" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="staffPhone">
                        Phone Number
                    </label>
                    <input type="tel" id="staffPhone" name="staffPhone" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="staffRole">
                        Role
                    </label>
                    <select id="staffRole" name="staffRole" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Select a role...</option>
                        <option value="librarian">Librarian</option>
                        <option value="assistant">Library Assistant</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="staffPassword">
                        Password
                    </label>
                    <input type="password" id="staffPassword" name="staffPassword" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex items-center justify-between mt-6">
                    <button type="button" onclick="closeAddStaffModal()"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Add Staff
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openAddStaffModal() {
    document.getElementById('addStaffModal').classList.remove('hidden');
}

function closeAddStaffModal() {
    document.getElementById('addStaffModal').classList.add('hidden');
}

function handleAddStaff(event) {
    event.preventDefault();
    
    // Get form data
    const formData = {
        name: document.getElementById('staffName').value,
        email: document.getElementById('staffEmail').value,
        phone: document.getElementById('staffPhone').value,
        role: document.getElementById('staffRole').value,
        password: document.getElementById('staffPassword').value
    };

    // Just show the data in console for now
    console.log('Staff data:', formData);
    alert('Staff member would be added here (check console for data)');
    
    // Clear form and close modal
    event.target.reset();
    closeAddStaffModal();
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('addStaffModal');
    if (event.target == modal) {
        closeAddStaffModal();
    }
}
</script>
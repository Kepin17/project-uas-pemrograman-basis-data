<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Mobile menu button -->
    <button id="menuBtn" class="fixed top-4 right-4 z-50 lg:hidden bg-blue-600 text-white p-2 rounded-lg">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 bg-blue-800 text-white w-64 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40">
        <div class="p-6">
            <h1 class="text-2xl font-bold">Library Admin</h1>
        </div>
        <nav class="mt-6">
            <div class="px-4 space-y-2">
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 active:bg-blue-700">
                    <i class="fas fa-home mr-2"></i>Dashboard
                </a>
                <a href="users.php" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
                    <i class="fas fa-users mr-2"></i>Users
                </a>
                <a href="staff.php" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
                    <i class="fas fa-user-tie mr-2"></i>Staff
                </a>
                <a href="books.php" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
                    <i class="fas fa-book mr-2"></i>Books
                </a>
                <a href="shelves.php" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
                    <i class="fas fa-bookmark mr-2"></i>Book Shelves
                </a>
                <a href="categories.php" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
                    <i class="fas fa-tags mr-2"></i>Categories
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="lg:ml-64 p-6">
        <!-- Top Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-600 bg-opacity-75">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="mb-2 text-sm font-medium text-gray-600">Total Users</p>
                        <p class="text-lg font-semibold text-gray-700">245</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-600 bg-opacity-75">
                        <i class="fas fa-book text-white text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="mb-2 text-sm font-medium text-gray-600">Total Books</p>
                        <p class="text-lg font-semibold text-gray-700">1,200</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-600 bg-opacity-75">
                        <i class="fas fa-bookmark text-white text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="mb-2 text-sm font-medium text-gray-600">Book Shelves</p>
                        <p class="text-lg font-semibold text-gray-700">35</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-600 bg-opacity-75">
                        <i class="fas fa-tags text-white text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="mb-2 text-sm font-medium text-gray-600">Categories</p>
                        <p class="text-lg font-semibold text-gray-700">12</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Recent Activity</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Book Added</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">John Doe</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2023-12-20</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">User Registered</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Jane Smith</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2023-12-19</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Mobile menu toggle
        const menuBtn = document.getElementById('menuBtn');
        const sidebar = document.getElementById('sidebar');
        
        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });
    </script>
</body>
</html>

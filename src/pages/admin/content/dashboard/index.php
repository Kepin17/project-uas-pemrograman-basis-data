<?php
// Dummy data for demonstration
$totalBooks = 1250;
$totalMembers = 450;
$activeLoans = 89;
$totalCategories = 25;
?>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <!-- Total Books Card -->
    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 mr-4">
                <i class="fas fa-book text-blue-500 text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Books</p>
                <p class="text-2xl font-bold text-gray-700"><?php echo number_format($totalBooks); ?></p>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-green-500 text-sm font-semibold">↑ 12%</span>
            <span class="text-gray-400 text-sm">from last month</span>
        </div>
    </div>

    <!-- Total Members Card -->
    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 mr-4">
                <i class="fas fa-users text-green-500 text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Members</p>
                <p class="text-2xl font-bold text-gray-700"><?php echo number_format($totalMembers); ?></p>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-green-500 text-sm font-semibold">↑ 8%</span>
            <span class="text-gray-400 text-sm">from last month</span>
        </div>
    </div>

    <!-- Active Loans Card -->
    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 mr-4">
                <i class="fas fa-book-reader text-yellow-500 text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Active Loans</p>
                <p class="text-2xl font-bold text-gray-700"><?php echo number_format($activeLoans); ?></p>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-yellow-500 text-sm font-semibold">↔ 0%</span>
            <span class="text-gray-400 text-sm">from last month</span>
        </div>
    </div>

    <!-- Categories Card -->
    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 mr-4">
                <i class="fas fa-tags text-purple-500 text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Categories</p>
                <p class="text-2xl font-bold text-gray-700"><?php echo number_format($totalCategories); ?></p>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-purple-500 text-sm font-semibold">↑ 2%</span>
            <span class="text-gray-400 text-sm">from last month</span>
        </div>
    </div>
</div>

<!-- Recent Activities and Quick Actions -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Activities -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Activities</h2>
        <div class="space-y-4">
            <!-- Activity Item -->
            <div class="flex items-center border-b pb-4">
                <div class="p-2 rounded-full bg-blue-100 mr-4">
                    <i class="fas fa-book-reader text-blue-500"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-700">New Book Borrowed</p>
                    <p class="text-sm text-gray-500">John Doe borrowed "The Great Gatsby"</p>
                </div>
                <span class="text-xs text-gray-400">2 mins ago</span>
            </div>

            <!-- Activity Item -->
            <div class="flex items-center border-b pb-4">
                <div class="p-2 rounded-full bg-green-100 mr-4">
                    <i class="fas fa-user-plus text-green-500"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-700">New Member</p>
                    <p class="text-sm text-gray-500">Sarah Smith joined the library</p>
                </div>
                <span class="text-xs text-gray-400">1 hour ago</span>
            </div>

            <!-- Activity Item -->
            <div class="flex items-center">
                <div class="p-2 rounded-full bg-yellow-100 mr-4">
                    <i class="fas fa-book text-yellow-500"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-700">Book Returned</p>
                    <p class="text-sm text-gray-500">Mike Johnson returned "1984"</p>
                </div>
                <span class="text-xs text-gray-400">2 hours ago</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-2 gap-4">
            <button class="p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-300">
                <i class="fas fa-book-medical text-blue-500 text-xl mb-2"></i>
                <p class="text-sm font-semibold text-gray-700">Add New Book</p>
            </button>
            <button class="p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors duration-300">
                <i class="fas fa-user-plus text-green-500 text-xl mb-2"></i>
                <p class="text-sm font-semibold text-gray-700">Add Member</p>
            </button>
            <button class="p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors duration-300">
                <i class="fas fa-book-reader text-yellow-500 text-xl mb-2"></i>
                <p class="text-sm font-semibold text-gray-700">Issue Book</p>
            </button>
            <button class="p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors duration-300">
                <i class="fas fa-chart-bar text-purple-500 text-xl mb-2"></i>
                <p class="text-sm font-semibold text-gray-700">View Reports</p>
            </button>
        </div>
    </div>
</div>
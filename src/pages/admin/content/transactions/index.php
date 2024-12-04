<?php
$activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'borrow';

$dummyBorrowings = [
    ['id' => 'TRX-001', 'member' => 'John Doe', 'book' => 'The Great Gatsby', 'borrowDate' => '2023-12-20', 'dueDate' => '2024-01-03', 'status' => 'Active'],
    ['id' => 'TRX-002', 'member' => 'Jane Smith', 'book' => 'To Kill a Mockingbird', 'borrowDate' => '2023-12-22', 'dueDate' => '2024-01-05', 'status' => 'Overdue'],
    ['id' => 'TRX-003', 'member' => 'Bob Johnson', 'book' => '1984', 'borrowDate' => '2023-12-25', 'dueDate' => '2024-01-08', 'status' => 'Active'],
];

$dummyReturns = [
    ['id' => 'RTN-001', 'transactionId' => 'TRX-001', 'member' => 'John Doe', 'book' => 'The Great Gatsby', 'returnDate' => '2024-01-05', 'fine' => 'Rp 10.000'],
    ['id' => 'RTN-002', 'transactionId' => 'TRX-004', 'member' => 'Alice Brown', 'book' => 'Pride and Prejudice', 'returnDate' => '2024-01-07', 'fine' => 'Rp 0'],
    ['id' => 'RTN-003', 'transactionId' => 'TRX-005', 'member' => 'Charlie Wilson', 'book' => 'The Catcher in the Rye', 'returnDate' => '2024-01-08', 'fine' => 'Rp 5.000'],
];
?>

<!-- Header -->
<div class="mb-8">
    <h2 class="text-2xl font-semibold text-gray-800">Transaction Management</h2>
    <p class="text-gray-600">Manage book borrowing and returns</p>
</div>

<!-- Tabs -->
<div class="mb-6">
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <a href="?page=transactions&tab=borrow" 
               class="<?php echo $activeTab === 'borrow' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Book Borrowing
            </a>
            <a href="?page=transactions&tab=return" 
               class="<?php echo $activeTab === 'return' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Book Returns
            </a>
        </nav>
    </div>
</div>

<?php if ($activeTab === 'borrow'): ?>
    <!-- Borrowing Section -->
    <div class="bg-white rounded-lg shadow-sm">
        <!-- Action Buttons and Search -->
        <div class="p-6 flex justify-between items-center border-b">
            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center" 
                onclick="showBorrowModal()">
                <i class="fas fa-plus mr-2"></i> New Borrowing
            </button>
            <div class="relative">
                <input type="text" placeholder="Search borrowings..." 
                    class="pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        </div>

        <!-- Borrowing Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrow Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($dummyBorrowings as $borrowing): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $borrowing['id']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $borrowing['member']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $borrowing['book']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $borrowing['borrowDate']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $borrowing['dueDate']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $borrowing['status'] === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                    <?php echo $borrowing['status']; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-blue-600 hover:text-blue-900">View</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>
    <!-- Returns Section -->
    <div class="bg-white rounded-lg shadow-sm">
        <!-- Action Buttons and Search -->
        <div class="p-6 flex justify-between items-center border-b">
            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center"
                onclick="showReturnModal()">
                <i class="fas fa-undo mr-2"></i> Process Return
            </button>
            <div class="relative">
                <input type="text" placeholder="Search returns..." 
                    class="pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        </div>

        <!-- Returns Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Return ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Return Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fine</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($dummyReturns as $return): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $return['id']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $return['transactionId']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $return['member']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $return['book']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $return['returnDate']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $return['fine']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-blue-600 hover:text-blue-900">View</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<!-- Include Modal Forms -->
<?php 
require_once __DIR__ . '/borrowForm.php';
require_once __DIR__ . '/returnForm.php';
?>

<script>
    const showBorrowModal = () => {
        const modal = document.getElementById('borrowModal');
        modal.classList.remove('hidden');
    }

    const showReturnModal = () => {
        const modal = document.getElementById('returnModal');
        modal.classList.remove('hidden');
    }
</script>

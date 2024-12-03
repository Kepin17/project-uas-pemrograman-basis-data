<?php
$books = [
    ['id' => 1, 'title' => 'The Great Gatsby', 'author' => 'F. Scott Fitzgerald', 'category' => 'Fiction', 'position' => 'A1', 'summary' => 'A story of decadence and excess in Jazz Age America'],
    ['id' => 2, 'title' => '1984', 'author' => 'George Orwell', 'category' => 'Science Fiction', 'position' => 'B2', 'summary' => 'A dystopian novel set in a totalitarian future'],
    ['id' => 3, 'title' => 'To Kill a Mockingbird', 'author' => 'Harper Lee', 'category' => 'Fiction', 'position' => 'C3', 'summary' => 'A novel of racism and injustice in the American South']
];

$itemsPerPage = 6;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$totalPages = ceil(count($books) / $itemsPerPage);
$paginatedBooks = array_slice($books, ($currentPage - 1) * $itemsPerPage, $itemsPerPage);

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';

if ($searchTerm || $selectedCategory) {
    $paginatedBooks = array_filter($paginatedBooks, function($book) use ($searchTerm, $selectedCategory) {
        $matchSearch = empty($searchTerm) || stripos($book['title'], $searchTerm) !== false || stripos($book['author'], $searchTerm) !== false;
        $matchCategory = empty($selectedCategory) || $book['category'] === $selectedCategory;
        return $matchSearch && $matchCategory;
    });
}
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Member Book Collection</h1>

    <!-- Search and Filter Section -->
    <form action="" method="GET" class="bg-white p-4 rounded-lg shadow mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" placeholder="Search books..." value="<?= htmlspecialchars($searchTerm) ?>" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex-1 md:flex-initial">
                <select name="category" class="w-full md:w-48 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Categories</option>
                    <option value="Fiction" <?= $selectedCategory === 'Fiction' ? 'selected' : '' ?>>Fiction</option>
                    <option value="Science Fiction" <?= $selectedCategory === 'Science Fiction' ? 'selected' : '' ?>>Science Fiction</option>
                    <option value="Non-Fiction" <?= $selectedCategory === 'Non-Fiction' ? 'selected' : '' ?>>Non-Fiction</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Search</button>
        </div>
    </form>

    <!-- Books Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($paginatedBooks as $book): ?>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-2"><?= htmlspecialchars($book['title']) ?></h3>
                <p class="text-gray-600 mb-2">By <?= htmlspecialchars($book['author']) ?></p>
                <p class="text-sm text-gray-500 mb-4"><?= htmlspecialchars($book['summary']) ?></p>
                <div class="flex justify-between items-center">
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                        <?= htmlspecialchars($book['category']) ?>
                    </span>
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                        Position: <?= htmlspecialchars($book['position']) ?>
                    </span>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
    <div class="mt-8 flex justify-center">
        <nav class="inline-flex rounded-md shadow">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>&search=<?= urlencode($searchTerm) ?>&category=<?= urlencode($selectedCategory) ?>" 
                   class="px-4 py-2 <?= $i === $currentPage ? 'bg-blue-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' ?> text-sm font-medium border <?= $i === 1 ? 'rounded-l-md' : ($i === $totalPages ? 'rounded-r-md' : '') ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </nav>
    </div>
    <?php endif; ?>
</div>

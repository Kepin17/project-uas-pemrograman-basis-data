<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Book Categories</h1>

    <!-- Search Bar -->
    <div class="mb-6">
        <input type="text" id="categorySearch" placeholder="Search categories..." class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Category Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="categoryGrid">
        <?php
        $categories = ['Fiction', 'Non-Fiction', 'Science Fiction', 'Mystery', 'Biography', 'History', 'Self-Help', 'Poetry'];
        foreach ($categories as $category):
        ?>
        <div class="category-card bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
            <h3 class="text-xl font-semibold text-gray-800 mb-2"><?= htmlspecialchars($category) ?></h3>
            <p class="text-gray-600 mb-4">Explore our collection of <?= strtolower(htmlspecialchars($category)) ?> books.</p>
            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">View Books &rarr;</a>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
document.getElementById('categorySearch').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const cards = document.querySelectorAll('.category-card');
    
    cards.forEach(card => {
        const title = card.querySelector('h3').textContent.toLowerCase();
        if (title.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});
</script>

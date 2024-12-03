<?php 
  require_once 'config/config.php';

  // Function to check if the current page matches the menu item
  function isActive($page) {
    return CURRENT_PAGE === $page ? 'opacity-100' : 'opacity-70';
  }
?>
<nav id="dynamic-navbar" class="fixed w-full z-50 top-0 left-0 bg-white shadow-md transition-all duration-300 ease-in-out">
    <div class="max-w-7xl mx-auto px-4 h-16">
        <div class="flex justify-between items-center h-full">
            <!-- Logo and Brand -->
            <div class="flex items-center">
                <a href="<?php echo BASE_URL; ?>" class="flex items-center space-x-2">
                    <span class="text-xl font-bold text-[#002B5B]">OneBook</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="<?php echo BASE_URL; ?>" 
                   class="text-[#002B5B] hover:text-[#1A5F7A] font-medium transition-colors duration-300 relative group">
                    Home
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-[#FFF4B7] group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="<?php echo BASE_URL; ?>/book-collection" 
                   class="text-[#002B5B] hover:text-[#1A5F7A] font-medium transition-colors duration-300 relative group">
                    Books
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-[#FFF4B7] group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="<?php echo BASE_URL; ?>/category-collection" 
                   class="text-[#002B5B] hover:text-[#1A5F7A] font-medium transition-colors duration-300 relative group">
                    Categories
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-[#FFF4B7] group-hover:w-full transition-all duration-300"></span>
                </a>
               
                <a href="<?php echo BASE_URL; ?>/about-oneBook" 
                   class="text-[#002B5B] hover:text-[#1A5F7A] font-medium transition-colors duration-300 relative group">
                   About OneBook
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-[#FFF4B7] group-hover:w-full transition-all duration-300"></span>
                </a>
            </div>

            <!-- Auth Buttons -->
            <div class="hidden md:flex items-center space-x-4">
                <?php if (!isset($_SESSION['user'])): ?>
                    <a href="<?php echo BASE_URL; ?>/auth/login" 
                       class="px-4 py-2 text-[#002B5B] hover:text-[#1A5F7A] font-medium transition-colors duration-300">
                        Login
                    </a>
                    <a href="<?php echo BASE_URL; ?>/auth/register" 
                       class="px-4 py-2 bg-[#002B5B] text-white rounded-lg hover:bg-[#1A5F7A] transition-colors duration-300">
                        Register
                    </a>
                <?php else: ?>
                    <div class="relative group">
                        <button class="flex items-center space-x-2 text-[#002B5B] hover:text-[#1A5F7A] transition-colors duration-300">
                            <span class="font-medium"><?php echo $_SESSION['user']['username']; ?></span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden group-hover:block">
                            <a href="<?php echo BASE_URL; ?>/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="<?php echo BASE_URL; ?>/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                            <hr class="my-2">
                            <a href="<?php echo BASE_URL; ?>/logout" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button id="mobile-menu-toggle" class="text-[#002B5B] hover:text-[#1A5F7A] focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu" class="fixed inset-0 bg-black/50 z-50 opacity-0 pointer-events-none transition-all duration-300 ease-in-out">
        <div class="absolute top-0 right-0 w-64 h-full bg-white shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out">
            <div class="p-4 border-b flex justify-between items-center">
                <span class="text-xl font-bold text-[#002B5B]">OneBook</span>
                <button id="mobile-menu-close" class="text-[#002B5B] hover:text-[#1A5F7A] focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="p-4 space-y-4">
                <a href="<?php echo BASE_URL; ?>" class="block text-[#002B5B] hover:text-[#1A5F7A] font-medium">Home</a>
                <a href="<?php echo BASE_URL; ?>/book-collection" class="block text-[#002B5B] hover:text-[#1A5F7A] font-medium">Books</a>
                <a href="<?php echo BASE_URL; ?>/category-collection" class="block text-[#002B5B] hover:text-[#1A5F7A] font-medium">Categories</a>
                <a href="<?php echo BASE_URL; ?>/About-oneBook" class="block text-[#002B5B] hover:text-[#1A5F7A] font-medium">About OneBook</a>
                
                <?php if (!isset($_SESSION['user'])): ?>
                    <div class="border-t pt-4 space-y-2">
                        <a href="<?php echo BASE_URL; ?>/auth/login" class="block text-[#002B5B] hover:text-[#1A5F7A] font-medium">Login</a>
                        <a href="<?php echo BASE_URL; ?>/auth/register" class="block bg-[#002B5B] text-white px-4 py-2 rounded-lg text-center hover:bg-[#1A5F7A]">Register</a>
                    </div>
                <?php else: ?>
                    <div class="border-t pt-4 space-y-2">
                        <span class="block text-sm text-gray-600">Welcome, <?php echo $_SESSION['user']['username']; ?></span>
                        <a href="<?php echo BASE_URL; ?>/profile" class="block text-[#002B5B] hover:text-[#1A5F7A] font-medium">Profile</a>
                        <a href="<?php echo BASE_URL; ?>/settings" class="block text-[#002B5B] hover:text-[#1A5F7A] font-medium">Settings</a>
                        <a href="<?php echo BASE_URL; ?>/logout" class="block text-red-600 hover:text-red-800 font-medium">Logout</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileMenu = document.getElementById('mobile-menu');

    // Mobile menu toggle functionality
    mobileMenuToggle.addEventListener('click', function() {
        mobileMenu.classList.remove('opacity-0', 'pointer-events-none');
        mobileMenu.querySelector('div').classList.remove('translate-x-full');
    });

    // Mobile menu close functionality
    mobileMenuClose.addEventListener('click', function() {
        mobileMenu.classList.add('opacity-0', 'pointer-events-none');
        mobileMenu.querySelector('div').classList.add('translate-x-full');
    });

    // Close mobile menu if clicked outside
    mobileMenu.addEventListener('click', function(event) {
        if (event.target === mobileMenu) {
            mobileMenu.classList.add('opacity-0', 'pointer-events-none');
            mobileMenu.querySelector('div').classList.add('translate-x-full');
        }
    });
});
</script>
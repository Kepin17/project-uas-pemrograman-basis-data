<header class="relative bg-gradient-to-r from-[#002B5B] to-[#1A5F7A] overflow-hidden">
    <!-- Hero Section Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative pt-16 pb-16 sm:pb-24">
            <!-- Background Decoration -->
            <div class="absolute inset-0">
                <div class="absolute transform -translate-x-1/2 left-full -translate-y-1/2 top-1/2">
                    <div class="w-[500px] h-[500px] bg-[#FFF4B7] opacity-20 rounded-full blur-3xl"></div>
                </div>
                <div class="absolute transform translate-x-1/2 right-full translate-y-1/2 bottom-1/2">
                    <div class="w-[500px] h-[500px] bg-[#80EE98] opacity-20 rounded-full blur-3xl"></div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="relative grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Column - Text Content -->
                <div class="text-center lg:text-left">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight">
                        Discover Your Next 
                        <span class="text-[#FFF4B7]">Great Read</span>
                    </h1>
                    <p class="mt-6 text-xl text-gray-300 max-w-2xl mx-auto lg:mx-0">
                        Your digital gateway to endless knowledge. Explore our vast collection of books, articles, and resources. Join our community of book lovers today.
                    </p>
                    
                    <!-- Search Bar -->
                    <div class="mt-8 max-w-xl mx-auto lg:mx-0">
                        <div class="flex items-center bg-white rounded-lg p-1 shadow-lg">
                            <input type="text" 
                                placeholder="Search for books, authors, or genres..." 
                                class="flex-1 p-3 pl-6 focus:outline-none text-gray-700 rounded-l-lg"
                            >
                            <button class="bg-[#002B5B] text-white px-8 py-3 rounded-lg hover:bg-[#1A5F7A] transition-colors duration-300 flex items-center gap-2">
                                <i class="fas fa-search"></i>
                                Search
                            </button>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="mt-12 grid grid-cols-3 gap-8">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-[#FFF4B7]">10K+</div>
                            <div class="text-sm text-gray-300 mt-1">Books</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-[#FFF4B7]">5K+</div>
                            <div class="text-sm text-gray-300 mt-1">Members</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-[#FFF4B7]">1K+</div>
                            <div class="text-sm text-gray-300 mt-1">Authors</div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Image -->
                <div class="relative lg:absolute lg:right-0 lg:w-1/2 xl:w-5/12 h-full max-h-[600px]">
                    <div class="relative h-full w-full">
                        <img src="<?php echo BASE_URL; ?>/public/images/hero.jpg" 
                            alt="Library Collection" 
                            class="object-cover w-full h-full rounded-3xl shadow-2xl transform hover:scale-105 transition-transform duration-500"
                        >
                        <!-- Floating Elements -->
                        <div class="absolute -top-4 -left-4 bg-white p-4 rounded-2xl shadow-xl transform hover:-translate-y-2 transition-transform duration-300">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-book-reader text-2xl text-[#002B5B]"></i>
                                <div>
                                    <div class="text-sm font-semibold text-gray-800">Easy Access</div>
                                    <div class="text-xs text-gray-500">Read Anywhere</div>
                                </div>
                            </div>
                        </div>
                        <div class="absolute -bottom-4 -right-4 bg-white p-4 rounded-2xl shadow-xl transform hover:-translate-y-2 transition-transform duration-300">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-clock text-2xl text-[#002B5B]"></i>
                                <div>
                                    <div class="text-sm font-semibold text-gray-800">24/7 Available</div>
                                    <div class="text-xs text-gray-500">Always Online</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
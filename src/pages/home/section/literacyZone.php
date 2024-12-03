<section id="literasi" class="min-h-screen bg-[#003161] p-4 md:p-10">
    <div class="wrap w-full h-full flex flex-col">
        <div class="title-wrapper mb-6">
            <h1 class="font-roboto text-2xl md:text-3xl font-bold text-[#FFF4B7] flex items-center gap-3">
                <i class="fa-brands fa-leanpub"></i>  
                Literacy Zone
            </h1>
        </div>
    </div>

    <div class="content-wrapper flex flex-col lg:flex-row gap-5">
        <!-- Sidebar Filters -->
        <aside class="sidebar w-full lg:w-[25rem] bg-white rounded-md overflow-hidden">
            <form action="" class="p-4 md:p-6 flex flex-col gap-4">
                <div class="grid grid-cols-2 md:grid-cols-1 gap-4">
                    <div class="form-wrap flex items-center gap-3">
                        <input type="checkbox" name="genre" id="genre" class="w-4 h-4">
                        <label for="genre" class="text-sm md:text-base">Genre</label>
                    </div>
                    <div class="form-wrap flex items-center gap-3">
                        <input type="checkbox" name="author" id="author" class="w-4 h-4">
                        <label for="author" class="text-sm md:text-base">Author</label>
                    </div>
                    <div class="form-wrap flex items-center gap-3">
                        <input type="checkbox" name="publisher" id="publisher" class="w-4 h-4">
                        <label for="publisher" class="text-sm md:text-base">Publisher</label>
                    </div>
                    <div class="form-wrap flex items-center gap-3">
                        <input type="checkbox" name="year" id="year" class="w-4 h-4">
                        <label for="year" class="text-sm md:text-base">Year</label>
                    </div>
                </div>
                <button class="cta-btn p-2 mt-4 h-10 w-full md:w-32 text-[#213A58] bg-[#80EE98] flex justify-center items-center font-bold rounded-md hover:bg-[#6cd584] transition-colors">
                    Filter
                </button>
            </form>
        </aside>

        <!-- Main Content -->
        <div class="literacy-content flex-1 bg-white rounded-md">
            <!-- Search Bar -->
            <div class="searchbar-wrapper w-full p-4">
                <div class="search flex flex-col md:flex-row items-center gap-3">
                    <input type="text" placeholder="Search..." class="w-full text-white p-2 h-10 rounded-md bg-[#003161] focus:outline-none focus:ring-2 focus:ring-[#80EE98]">
                    <button class="cta-btn p-2 h-10 w-full md:w-32 text-[#213A58] bg-[#80EE98] flex justify-center items-center font-bold rounded-md hover:bg-[#6cd584] transition-colors">
                        Search
                    </button>
                </div>
            </div>

            <!-- Books Grid -->
            <div class="card-wrapper p-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    <!-- Book Card Template -->
                    <div class="card bg-[#FFF4B7] shadow-md rounded-md overflow-hidden hover:shadow-lg transition-shadow cursor-pointer">
                        <div class="header-card">
                            <img src="https://plus.unsplash.com/premium_photo-1732115973201-6aac974f4eb8?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" 
                                 alt="Book Cover" 
                                 class="w-full h-48 object-cover">
                        </div>
                        <div class="body-card p-4">
                            <h3 class="font-roboto text-lg font-bold text-[#000B58] line-clamp-2 mb-2">
                                The Great Gatsby
                            </h3>
                            <p class="font-roboto text-sm text-[#000B58] mb-1">In Fiction</p>
                            <p class="font-roboto text-sm text-[#000B58]">By: F. Scott Fitzgerald</p>
                        </div>
                    </div>

                    <!-- Repeat book cards as needed -->
                </div>
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper p-4 flex justify-center">
                <div class="flex gap-2">
                    <button class="bg-[#006A67] text-[#FFF4B7] w-10 h-10 rounded-md flex items-center justify-center hover:bg-[#005652] transition-colors">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="bg-[#006A67] text-[#FFF4B7] w-10 h-10 rounded-md flex items-center justify-center hover:bg-[#005652] transition-colors">1</button>
                    <button class="bg-[#006A67] text-[#FFF4B7] w-10 h-10 rounded-md flex items-center justify-center hover:bg-[#005652] transition-colors">2</button>
                    <button class="bg-[#006A67] text-[#FFF4B7] w-10 h-10 rounded-md flex items-center justify-center hover:bg-[#005652] transition-colors">3</button>
                    <button class="bg-[#006A67] text-[#FFF4B7] w-10 h-10 rounded-md flex items-center justify-center hover:bg-[#005652] transition-colors">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
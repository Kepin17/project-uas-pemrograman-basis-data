<section class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-[#002B5B] mb-4">About OneBook</h2>
            <div class="w-24 h-1 bg-[#FFF4B7] mx-auto rounded-full mb-6"></div>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Transforming the way you experience knowledge. We're not just a library, we're a gateway to endless possibilities.
            </p>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <!-- Image Column -->
            <div class="relative">
                <img 
                    src="<?php echo BASE_URL; ?>/public/images/about-1.jpg" 
                    alt="OneBook Library" 
                    class="rounded-3xl shadow-2xl transform hover:scale-105 transition-transform duration-500"
                >
                <!-- Floating Achievement Badge -->
                <div class="absolute -top-8 -right-8 bg-[#002B5B] text-white p-6 rounded-2xl shadow-xl">
                    <div class="text-4xl font-bold text-[#FFF4B7] mb-1">15+</div>
                    <div class="text-sm">Years of Service</div>
                </div>
            </div>

            <!-- Text Column -->
            <div>
                <h3 class="text-3xl font-bold text-[#002B5B] mb-6">Our Story and Mission</h3>
                
                <!-- Mission Highlights -->
                <div class="space-y-6">
                    <!-- Mission Point 1 -->
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-[#002B5B] rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-book-open text-white text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-semibold text-[#002B5B] mb-2">Our Mission</h4>
                            <p class="text-gray-600">
                                Democratize access to knowledge by providing a comprehensive digital library platform that connects readers with diverse, high-quality resources.
                            </p>
                        </div>
                    </div>

                    <!-- Mission Point 2 -->
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-[#002B5B] rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-globe text-white text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-semibold text-[#002B5B] mb-2">Our Vision</h4>
                            <p class="text-gray-600">
                                To become the world's most accessible and innovative digital library, empowering learners of all backgrounds to pursue knowledge seamlessly.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Key Stats -->
                <div class="mt-10 grid grid-cols-3 gap-4 bg-gray-50 p-6 rounded-2xl">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-[#002B5B]">10K+</div>
                        <div class="text-sm text-gray-600">Books</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-[#002B5B]">5K+</div>
                        <div class="text-sm text-gray-600">Members</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-[#002B5B]">100+</div>
                        <div class="text-sm text-gray-600">Categories</div>
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="mt-8">
                    <a href="#" class="inline-flex items-center gap-2 bg-[#002B5B] text-white px-6 py-3 rounded-full hover:bg-[#1A5F7A] transition-colors duration-300">
                        <span>Learn More About Us</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
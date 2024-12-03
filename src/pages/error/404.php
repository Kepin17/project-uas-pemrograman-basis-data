<?php
$quotes = [
    "Every detour leads to new discoveries.",
    "Not all who wander are lost.",
    "Sometimes the wrong path leads to the right destination.",
    "Keep moving forward, even if you have to start again.",
    "Every error is a chance to learn something new."
];
$randomQuote = $quotes[array_rand($quotes)];
?>
<style>
    @keyframes slideIn {
        from {
            transform: translateX(-100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    .slide-in {
        animation: slideIn 1s ease-out forwards;
    }
    .fade-in {
        animation: fadeIn 1.5s ease-out forwards;
    }
    .progress-bar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: #80EE98;
        transform-origin: 0%;
    }
</style>

<body">
    <!-- Progress Bar -->
    <div class="progress-bar" id="progressBar"></div>
    <div class="max-w-8xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="grid md:grid-cols-2 gap-0">
            <!-- Left Side - Error Message -->
            <div class="bg-[#FFF4B7] p-12 flex items-center justify-center slide-in">
                <div class="text-center">
                    <h1 class="text-8xl font-bold text-[#002B5B] mb-4">404</h1>
                    <p class="text-2xl text-[#002B5B] mb-6">Page Not Found</p>
                    <div class="h-1 w-20 bg-[#80EE98] mx-auto"></div>
                </div>
            </div>
            <!-- Right Side - Motivational Message -->
            <div class="p-12 flex flex-col justify-center items-center text-center fade-in">
                <div class="max-w-sm">
                    <h2 class="text-2xl font-bold text-[#002B5B] mb-6">Keep Exploring</h2>
                    <p class="text-gray-600 italic mb-8">"<?php echo htmlspecialchars($randomQuote); ?>"</p>
                    <div class="space-y-4">
                        <a href="<?php echo BASE_URL; ?>" 
                           class="block w-full bg-[#002B5B] text-white py-3 px-6 rounded-full hover:bg-[#1A5F7A] transition duration-300">
                            Return Home
                        </a>
                        <button onclick="window.history.back()" 
                                class="block w-full border-2 border-[#002B5B] text-[#002B5B] py-3 px-6 rounded-full hover:bg-[#002B5B] hover:text-white transition duration-300">
                            Go Back
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
</body>
</html>
<?php
$estimatedTime = "10 hours"; 
?>

    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        .spinning {
            animation: spin 10s linear infinite;
        }

        .progress-line {
            width: 100%;
            height: 4px;
            background: linear-gradient(to right, #80EE98, #002B5B);
            background-size: 200% 100%;
            animation: gradient 2s linear infinite;
        }

        @keyframes gradient {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
    
    <div  class="bg-gradient-to-br from-[#002B5B] to-[#1A5F7A] min-h-screen flex items-center justify-center p-4">

        <div class="progress-line fixed top-0 left-0"></div>
        
        <div class="max-w-4xl w-full bg-white rounded-2xl shadow-2xl p-8 md:p-12 text-center">
            <div class="floating">
            <svg class="w-32 h-32 mx-auto mb-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.5 3.75H13.5M10.5 21H13.5M5.25 7.5L7.5 5.25M16.5 18.75L18.75 16.5M3.75 13.5V10.5M21 13.5V10.5M5.25 16.5L7.5 18.75M16.5 5.25L18.75 7.5M12 7.5C9.51472 7.5 7.5 9.51472 7.5 12C7.5 14.4853 9.51472 16.5 12 16.5C14.4853 16.5 16.5 14.4853 16.5 12C16.5 9.51472 14.4853 7.5 12 7.5Z" stroke="#002B5B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="spinning"/>
            </svg>
        </div>
        
        <h1 class="text-4xl md:text-5xl font-bold text-[#002B5B] mb-6">Under Maintenance</h1>
        
        <div class="bg-[#FFF4B7] rounded-xl p-6 mb-8 max-w-2xl mx-auto">
            <p class="text-lg text-[#002B5B] mb-4">
                We're currently upgrading our system to bring you an even better experience.
            </p>
            <p class="text-gray-600">
                Estimated downtime: <span class="font-semibold"><?php echo htmlspecialchars($estimatedTime); ?></span>
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-6 max-w-2xl mx-auto mb-8">
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-[#002B5B] font-bold mb-2">System Upgrade</div>
                <div class="text-sm text-gray-600">Enhancing performance</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-[#002B5B] font-bold mb-2">Security Update</div>
                <div class="text-sm text-gray-600">Strengthening protection</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-[#002B5B] font-bold mb-2">New Features</div>
                <div class="text-sm text-gray-600">Adding capabilities</div>
            </div>
        </div>
        
        <div class="space-y-4">
            <button onclick="window.history.back()" 
            class="bg-[#002B5B] text-white py-3 px-8 rounded-full hover:bg-[#1A5F7A] transition duration-300 inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Go Back
            </button>
        </div>
    </div>

</div>

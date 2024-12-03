<div class="w-full max-w-md mx-auto bg-white/80 backdrop-blur-lg rounded-2xl shadow-2xl p-8 animate-fadeIn">
    <form action="process/login.php" method="POST" class="space-y-6">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Welcome Back</h1>
            <p class="text-gray-600">Sign in to continue your journey</p>
        </div>

        <div class="relative">
            <input 
                type="email" 
                name="email" 
                id="email" 
                required 
                placeholder=" "
                class="peer w-full h-12 bg-transparent border-b-2 border-gray-300 text-gray-900 focus:border-blue-500 focus:outline-none transition-colors duration-300"
            />
            <label 
                for="email" 
                class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all 
                peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 
                peer-placeholder-shown:top-3 peer-focus:-top-3.5 
                peer-focus:text-blue-500 peer-focus:text-sm"
            >
                Email Address
            </label>
        </div>

        <div class="relative">
            <input 
                type="password" 
                name="password" 
                id="password" 
                required 
                placeholder=" "
                class="peer w-full h-12 bg-transparent border-b-2 border-gray-300 text-gray-900 focus:border-blue-500 focus:outline-none transition-colors duration-300"
            />
            <label 
                for="password" 
                class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all 
                peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 
                peer-placeholder-shown:top-3 peer-focus:-top-3.5 
                peer-focus:text-blue-500 peer-focus:text-sm"
            >
                Password
            </label>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input 
                    type="checkbox" 
                    id="remember" 
                    name="remember" 
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                >
                <label for="remember" class="ml-2 block text-sm text-gray-900">
                    Remember me
                </label>
            </div>
            <a href="#" class="text-sm text-blue-600 hover:text-blue-800 transition-colors">
                Forgot password?
            </a>
        </div>

        <button 
            type="submit" 
            class="w-full py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg 
            hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 
            transform hover:-translate-y-1 hover:shadow-lg"
        >
            Sign In
        </button>

        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">
                Don't have an account? 
                <a 
                    href="<?= BASE_URL ?>/auth/register" 
                    class="text-blue-600 hover:text-blue-800 font-semibold transition-colors"
                >
                    Sign Up
                </a>
            </p>
        </div>
    </form>
</div>

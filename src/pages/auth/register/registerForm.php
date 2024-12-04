<div class="w-full max-w-md mx-auto bg-white/80 backdrop-blur-lg rounded-2xl shadow-2xl p-8 animate-fadeIn">
    <form action="process/register.php" method="POST" class="space-y-6">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Create an Account</h1>
            <p class="text-gray-600">Join our library community today</p>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="relative">
                <input 
                    type="text" 
                    name="firstname" 
                    id="firstname" 
                    required 
                    placeholder=" "
                    class="peer w-full h-12 bg-transparent border-b-2 border-gray-300 text-gray-900 focus:border-blue-500 focus:outline-none transition-colors duration-300"
                />
                <label 
                    for="firstname" 
                    class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all 
                    peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 
                    peer-placeholder-shown:top-3 peer-focus:-top-3.5 
                    peer-focus:text-blue-500 peer-focus:text-sm"
                >
                    First Name
                </label>
            </div>

            <div class="relative">
                <input 
                    type="text" 
                    name="lastname" 
                    id="lastname" 
                    required 
                    placeholder=" "
                    class="peer w-full h-12 bg-transparent border-b-2 border-gray-300 text-gray-900 focus:border-blue-500 focus:outline-none transition-colors duration-300"
                />
                <label 
                    for="lastname" 
                    class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all 
                    peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 
                    peer-placeholder-shown:top-3 peer-focus:-top-3.5 
                    peer-focus:text-blue-500 peer-focus:text-sm"
                >
                    Last Name
                </label>
            </div>
        </div>

        <div class="relative mt-4">
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

        <?php require_once __DIR__ . '/../../../utils/phoneCodes.php'; ?>
        <div class="relative mt-4">
            <div class="flex gap-2">
                <div class="w-1/3">
                    <select 
                        name="phone_code" 
                        id="phone_code" 
                        required
                        class="peer w-full h-12 bg-transparent border-b-2 border-gray-300 text-gray-900 focus:border-blue-500 focus:outline-none transition-colors duration-300"
                    >
                        <option value="">Select</option>
                        <?php foreach($phoneCodes as $code => $country): ?>
                            <option value="<?php echo $code; ?>"><?php echo $code . ' ' . $country; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label 
                        for="phone_code" 
                        class="absolute left-0 -top-3.5 text-gray-600 text-sm"
                    >
                        Country Code
                    </label>
                </div>
                <div class="w-2/3 relative">
                    <input 
                        type="tel" 
                        name="phone" 
                        id="phone" 
                        required 
                        placeholder=" "
                        class="peer w-full h-12 bg-transparent border-b-2 border-gray-300 text-gray-900 focus:border-blue-500 focus:outline-none transition-colors duration-300"
                    />
                    <label 
                        for="phone" 
                        class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all 
                        peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 
                        peer-placeholder-shown:top-3 peer-focus:-top-3.5 
                        peer-focus:text-blue-500 peer-focus:text-sm"
                    >
                        Phone Number
                    </label>
                </div>
            </div>
        </div>

        <div class="relative mt-4">
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

        <div class="relative mt-4">
            <input 
                type="password" 
                name="confirm_password" 
                id="confirm_password" 
                required 
                placeholder=" "
                class="peer w-full h-12 bg-transparent border-b-2 border-gray-300 text-gray-900 focus:border-blue-500 focus:outline-none transition-colors duration-300"
            />
            <label 
                for="confirm_password" 
                class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all 
                peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 
                peer-placeholder-shown:top-3 peer-focus:-top-3.5 
                peer-focus:text-blue-500 peer-focus:text-sm"
            >
                Confirm Password
            </label>
        </div>

        <div class="flex items-center mt-4">
            <input 
                type="checkbox" 
                id="terms" 
                name="terms" 
                required
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
            >
            <label for="terms" class="ml-2 text-sm text-gray-900">
                I agree to the 
                <a href="#" class="text-blue-600 hover:text-blue-800 transition-colors">
                    Terms and Conditions
                </a>                    
            </label>
        </div>

        <button 
            type="submit" 
            class="w-full py-3 mt-6 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg 
            hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 
            transform hover:-translate-y-1 hover:shadow-lg"
        >
            Create Account
        </button>

        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">
                Already have an account? 
                <a 
                    href="<?= BASE_URL ?>/auth/login" 
                    class="text-blue-600 hover:text-blue-800 font-semibold transition-colors"
                >
                    Sign in
                </a>
            </p>
        </div>
    </form>
</div>

<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = event.currentTarget.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
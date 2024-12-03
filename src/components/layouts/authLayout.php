<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Authentication'; ?> - OneBook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body class="bg-gradient-to-r from-blue-500 to-purple-600 min-h-screen flex items-center justify-center relative">
    <!-- Back to Home Button -->
    <a href="<?php echo BASE_URL; ?>" class="absolute top-6 left-6 bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-full transition-all duration-300 flex items-center space-x-2 group">
        <i class="fas fa-chevron-left transform group-hover:-translate-x-1 transition-transform"></i>
        <span class="text-sm font-medium">Back to Home</span>
    </a>

    <?php echo $formContent; ?>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', () => {
                    input.parentElement.classList.add('transform', 'scale-105', 'transition-transform');
                });
                input.addEventListener('blur', () => {
                    input.parentElement.classList.remove('transform', 'scale-105', 'transition-transform');
                });
            });
        });
    </script>
</body>
</html>

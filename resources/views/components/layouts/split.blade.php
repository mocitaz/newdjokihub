<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DjokiHub') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@400;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
        
        /* Chill Animations */
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fade-in-up 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 10s infinite;
        }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }

        /* Minimalist Focus */
        .focus-ring-black:focus {
            box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.1);
            border-color: #000;
        }
    </style>
</head>
<body class="antialiased bg-white">
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
        
        <!-- Left Side: Premium Light Mesh (Desktop Only) -->
        <div class="relative hidden lg:flex flex-col justify-between p-12 overflow-hidden bg-white text-slate-900 border-r border-slate-100">
            <!-- Mesh Background -->
            <div class="absolute inset-0 bg-[#f8fafc]"></div>
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-100/50 rounded-full blur-[120px] animate-blob mix-blend-multiply"></div>
            <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-purple-100/50 rounded-full blur-[120px] animate-blob animation-delay-2000 mix-blend-multiply"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-pink-100/50 rounded-full blur-[120px] animate-blob animation-delay-4000 mix-blend-multiply"></div>
            
            <!-- Noise Texture -->
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-soft-light"></div>

            <!-- Left Content Slot -->
             <div class="relative z-10 h-full flex flex-col justify-between">
                 {{ $left ?? '' }}
             </div>
        </div>

        <!-- Right Side: Clean Form -->
        <div class="flex items-center justify-center p-6 bg-white relative">
             <div class="w-full max-w-sm"> <!-- Compact width -->
                 {{ $slot }}
             </div>
        </div>

    </div>
</body>
</html>

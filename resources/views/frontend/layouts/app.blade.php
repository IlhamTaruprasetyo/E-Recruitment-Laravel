<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Portal E-Rekrutmen | Temukan Karir Impian Masa Depanmu')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Tailwind CSS CDN Fallback for instant styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --primary-green: #08CB00;
            --primary-green-glow: rgba(8, 203, 0, 0.4);
            --primary-green-dark: #058500;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        /* Custom Neon Green #08CB00 Accents */
        .text-neon-green {
            color: #08CB00;
            text-shadow: 0 0 20px rgba(8, 203, 0, 0.6);
        }
        .bg-neon-green {
            background-color: #08CB00;
        }
        .glow-green {
            box-shadow: 0 0 35px -5px rgba(8, 203, 0, 0.45);
        }
        .glow-green-lg {
            box-shadow: 0 0 80px -10px rgba(8, 203, 0, 0.55);
        }
        .border-neon-green {
            border-color: rgba(8, 203, 0, 0.4);
            box-shadow: 0 0 15px rgba(8, 203, 0, 0.2);
        }
        .bg-mesh-dark {
            background-color: #040804;
        }

        /* Lightweight Page Entrance Animation */
        @keyframes pageFadeIn {
            from {
                opacity: 0;
                transform: translateY(6px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-page-fade {
            animation: pageFadeIn 0.45s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes pulseGlow {
            0%, 100% {
                transform: scale(1);
                opacity: 0.8;
            }
            50% {
                transform: scale(1.08);
                opacity: 1;
                filter: drop-shadow(0 0 16px rgba(8, 203, 0, 0.8));
            }
        }

        .animate-brand-pulse {
            animation: pulseGlow 1.2s ease-in-out infinite;
        }
    </style>
</head>

<body class="antialiased bg-[#040804] text-[#EEEEEE] selection:bg-[#08CB00] selection:text-black min-h-screen flex flex-col justify-between"
      x-data="{ pageLoaded: false }" 
      x-init="window.addEventListener('load', () => setTimeout(() => pageLoaded = true, 200)); setTimeout(() => pageLoaded = true, 500)">
    
    <!-- Lightweight Initial Page Loader Overlay (Smooth Rotating Neon Spinner) -->
    <div x-show="!pageLoaded" 
         x-transition:leave="transition ease-out duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0 pointer-events-none"
         class="fixed inset-0 z-[100] bg-[#040804] flex flex-col items-center justify-center select-none">
        
        <div class="relative flex items-center justify-center">
            <!-- Subtle Glow behind spinner -->
            <div class="w-20 h-20 rounded-full bg-[#08CB00]/30 blur-xl absolute"></div>
            
            <!-- Sleek Rotating Neon Green Spinner -->
            <div class="w-14 h-14 border-4 border-[#08CB00]/20 border-t-[#08CB00] rounded-full animate-spin"></div>
        </div>
    </div>

    <!-- Top Navigation Header -->
    @include('frontend.components.navbar')

    <!-- Main Content with smooth fade entrance -->
    <main class="flex-grow animate-page-fade">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('frontend.components.footer')

    @stack('scripts')
</body>
</html>

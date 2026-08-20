<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MIKA CAREER') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Tailwind CSS CDN Fallback -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --primary-green: #93F514;
            --primary-green-glow: rgba(147, 245, 20, 0.35);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #040904;
        }

        .heading-font {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Ambient Glow Animations */
        @keyframes pulseGlow {
            0%, 100% { opacity: 0.35; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.08); }
        }
        .animate-pulse-glow {
            animation: pulseGlow 8s ease-in-out infinite;
        }
        .animate-pulse-glow-delayed {
            animation: pulseGlow 10s ease-in-out infinite 3s;
        }
        .animate-pulse-glow-delayed {
            animation: pulseGlow 10s ease-in-out infinite 3s;
        }

        /* Glassmorphism Styles */
        .glass-card-main {
            background: rgba(10, 24, 10, 0.75);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(147, 245, 20, 0.25);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.75), 0 0 40px rgba(147, 245, 20, 0.08);
        }

        /* Subtle grid background */
        .bg-grid-pattern {
            background-size: 36px 36px;
            background-image: 
                linear-gradient(to right, rgba(147, 245, 20, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(147, 245, 20, 0.03) 1px, transparent 1px);
        }

        /* Left Banner gradient */
        .banner-gradient {
            background: linear-gradient(145deg, #071f08 0%, #0d3810 50%, #155e1b 100%);
            border: 1px solid rgba(147, 245, 20, 0.3);
        }
    </style>
</head>

<body class="font-sans antialiased text-[#EEEEEE] bg-[#040904] min-h-screen relative overflow-x-hidden selection:bg-[#93F514] selection:text-black flex items-center justify-center p-3 sm:p-6 lg:p-10">
    
    <!-- Background Ambient Glows & Grid Pattern -->
    <div class="fixed inset-0 bg-grid-pattern pointer-events-none z-0"></div>
    <div class="fixed top-[-10%] left-[10%] w-[500px] sm:w-[700px] h-[500px] sm:h-[700px] rounded-full bg-[#93F514]/12 blur-[130px] pointer-events-none animate-pulse-glow z-0"></div>
    <div class="fixed bottom-[-10%] right-[10%] w-[450px] sm:w-[600px] h-[450px] sm:h-[600px] rounded-full bg-[#46ee40]/10 blur-[140px] pointer-events-none animate-pulse-glow-delayed z-0"></div>
    <div class="fixed top-[40%] right-[25%] w-[350px] h-[350px] rounded-full bg-[#5FE6B6]/5 blur-[120px] pointer-events-none z-0"></div>

    <!-- Main Content Container -->
    <main class="relative z-10 w-full flex justify-center items-center">
        {{ $slot }}
    </main>

</body>

</html>

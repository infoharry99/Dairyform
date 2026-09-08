<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MilkFlow - Smart Dairy Management for Every Dairy')</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                            950: '#052e16',
                        },
                        cream: {
                            50: '#fffdfa',
                            100: '#fef9ee',
                            200: '#fcf1d6',
                            300: '#f9e4b3',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Canvas Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
    @stack('styles')
</head>
<body class="h-full flex flex-col text-slate-800 antialiased" x-data="{ demoTourOpen: false }">

    <!-- Persistent Client Demo Navigator Bar -->
    @include('layouts.components.demo-bar')

    <!-- Flash Notifications / Toast -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)" 
             class="fixed top-14 right-4 z-50 flex items-center gap-3 bg-emerald-900/95 text-white px-5 py-3.5 rounded-xl shadow-2xl border border-emerald-500/30 backdrop-blur-md transition-all">
            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-400"></i>
            <span class="text-sm font-medium">{{ session('success') }}</span>
            <button @click="show = false" class="ml-2 text-white/70 hover:text-white"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>
    @endif

    @if(session('error') || $errors->any())
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 8000)" 
             class="fixed top-14 right-4 z-50 flex items-center gap-3 bg-rose-900/95 text-white px-5 py-3.5 rounded-xl shadow-2xl border border-rose-500/30 backdrop-blur-md transition-all">
            <i data-lucide="alert-circle" class="w-5 h-5 text-rose-400"></i>
            <span class="text-sm font-medium">{{ session('error') ?? $errors->first() }}</span>
            <button @click="show = false" class="ml-2 text-white/70 hover:text-white"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>
    @endif

    <!-- Main View Content -->
    <div class="flex-1 flex flex-col">
        @yield('layout_content')
    </div>

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
</body>
</html>

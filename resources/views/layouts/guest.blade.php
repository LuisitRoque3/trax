<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Trax') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-100 antialiased bg-slate-950 selection:bg-blue-500 selection:text-white">
        <!-- Background decorative elements -->
        <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-blue-600/20 blur-[120px]"></div>
            <div class="absolute top-[60%] -right-[10%] w-[40%] h-[60%] rounded-full bg-cyan-500/10 blur-[100px]"></div>
        </div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center p-6 sm:p-0 relative z-10">
            <div>
                <a href="/" wire:navigate class="flex items-center gap-3 group">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-105 transition-transform">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="text-3xl font-bold tracking-tight text-white">Trax</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-8 px-8 py-10 bg-slate-900/60 backdrop-blur-xl border border-slate-700/50 shadow-2xl overflow-hidden rounded-3xl">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-slate-500 text-sm">
                &copy; {{ date('Y') }} Trax. Todos los derechos reservados.
            </div>
        </div>
    </body>
</html>

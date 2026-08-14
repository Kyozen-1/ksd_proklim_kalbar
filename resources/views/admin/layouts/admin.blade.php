<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin CMS Panel - Proklim Kalbar')</title>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>
<body class="h-full font-sans antialiased text-slate-800 flex">

    <!-- Admin Sidebar Stub -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex-shrink-0 hidden md:flex flex-col justify-between p-6">
        <div class="space-y-6">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-emerald-600 flex items-center justify-center text-white font-bold">
                    <i class="fa-solid fa-leaf"></i>
                </div>
                <span class="font-extrabold text-white text-base">CMS PROKLIM</span>
            </div>

            <nav class="space-y-1 text-sm font-medium">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-emerald-600 text-white font-semibold">
                    <i class="fa-solid fa-gauge w-5 text-center"></i> Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">
                    <i class="fa-solid fa-location-dot w-5 text-center"></i> Kelola Lokasi
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">
                    <i class="fa-solid fa-newspaper w-5 text-center"></i> Berita & Artikel
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">
                    <i class="fa-solid fa-gear w-5 text-center"></i> Pengaturan
                </a>
            </nav>
        </div>

        <div class="pt-6 border-t border-slate-800">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-xs font-semibold text-emerald-400 hover:underline">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Frontend
            </a>
        </div>
    </aside>

    <!-- Content Area -->
    <div class="flex-grow flex flex-col min-w-0">
        <header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-800">Admin Control Panel</h2>
            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold text-slate-500">Administrator</span>
                <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center font-bold text-xs text-slate-700">
                    AD
                </div>
            </div>
        </header>
        <main class="p-8 flex-grow">
            @yield('content')
        </main>
    </div>

</body>
</html>

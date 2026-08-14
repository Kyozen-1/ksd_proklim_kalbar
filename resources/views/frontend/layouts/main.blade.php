<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    @include('frontend.layouts.head')
</head>
<body class="h-full flex flex-col bg-slate-50 font-sans text-slate-800 antialiased selection:bg-emerald-500 selection:text-white">
    
    <!-- Navbar Header -->
    @include('frontend.layouts.navbar')

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('frontend.layouts.footer')

    <!-- Scripts -->
    @include('frontend.layouts.script')

</body>
</html>

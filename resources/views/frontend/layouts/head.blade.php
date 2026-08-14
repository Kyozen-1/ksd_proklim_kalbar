<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title', 'Proklim Kalimantan Barat - Program Kampung Iklim DLHK Kalbar')</title>
<meta name="description" content="@yield('meta_description', 'Portal Resmi Program Kampung Iklim (Proklim) Provinsi Kalimantan Barat - Akselerasi Adaptasi dan Mitigasi Perubahan Iklim.')">

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

<!-- FontAwesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<!-- Alpine.js via CDN for responsive micro-interactions -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- Vite Assets -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

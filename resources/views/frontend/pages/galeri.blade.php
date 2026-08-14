@extends('frontend.layouts.main')

@section('title', 'Galeri Dokumentasi - DLHK Proklim Kalimantan Barat')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 space-y-12 py-8 sm:py-12">

    <!-- BADGE AND PAGE HEADER -->
    <section class="text-center space-y-4 max-w-4xl mx-auto">
        <div class="inline-block">
            <span class="px-4 py-1.5 rounded-full border border-[#7AE3BC]/70 text-[#00A86B] text-[11px] font-extrabold uppercase tracking-widest bg-[#E6F9F2]">
                GALERI
            </span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-snug">
            <span class="text-[#00D182]">Ruang Dokumentasi PSLB3PP:</span> Rekam Jejak Aksi<br class="hidden sm:inline" />
            Pengelolaan Limbah dan Penguatan Kapasitas
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed max-w-3xl mx-auto font-normal">
            Galeri visual rangkaian kegiatan DLHK dalam pengawasan LB3, optimalisasi pengurangan sampah di sumber, serta pembinaan komunitas hijau tingkat tapak.
        </p>
    </section>

    <!-- GALLERY GRID SECTION -->
    <section class="max-w-[1360px] mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            
            <!-- Gallery Item 1 -->
            <div class="h-48 sm:h-56 rounded-2xl overflow-hidden relative group shadow-md hover:shadow-lg transition-all cursor-pointer bg-slate-100">
                <!-- Cover Image -->
                <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop" 
                     alt="Kegiatan Hari Lingkungan" 
                     class="w-full h-full object-cover">
                
                <!-- Hover Overlay Container (Hidden by default, fades in on hover) -->
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex flex-col justify-between p-5 transition-all duration-300 z-20">
                    <!-- Center: Eye Icon -->
                    <div class="flex-grow flex items-center justify-center">
                        <div class="w-11 h-11 rounded-full bg-white/20 backdrop-blur-xs flex items-center justify-center border border-white/30 shadow-sm scale-90 group-hover:scale-100 transition-all duration-300">
                            <i class="fa-regular fa-eye text-base text-white"></i>
                        </div>
                    </div>
                    <!-- Bottom: Title and Meta (Slides up slightly on hover) -->
                    <div class="space-y-1.5 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                        <h3 class="text-sm sm:text-base font-bold text-white leading-snug">
                            Kegiatan Hari Lingkungan
                        </h3>
                        <div class="flex items-center gap-4 text-[10px] sm:text-xs text-white/90 font-semibold">
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-regular fa-calendar text-[#00E58F]"></i> 24 Mei 2026
                            </span>
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-[#00E58F]"></i> Kota Pontianak
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 2 -->
            <div class="h-48 sm:h-56 rounded-2xl overflow-hidden relative group shadow-md hover:shadow-lg transition-all cursor-pointer bg-slate-100">
                <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop" 
                     alt="Kegiatan Hari Lingkungan" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex flex-col justify-between p-5 transition-all duration-300 z-20">
                    <div class="flex-grow flex items-center justify-center">
                        <div class="w-11 h-11 rounded-full bg-white/20 backdrop-blur-xs flex items-center justify-center border border-white/30 shadow-sm scale-90 group-hover:scale-100 transition-all duration-300">
                            <i class="fa-regular fa-eye text-base text-white"></i>
                        </div>
                    </div>
                    <div class="space-y-1.5 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                        <h3 class="text-sm sm:text-base font-bold text-white leading-snug">
                            Kegiatan Hari Lingkungan
                        </h3>
                        <div class="flex items-center gap-4 text-[10px] sm:text-xs text-white/90 font-semibold">
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-regular fa-calendar text-[#00E58F]"></i> 24 Mei 2026
                            </span>
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-[#00E58F]"></i> Kota Pontianak
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 3 -->
            <div class="h-48 sm:h-56 rounded-2xl overflow-hidden relative group shadow-md hover:shadow-lg transition-all cursor-pointer bg-slate-100">
                <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop" 
                     alt="Kegiatan Hari Lingkungan" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex flex-col justify-between p-5 transition-all duration-300 z-20">
                    <div class="flex-grow flex items-center justify-center">
                        <div class="w-11 h-11 rounded-full bg-white/20 backdrop-blur-xs flex items-center justify-center border border-white/30 shadow-sm scale-90 group-hover:scale-100 transition-all duration-300">
                            <i class="fa-regular fa-eye text-base text-white"></i>
                        </div>
                    </div>
                    <div class="space-y-1.5 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                        <h3 class="text-sm sm:text-base font-bold text-white leading-snug">
                            Kegiatan Hari Lingkungan
                        </h3>
                        <div class="flex items-center gap-4 text-[10px] sm:text-xs text-white/90 font-semibold">
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-regular fa-calendar text-[#00E58F]"></i> 24 Mei 2026
                            </span>
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-[#00E58F]"></i> Kota Pontianak
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 4 -->
            <div class="h-48 sm:h-56 rounded-2xl overflow-hidden relative group shadow-md hover:shadow-lg transition-all cursor-pointer bg-slate-100">
                <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop" 
                     alt="Kegiatan Hari Lingkungan" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex flex-col justify-between p-5 transition-all duration-300 z-20">
                    <div class="flex-grow flex items-center justify-center">
                        <div class="w-11 h-11 rounded-full bg-white/20 backdrop-blur-xs flex items-center justify-center border border-white/30 shadow-sm scale-90 group-hover:scale-100 transition-all duration-300">
                            <i class="fa-regular fa-eye text-base text-white"></i>
                        </div>
                    </div>
                    <div class="space-y-1.5 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                        <h3 class="text-sm sm:text-base font-bold text-white leading-snug">
                            Kegiatan Hari Lingkungan
                        </h3>
                        <div class="flex items-center gap-4 text-[10px] sm:text-xs text-white/90 font-semibold">
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-regular fa-calendar text-[#00E58F]"></i> 24 Mei 2026
                            </span>
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-[#00E58F]"></i> Kota Pontianak
                        </span>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 5 -->
            <div class="h-48 sm:h-56 rounded-2xl overflow-hidden relative group shadow-md hover:shadow-lg transition-all cursor-pointer bg-slate-100">
                <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop" 
                     alt="Kegiatan Hari Lingkungan" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex flex-col justify-between p-5 transition-all duration-300 z-20">
                    <div class="flex-grow flex items-center justify-center">
                        <div class="w-11 h-11 rounded-full bg-white/20 backdrop-blur-xs flex items-center justify-center border border-white/30 shadow-sm scale-90 group-hover:scale-100 transition-all duration-300">
                            <i class="fa-regular fa-eye text-base text-white"></i>
                        </div>
                    </div>
                    <div class="space-y-1.5 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                        <h3 class="text-sm sm:text-base font-bold text-white leading-snug">
                            Kegiatan Hari Lingkungan
                        </h3>
                        <div class="flex items-center gap-4 text-[10px] sm:text-xs text-white/90 font-semibold">
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-regular fa-calendar text-[#00E58F]"></i> 24 Mei 2026
                            </span>
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-[#00E58F]"></i> Kota Pontianak
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 6 -->
            <div class="h-48 sm:h-56 rounded-2xl overflow-hidden relative group shadow-md hover:shadow-lg transition-all cursor-pointer bg-slate-100">
                <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop" 
                     alt="Kegiatan Hari Lingkungan" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex flex-col justify-between p-5 transition-all duration-300 z-20">
                    <div class="flex-grow flex items-center justify-center">
                        <div class="w-11 h-11 rounded-full bg-white/20 backdrop-blur-xs flex items-center justify-center border border-white/30 shadow-sm scale-90 group-hover:scale-100 transition-all duration-300">
                            <i class="fa-regular fa-eye text-base text-white"></i>
                        </div>
                    </div>
                    <div class="space-y-1.5 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                        <h3 class="text-sm sm:text-base font-bold text-white leading-snug">
                            Kegiatan Hari Lingkungan
                        </h3>
                        <div class="flex items-center gap-4 text-[10px] sm:text-xs text-white/90 font-semibold">
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-regular fa-calendar text-[#00E58F]"></i> 24 Mei 2026
                            </span>
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-[#00E58F]"></i> Kota Pontianak
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 7 -->
            <div class="h-48 sm:h-56 rounded-2xl overflow-hidden relative group shadow-md hover:shadow-lg transition-all cursor-pointer bg-slate-100">
                <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop" 
                     alt="Kegiatan Hari Lingkungan" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex flex-col justify-between p-5 transition-all duration-300 z-20">
                    <div class="flex-grow flex items-center justify-center">
                        <div class="w-11 h-11 rounded-full bg-white/20 backdrop-blur-xs flex items-center justify-center border border-white/30 shadow-sm scale-90 group-hover:scale-100 transition-all duration-300">
                            <i class="fa-regular fa-eye text-base text-white"></i>
                        </div>
                    </div>
                    <div class="space-y-1.5 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                        <h3 class="text-sm sm:text-base font-bold text-white leading-snug">
                            Kegiatan Hari Lingkungan
                        </h3>
                        <div class="flex items-center gap-4 text-[10px] sm:text-xs text-white/90 font-semibold">
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-regular fa-calendar text-[#00E58F]"></i> 24 Mei 2026
                            </span>
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-[#00E58F]"></i> Kota Pontianak
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 8 -->
            <div class="h-48 sm:h-56 rounded-2xl overflow-hidden relative group shadow-md hover:shadow-lg transition-all cursor-pointer bg-slate-100">
                <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop" 
                     alt="Kegiatan Hari Lingkungan" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex flex-col justify-between p-5 transition-all duration-300 z-20">
                    <div class="flex-grow flex items-center justify-center">
                        <div class="w-11 h-11 rounded-full bg-white/20 backdrop-blur-xs flex items-center justify-center border border-white/30 shadow-sm scale-90 group-hover:scale-100 transition-all duration-300">
                            <i class="fa-regular fa-eye text-base text-white"></i>
                        </div>
                    </div>
                    <div class="space-y-1.5 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                        <h3 class="text-sm sm:text-base font-bold text-white leading-snug">
                            Kegiatan Hari Lingkungan
                        </h3>
                        <div class="flex items-center gap-4 text-[10px] sm:text-xs text-white/90 font-semibold">
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-regular fa-calendar text-[#00E58F]"></i> 24 Mei 2026
                            </span>
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-[#00E58F]"></i> Kota Pontianak
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 9 -->
            <div class="h-48 sm:h-56 rounded-2xl overflow-hidden relative group shadow-md hover:shadow-lg transition-all cursor-pointer bg-slate-100">
                <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop" 
                     alt="Kegiatan Hari Lingkungan" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex flex-col justify-between p-5 transition-all duration-300 z-20">
                    <div class="flex-grow flex items-center justify-center">
                        <div class="w-11 h-11 rounded-full bg-white/20 backdrop-blur-xs flex items-center justify-center border border-white/30 shadow-sm scale-90 group-hover:scale-100 transition-all duration-300">
                            <i class="fa-regular fa-eye text-base text-white"></i>
                        </div>
                    </div>
                    <div class="space-y-1.5 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                        <h3 class="text-sm sm:text-base font-bold text-white leading-snug">
                            Kegiatan Hari Lingkungan
                        </h3>
                        <div class="flex items-center gap-4 text-[10px] sm:text-xs text-white/90 font-semibold">
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-regular fa-calendar text-[#00E58F]"></i> 24 Mei 2026
                            </span>
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-[#00E58F]"></i> Kota Pontianak
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- CENTERED PAGINATION -->
    <div class="pt-8 flex items-center justify-center gap-3 text-xs font-semibold text-slate-500 mt-6">
        <button class="w-8 h-8 rounded-lg border border-slate-200 flex items-center justify-center hover:text-[#00A86B] hover:border-[#00A86B] transition-all cursor-pointer">
            <i class="fa-solid fa-chevron-left text-[10px]"></i>
        </button>
        
        <div class="flex items-center gap-1.5">
            <button class="w-8 h-8 rounded-lg bg-[#00E58F] text-white flex items-center justify-center font-bold shadow-xs">
                1
            </button>
            <button class="w-8 h-8 rounded-lg border border-slate-200 flex items-center justify-center hover:text-[#00A86B] hover:border-[#00A86B] transition-all cursor-pointer">
                2
            </button>
            <button class="w-8 h-8 rounded-lg border border-slate-200 flex items-center justify-center hover:text-[#00A86B] hover:border-[#00A86B] transition-all cursor-pointer">
                3
            </button>
            <button class="w-8 h-8 rounded-lg border border-slate-200 flex items-center justify-center hover:text-[#00A86B] hover:border-[#00A86B] transition-all cursor-pointer">
                4
            </button>
        </div>

        <button class="w-8 h-8 rounded-lg border border-slate-200 flex items-center justify-center hover:text-[#00A86B] hover:border-[#00A86B] transition-all cursor-pointer">
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
        </button>
    </div>

</div>
@endsection

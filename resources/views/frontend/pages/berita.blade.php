@extends('frontend.layouts.main')

@section('title', 'Berita dan Liputan - DLHK Proklim Kalimantan Barat')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 space-y-12 py-8 sm:py-12" x-data="{ searchQuery: '' }">

    <!-- BADGE AND PAGE HEADER -->
    <section class="text-center space-y-3 max-w-4xl mx-auto">
        <div class="inline-block">
            <span class="px-4 py-1.5 rounded-full border border-[#7AE3BC]/70 text-[#00A86B] text-[11px] font-extrabold uppercase tracking-widest bg-[#E6F9F2]">
                BERITA
            </span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-snug">
            Berita Proklim
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed max-w-3xl mx-auto font-normal">
            Liputan utama program pendaftaran Kampung Iklim, profil desa inspiratif tangguh iklim, dan panduan edukasi ekologis di Kalimantan Barat
        </p>
    </section>

    <!-- SEARCH CONTAINER -->
    <section class="max-w-[1360px] mx-auto">
        <div class="bg-white border border-slate-200/90 rounded-2xl p-4 sm:p-5 flex items-center shadow-xs">
            <!-- Search Input -->
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-slate-400 text-sm"></i>
                </span>
                <input type="text" 
                       x-model="searchQuery"
                       placeholder="Cari Berita..." 
                       class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl text-xs sm:text-sm bg-[#FAFAFA] focus:outline-none focus:border-[#00E58F] focus:bg-white transition-all">
            </div>
        </div>
    </section>

    <!-- BERITA GRID SECTION -->
    <section class="max-w-[1360px] mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            
            <!-- Card 1 -->
            <a href="{{ route('berita-detail') }}" 
               class="bg-white border border-slate-200/70 rounded-xl overflow-hidden flex flex-col group transition-all shadow-md hover:shadow-lg block"
               x-show="searchQuery === '' || 'DLHK Kalbar Targetkan 500 Kampung Iklim Aktif Sebelum Tahun 2029'.toLowerCase().includes(searchQuery.toLowerCase())">
                <div class="relative h-48 sm:h-56 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop" 
                         alt="Kampung Iklim" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-5 space-y-3.5 flex-grow flex flex-col justify-between">
                    <div class="space-y-2.5">
                        <div class="flex items-center gap-4 text-[11px] sm:text-xs text-slate-400 font-semibold">
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-regular fa-calendar text-[#00A86B]"></i> 24 Mei 2026
                            </span>
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-regular fa-user text-[#00A86B]"></i> Humas PSLB3PP
                            </span>
                        </div>
                        <h3 class="text-sm sm:text-base lg:text-lg font-bold text-slate-900 leading-snug group-hover:text-[#00A86B] transition-colors">
                            DLHK Kalbar Targetkan 500 Kampung Iklim Aktif Sebelum Tahun 2029
                        </h3>
                        <p class="text-xs sm:text-xs text-slate-500 font-normal leading-relaxed">
                            Dinas Lingkungan Hidup dan Kehutanan Provinsi Kalimantan Barat menginisiasi percepatan pendaftaran Proklim tingkat desa sebagai upaya nasional mitigasi krisis iklim.
                        </p>
                    </div>
                    <div class="pt-1">
                        <span class="text-xs font-bold text-[#00A86B] group-hover:text-[#00905b] inline-flex items-center gap-1 transition-all underline">
                            Baca Selengkapnya
                        </span>
                    </div>
                </div>
            </a>

            <!-- Card 2 -->
            <a href="{{ route('berita-detail') }}" 
               class="bg-white border border-slate-200/70 rounded-xl overflow-hidden flex flex-col group transition-all shadow-md hover:shadow-lg block"
               x-show="searchQuery === '' || 'DLHK Kalbar Targetkan 500 Kampung Iklim Aktif Sebelum Tahun 2029'.toLowerCase().includes(searchQuery.toLowerCase())">
                <div class="relative h-48 sm:h-56 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop" 
                         alt="Kampung Iklim" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-5 space-y-3.5 flex-grow flex flex-col justify-between">
                    <div class="space-y-2.5">
                        <div class="flex items-center gap-4 text-[11px] sm:text-xs text-slate-400 font-semibold">
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-regular fa-calendar text-[#00A86B]"></i> 24 Mei 2026
                            </span>
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-regular fa-user text-[#00A86B]"></i> Humas PSLB3PP
                            </span>
                        </div>
                        <h3 class="text-sm sm:text-base lg:text-lg font-bold text-slate-900 leading-snug group-hover:text-[#00A86B] transition-colors">
                            DLHK Kalbar Targetkan 500 Kampung Iklim Aktif Sebelum Tahun 2029
                        </h3>
                        <p class="text-xs sm:text-xs text-slate-500 font-normal leading-relaxed">
                            Dinas Lingkungan Hidup dan Kehutanan Provinsi Kalimantan Barat menginisiasi percepatan pendaftaran Proklim tingkat desa sebagai upaya nasional mitigasi krisis iklim.
                        </p>
                    </div>
                    <div class="pt-1">
                        <span class="text-xs font-bold text-[#00A86B] group-hover:text-[#00905b] inline-flex items-center gap-1 transition-all underline">
                            Baca Selengkapnya
                        </span>
                    </div>
                </div>
            </a>

            <!-- Card 3 -->
            <a href="{{ route('berita-detail') }}" 
               class="bg-white border border-slate-200/70 rounded-xl overflow-hidden flex flex-col group transition-all shadow-md hover:shadow-lg block"
               x-show="searchQuery === '' || 'DLHK Kalbar Targetkan 500 Kampung Iklim Aktif Sebelum Tahun 2029'.toLowerCase().includes(searchQuery.toLowerCase())">
                <div class="relative h-48 sm:h-56 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop" 
                         alt="Kampung Iklim" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-5 space-y-3.5 flex-grow flex flex-col justify-between">
                    <div class="space-y-2.5">
                        <div class="flex items-center gap-4 text-[11px] sm:text-xs text-slate-400 font-semibold">
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-regular fa-calendar text-[#00A86B]"></i> 24 Mei 2026
                            </span>
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-regular fa-user text-[#00A86B]"></i> Humas PSLB3PP
                            </span>
                        </div>
                        <h3 class="text-sm sm:text-base lg:text-lg font-bold text-slate-900 leading-snug group-hover:text-[#00A86B] transition-colors">
                            DLHK Kalbar Targetkan 500 Kampung Iklim Aktif Sebelum Tahun 2029
                        </h3>
                        <p class="text-xs sm:text-xs text-slate-500 font-normal leading-relaxed">
                            Dinas Lingkungan Hidup dan Kehutanan Provinsi Kalimantan Barat menginisiasi percepatan pendaftaran Proklim tingkat desa sebagai upaya nasional mitigasi krisis iklim.
                        </p>
                    </div>
                    <div class="pt-1">
                        <span class="text-xs font-bold text-[#00A86B] group-hover:text-[#00905b] inline-flex items-center gap-1 transition-all underline">
                            Baca Selengkapnya
                        </span>
                    </div>
                </div>
            </a>

            <!-- Card 4 -->
            <a href="{{ route('berita-detail') }}" 
               class="bg-white border border-slate-200/70 rounded-xl overflow-hidden flex flex-col group transition-all shadow-md hover:shadow-lg block"
               x-show="searchQuery === '' || 'DLHK Kalbar Targetkan 500 Kampung Iklim Aktif Sebelum Tahun 2029'.toLowerCase().includes(searchQuery.toLowerCase())">
                <div class="relative h-48 sm:h-56 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop" 
                         alt="Kampung Iklim" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-5 space-y-3.5 flex-grow flex flex-col justify-between">
                    <div class="space-y-2.5">
                        <div class="flex items-center gap-4 text-[11px] sm:text-xs text-slate-400 font-semibold">
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-regular fa-calendar text-[#00A86B]"></i> 24 Mei 2026
                            </span>
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-regular fa-user text-[#00A86B]"></i> Humas PSLB3PP
                            </span>
                        </div>
                        <h3 class="text-sm sm:text-base lg:text-lg font-bold text-slate-900 leading-snug group-hover:text-[#00A86B] transition-colors">
                            DLHK Kalbar Targetkan 500 Kampung Iklim Aktif Sebelum Tahun 2029
                        </h3>
                        <p class="text-xs sm:text-xs text-slate-500 font-normal leading-relaxed">
                            Dinas Lingkungan Hidup dan Kehutanan Provinsi Kalimantan Barat menginisiasi percepatan pendaftaran Proklim tingkat desa sebagai upaya nasional mitigasi krisis iklim.
                        </p>
                    </div>
                    <div class="pt-1">
                        <span class="text-xs font-bold text-[#00A86B] group-hover:text-[#00905b] inline-flex items-center gap-1 transition-all underline">
                            Baca Selengkapnya
                        </span>
                    </div>
                </div>
            </a>

            <!-- Card 5 -->
            <a href="{{ route('berita-detail') }}" 
               class="bg-white border border-slate-200/70 rounded-xl overflow-hidden flex flex-col group transition-all shadow-md hover:shadow-lg block"
               x-show="searchQuery === '' || 'DLHK Kalbar Targetkan 500 Kampung Iklim Aktif Sebelum Tahun 2029'.toLowerCase().includes(searchQuery.toLowerCase())">
                <div class="relative h-48 sm:h-56 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop" 
                         alt="Kampung Iklim" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-5 space-y-3.5 flex-grow flex flex-col justify-between">
                    <div class="space-y-2.5">
                        <div class="flex items-center gap-4 text-[11px] sm:text-xs text-slate-400 font-semibold">
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-regular fa-calendar text-[#00A86B]"></i> 24 Mei 2026
                            </span>
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-regular fa-user text-[#00A86B]"></i> Humas PSLB3PP
                            </span>
                        </div>
                        <h3 class="text-sm sm:text-base lg:text-lg font-bold text-slate-900 leading-snug group-hover:text-[#00A86B] transition-colors">
                            DLHK Kalbar Targetkan 500 Kampung Iklim Aktif Sebelum Tahun 2029
                        </h3>
                        <p class="text-xs sm:text-xs text-slate-500 font-normal leading-relaxed">
                            Dinas Lingkungan Hidup dan Kehutanan Provinsi Kalimantan Barat menginisiasi percepatan pendaftaran Proklim tingkat desa sebagai upaya nasional mitigasi krisis iklim.
                        </p>
                    </div>
                    <div class="pt-1">
                        <span class="text-xs font-bold text-[#00A86B] group-hover:text-[#00905b] inline-flex items-center gap-1 transition-all underline">
                            Baca Selengkapnya
                        </span>
                    </div>
                </div>
            </a>

            <!-- Card 6 -->
            <a href="{{ route('berita-detail') }}" 
               class="bg-white border border-slate-200/70 rounded-xl overflow-hidden flex flex-col group transition-all shadow-md hover:shadow-lg block"
               x-show="searchQuery === '' || 'DLHK Kalbar Targetkan 500 Kampung Iklim Aktif Sebelum Tahun 2029'.toLowerCase().includes(searchQuery.toLowerCase())">
                <div class="relative h-48 sm:h-56 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop" 
                         alt="Kampung Iklim" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-5 space-y-3.5 flex-grow flex flex-col justify-between">
                    <div class="space-y-2.5">
                        <div class="flex items-center gap-4 text-[11px] sm:text-xs text-slate-400 font-semibold">
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-regular fa-calendar text-[#00A86B]"></i> 24 Mei 2026
                            </span>
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-regular fa-user text-[#00A86B]"></i> Humas PSLB3PP
                            </span>
                        </div>
                        <h3 class="text-sm sm:text-base lg:text-lg font-bold text-slate-900 leading-snug group-hover:text-[#00A86B] transition-colors">
                            DLHK Kalbar Targetkan 500 Kampung Iklim Aktif Sebelum Tahun 2029
                        </h3>
                        <p class="text-xs sm:text-xs text-slate-500 font-normal leading-relaxed">
                            Dinas Lingkungan Hidup dan Kehutanan Provinsi Kalimantan Barat menginisiasi percepatan pendaftaran Proklim tingkat desa sebagai upaya nasional mitigasi krisis iklim.
                        </p>
                    </div>
                    <div class="pt-1">
                        <span class="text-xs font-bold text-[#00A86B] group-hover:text-[#00905b] inline-flex items-center gap-1 transition-all underline">
                            Baca Selengkapnya
                        </span>
                    </div>
                </div>
            </a>

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

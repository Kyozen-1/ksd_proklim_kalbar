@extends('frontend.layouts.main')

@section('title', 'Dokumen Resmi Regulasi - DLHK Proklim Kalimantan Barat')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 space-y-12 py-8 sm:py-12" x-data="{ activeFilter: 'semua', searchQuery: '' }">

    <!-- BADGE AND PAGE HEADER -->
    <section class="text-center space-y-3 max-w-4xl mx-auto">
        <div class="inline-block">
            <span class="px-4 py-1.5 rounded-full border border-[#7AE3BC]/70 text-[#00A86B] text-[11px] font-extrabold uppercase tracking-widest bg-[#E6F9F2]">
                DOKUMEN RESMI
            </span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-snug">
            Dokumen Resmi Proklim
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed max-w-3xl mx-auto font-normal">
            Arsip peraturan menteri, buku panduan pendaftaran tingkat tapak desa, draf SK Kepala Desa.
        </p>
    </section>

    <!-- SEARCH AND FILTER CONTAINER -->
    <section class="max-w-6xl mx-auto">
        <div class="bg-white border border-slate-200/90 rounded-2xl p-4 sm:p-5 flex flex-col md:flex-row items-center justify-between gap-4 shadow-xs">
            
            <!-- Left Side: Search Input -->
            <div class="relative w-full md:w-80">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-slate-400 text-sm"></i>
                </span>
                <input type="text" 
                       x-model="searchQuery"
                       placeholder="Cari Dokumen..." 
                       class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl text-xs sm:text-sm bg-[#FAFAFA] focus:outline-none focus:border-[#00E58F] focus:bg-white transition-all">
            </div>

            <!-- Right Side: Filter Categories (Premium Pill Capsule Container 1:1) -->
            <div class="bg-[#F2F2F2] rounded-xl p-1 inline-flex items-center gap-1 shrink-0 overflow-x-auto max-w-full">
                <button @click="activeFilter = 'semua'"
                        class="px-4 py-2 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap"
                        :class="activeFilter === 'semua' ? 'bg-[#00D182] text-white shadow-xs' : 'bg-transparent text-slate-800 hover:bg-slate-200/40'">
                    Semua
                </button>
                <button @click="activeFilter = 'undang-undang'"
                        class="px-4 py-2 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap"
                        :class="activeFilter === 'undang-undang' ? 'bg-[#00D182] text-white shadow-xs' : 'bg-transparent text-slate-800 hover:bg-slate-200/40'">
                    Undang-Undang
                </button>
                <button @click="activeFilter = 'peraturan-daerah'"
                        class="px-4 py-2 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap"
                        :class="activeFilter === 'peraturan-daerah' ? 'bg-[#00D182] text-white shadow-xs' : 'bg-transparent text-slate-800 hover:bg-slate-200/40'">
                    Peraturan Daerah
                </button>
                <button @click="activeFilter = 'panduan'"
                        class="px-4 py-2 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap"
                        :class="activeFilter === 'panduan' ? 'bg-[#00D182] text-white shadow-xs' : 'bg-transparent text-slate-800 hover:bg-slate-200/40'">
                    Panduan
                </button>
            </div>

        </div>
    </section>

    <!-- DOCUMENT LIST SECTION (1 Single Card Section Container with Dividers) -->
    <section class="max-w-6xl mx-auto">
        <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden divide-y divide-slate-100">
            
            <!-- Document 1 -->
            <div class="p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-all hover:bg-slate-50/40"
                 x-show="(activeFilter === 'semua' || activeFilter === 'undang-undang') && (searchQuery === '' || 'Undang-Undang Republik Indonesia Nomor 32 Tahun 2009 tentang Perlindungan dan Pengelolaan Lingkungan Hidup'.toLowerCase().includes(searchQuery.toLowerCase()))">
                <div class="flex items-start sm:items-center gap-4">
                    <!-- Rounded Icon Box -->
                    <div class="w-12 h-12 rounded-xl bg-[#E6F9F2] text-[#00A86B] flex items-center justify-center text-xl shrink-0">
                        <i class="fa-regular fa-file-lines"></i>
                    </div>
                    <div class="space-y-0.5">
                        <span class="text-xs font-semibold text-[#00A86B] block">
                            Undang-Undang
                        </span>
                        <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug">
                            Undang-Undang Republik Indonesia Nomor 32 Tahun 2009 tentang Perlindungan dan Pengelolaan Lingkungan Hidup
                        </h3>
                        <p class="text-xs text-slate-500 font-medium">
                            Ukuran: 2.4 MB
                        </p>
                    </div>
                </div>
                <div class="shrink-0 w-full sm:w-auto">
                    <a href="#" class="w-full sm:w-auto px-5 py-2.5 rounded-lg bg-[#00E58F] hover:bg-[#00d080] text-white font-extrabold text-xs inline-flex items-center justify-center gap-1.5 transition-all shadow-sm">
                        Download Dokumen
                    </a>
                </div>
            </div>

            <!-- Document 2 -->
            <div class="p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-all hover:bg-slate-50/40"
                 x-show="(activeFilter === 'semua' || activeFilter === 'peraturan-daerah') && (searchQuery === '' || 'Peraturan Menteri LHK Nomor P.84/MENLHK-SETJEN/KUM.1/11/2016 tentang Program Kampung Iklim (Proklim)'.toLowerCase().includes(searchQuery.toLowerCase()))">
                <div class="flex items-start sm:items-center gap-4">
                    <!-- Rounded Icon Box -->
                    <div class="w-12 h-12 rounded-xl bg-[#E6F9F2] text-[#00A86B] flex items-center justify-center text-xl shrink-0">
                        <i class="fa-regular fa-file-lines"></i>
                    </div>
                    <div class="space-y-0.5">
                        <span class="text-xs font-semibold text-[#00A86B] block">
                            Peraturan Daerah
                        </span>
                        <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug">
                            Peraturan Menteri LHK Nomor P.84/MENLHK-SETJEN/KUM.1/11/2016 tentang Program Kampung Iklim (Proklim)
                        </h3>
                        <p class="text-xs text-slate-500 font-medium">
                            Ukuran: 2.4 MB
                        </p>
                    </div>
                </div>
                <div class="shrink-0 w-full sm:w-auto">
                    <a href="#" class="w-full sm:w-auto px-5 py-2.5 rounded-lg bg-[#00E58F] hover:bg-[#00d080] text-white font-extrabold text-xs inline-flex items-center justify-center gap-1.5 transition-all shadow-sm">
                        Download Dokumen
                    </a>
                </div>
            </div>

            <!-- Document 3 -->
            <div class="p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-all hover:bg-slate-50/40"
                 x-show="(activeFilter === 'semua' || activeFilter === 'panduan') && (searchQuery === '' || 'Panduan Perintis Pelaksanaan Program Kampung Iklim (Proklim) Tingkat Tapak Tapak Desa'.toLowerCase().includes(searchQuery.toLowerCase()))">
                <div class="flex items-start sm:items-center gap-4">
                    <!-- Rounded Icon Box -->
                    <div class="w-12 h-12 rounded-xl bg-[#E6F9F2] text-[#00A86B] flex items-center justify-center text-xl shrink-0">
                        <i class="fa-regular fa-file-lines"></i>
                    </div>
                    <div class="space-y-0.5">
                        <span class="text-xs font-semibold text-[#00A86B] block">
                            Panduan
                        </span>
                        <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug">
                            Panduan Perintis Pelaksanaan Program Kampung Iklim (Proklim) Tingkat Tapak Tapak Desa
                        </h3>
                        <p class="text-xs text-slate-500 font-medium">
                            Ukuran: 2.4 MB
                        </p>
                    </div>
                </div>
                <div class="shrink-0 w-full sm:w-auto">
                    <a href="#" class="w-full sm:w-auto px-5 py-2.5 rounded-lg bg-[#00E58F] hover:bg-[#00d080] text-white font-extrabold text-xs inline-flex items-center justify-center gap-1.5 transition-all shadow-sm">
                        Download Dokumen
                    </a>
                </div>
            </div>

            <!-- Document 4 -->
            <div class="p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-all hover:bg-slate-50/40"
                 x-show="(activeFilter === 'semua') && (searchQuery === '' || 'Laporan Capaian Pengurangan Emisi Karbon Sektor Kehutanan & Gambut Kalimantan Barat'.toLowerCase().includes(searchQuery.toLowerCase()))">
                <div class="flex items-start sm:items-center gap-4">
                    <!-- Rounded Icon Box -->
                    <div class="w-12 h-12 rounded-xl bg-[#E6F9F2] text-[#00A86B] flex items-center justify-center text-xl shrink-0">
                        <i class="fa-regular fa-file-lines"></i>
                    </div>
                    <div class="space-y-0.5">
                        <span class="text-xs font-semibold text-[#00A86B] block">
                            Laporan Tahunan
                        </span>
                        <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug">
                            Laporan Capaian Pengurangan Emisi Karbon Sektor Kehutanan & Gambut Kalimantan Barat
                        </h3>
                        <p class="text-xs text-slate-500 font-medium">
                            Ukuran: 2.4 MB
                        </p>
                    </div>
                </div>
                <div class="shrink-0 w-full sm:w-auto">
                    <a href="#" class="w-full sm:w-auto px-5 py-2.5 rounded-lg bg-[#00E58F] hover:bg-[#00d080] text-white font-extrabold text-xs inline-flex items-center justify-center gap-1.5 transition-all shadow-sm">
                        Download Dokumen
                    </a>
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

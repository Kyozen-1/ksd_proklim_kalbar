@extends('frontend.layouts.main')

@section('title', 'Beranda Utama - DLHK Proklim Kalimantan Barat')

@section('content')
<div class="space-y-16 py-6 sm:py-8">

    <!-- 1. HERO SLIDER SECTION CARD -->
    <section class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10">
        <div x-data="{ 
                activeSlide: 1, 
                totalSlides: 3, 
                timer: null,
                startAutoplay() {
                    this.timer = setInterval(() => {
                        this.activeSlide = this.activeSlide === this.totalSlides ? 1 : this.activeSlide + 1;
                    }, 6000);
                },
                stopAutoplay() {
                    clearInterval(this.timer);
                }
             }"
             x-init="startAutoplay()"
             @mouseenter="stopAutoplay()"
             @mouseleave="startAutoplay()"
             class="relative rounded-2xl overflow-hidden shadow-2xl bg-slate-950 min-h-[480px] sm:min-h-[540px] lg:min-h-[580px] flex items-center">

            <!-- Background Image Slides -->
            <div class="absolute inset-0 z-0">
                <!-- Slide 1 -->
                <div x-show="activeSlide === 1"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 scale-102"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-500"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-98"
                     class="absolute inset-0 bg-cover bg-right lg:bg-center"
                     style="background-image: url('{{ asset('frontend/img/default-slider-1.png') }}');">
                </div>

                <!-- Slide 2 -->
                <div x-show="activeSlide === 2"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 scale-102"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-500"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-98"
                     class="absolute inset-0 bg-cover bg-right lg:bg-center"
                     style="background-image: url('{{ asset('frontend/img/default-slider-2.png') }}');"
                     style="display: none;">
                </div>

                <!-- Slide 3 -->
                <div x-show="activeSlide === 3"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 scale-102"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-500"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-98"
                     class="absolute inset-0 bg-cover bg-right lg:bg-center"
                     style="background-image: url('{{ asset('frontend/img/default-slider-3.png') }}');"
                     style="display: none;">
                </div>

                <!-- Mobile Gradient Fade -->
                <div class="absolute inset-0 bg-gradient-to-r from-slate-950/85 via-slate-950/50 to-transparent lg:hidden"></div>
            </div>

            <!-- Left Content Overlay -->
            <div class="relative z-10 w-full p-8 sm:p-12 lg:p-16 max-w-3xl space-y-6">
                
                <!-- Top Header Logo & Text -->
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('frontend/img/logo_pemprov_kalbar.webp') }}" 
                             alt="Logo Pemprov Kalbar" 
                             class="h-9 w-auto object-contain">
                        <span class="text-xs sm:text-sm font-extrabold text-white tracking-wide uppercase leading-tight">
                            Pemerintah Provinsi <br />Kalimantan Barat
                        </span>
                    </div>

                    <!-- Green Pill Badge -->
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#00E58F]/20 border border-[#00E58F]/50 text-[#00E58F] text-[11px] sm:text-xs font-bold tracking-wider uppercase">
                        <i class="fa-solid fa-cloud-sun text-xs"></i>
                        <span>AKSI IKLIM TANGGUH KALIMANTAN BARAT</span>
                    </div>
                </div>

                <!-- Main Headline -->
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-[1.12]">
                    Bersama Menjaga Bumi dari <br />
                    <span class="text-[#00E58F]">Tapak Desa</span>
                </h1>

                <!-- Paragraph Description -->
                <p class="text-slate-200/95 text-xs sm:text-sm leading-relaxed max-w-xl font-normal">
                    PROKLIM (Program Kampung Iklim) Kalbar adalah gerakan kemasyarakatan berkelanjutan bentukan DLHK Kalbar guna meningkatkan kapasitas adaptasi, menurunkan emisi karbon, dan menciptakan kemandirian ekologis tangguh bencana tingkat RW/Dusun.
                </p>

                <!-- Action Buttons -->
                <div class="pt-2 flex items-center gap-3">
                    <a href="{{ route('data') }}" class="px-5 py-2.5 rounded-xl bg-slate-900/60 hover:bg-slate-900 text-white font-bold border border-slate-400/30 text-xs sm:text-sm backdrop-blur-md transition-all">
                        PROKLIM
                    </a>
                    <a href="{{ route('about') }}" class="px-5 py-2.5 rounded-xl bg-[#00E58F] hover:bg-[#00d080] text-slate-950 font-extrabold text-xs sm:text-sm inline-flex items-center gap-1.5 shadow-lg transition-all hover:scale-105">
                        <span>Pelajari Cara Kerja</span>
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                </div>

            </div>

        </div>
    </section>

    <!-- 2. STATS CARDS SECTION ("CAPAIAN KOLEKTIF TERKINI") -->
    <section class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10">
        <div class="text-center max-w-2xl mx-auto mb-8 space-y-2">
            <span class="text-xs sm:text-sm font-bold uppercase tracking-widest text-[#00A86B]">CAPAIAN KOLEKTIF TERKINI</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Dampak Nyata Lapangan Kalimantan Barat
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Card 1 -->
            <div class="bg-[#FAFCFA] rounded-xl p-5 sm:p-6 border-2 border-[#7AE3BC]/80 shadow-xs flex flex-col justify-between space-y-4">
                <div class="flex items-start gap-4">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl bg-[#00A86B] text-white flex items-center justify-center text-3xl sm:text-4xl font-bold shrink-0 shadow-md">
                        <i class="fa-solid fa-house"></i>
                    </div>
                    <div class="min-w-0 flex-1 my-auto">
                        <span class="text-[11px] sm:text-xs font-bold text-[#00A86B] tracking-wide uppercase block truncate">KAMPUNG IKLIM AKTIF</span>
                        <div class="flex items-baseline gap-1 mt-0.5">
                            <span class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">285</span>
                        </div>
                    </div>
                </div>
                <div class="pt-1 flex justify-start">
                    <span class="px-3 py-1 rounded-full text-[11px] sm:text-xs font-bold bg-[#D8F5EA] text-[#00A86B] border border-[#A3EED4] whitespace-nowrap">
                        2026: 12 Titik
                    </span>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-[#FAFCFA] rounded-xl p-5 sm:p-6 border-2 border-[#7AE3BC]/80 shadow-xs flex flex-col justify-between space-y-4">
                <div class="flex items-start gap-4">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl bg-[#00A86B] text-white flex items-center justify-center text-3xl sm:text-4xl font-bold shrink-0 shadow-md">
                        <i class="fa-solid fa-wind"></i>
                    </div>
                    <div class="min-w-0 flex-1 my-auto">
                        <span class="text-[11px] sm:text-xs font-bold text-[#00A86B] tracking-wide uppercase block truncate">REDUKSI GAS EMISI</span>
                        <div class="flex items-baseline flex-wrap gap-1 mt-0.5">
                            <span class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">24.460</span>
                            <span class="text-[11px] sm:text-xs font-semibold text-slate-500">tCO₂e/th</span>
                        </div>
                    </div>
                </div>
                <div class="pt-1 flex justify-start">
                    <span class="px-3 py-1 rounded-full text-[11px] sm:text-xs font-bold bg-[#D8F5EA] text-[#00A86B] border border-[#A3EED4] whitespace-nowrap">
                        2026: 10.000 tCO₂e
                    </span>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-[#FAFCFA] rounded-xl p-5 sm:p-6 border-2 border-[#7AE3BC]/80 shadow-xs flex flex-col justify-between space-y-4">
                <div class="flex items-start gap-4">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl bg-[#00A86B] text-white flex items-center justify-center text-3xl sm:text-4xl font-bold shrink-0 shadow-md">
                        <i class="fa-solid fa-wind"></i>
                    </div>
                    <div class="min-w-0 flex-1 my-auto">
                        <span class="text-[11px] sm:text-xs font-bold text-[#00A86B] tracking-wide uppercase block truncate">TOTAL EMISI</span>
                        <div class="flex items-baseline flex-wrap gap-1 mt-0.5">
                            <span class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">450.000</span>
                            <span class="text-[11px] sm:text-xs font-semibold text-slate-500">tCO₂e/th</span>
                        </div>
                    </div>
                </div>
                <div class="pt-1 flex justify-start">
                    <span class="px-3 py-1 rounded-full text-[11px] sm:text-xs font-bold bg-[#D8F5EA] text-[#00A86B] border border-[#A3EED4] whitespace-nowrap">
                        2026: 10.000 tCO₂e
                    </span>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="bg-[#FAFCFA] rounded-xl p-5 sm:p-6 border-2 border-[#7AE3BC]/80 shadow-xs flex flex-col justify-between space-y-4">
                <div class="flex items-start gap-4">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl bg-[#00A86B] text-white flex items-center justify-center text-3xl sm:text-4xl font-bold shrink-0 shadow-md">
                        <i class="fa-solid fa-trash-can"></i>
                    </div>
                    <div class="min-w-0 flex-1 my-auto">
                        <span class="text-[11px] sm:text-xs font-bold text-[#00A86B] tracking-wide uppercase block truncate">TOTAL TPS AKTIF</span>
                        <div class="flex items-baseline flex-wrap gap-1 mt-0.5">
                            <span class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">184</span>
                            <span class="text-[11px] sm:text-xs font-semibold text-slate-500">Unit</span>
                        </div>
                    </div>
                </div>
                <div class="pt-1 flex justify-start">
                    <span class="px-3 py-1 rounded-full text-[11px] sm:text-xs font-bold bg-[#D8F5EA] text-[#00A86B] border border-[#A3EED4] whitespace-nowrap">
                        2026: 145 Unit
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. TUGAS DAN FUNGSI PSLB3PP SECTION -->
    <section class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10">
        <div class="bg-[#004A33] text-white rounded-xl p-8 sm:p-12 lg:p-16 space-y-12 shadow-xl">
            
            <!-- Top Header -->
            <div class="text-center max-w-4xl mx-auto space-y-3">
                <span class="text-xs font-bold uppercase tracking-wider text-[#00E58F]">TUGAS DAN FUNGSI</span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold tracking-tight text-white">
                    Tugas Bidang PSLB3PP
                </h2>
                <p class="text-slate-100/90 text-xs sm:text-sm leading-relaxed max-w-3xl mx-auto pt-1 font-normal">
                    Bidang Pengelolaan Sampah, Limbah Bahan Berbahaya dan Beracun, serta Pengendalian Pencemaran (PSLB3PP) bertugas melaksanakan perumusan, koordinasi, dan evaluasi kebijakan teknis di bidang pengurangan dan penanganan sampah, pengelolaan limbah B3 (Bahan Berbahaya dan Beracun), serta pengendalian pencemaran
                </p>
            </div>

            <!-- Subheading -->
            <div class="text-center pt-2">
                <h3 class="text-xl sm:text-2xl font-bold text-white tracking-tight">
                    Fungsi Bidang PSLB3PP
                </h3>
            </div>

            <!-- 5 Numbered Items Columns (1 to 5) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 lg:gap-8">
                <!-- Item 1 -->
                <div class="space-y-3 text-left">
                    <div class="w-12 h-12 rounded-full bg-white text-[#004A33] font-extrabold flex items-center justify-center text-xl shadow-md">
                        1
                    </div>
                    <h4 class="text-sm sm:text-base font-bold text-white leading-snug">Pengelolaan Sampah</h4>
                    <p class="text-xs text-slate-200/85 leading-relaxed">
                        Membentuk kelompok kerja / kepengurusan Program Kampung Iklim tingkat dusun/desa yang disahkan berupa Surat Keputusan (SK) Kepala Desa atau Lurah.
                    </p>
                </div>

                <!-- Item 2 -->
                <div class="space-y-3 text-left">
                    <div class="w-12 h-12 rounded-full bg-white text-[#004A33] font-extrabold flex items-center justify-center text-xl shadow-md">
                        2
                    </div>
                    <h4 class="text-sm sm:text-base font-bold text-white leading-snug">Pembinaan & Pengurangan Timbunan Sampah</h4>
                    <p class="text-xs text-slate-200/85 leading-relaxed">
                        Melakukan pembinaan pembatasan timbunan sampah kepada produsen/industri dan mempromosikan ekonomi sirkular melalui gerakan daur ulang dan pemanfaatan kembali
                    </p>
                </div>

                <!-- Item 3 -->
                <div class="space-y-3 text-left">
                    <div class="w-12 h-12 rounded-full bg-white text-[#004A33] font-extrabold flex items-center justify-center text-xl shadow-md">
                        3
                    </div>
                    <h4 class="text-sm sm:text-base font-bold text-white leading-snug">Pengelolaan Limbah B3</h4>
                    <p class="text-xs text-slate-200/85 leading-relaxed">
                        Melakukan pengawasan dan pembinaan teknis terhadap kegiatan penyimpanan, pengumpulan, pemanfaatan, pengangkutan, hingga pengolahan limbah B3
                    </p>
                </div>

                <!-- Item 4 -->
                <div class="space-y-3 text-left">
                    <div class="w-12 h-12 rounded-full bg-white text-[#004A33] font-extrabold flex items-center justify-center text-xl shadow-md">
                        4
                    </div>
                    <h4 class="text-sm sm:text-base font-bold text-white leading-snug">Perizinan & Pertimbangan Teknis</h4>
                    <p class="text-xs text-slate-200/85 leading-relaxed">
                        Menyiapkan bahan pertimbangan teknis untuk perizinan pengumpulan dan pengangkutan limbah B3, serta penerbitan izin pendaur-ulangan sampah
                    </p>
                </div>

                <!-- Item 5 -->
                <div class="space-y-3 text-left">
                    <div class="w-12 h-12 rounded-full bg-white text-[#004A33] font-extrabold flex items-center justify-center text-xl shadow-md">
                        5
                    </div>
                    <h4 class="text-sm sm:text-base font-bold text-white leading-snug">Pemantauan & Evaluasi</h4>
                    <p class="text-xs text-slate-200/85 leading-relaxed">
                        Melakukan pemantauan dan evaluasi berkala terhadap Tempat Pemrosesan Akhir (TPA) sampah, sistem tanggap darurat, dan pencegahan pencemaran lingkungan
                    </p>
                </div>
            </div>

        </div>
    </section>

    <!-- 4. NEWS SECTION ("Berita Proklim & Aksi Iklim Kalbar") -->
    <section class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <span class="text-xs font-bold uppercase tracking-widest text-[#00E58F]">KABAR & BERITA TERKINI</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Berita Proklim & Aksi Iklim Kalbar
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- News Card 1 -->
            <article class="bg-white rounded-xl overflow-hidden border border-slate-100 shadow-sm card-hover flex flex-col group">
                <div class="relative h-48 overflow-hidden bg-slate-100">
                    <img src="{{ asset('frontend/img/default-slider-1.png') }}" alt="Berita Proklim" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-2">
                            <i class="fa-regular fa-calendar-check text-[#00E58F]"></i>
                            <span>05 Aug 2026</span>
                            <span class="mx-1">•</span>
                            <span class="text-[#00E58F]">Program Kampung Iklim</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 leading-snug group-hover:text-[#00E58F] transition-colors">
                            DLHK Kalbar Targetkan 500 Kampung Iklim Aktif Sebelum Tahun 2030
                        </h3>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mt-2">
                            Dinas Lingkungan Hidup dan Kehutanan Provinsi Kalimantan Barat mengakselerasi pembentukan Komunitas Iklim di wilayah kabupaten & kota.
                        </p>
                    </div>
                    <div class="pt-2 border-t border-slate-100 flex items-center text-xs font-bold text-[#00E58F]">
                        <span>Baca Selengkapnya</span>
                        <i class="fa-solid fa-chevron-right text-[10px] ml-1.5 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            </article>

            <!-- News Card 2 -->
            <article class="bg-white rounded-xl overflow-hidden border border-slate-100 shadow-sm card-hover flex flex-col group">
                <div class="relative h-48 overflow-hidden bg-slate-100">
                    <img src="{{ asset('frontend/img/default-slider-2.png') }}" alt="Berita Proklim" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-2">
                            <i class="fa-regular fa-calendar-check text-[#00E58F]"></i>
                            <span>28 Jul 2026</span>
                            <span class="mx-1">•</span>
                            <span class="text-[#00E58F]">Penghargaan</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 leading-snug group-hover:text-[#00E58F] transition-colors">
                            DLHK Kalbar Targetkan 500 Kampung Iklim Aktif Sebelum Tahun 2030
                        </h3>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mt-2">
                            Dinas Lingkungan Hidup dan Kehutanan Provinsi Kalimantan Barat memberikan apresiasi tinggi kepada 15 lokasi Proklim berprestasi.
                        </p>
                    </div>
                    <div class="pt-2 border-t border-slate-100 flex items-center text-xs font-bold text-[#00E58F]">
                        <span>Baca Selengkapnya</span>
                        <i class="fa-solid fa-chevron-right text-[10px] ml-1.5 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            </article>

            <!-- News Card 3 -->
            <article class="bg-white rounded-xl overflow-hidden border border-slate-100 shadow-sm card-hover flex flex-col group">
                <div class="relative h-48 overflow-hidden bg-slate-100">
                    <img src="{{ asset('frontend/img/default-slider-3.png') }}" alt="Berita Proklim" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-2">
                            <i class="fa-regular fa-calendar-check text-[#00E58F]"></i>
                            <span>14 Jul 2026</span>
                            <span class="mx-1">•</span>
                            <span class="text-[#00E58F]">Mitigasi</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 leading-snug group-hover:text-[#00E58F] transition-colors">
                            DLHK Kalbar Targetkan 500 Kampung Iklim Aktif Sebelum Tahun 2030
                        </h3>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mt-2">
                            Pengolahan limbah organik menjadi biogas pengganti bahan bakar LPG di Kabupaten Kubu Raya.
                        </p>
                    </div>
                    <div class="pt-2 border-t border-slate-100 flex items-center text-xs font-bold text-[#00E58F]">
                        <span>Baca Selengkapnya</span>
                        <i class="fa-solid fa-chevron-right text-[10px] ml-1.5 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            </article>
        </div>

        <!-- Center Action Button ("Lihat Berita Lainnya >") -->
        <div class="text-center pt-8">
            <a href="{{ route('berita') }}" class="px-6 py-3 rounded-xl bg-[#00E58F] hover:bg-[#00d080] text-white font-extrabold text-xs sm:text-sm inline-flex items-center gap-2 shadow-md transition-all hover:scale-105">
                <span>Lihat Berita Lainnya</span>
                <i class="fa-solid fa-chevron-right text-[11px]"></i>
            </a>
        </div>
    </section>

    <!-- 5. AIR QUALITY ISPU BANNER SECTION -->
    <section class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 pt-4">
        <div class="text-center space-y-4 max-w-4xl mx-auto">
            <span class="text-xs font-bold uppercase tracking-widest text-[#00E58F]">AKSES DATA</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Ketahui Informasi Mengenai ISPU (Indeks Standar Pencemaran Udara)
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-2xl mx-auto">
                Pantau kondisi kualitas udara secara berkala di berbagai kota dan kabupaten se-Kalimantan Barat. Dapatkan informasi parameter zat pencemar udara terkini untuk mendukung aktivitas harian yang lebih sehat
            </p>
            <div class="pt-2">
                <a href="{{ route('data') }}" class="px-6 py-3 rounded-xl bg-[#00E58F] hover:bg-[#00d080] text-white font-extrabold text-xs sm:text-sm inline-flex items-center gap-2 shadow-md transition-all hover:scale-105">
                    <span>Kunjungi Halaman</span>
                    <i class="fa-solid fa-chevron-right text-[11px]"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- 6. REGULATION BANNER -->
    <section class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10">
        <div class="bg-[#004A33] text-white rounded-xl p-8 sm:p-10 lg:p-12 shadow-xl flex flex-col lg:flex-row items-center justify-between gap-6">
            <div class="space-y-2 text-center lg:text-left max-w-2xl">
                <span class="text-xs font-bold uppercase tracking-wider text-[#00E58F]">AKSES DATA TERBUKA</span>
                <h3 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">
                    Ketahui Peraturan Desa & Tata Kelola Baku
                </h3>
                <p class="text-xs sm:text-sm text-slate-100/90 leading-relaxed">
                    Unduh draf regulasi, surat keputusan pimpinan daerah, serta buku saku petunjuk teknis pendaftaran SRN KLHK untuk memperlancar aksi nyata kampung iklim Anda.
                </p>
            </div>
            <div class="shrink-0">
                <a href="{{ route('regulasi') }}" class="px-6 py-3 rounded-xl bg-white hover:bg-slate-100 text-[#004A33] font-extrabold text-xs sm:text-sm inline-flex items-center gap-2 shadow-md transition-all hover:scale-105">
                    <span>Lihat Dokumen & Regulasi</span>
                    <i class="fa-solid fa-chevron-right text-[11px] text-[#004A33]"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- 7. OFFICIAL DLHK WEBSITE CARD SECTION -->
    <section class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10">
        <div class="bg-[#004A33] text-white rounded-xl p-8 sm:p-12 text-center space-y-4 max-w-4xl mx-auto shadow-xl">
            <span class="text-xs font-bold uppercase tracking-wider text-[#00E58F]">DLHK KALIMANTAN BARAT</span>
            <h3 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">
                Website Resmi DLHK Kalimantan Barat
            </h3>
            <p class="text-xs sm:text-sm text-slate-100/90 leading-relaxed max-w-2xl mx-auto">
                Lihat informasi lengkap lainnya mengenai DLHK Kalimantan Barat melalui website resmi Dinas Lingkungan Hidup dan Kehutana Provinsi Kalimantan Barat
            </p>
            <div class="pt-2">
                <a href="https://dlhk.kalbarprov.go.id" target="_blank" class="px-6 py-3 rounded-xl bg-white hover:bg-slate-100 text-[#004A33] font-extrabold text-xs sm:text-sm inline-flex items-center gap-2 shadow-md transition-all hover:scale-105">
                    <span>Buka Website</span>
                    <i class="fa-solid fa-chevron-right text-[11px] text-[#004A33]"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- 8. VISITOR COUNTER SECTION (Narrower Centered Container max-w-4xl) -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="space-y-1 text-center sm:text-left">
                <h3 class="text-2xl sm:text-3xl font-extrabold text-[#033B26] tracking-tight">Kunjungi Website</h3>
                <p class="text-xs sm:text-sm text-slate-500 font-medium leading-relaxed">
                    Total akumulasi aktivitas kunjungan per-bulan dari<br class="hidden sm:inline" /> seluruh pengguna
                </p>
            </div>
            <div class="bg-[#033B26] text-white px-7 py-5 rounded-xl flex items-center justify-between gap-8 sm:gap-12 shadow-md shrink-0">
                <div class="text-left space-y-0.5">
                    <span class="text-[11px] font-bold text-white uppercase block tracking-wider">TOTAL KUNJUNGAN WEBSITE</span>
                    <span class="text-xs text-white/95 font-medium block">Februari 2026</span>
                </div>
                <span class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white">413.939</span>
            </div>
        </div>
    </section>

</div>
@endsection

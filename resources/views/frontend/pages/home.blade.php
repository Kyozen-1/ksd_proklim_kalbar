@extends('frontend.layouts.main')

@section('title', 'Beranda Utama - DLHK Proklim Kalimantan Barat')

@section('content')
@php
    $defaultHero = [
        'eyebrow' => 'AKSI IKLIM TANGGUH KALIMANTAN BARAT',
        'title' => 'Bersama Menjaga Bumi dari',
        'subtitle' => 'Tapak Desa',
        'description' => 'PROKLIM (Program Kampung Iklim) Kalbar adalah gerakan kemasyarakatan berkelanjutan bentukan DLHK Kalbar guna meningkatkan kapasitas adaptasi, menurunkan emisi karbon, dan menciptakan kemandirian ekologis tangguh bencana tingkat RW/Dusun.',
        'button_text' => 'Pelajari Cara Kerja',
        'button_link' => route('about'),
        'secondary_button_text' => 'PROKLIM',
        'secondary_button_link' => route('data'),
    ];
    $heroSlides = collect($homeSlides ?? []);
    if ($heroSlides->isEmpty()) {
        $heroSlides = collect([
            array_merge($defaultHero, ['image_url' => asset('frontend/img/default-slider-1.png')]),
            array_merge($defaultHero, ['image_url' => asset('frontend/img/default-slider-2.png')]),
            array_merge($defaultHero, ['image_url' => asset('frontend/img/default-slider-3.png')]),
        ]);
    }

    $statsEyebrow = $homeStats['eyebrow'] ?? $homeStats['subtitle'] ?? 'CAPAIAN KOLEKTIF TERKINI';
    $statsTitle = $homeStats['title'] ?? 'Dampak Nyata Lapangan Kalimantan Barat';

    $functionTitle = $homeFunction['title'] ?? 'Tugas Bidang PSLB3PP';
    $functionDescription = $homeFunction['description'] ?? 'Bidang Pengelolaan Sampah, Limbah Bahan Berbahaya dan Beracun, serta Pengendalian Pencemaran (PSLB3PP) bertugas melaksanakan perumusan, koordinasi, dan evaluasi kebijakan teknis di bidang pengurangan dan penanganan sampah, pengelolaan limbah B3 (Bahan Berbahaya dan Beracun), serta pengendalian pencemaran';
    $functionEyebrow = $homeFunction['eyebrow'] ?? 'TUGAS DAN FUNGSI';
    $functionSubtitle = $homeFunction['subtitle'] ?? 'Fungsi Bidang PSLB3PP';
    $functionItems = collect($homeFunctionItems ?? []);
    if ($functionItems->isEmpty()) {
        $functionItems = collect([
            ['title' => 'Pengelolaan Sampah', 'description' => 'Membentuk kelompok kerja / kepengurusan Program Kampung Iklim tingkat dusun/desa yang disahkan berupa Surat Keputusan (SK) Kepala Desa atau Lurah.'],
            ['title' => 'Pembinaan & Pengurangan Timbunan Sampah', 'description' => 'Melakukan pembinaan pembatasan timbunan sampah kepada produsen/industri dan mempromosikan ekonomi sirkular melalui gerakan daur ulang dan pemanfaatan kembali.'],
            ['title' => 'Pengelolaan Limbah B3', 'description' => 'Melakukan pengawasan dan pembinaan teknis terhadap kegiatan penyimpanan, pengumpulan, pemanfaatan, pengangkutan, hingga pengolahan limbah B3.'],
            ['title' => 'Perizinan & Pertimbangan Teknis', 'description' => 'Menyiapkan bahan pertimbangan teknis untuk perizinan pengumpulan dan pengangkutan limbah B3, serta penerbitan izin pendaur-ulangan sampah.'],
            ['title' => 'Pemantauan & Evaluasi', 'description' => 'Melakukan pemantauan dan evaluasi berkala terhadap Tempat Pemrosesan Akhir (TPA) sampah, sistem tanggap darurat, dan pencegahan pencemaran lingkungan.'],
        ]);
    }

    $newsEyebrow = $homeNews['eyebrow'] ?? $homeNews['subtitle'] ?? 'KABAR & BERITA TERKINI';
    $newsTitle = $homeNews['title'] ?? 'Berita Proklim & Aksi Iklim Kalbar';
    $newsButtonText = $homeNews['button_text'] ?? 'Lihat Berita Lainnya';
    $newsButtonLink = $homeNews['button_link'] ?? route('berita');

    $ispuTitle = $homeIspu['title'] ?? 'Ketahui Informasi Mengenai ISPU (Indeks Standar Pencemaran Udara)';
    $ispuDescription = $homeIspu['description'] ?? 'Pantau kondisi kualitas udara secara berkala di berbagai kota dan kabupaten se-Kalimantan Barat. Dapatkan informasi parameter zat pencemar udara terkini untuk mendukung aktivitas harian yang lebih sehat';
    $ispuButtonText = $homeIspu['button_text'] ?? 'Kunjungi Halaman';
    $ispuButtonLink = $homeIspu['button_link'] ?? route('data');
    $ispuEyebrow = $homeIspu['eyebrow'] ?? $homeIspu['subtitle'] ?? 'AKSES DATA';

    $regulationTitle = $homeRegulation['title'] ?? 'Ketahui Peraturan Desa & Tata Kelola Baku';
    $regulationDescription = $homeRegulation['description'] ?? 'Unduh draf regulasi, surat keputusan pimpinan daerah, serta buku saku petunjuk teknis pendaftaran SRN KLHK untuk memperlancar aksi nyata kampung iklim Anda.';
    $regulationButtonText = $homeRegulation['button_text'] ?? 'Lihat Dokumen & Regulasi';
    $regulationButtonLink = $homeRegulation['button_link'] ?? route('regulasi');
    $regulationEyebrow = $homeRegulation['eyebrow'] ?? $homeRegulation['subtitle'] ?? 'AKSES DATA TERBUKA';

    $officialTitle = $homeOfficial['title'] ?? 'Website Resmi DLHK Kalimantan Barat';
    $officialDescription = $homeOfficial['description'] ?? 'Lihat informasi lengkap lainnya mengenai DLHK Kalimantan Barat melalui website resmi Dinas Lingkungan Hidup dan Kehutanan Provinsi Kalimantan Barat';
    $officialButtonText = $homeOfficial['button_text'] ?? 'Buka Website';
    $officialButtonLink = $homeOfficial['button_link'] ?? 'https://dlhk.kalbarprov.go.id';
    $officialEyebrow = $homeOfficial['eyebrow'] ?? $homeOfficial['subtitle'] ?? 'DLHK KALIMANTAN BARAT';

    $visitorTitle = $homeVisitor['title'] ?? 'Kunjungi Website';
    $visitorDescription = $homeVisitor['description'] ?? 'Total akumulasi aktivitas kunjungan per-bulan dari seluruh pengguna';
    $visitorLabel = $homeVisitor['label'] ?? 'TOTAL KUNJUNGAN WEBSITE';
    $visitorSubtitle = ($visitorStats['month_label'] ?? now()->locale('id')->translatedFormat('F Y'))
        .': '.number_format($visitorStats['monthly'] ?? 0, 0, ',', '.').' kunjungan';
    $visitorCount = number_format($visitorStats['total'] ?? 0, 0, ',', '.');
@endphp
<div class="space-y-16 py-6 sm:py-8">

    <!-- 1. HERO SLIDER SECTION CARD -->
    <section class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10">
        <div x-data="{
                activeSlide: 0,
                totalSlides: {{ $heroSlides->count() }},
                timer: null,
                startAutoplay() {
                    if (this.totalSlides < 2) return;
                    this.timer = setInterval(() => {
                        this.activeSlide = this.activeSlide === this.totalSlides - 1 ? 0 : this.activeSlide + 1;
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

            <!-- CMS-driven background slides -->
            <div class="absolute inset-0 z-0">
                @foreach($heroSlides as $slideIndex => $slide)
                    @php
                        $slideImage = $slide['image_url'] ?? asset('frontend/img/default-slider-'.(($slideIndex % 3) + 1).'.png');
                    @endphp
                    <div x-show="activeSlide === {{ $slideIndex }}"
                         x-transition:enter="transition ease-out duration-700"
                         x-transition:enter-start="opacity-0 scale-102"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-500"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-98"
                         class="absolute inset-0 bg-cover bg-right lg:bg-center"
                         style="background-image: url('{{ $slideImage }}');{{ $slideIndex > 0 ? ' display: none;' : '' }}">
                    </div>
                @endforeach

                <!-- Mobile Gradient Fade -->
                <div class="absolute inset-0 bg-gradient-to-r from-slate-950/85 via-slate-950/50 to-transparent lg:hidden"></div>
            </div>

            @foreach($heroSlides as $slideIndex => $slide)
                <!-- CMS-driven slide content -->
                <div x-show="activeSlide === {{ $slideIndex }}"
                     x-transition.opacity.duration.500ms
                     class="relative z-10 w-full p-8 sm:p-12 lg:p-16 max-w-3xl space-y-6"
                     style="{{ $slideIndex > 0 ? 'display: none;' : '' }}">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('frontend/img/logo_pemprov_kalbar.webp') }}"
                                 alt="Logo Pemprov Kalbar"
                                 class="h-9 w-auto object-contain">
                            <span class="text-xs sm:text-sm font-extrabold text-white tracking-wide uppercase leading-tight">
                                Pemerintah Provinsi <br />Kalimantan Barat
                            </span>
                        </div>

                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#00E58F]/20 border border-[#00E58F]/50 text-[#00E58F] text-[11px] sm:text-xs font-bold tracking-wider uppercase">
                            <i class="fa-solid {{ $slide['icon'] ?? 'fa-cloud-sun' }} text-xs"></i>
                            <span>{{ $slide['eyebrow'] ?? $defaultHero['eyebrow'] }}</span>
                        </div>
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-[1.12]">
                        {{ $slide['title'] ?? $defaultHero['title'] }} <br />
                        <span class="text-[#00E58F]">{{ $slide['subtitle'] ?? $defaultHero['subtitle'] }}</span>
                    </h1>

                    <p class="text-slate-200/95 text-xs sm:text-sm leading-relaxed max-w-xl font-normal">
                        {{ $slide['description'] ?? $defaultHero['description'] }}
                    </p>

                    <div class="pt-2 flex items-center gap-3">
                        <a href="{{ $slide['secondary_button_link'] ?? $defaultHero['secondary_button_link'] }}" class="px-5 py-2.5 rounded-xl bg-slate-900/60 hover:bg-slate-900 text-white font-bold border border-slate-400/30 text-xs sm:text-sm backdrop-blur-md transition-all">
                            {{ $slide['secondary_button_text'] ?? $defaultHero['secondary_button_text'] }}
                        </a>
                        <a href="{{ $slide['button_link'] ?? $defaultHero['button_link'] }}" class="px-5 py-2.5 rounded-xl bg-[#00E58F] hover:bg-[#00d080] text-slate-950 font-extrabold text-xs sm:text-sm inline-flex items-center gap-1.5 shadow-lg transition-all hover:scale-105">
                            <span>{{ $slide['button_text'] ?? $defaultHero['button_text'] }}</span>
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            @endforeach

        </div>
    </section>

    <!-- 2. STATS CARDS SECTION ("CAPAIAN KOLEKTIF TERKINI") -->
    <section class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10">
        <div class="text-center max-w-2xl mx-auto mb-8 space-y-2">
            <span class="text-xs sm:text-sm font-bold uppercase tracking-widest text-[#00A86B]">{{ $statsEyebrow }}</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                {{ $statsTitle }}
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($stats as $stat)
                <div class="bg-[#FAFCFA] rounded-xl p-5 sm:p-6 border-2 border-[#7AE3BC]/80 shadow-xs flex flex-col justify-between space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl bg-[#00A86B] text-white flex items-center justify-center text-3xl sm:text-4xl font-bold shrink-0 shadow-md">
                            <i class="fa-solid {{ $stat['icon'] }}"></i>
                        </div>
                        <div class="min-w-0 flex-1 my-auto">
                            <span class="text-[11px] sm:text-xs font-bold text-[#00A86B] tracking-wide uppercase block truncate">{{ $stat['label'] }}</span>
                            <div class="flex items-baseline flex-wrap gap-1 mt-0.5">
                                <span class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">{{ $stat['value'] }}</span>
                                <span class="text-[11px] sm:text-xs font-semibold text-slate-500">{{ $stat['unit'] }}</span>
                            </div>
                        </div>
                    </div>
                    @if($stat['meta'] !== '')
                        <div class="pt-1 flex justify-start">
                            <span class="px-3 py-1 rounded-full text-[11px] sm:text-xs font-bold bg-[#D8F5EA] text-[#00A86B] border border-[#A3EED4] whitespace-nowrap">
                                {{ $stat['meta'] }}
                            </span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

    <!-- 3. TUGAS DAN FUNGSI PSLB3PP SECTION -->
    <section class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10">
        <div class="bg-[#004A33] text-white rounded-xl p-8 sm:p-12 lg:p-16 space-y-12 shadow-xl">
            
            <!-- Top Header -->
            <div class="text-center max-w-4xl mx-auto space-y-3">
                <span class="text-xs font-bold uppercase tracking-wider text-[#00E58F]">{{ $functionEyebrow }}</span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold tracking-tight text-white">
                    {{ $functionTitle }}
                </h2>
                <p class="text-slate-100/90 text-xs sm:text-sm leading-relaxed max-w-3xl mx-auto pt-1 font-normal">
                    {{ $functionDescription }}
                </p>
            </div>

            <!-- Subheading -->
            <div class="text-center pt-2">
                <h3 class="text-xl sm:text-2xl font-bold text-white tracking-tight">
                    {{ $functionSubtitle }}
                </h3>
            </div>

            <!-- Repeatable CMS items -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 lg:gap-8">
                @foreach($functionItems as $functionIndex => $functionItem)
                    <div class="space-y-3 text-left">
                        <div class="w-12 h-12 rounded-full bg-white text-[#004A33] font-extrabold flex items-center justify-center text-xl shadow-md">
                            {{ $functionIndex + 1 }}
                        </div>
                        <h4 class="text-sm sm:text-base font-bold text-white leading-snug">
                            {{ $functionItem['title'] ?? 'Fungsi PSLB3PP' }}
                        </h4>
                        <p class="text-xs text-slate-200/85 leading-relaxed">
                            {{ $functionItem['description'] ?? '' }}
                        </p>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    <!-- 4. NEWS SECTION ("Berita Proklim & Aksi Iklim Kalbar") -->
    <section class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <span class="text-xs font-bold uppercase tracking-widest text-[#00E58F]">{{ $newsEyebrow }}</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                {{ $newsTitle }}
            </h2>
        </div>

        @if($latestNews->count())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($latestNews as $news)
                    @php
                        $cover = $news->pivot_gambar_berita->first();
                        $imageUrl = $cover ? route('frontend.berita.image', $cover->id) : asset('frontend/img/default-slider-1.png');
                    @endphp
                    <a href="{{ route('berita-detail', $news->id) }}" class="bg-white rounded-xl overflow-hidden border border-slate-100 shadow-sm card-hover flex flex-col group">
                        <div class="relative h-48 overflow-hidden bg-slate-100">
                            <img src="{{ $imageUrl }}" alt="{{ $news->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                            <div>
                                <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-2">
                                    <i class="fa-regular fa-calendar-check text-[#00E58F]"></i>
                                    <span>{{ optional($news->created_at)->translatedFormat('d M Y') }}</span>
                                    <span class="mx-1">-</span>
                                    <span class="text-[#00E58F]">Berita</span>
                                </div>
                                <h3 class="text-base font-bold text-slate-900 leading-snug group-hover:text-[#00E58F] transition-colors">
                                    {{ $news->judul }}
                                </h3>
                                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mt-2">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($news->deskripsi), 120) }}
                                </p>
                            </div>
                            <div class="pt-2 border-t border-slate-100 flex items-center text-xs font-bold text-[#00E58F]">
                                <span>Baca Selengkapnya</span>
                                <i class="fa-solid fa-chevron-right text-[10px] ml-1.5 group-hover:translate-x-1 transition-transform"></i>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="bg-white border border-slate-200 rounded-2xl p-8 text-center text-sm text-slate-500">
                Belum ada berita aktif yang diterbitkan dari CMS.
            </div>
        @endif

        <!-- Center Action Button ("Lihat Berita Lainnya >") -->
        <div class="text-center pt-8">
            <a href="{{ $newsButtonLink }}" class="px-6 py-3 rounded-xl bg-[#00E58F] hover:bg-[#00d080] text-white font-extrabold text-xs sm:text-sm inline-flex items-center gap-2 shadow-md transition-all hover:scale-105">
                <span>{{ $newsButtonText }}</span>
                <i class="fa-solid fa-chevron-right text-[11px]"></i>
            </a>
        </div>
    </section>

    <!-- 5. AIR QUALITY ISPU BANNER SECTION -->
    <section class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 pt-4">
        <div class="text-center space-y-4 max-w-4xl mx-auto">
            <span class="text-xs font-bold uppercase tracking-widest text-[#00E58F]">{{ $ispuEyebrow }}</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                {{ $ispuTitle }}
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-2xl mx-auto">
                {{ $ispuDescription }}
            </p>
            <div class="pt-2">
                <a href="{{ $ispuButtonLink }}" class="px-6 py-3 rounded-xl bg-[#00E58F] hover:bg-[#00d080] text-white font-extrabold text-xs sm:text-sm inline-flex items-center gap-2 shadow-md transition-all hover:scale-105">
                    <span>{{ $ispuButtonText }}</span>
                    <i class="fa-solid fa-chevron-right text-[11px]"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- 6. REGULATION BANNER -->
    <section class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10">
        <div class="bg-[#004A33] text-white rounded-xl p-8 sm:p-10 lg:p-12 shadow-xl flex flex-col lg:flex-row items-center justify-between gap-6">
            <div class="space-y-2 text-center lg:text-left max-w-2xl">
                <span class="text-xs font-bold uppercase tracking-wider text-[#00E58F]">{{ $regulationEyebrow }}</span>
                <h3 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">
                    {{ $regulationTitle }}
                </h3>
                <p class="text-xs sm:text-sm text-slate-100/90 leading-relaxed">
                    {{ $regulationDescription }}
                </p>
            </div>
            <div class="shrink-0">
                <a href="{{ $regulationButtonLink }}" class="px-6 py-3 rounded-xl bg-white hover:bg-slate-100 text-[#004A33] font-extrabold text-xs sm:text-sm inline-flex items-center gap-2 shadow-md transition-all hover:scale-105">
                    <span>{{ $regulationButtonText }}</span>
                    <i class="fa-solid fa-chevron-right text-[11px] text-[#004A33]"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- 7. OFFICIAL DLHK WEBSITE CARD SECTION -->
    <section class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10">
        <div class="bg-[#004A33] text-white rounded-xl p-8 sm:p-12 text-center space-y-4 max-w-4xl mx-auto shadow-xl">
            <span class="text-xs font-bold uppercase tracking-wider text-[#00E58F]">{{ $officialEyebrow }}</span>
            <h3 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">
                {{ $officialTitle }}
            </h3>
            <p class="text-xs sm:text-sm text-slate-100/90 leading-relaxed max-w-2xl mx-auto">
                {{ $officialDescription }}
            </p>
            <div class="pt-2">
                <a href="{{ $officialButtonLink }}" target="_blank" rel="noopener noreferrer" class="px-6 py-3 rounded-xl bg-white hover:bg-slate-100 text-[#004A33] font-extrabold text-xs sm:text-sm inline-flex items-center gap-2 shadow-md transition-all hover:scale-105">
                    <span>{{ $officialButtonText }}</span>
                    <i class="fa-solid fa-chevron-right text-[11px] text-[#004A33]"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- 8. VISITOR COUNTER SECTION (Narrower Centered Container max-w-4xl) -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="space-y-1 text-center sm:text-left">
                <h3 class="text-2xl sm:text-3xl font-extrabold text-[#033B26] tracking-tight">{{ $visitorTitle }}</h3>
                <p class="text-xs sm:text-sm text-slate-500 font-medium leading-relaxed">
                    {{ $visitorDescription }}
                </p>
            </div>
            <div class="bg-[#033B26] text-white px-7 py-5 rounded-xl flex items-center justify-between gap-8 sm:gap-12 shadow-md shrink-0">
                <div class="text-left space-y-0.5">
                    <span class="text-[11px] font-bold text-white uppercase block tracking-wider">{{ $visitorLabel }}</span>
                    <span class="text-xs text-white/95 font-medium block">{{ $visitorSubtitle }}</span>
                </div>
                <span class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white">{{ $visitorCount }}</span>
            </div>
        </div>
    </section>

</div>
@endsection

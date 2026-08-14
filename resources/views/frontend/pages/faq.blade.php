@extends('frontend.layouts.main')

@section('title', 'Frequently Asked Questions - DLHK Proklim Kalimantan Barat')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 space-y-12 py-8 sm:py-12">

    <!-- BADGE AND PAGE HEADER -->
    <section class="text-center space-y-3 max-w-4xl mx-auto">
        <div class="inline-block">
            <span class="px-4 py-1.5 rounded-full border border-[#7AE3BC]/70 text-[#00A86B] text-[11px] font-extrabold uppercase tracking-widest bg-[#E6F9F2]">
                FAQ
            </span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-snug">
            Frequently Asked Questions
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed max-w-3xl mx-auto font-normal">
            Menyajikan informasi terkait PSLB3PP, Proklim, dan lain-lain
        </p>
    </section>

    <!-- ACCORDION SECTION (CENTERED) -->
    <section class="max-w-5xl mx-auto">
        <div x-data="{ activeFaq: 1 }" class="space-y-4">
            
            <!-- FAQ Item 1 -->
            <div class="space-y-2">
                <button @click="activeFaq = activeFaq === 1 ? null : 1" 
                        class="w-full flex items-center justify-between p-5 rounded-xl bg-[#E6F9F2] hover:bg-[#d5f5e8] transition-all duration-200 text-left font-bold text-slate-800 text-xs sm:text-sm md:text-base leading-snug cursor-pointer gap-4">
                    <span>Apa hubungan antara aksi pengelolaan sampah di bawah Ditjen PSLB3 dengan penilaian Program Kampung Iklim (ProKlim)?</span>
                    <i class="fa-solid text-slate-500 transition-transform duration-200 text-sm" 
                       :class="activeFaq === 1 ? 'fa-chevron-up rotate-180' : 'fa-chevron-down'"></i>
                </button>
                <div x-show="activeFaq === 1" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="p-5 sm:p-6 text-xs sm:text-sm text-slate-600 leading-relaxed font-normal bg-transparent">
                    Sangat erat. Pengelolaan sampah (seperti pemilahan dari sumber, pengomposan, dan aktivasi Bank Sampah) merupakan salah satu indikator utama dalam komponen Mitigasi Perubahan Iklim di ProKlim. Keberhasilan pengelolaan sampah yang terdata di bawah Ditjen PSLB3 akan langsung mendongkrak poin penilaian kategori ProKlim di wilayah Anda.
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="space-y-2">
                <button @click="activeFaq = activeFaq === 2 ? null : 2" 
                        class="w-full flex items-center justify-between p-5 rounded-xl bg-[#E6F9F2] hover:bg-[#d5f5e8] transition-all duration-200 text-left font-bold text-slate-800 text-xs sm:text-sm md:text-base leading-snug cursor-pointer gap-4">
                    <span>Wilayah kami memiliki Bank Sampah aktif dan unit ProKlim baru. Apakah kami harus membuat dua akun laporan yang berbeda?</span>
                    <i class="fa-solid text-slate-500 transition-transform duration-200 text-sm" 
                       :class="activeFaq === 2 ? 'fa-chevron-up rotate-180' : 'fa-chevron-down'"></i>
                </button>
                <div x-show="activeFaq === 2" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="p-5 sm:p-6 text-xs sm:text-sm text-slate-600 leading-relaxed font-normal bg-transparent">
                    Ya, laporan Bank Sampah dikelola melalui sistem pelaporan sampah nasional, sedangkan pendaftaran ProKlim dilakukan melalui SRN LHK. Namun, kedua data tersebut akan diintegrasikan oleh dinas untuk verifikasi penghargaan tingkat provinsi.
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="space-y-2">
                <button @click="activeFaq = activeFaq === 3 ? null : 3" 
                        class="w-full flex items-center justify-between p-5 rounded-xl bg-[#E6F9F2] hover:bg-[#d5f5e8] transition-all duration-200 text-left font-bold text-slate-800 text-xs sm:text-sm md:text-base leading-snug cursor-pointer gap-4">
                    <span>Wilayah kami memiliki Bank Sampah aktif dan unit ProKlim baru. Apakah kami harus membuat dua akun laporan yang berbeda?</span>
                    <i class="fa-solid text-slate-500 transition-transform duration-200 text-sm" 
                       :class="activeFaq === 3 ? 'fa-chevron-up rotate-180' : 'fa-chevron-down'"></i>
                </button>
                <div x-show="activeFaq === 3" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="p-5 sm:p-6 text-xs sm:text-sm text-slate-600 leading-relaxed font-normal bg-transparent">
                    Ya, laporan Bank Sampah dikelola melalui sistem pelaporan sampah nasional, sedangkan pendaftaran ProKlim dilakukan melalui SRN LHK. Namun, kedua data tersebut akan diintegrasikan oleh dinas untuk verifikasi penghargaan tingkat provinsi.
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="space-y-2">
                <button @click="activeFaq = activeFaq === 4 ? null : 4" 
                        class="w-full flex items-center justify-between p-5 rounded-xl bg-[#E6F9F2] hover:bg-[#d5f5e8] transition-all duration-200 text-left font-bold text-slate-800 text-xs sm:text-sm md:text-base leading-snug cursor-pointer gap-4">
                    <span>Apakah desa/kelurahan yang rutin melaporkan pengelolaan sampah B3 domestik dan menjalankan ProKlim akan mendapatkan bantuan dana langsung?</span>
                    <i class="fa-solid text-slate-500 transition-transform duration-200 text-sm" 
                       :class="activeFaq === 4 ? 'fa-chevron-up rotate-180' : 'fa-chevron-down'"></i>
                </button>
                <div x-show="activeFaq === 4" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="p-5 sm:p-6 text-xs sm:text-sm text-slate-600 leading-relaxed font-normal bg-transparent">
                    Dinas Lingkungan Hidup memberikan prioritas bantuan sarana prasarana pengolahan sampah (seperti motor sampah, komposter, dan bibit tanaman) serta pendampingan teknis gratis bagi desa yang aktif melaporkan pengelolaan lingkungannya.
                </div>
            </div>

        </div>
    </section>

</div>
@endsection

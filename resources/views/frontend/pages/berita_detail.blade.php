@extends('frontend.layouts.main')

@section('title', 'Detail Berita - DLHK Proklim Kalimantan Barat')

@section('content')
<!-- Back Button Section -->
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 pt-6">
    <a href="{{ route('berita') }}" class="text-[#00A86B] hover:text-[#00905b] font-bold text-sm inline-flex items-center gap-1.5 transition-all">
        <i class="fa-solid fa-chevron-left text-xs"></i>
        <span>Kembali</span>
    </a>
</div>

<!-- Main Single Column Article Section (Maximum Width 1440px & Increased Font Sizes) -->
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 pb-16 pt-4 space-y-8">
    
    <!-- Center/Full Width Image -->
    <div class="w-full h-64 sm:h-96 lg:h-[520px] rounded-xl overflow-hidden bg-slate-100">
        <img src="https://images.unsplash.com/photo-1542273917363-3b1817f69a2d?q=80&w=1440&auto=format&fit=crop" 
             alt="DLHK Kalbar Targetkan 500 Kampung Iklim Aktif Sebelum Tahun 2029" 
             class="w-full h-full object-cover">
    </div>

    <!-- Metadata Line -->
    <div class="flex items-center gap-4 text-xs sm:text-sm lg:text-base text-slate-400 font-semibold">
        <span class="inline-flex items-center gap-1.5">
            <i class="fa-regular fa-calendar text-[#00A86B] text-sm lg:text-base"></i> 24 Mei 2026
        </span>
        <span class="inline-flex items-center gap-1.5">
            <i class="fa-regular fa-user text-[#00A86B] text-sm lg:text-base"></i> Humas PSLB3PP
        </span>
    </div>

    <!-- Headline -->
    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 leading-snug tracking-tight">
        DLHK Kalbar Targetkan 500 Kampung Iklim Aktif Sebelum Tahun 2029
    </h1>

    <!-- Article Body Content -->
    <div class="space-y-6 text-sm sm:text-base lg:text-lg text-slate-600 leading-relaxed lg:leading-loose font-normal">
        <p>
            Dalam komitmen menurunkan emisi gas rumah kaca daerah, DLHK Kalimantan Barat menggelar rapat koordinasi teknis bersama jajaran Bupati dan Wali Kota. Kepala Dinas menyatakan bahwa Kalimantan Barat memiliki kekayaan ekologis luar biasa yang di dalamnya terdapat potensi besar serapan karbon. Melalui perluasan Kampung Iklim, aksi adaptasi seperti perlindungan sumber air, ketahanan pangan lokal, dan pengolahan limbah akan menjadi standar kemandirian masing-masing desa. Dinas akan memberikan bantuan alat pengomposan, bibit tanaman tumpang sari, serta pendampingan registrasi SRN KLHK secara gratis.
        </p>
        <p>
            Program Kampung Iklim (Proklim) yang dikoordinasikan secara penuh oleh Dinas Lingkungan Hidup dan Kehutanan (DLHK) Kalimantan Barat berkomitmen tinggi menyalurkan sarana dan pendampingan lapangan agar setiap kampung binaan mampu lolos validasi SRN LHK tingkat nasional.
        </p>
        <p>
            Partisipasi aktif dari kaum pemuda, ibu-ibu tani, hingga jajaran rukun tetangga terbukti mampu memangkas kesalahpahaman penanganan limbah secara drastis serta mengukuhkan fondasi pertahanan pangan yang mandiri, sehat, tangguh, dan lestari di masa depan.
        </p>
    </div>

    <!-- Share/Bagikan Berita Link at the bottom -->
    <div class="pt-6 border-t border-slate-200/60">
        <button class="text-sm sm:text-base font-bold text-[#00A86B] hover:text-[#00905b] inline-flex items-center gap-1.5 transition-all cursor-pointer">
            <i class="fa-solid fa-share-nodes text-sm lg:text-base"></i>
            <span>Bagikan Berita</span>
        </button>
    </div>

</div>
@endsection

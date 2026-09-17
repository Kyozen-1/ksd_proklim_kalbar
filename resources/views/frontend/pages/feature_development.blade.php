@extends('frontend.layouts.main')

@section('title', $featureName . ' - Fitur Dalam Pengembangan')

@section('content')
<section class="min-h-[65vh] flex items-center justify-center px-4 sm:px-6 py-16 sm:py-24">
    <div class="w-full max-w-2xl text-center">
        <div class="w-16 h-16 mx-auto mb-6 rounded-full bg-[#DDF8EC] text-[#00A86B] flex items-center justify-center">
            <i class="fa-solid fa-screwdriver-wrench text-2xl" aria-hidden="true"></i>
        </div>

        <span class="inline-flex items-center px-3 py-1 rounded-full bg-white border border-emerald-200 text-[#00A86B] text-xs font-bold uppercase">
            {{ $featureName }}
        </span>

        <h1 class="mt-5 text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
            Fitur Dalam Pengembangan
        </h1>

        <p class="mt-4 text-sm sm:text-base text-slate-600 leading-relaxed max-w-xl mx-auto">
            {{ $featureDescription }}
        </p>

        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('home') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-lg bg-[#00A86B] hover:bg-[#008f5b] text-white text-sm font-bold transition-colors">
                <i class="fa-solid fa-house text-xs" aria-hidden="true"></i>
                <span>Kembali ke Beranda</span>
            </a>
            <a href="{{ route('edukasi') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-lg bg-white border border-slate-200 hover:border-emerald-300 text-slate-700 hover:text-[#00A86B] text-sm font-bold transition-colors">
                <i class="fa-solid fa-book-open text-xs" aria-hidden="true"></i>
                <span>Buka Edukasi</span>
            </a>
        </div>
    </div>
</section>
@endsection

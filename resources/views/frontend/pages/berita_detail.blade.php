@extends('frontend.layouts.main')

@section('title', $berita->judul.' - DLHK Proklim Kalimantan Barat')

@section('content')
@php
    $cover = $berita->pivot_gambar_berita->first();
    $imageUrl = $cover ? route('frontend.berita.image', $cover->id) : asset('frontend/img/default-slider-1.png');
@endphp

<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 pt-6">
    <a href="{{ route('berita') }}" class="text-[#00A86B] hover:text-[#00905b] font-bold text-sm inline-flex items-center gap-1.5 transition-all">
        <i class="fa-solid fa-chevron-left text-xs"></i>
        <span>Kembali</span>
    </a>
</div>

<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 pb-16 pt-4 space-y-8">
    <div class="w-full h-64 sm:h-96 lg:h-[520px] rounded-xl overflow-hidden bg-slate-100">
        <img src="{{ $imageUrl }}"
             alt="{{ $berita->judul }}"
             class="w-full h-full object-cover">
    </div>

    <div class="flex items-center gap-4 text-xs sm:text-sm lg:text-base text-slate-400 font-semibold">
        <span class="inline-flex items-center gap-1.5">
            <i class="fa-regular fa-calendar text-[#00A86B] text-sm lg:text-base"></i>
            {{ optional($berita->created_at)->translatedFormat('d M Y') }}
        </span>
        <span class="inline-flex items-center gap-1.5">
            <i class="fa-regular fa-user text-[#00A86B] text-sm lg:text-base"></i> Humas PSLB3PP
        </span>
    </div>

    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 leading-snug tracking-tight">
        {{ $berita->judul }}
    </h1>

    <div class="space-y-6 text-sm sm:text-base lg:text-lg text-slate-600 leading-relaxed lg:leading-loose font-normal">
        {!! $berita->deskripsi !!}
    </div>

    <div class="pt-6 border-t border-slate-200/60">
        <button type="button"
                onclick="navigator.share ? navigator.share({ title: @js($berita->judul), url: window.location.href }) : navigator.clipboard.writeText(window.location.href)"
                class="text-sm sm:text-base font-bold text-[#00A86B] hover:text-[#00905b] inline-flex items-center gap-1.5 transition-all cursor-pointer">
            <i class="fa-solid fa-share-nodes text-sm lg:text-base"></i>
            <span>Bagikan Berita</span>
        </button>
    </div>
</div>
@endsection

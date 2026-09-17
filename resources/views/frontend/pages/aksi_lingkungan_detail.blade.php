@extends('frontend.layouts.main')

@section('title', $kegiatan->judul.' - DLHK Proklim Kalimantan Barat')

@section('content')
@php
    $cover = $kegiatan->pivot_gambar_kegiatan->first();
    $imageUrl = $cover ? route('frontend.kegiatan.image', $cover->id) : asset('frontend/img/default-slider-2.png');
@endphp

<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 pt-6">
    <a href="{{ route('aksi-lingkungan') }}" class="text-[#00A86B] hover:text-[#00905b] font-bold text-sm inline-flex items-center gap-1.5 transition-all">
        <i class="fa-solid fa-chevron-left text-xs"></i>
        <span>Kembali ke Galeri Aksi</span>
    </a>
</div>

<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 space-y-12 pb-16 pt-4">

    <section class="text-center space-y-3 max-w-4xl mx-auto">
        <div class="inline-block">
            <span class="px-4 py-1.5 rounded-full border border-[#7AE3BC]/70 text-[#00A86B] text-[11px] font-extrabold uppercase tracking-widest bg-[#E6F9F2]">
                INFORMASI DETAIL LINGKUNGAN
            </span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-snug">
            {{ $kegiatan->judul }}
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed max-w-3xl mx-auto font-normal">
            {{ optional($kegiatan->kabupaten_kota)->name }} @if($kegiatan->tanggal) - {{ \Carbon\Carbon::parse($kegiatan->tanggal)->translatedFormat('d M Y') }} @endif
        </p>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12">
        <div class="lg:col-span-4 space-y-6">
            @forelse($relatedKegiatans as $related)
                @php
                    $relatedCover = $related->pivot_gambar_kegiatan->first();
                    $relatedImageUrl = $relatedCover ? route('frontend.kegiatan.image', $relatedCover->id) : asset('frontend/img/default-slider-2.png');
                @endphp
                <a href="{{ route('aksi-lingkungan-detail', $related->id) }}" class="bg-white border border-slate-200/70 rounded-xl overflow-hidden flex flex-col group transition-all shadow-md hover:shadow-lg block">
                    <div class="relative h-32 overflow-hidden bg-slate-100">
                        <img src="{{ $relatedImageUrl }}"
                             alt="{{ $related->judul }}"
                             class="w-full h-full object-cover">
                    </div>
                    <div class="p-5 space-y-2">
                        <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug group-hover:text-[#00A86B] transition-colors">
                            {{ $related->judul }}
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 font-normal leading-relaxed">
                            {{ \Illuminate\Support\Str::limit(strip_tags($related->deskripsi), 95) }}
                        </p>
                    </div>
                </a>
            @empty
                <div class="bg-white border border-slate-200/70 rounded-xl p-5 text-sm text-slate-500">
                    Belum ada kegiatan terkait.
                </div>
            @endforelse
        </div>

        <div class="lg:col-span-8">
            <article class="bg-white border border-slate-200/90 rounded-2xl shadow-md flex flex-col h-full overflow-hidden transition-all">
                <div class="w-full h-64 sm:h-80 lg:h-96 bg-slate-100 shrink-0">
                    <img src="{{ $imageUrl }}"
                         alt="{{ $kegiatan->judul }}"
                         class="w-full h-full object-cover">
                </div>

                <div class="p-6 sm:p-8 flex flex-col flex-grow space-y-6">
                    <div class="space-y-3 text-xs sm:text-sm text-slate-500 font-semibold">
                        @if($kegiatan->tempat)
                            <span class="inline-flex items-center gap-1.5 mr-4">
                                <i class="fa-solid fa-location-dot text-[#00A86B]"></i> {{ $kegiatan->tempat }}
                            </span>
                        @endif
                        @if($kegiatan->tanggal)
                            <span class="inline-flex items-center gap-1.5">
                                <i class="fa-regular fa-calendar text-[#00A86B]"></i> {{ \Carbon\Carbon::parse($kegiatan->tanggal)->translatedFormat('d M Y') }}
                            </span>
                        @endif
                    </div>

                    @if($kegiatan->alamat)
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                            {{ $kegiatan->alamat }}
                        </p>
                    @endif

                    @if($kegiatan->link_yt)
                        <div class="aspect-video rounded-xl overflow-hidden bg-slate-100">
                            <iframe src="{{ $kegiatan->link_yt }}" class="w-full h-full" title="{{ $kegiatan->judul }}" allowfullscreen></iframe>
                        </div>
                    @endif

                    <div class="space-y-4 text-xs sm:text-sm text-slate-500 leading-relaxed font-normal">
                        {!! $kegiatan->deskripsi !!}
                    </div>
                </div>
            </article>
        </div>
    </div>

</div>
@endsection

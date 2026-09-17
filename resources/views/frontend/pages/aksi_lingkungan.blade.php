@extends('frontend.layouts.main')

@section('title', 'Aksi Menjaga Kualitas Lingkungan - DLHK Proklim Kalimantan Barat')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 pt-6">
    <a href="{{ route('edukasi') }}" class="text-[#00A86B] hover:text-[#00905b] font-bold text-sm inline-flex items-center gap-1.5 transition-all">
        <i class="fa-solid fa-chevron-left text-xs"></i>
        <span>Kembali</span>
    </a>
</div>

<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 space-y-12 pb-16 pt-4">

    <section class="text-center space-y-3 max-w-4xl mx-auto">
        <div class="inline-block">
            <span class="px-4 py-1.5 rounded-full border border-[#7AE3BC]/70 text-[#00A86B] text-[11px] font-extrabold uppercase tracking-widest bg-[#E6F9F2]">
                INFORMASI JAGA LINGKUNGAN
            </span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-snug">
            Aksi Menjaga Kualitas Lingkungan
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed max-w-3xl mx-auto font-normal">
            Informasi panduan mengenai kontribusi nyata yang dapat dilakukan masyarakat secara mandiri di pekarangan atau lingkungan tempat tinggal
        </p>
    </section>

    @if($kegiatans->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @foreach($kegiatans as $kegiatan)
                @php
                    $cover = $kegiatan->pivot_gambar_kegiatan->first();
                    $imageUrl = $cover ? route('frontend.kegiatan.image', $cover->id) : asset('frontend/img/default-slider-2.png');
                @endphp
                <a href="{{ route('aksi-lingkungan-detail', $kegiatan->id) }}" class="bg-white border border-slate-200/70 rounded-xl overflow-hidden flex flex-col group transition-all shadow-md hover:shadow-lg">
                <div class="relative h-48 overflow-hidden bg-slate-100">
                    <img src="{{ $imageUrl }}"
                         alt="{{ $kegiatan->judul }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-5 space-y-2 flex-grow flex flex-col justify-between">
                    <div>
                        <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug group-hover:text-[#00A86B] transition-colors">
                            {{ $kegiatan->judul }}
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 font-normal leading-relaxed mt-2">
                            {{ \Illuminate\Support\Str::limit(strip_tags($kegiatan->deskripsi), 130) }}
                        </p>
                    </div>
                </div>
                </a>
            @endforeach
        </div>

        <div class="pt-10">
            {{ $kegiatans->links() }}
        </div>
    @else
        <div class="bg-white border border-slate-200 rounded-2xl p-8 text-center text-sm text-slate-500">
            Belum ada aksi lingkungan aktif yang diterbitkan dari CMS.
        </div>
    @endif

</div>
@endsection

@extends('frontend.layouts.main')

@section('title', 'Galeri Dokumentasi - DLHK Proklim Kalimantan Barat')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 space-y-12 py-8 sm:py-12">

    <section class="text-center space-y-4 max-w-4xl mx-auto">
        <div class="inline-block">
            <span class="px-4 py-1.5 rounded-full border border-[#7AE3BC]/70 text-[#00A86B] text-[11px] font-extrabold uppercase tracking-widest bg-[#E6F9F2]">
                GALERI
            </span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-snug">
            <span class="text-[#00D182]">Ruang Dokumentasi PSLB3PP:</span> Rekam Jejak Aksi<br class="hidden sm:inline" />
            Pengelolaan Limbah dan Penguatan Kapasitas
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed max-w-3xl mx-auto font-normal">
            Galeri visual rangkaian kegiatan DLHK yang dikelola melalui CMS.
        </p>
    </section>

    <section class="max-w-[1360px] mx-auto">
        @if($kegiatans->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach($kegiatans as $kegiatan)
                    @php
                        $cover = $kegiatan->pivot_gambar_kegiatan->first();
                        $imageUrl = $cover ? route('frontend.kegiatan.image', $cover->id) : asset('frontend/img/default-slider-2.png');
                    @endphp
                    <a href="{{ route('aksi-lingkungan-detail', $kegiatan->id) }}" class="h-48 sm:h-56 rounded-2xl overflow-hidden relative group shadow-md hover:shadow-lg transition-all cursor-pointer bg-slate-100 block">
                        <img src="{{ $imageUrl }}"
                             alt="{{ $kegiatan->judul }}"
                             class="w-full h-full object-cover">

                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex flex-col justify-between p-5 transition-all duration-300 z-20">
                            <div class="flex-grow flex items-center justify-center">
                                <div class="w-11 h-11 rounded-full bg-white/20 backdrop-blur-xs flex items-center justify-center border border-white/30 shadow-sm scale-90 group-hover:scale-100 transition-all duration-300">
                                    <i class="fa-regular fa-eye text-base text-white"></i>
                                </div>
                            </div>
                            <div class="space-y-1.5 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                                <h3 class="text-sm sm:text-base font-bold text-white leading-snug">
                                    {{ $kegiatan->judul }}
                                </h3>
                                <div class="flex items-center gap-4 text-[10px] sm:text-xs text-white/90 font-semibold">
                                    @if($kegiatan->tanggal)
                                        <span class="inline-flex items-center gap-1">
                                            <i class="fa-regular fa-calendar text-[#00E58F]"></i> {{ \Carbon\Carbon::parse($kegiatan->tanggal)->translatedFormat('d M Y') }}
                                        </span>
                                    @endif
                                    @if($kegiatan->kabupaten_kota)
                                        <span class="inline-flex items-center gap-1">
                                            <i class="fa-solid fa-location-dot text-[#00E58F]"></i> {{ $kegiatan->kabupaten_kota->name }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="pt-8">
                {{ $kegiatans->links() }}
            </div>
        @else
            <div class="bg-white border border-slate-200 rounded-2xl p-8 text-center text-sm text-slate-500">
                Belum ada galeri kegiatan aktif yang diterbitkan dari CMS.
            </div>
        @endif
    </section>

</div>
@endsection

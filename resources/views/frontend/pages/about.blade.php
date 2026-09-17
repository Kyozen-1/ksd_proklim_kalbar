@extends('frontend.layouts.main')

@section('title', 'Tentang PSLB3PP - DLHK Proklim Kalimantan Barat')

@section('content')
@php
    $profileBadge = $profile['subtitle'] ?? 'TENTANG PSLB3PP';
    $profileTitle = $profile['title'] ?? 'Penanganan Sampah, Limbah Bahan Berbahaya dan Beracun, serta Pengendalian Pencemaran';
    $profileDescription = $profile['description'] ?? 'Mengenal pilar birokrasi penjamin kelestarian sumber daya kehutanan, kebersihan perkotaan, dan aksi adaptasi ketangguhan iklim Kalimantan Barat';
    $definitionBadge = $definition['subtitle'] ?? 'PERAN PSLB3PP';
    $definitionTitle = $definition['title'] ?? 'Definisi Bidang';
    $definitionDescription = $definition['description'] ?? 'Bidang PSLB3PP (Penanganan Sampah, Limbah Bahan Berbahaya dan Beracun, serta Pengendalian Pencemaran) adalah unit yang bertanggung jawab dalam melaksanakan kebijakan, pengawasan, dan pembinaan teknis di bidang pengelolaan lingkungan, khususnya terkait sampah, limbah B3, serta pencegahan pencemaran lingkungan.';
    $functionBadge = $function['subtitle'] ?? 'TUGAS DAN FUNGSI';
    $functionTitle = $function['title'] ?? 'Tugas Bidang PSLB3PP';
    $functionDescription = $function['description'] ?? 'Bidang Pengelolaan Sampah, Limbah Bahan Berbahaya dan Beracun, serta Pengendalian Pencemaran (PSLB3PP) bertugas melaksanakan perumusan, koordinasi, dan evaluasi kebijakan teknis di bidang pengurangan dan penanganan sampah, pengelolaan limbah B3, serta pengendalian pencemaran.';

    $fungsiBidang = [
        [
            'title' => 'Pengelolaan Sampah',
            'description' => 'Membentuk kelompok kerja / kepengurusan Program Kampung Iklim tingkat dusun/desa yang disahkan berupa Surat Keputusan (SK) Kepala Desa atau Lurah.',
        ],
        [
            'title' => 'Pembinaan & Pengurangan Timbunan Sampah',
            'description' => 'Melakukan pembinaan pembatasan timbunan sampah kepada produsen/industri dan mempromosikan ekonomi sirkular melalui gerakan daur ulang dan pemanfaatan kembali.',
        ],
        [
            'title' => 'Pengelolaan Limbah B3',
            'description' => 'Melakukan pengawasan dan pembinaan teknis terhadap kegiatan penyimpanan, pengumpulan, pemanfaatan, pengangkutan, hingga pengolahan limbah B3.',
        ],
        [
            'title' => 'Perizinan & Pertimbangan Teknis',
            'description' => 'Menyiapkan bahan pertimbangan teknis untuk perizinan pengumpulan dan pengangkutan limbah B3, serta penerbitan izin pendaur-ulangan sampah.',
        ],
        [
            'title' => 'Pemantauan & Evaluasi',
            'description' => 'Melakukan pemantauan dan evaluasi berkala terhadap Tempat Pemrosesan Akhir (TPA) sampah, sistem tanggap darurat, dan pencegahan pencemaran lingkungan.',
        ],
    ];

    $fallbackKegiatans = collect(range(1, 6))->map(fn () => [
        'judul' => 'Kegiatan Hari Lingkungan',
        'deskripsi' => 'Lorem ipsum dolor sit amet consectetur. Augue scelerisque vulputate tortor libero facilisis. Dictumst suspendisse consectetur semper faucibus. Quam ultrices magna enim ...',
        'tanggal' => '2026-05-24',
        'lokasi' => 'Kota Pontianak',
        'image' => 'https://images.unsplash.com/photo-1498972685288-c3fd157d7c7a?q=80&w=800&auto=format&fit=crop',
    ]);

    $fallbackAnggota = collect([
        ['nama' => 'Adi Pramono', 'jabatan' => 'Kepala Bidang PSLB3PP', 'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=600&auto=format&fit=crop'],
        ['nama' => 'Dr. Riani Lestari, M.Env.', 'jabatan' => 'Kepala Bidang PSLB3PP', 'image' => 'https://images.unsplash.com/photo-1544725176-7c40e5a71c5e?q=80&w=600&auto=format&fit=crop'],
        ['nama' => 'Fitri Handayani, S.ST.', 'jabatan' => 'Pranata Humas & Edukasi Kelompok Rentan', 'image' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=600&auto=format&fit=crop'],
        ['nama' => 'Randy Septimus, S.ST', 'jabatan' => 'Pranata Humas & Edukasi Kelompok Rentan', 'image' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&w=600&auto=format&fit=crop'],
    ])->concat(collect([
        ['nama' => 'Adi Pramono', 'jabatan' => 'Kepala Bidang PSLB3PP', 'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=600&auto=format&fit=crop'],
        ['nama' => 'Dr. Riani Lestari, M.Env.', 'jabatan' => 'Kepala Bidang PSLB3PP', 'image' => 'https://images.unsplash.com/photo-1544725176-7c40e5a71c5e?q=80&w=600&auto=format&fit=crop'],
        ['nama' => 'Fitri Handayani, S.ST.', 'jabatan' => 'Pranata Humas & Edukasi Kelompok Rentan', 'image' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=600&auto=format&fit=crop'],
        ['nama' => 'Randy Septimus, S.ST', 'jabatan' => 'Pranata Humas & Edukasi Kelompok Rentan', 'image' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&w=600&auto=format&fit=crop'],
    ]));
@endphp

<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 space-y-16 py-8 sm:py-12">

    <section class="text-center space-y-5 max-w-4xl mx-auto">
        <div class="inline-block">
            <span class="px-4 py-1.5 rounded-full border border-[#7AE3BC]/70 text-[#00A86B] text-[11px] font-extrabold uppercase tracking-widest bg-[#E6F9F2]">
                {{ $profileBadge }}
            </span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-snug">
            {{ $profileTitle }}
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed max-w-3xl mx-auto font-semibold">
            {{ $profileDescription }}
        </p>
    </section>

    <section class="space-y-4">
        <div class="space-y-1">
            <span class="text-xs font-extrabold uppercase tracking-wide text-[#00A86B]">{{ $definitionBadge }}</span>
            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">{{ $definitionTitle }}</h2>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-5 sm:p-6">
            <p class="text-xs sm:text-sm text-slate-700 font-semibold leading-relaxed">
                {{ $definitionDescription }}
            </p>
        </div>
    </section>

    <section class="pslb3pp-function-panel rounded-xl p-7 sm:p-10 lg:p-12">
        <div class="text-center max-w-4xl mx-auto space-y-3">
            <span class="text-xs font-bold uppercase tracking-wider text-[#00E58F]">{{ $functionBadge }}</span>
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">
                {{ $functionTitle }}
            </h2>
            <p class="pslb3pp-function-panel__description text-xs sm:text-sm leading-relaxed max-w-3xl mx-auto pt-1 font-normal">
                {{ $functionDescription }}
            </p>
        </div>

        <div class="text-center mt-9 sm:mt-10">
            <h3 class="text-xl sm:text-2xl font-bold text-white tracking-tight">
                Fungsi Bidang PSLB3PP
            </h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-7 lg:gap-6 mt-7 sm:mt-8">
            @foreach($fungsiBidang as $fungsi)
                <div class="space-y-3 text-left">
                    <div class="pslb3pp-function-panel__number">
                        {{ $loop->iteration }}
                    </div>
                    <h4 class="text-sm font-bold text-white leading-snug">{{ $fungsi['title'] }}</h4>
                    <p class="pslb3pp-function-panel__item-description text-xs leading-relaxed">
                        {{ $fungsi['description'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="space-y-8">
        <div class="text-center">
            <span class="text-xs font-extrabold uppercase tracking-wide text-[#00A86B]">KEGIATAN PSLB3PP</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @forelse($kegiatans as $kegiatan)
                @php
                    $cover = $kegiatan->pivot_gambar_kegiatan->first();
                    $imageUrl = $cover ? route('frontend.kegiatan.image', $cover->id) : asset('frontend/img/default-slider-1.png');
                @endphp
                <a href="{{ route('aksi-lingkungan-detail', $kegiatan->id) }}" class="bg-white border border-slate-200/70 rounded-xl overflow-hidden flex flex-col group transition-all shadow-md hover:shadow-lg block">
                    <div class="relative h-48 overflow-hidden bg-slate-100">
                        <img src="{{ $imageUrl }}" alt="{{ $kegiatan->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="flex items-center gap-3 text-[11px] text-slate-400 font-semibold">
                            @if($kegiatan->tanggal)
                                <span><i class="fa-regular fa-calendar text-[#00A86B]"></i> {{ \Carbon\Carbon::parse($kegiatan->tanggal)->translatedFormat('d M Y') }}</span>
                            @endif
                            @if($kegiatan->kabupaten_kota)
                                <span><i class="fa-solid fa-location-dot text-[#00A86B]"></i> {{ $kegiatan->kabupaten_kota->name }}</span>
                            @endif
                        </div>
                        <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug group-hover:text-[#00A86B] transition-colors">
                            {{ $kegiatan->judul }}
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                            {{ \Illuminate\Support\Str::limit(strip_tags($kegiatan->deskripsi), 120) }}
                        </p>
                    </div>
                </a>
            @empty
                @foreach($fallbackKegiatans as $kegiatan)
                    <article class="bg-white border border-slate-200/70 rounded-xl overflow-hidden flex flex-col shadow-md">
                        <div class="relative h-48 overflow-hidden bg-slate-100">
                            <img src="{{ $kegiatan['image'] }}" alt="{{ $kegiatan['judul'] }}" class="w-full h-full object-cover">
                        </div>
                        <div class="p-5 space-y-3">
                            <div class="flex items-center gap-3 text-[11px] text-slate-400 font-semibold">
                                <span><i class="fa-regular fa-calendar text-[#00A86B]"></i> {{ \Carbon\Carbon::parse($kegiatan['tanggal'])->translatedFormat('d M Y') }}</span>
                                <span><i class="fa-solid fa-location-dot text-[#00A86B]"></i> {{ $kegiatan['lokasi'] }}</span>
                            </div>
                            <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug">{{ $kegiatan['judul'] }}</h3>
                            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">{{ $kegiatan['deskripsi'] }}</p>
                        </div>
                    </article>
                @endforeach
            @endforelse
        </div>

        <div class="text-center pt-2">
            <a href="{{ route('galeri') }}" class="px-6 py-3 rounded-lg bg-[#00E58F] hover:bg-[#00d080] text-white font-extrabold text-xs sm:text-sm inline-flex items-center gap-2 shadow-md transition-all hover:scale-105">
                <span>Lihat Kegiatan Lainnya</span>
                <i class="fa-solid fa-chevron-right text-[11px]"></i>
            </a>
        </div>
    </section>

    <section class="space-y-8">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
            STRUKTUR KOORDINATOR PELAKSANA
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
            @forelse($anggotaPelaksanas as $anggota)
                @php
                    $anggotaImage = $anggota->foto
                        ? route('frontend.anggota-pelaksana.image', $anggota->id)
                        : 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=600&auto=format&fit=crop';
                @endphp
                <article class="bg-white border border-slate-200/70 rounded-xl overflow-hidden shadow-sm h-full flex flex-col">
                    <div class="bg-slate-100 overflow-hidden shrink-0">
                        <img src="{{ $anggotaImage }}" alt="{{ $anggota->nama }}" class="coordinator-photo">
                    </div>
                    <div class="p-5 space-y-1 flex-1">
                        <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug">{{ $anggota->nama }}</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">{{ $anggota->jabatan?->nama ?? 'Koordinator Pelaksana' }}</p>
                    </div>
                </article>
            @empty
                @foreach($fallbackAnggota as $anggota)
                    <article class="bg-white border border-slate-200/70 rounded-xl overflow-hidden shadow-sm h-full flex flex-col">
                        <div class="bg-slate-100 overflow-hidden shrink-0">
                            <img src="{{ $anggota['image'] }}" alt="{{ $anggota['nama'] }}" class="coordinator-photo">
                        </div>
                        <div class="p-5 space-y-1 flex-1">
                            <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug">{{ $anggota['nama'] }}</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">{{ $anggota['jabatan'] }}</p>
                        </div>
                    </article>
                @endforeach
            @endforelse
        </div>
    </section>

</div>
@endsection

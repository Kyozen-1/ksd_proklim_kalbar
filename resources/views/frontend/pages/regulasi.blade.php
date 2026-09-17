@extends('frontend.layouts.main')

@section('title', 'Dokumen Resmi Regulasi - DLHK Proklim Kalimantan Barat')

@section('content')
@php
    $categoryLabels = [
        'undang_undang' => 'Undang-Undang',
        'peraturan_daerah' => 'Peraturan Daerah',
        'panduan' => 'Panduan',
    ];
@endphp

<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 space-y-12 py-8 sm:py-12" x-data="{ activeFilter: 'semua', searchQuery: '' }">

    <section class="text-center space-y-3 max-w-4xl mx-auto">
        <div class="inline-block">
            <span class="px-4 py-1.5 rounded-full border border-[#7AE3BC]/70 text-[#00A86B] text-[11px] font-extrabold uppercase tracking-widest bg-[#E6F9F2]">
                DOKUMEN RESMI
            </span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-snug">
            Dokumen Resmi Proklim
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed max-w-3xl mx-auto font-normal">
            Arsip peraturan, buku panduan, dan dokumen resmi yang dikelola melalui CMS.
        </p>
    </section>

    <section class="max-w-6xl mx-auto">
        <div class="bg-white border border-slate-200/90 rounded-2xl p-4 sm:p-5 flex flex-col md:flex-row items-center justify-between gap-4 shadow-xs">
            <div class="relative w-full md:w-80">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-slate-400 text-sm"></i>
                </span>
                <input type="text"
                       x-model="searchQuery"
                       placeholder="Cari Dokumen..."
                       class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl text-xs sm:text-sm bg-[#FAFAFA] focus:outline-none focus:border-[#00E58F] focus:bg-white transition-all">
            </div>

            <div class="bg-[#F2F2F2] rounded-xl p-1 inline-flex items-center gap-1 shrink-0 overflow-x-auto max-w-full">
                <button @click="activeFilter = 'semua'"
                        class="px-4 py-2 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap"
                        :class="activeFilter === 'semua' ? 'bg-[#00D182] text-white shadow-xs' : 'bg-transparent text-slate-800 hover:bg-slate-200/40'">
                    Semua
                </button>
                @foreach($categoryLabels as $key => $label)
                    <button @click="activeFilter = @js($key)"
                            class="px-4 py-2 rounded-lg text-xs font-bold transition-all cursor-pointer whitespace-nowrap"
                            :class="activeFilter === @js($key) ? 'bg-[#00D182] text-white shadow-xs' : 'bg-transparent text-slate-800 hover:bg-slate-200/40'">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto">
        @if($dokumens->count())
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden divide-y divide-slate-100">
                @foreach($dokumens as $dokumen)
                    @php
                        $label = $categoryLabels[$dokumen->kategori] ?? str_replace('_', ' ', $dokumen->kategori);
                        $searchText = \Illuminate\Support\Str::lower($dokumen->nama.' '.$label);
                    @endphp
                    <div class="p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-all hover:bg-slate-50/40"
                         x-show="(activeFilter === 'semua' || activeFilter === @js($dokumen->kategori)) && (searchQuery === '' || @js($searchText).includes(searchQuery.toLowerCase()))">
                        <div class="flex items-start sm:items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-[#E6F9F2] text-[#00A86B] flex items-center justify-center text-xl shrink-0">
                                <i class="fa-regular fa-file-lines"></i>
                            </div>
                            <div class="space-y-0.5">
                                <span class="text-xs font-semibold text-[#00A86B] block">
                                    {{ $label }}
                                </span>
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug">
                                    {{ $dokumen->nama }}
                                </h3>
                            </div>
                        </div>
                        <div class="shrink-0 w-full sm:w-auto">
                            <a href="{{ route('frontend.dokumen.file', $dokumen->id) }}" target="_blank" class="w-full sm:w-auto px-5 py-2.5 rounded-lg bg-[#00E58F] hover:bg-[#00d080] text-white font-extrabold text-xs inline-flex items-center justify-center gap-1.5 transition-all shadow-sm">
                                Download Dokumen
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pt-8">
                {{ $dokumens->links() }}
            </div>
        @else
            <div class="bg-white border border-slate-200 rounded-2xl p-8 text-center text-sm text-slate-500">
                Belum ada dokumen regulasi aktif yang diterbitkan dari CMS.
            </div>
        @endif
    </section>

</div>
@endsection

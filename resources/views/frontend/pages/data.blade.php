@extends('frontend.layouts.main')

@section('title', 'Data Aksi Iklim - Proklim Kalimantan Barat')

@section('content')
<section class="bg-slate-900 text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="text-xs font-semibold text-emerald-400 uppercase tracking-widest">Sistem Informasi Peta & Data</span>
                <h1 class="text-3xl font-extrabold tracking-tight mt-1">Sebaran Lokasi Proklim Kalimantan Barat</h1>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-slate-400">Total Terdaftar: <strong class="text-emerald-400 text-sm">{{ number_format($locations->total(), 0, ',', '.') }} Lokasi</strong></span>
            </div>
        </div>
    </div>
</section>

<section class="py-12 bg-slate-50" x-data="{ search: '', selectedKab: 'all' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="relative w-full md:w-80">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input x-model="search" type="text" placeholder="Cari nama desa/lokasi..." class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-500 text-sm">
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <select x-model="selectedKab" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 bg-white font-medium w-full md:w-auto">
                    <option value="all">Semua Kabupaten/Kota</option>
                    @foreach($regencies as $regency)
                        <option value="{{ $regency->name }}">{{ $regency->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="bg-slate-900 rounded-3xl p-8 text-white relative overflow-hidden flex flex-col items-center justify-center text-center min-h-[280px]">
            <div class="space-y-3 relative z-10 max-w-md">
                <div class="w-14 h-14 rounded-2xl bg-emerald-500/20 border border-emerald-400/30 text-emerald-400 flex items-center justify-center text-2xl mx-auto">
                    <i class="fa-solid fa-map-location-dot"></i>
                </div>
                <h3 class="text-xl font-bold">Peta GIS Sebaran Lokasi Proklim</h3>
                <p class="text-xs text-slate-400">Area ini siap dihubungkan ke WebGIS setelah data koordinat tersedia di backend.</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-wider">
                            <th class="py-4 px-6">No</th>
                            <th class="py-4 px-6">Nama Desa / Kelurahan</th>
                            <th class="py-4 px-6">Kecamatan</th>
                            <th class="py-4 px-6">Kabupaten / Kota</th>
                            <th class="py-4 px-6">Status Data</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($locations as $location)
                            @php
                                $searchText = \Illuminate\Support\Str::lower($location->village_name.' '.$location->district_name.' '.$location->regency_name);
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition-colors"
                                x-show="(search === '' || @js($searchText).includes(search.toLowerCase())) && (selectedKab === 'all' || selectedKab === @js($location->regency_name))">
                                <td class="py-4 px-6 font-semibold text-slate-400">{{ $locations->firstItem() + $loop->index }}</td>
                                <td class="py-4 px-6 font-bold text-slate-900">{{ $location->village_name }}</td>
                                <td class="py-4 px-6 text-slate-600">{{ $location->district_name }}</td>
                                <td class="py-4 px-6 text-slate-600">{{ $location->regency_name }}</td>
                                <td class="py-4 px-6"><span class="text-xs font-semibold text-emerald-600"><i class="fa-solid fa-circle-check"></i> Terdata</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 px-6 text-center text-slate-500">Belum ada data lokasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            {{ $locations->links() }}
        </div>

    </div>
</section>
@endsection

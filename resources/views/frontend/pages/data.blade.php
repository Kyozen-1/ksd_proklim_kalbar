@extends('frontend.layouts.main')

@section('title', 'Data Aksi Iklim - Proklim Kalimantan Barat')

@section('content')
<!-- Header -->
<section class="bg-slate-900 text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="text-xs font-semibold text-emerald-400 uppercase tracking-widest">Sistem Informasi Peta & Data</span>
                <h1 class="text-3xl font-extrabold tracking-tight mt-1">Sebaran Lokasi Proklim Kalimantan Barat</h1>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-slate-400">Total Terdaftar: <strong class="text-emerald-400 text-sm">148 Lokasi</strong></span>
            </div>
        </div>
    </div>
</section>

<!-- Filter & Data Table Placeholder -->
<section class="py-12 bg-slate-50" x-data="{ search: '', selectedKab: 'all' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Controls & Filters -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row items-center justify-between gap-4">
            
            <!-- Search input -->
            <div class="relative w-full md:w-80">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input x-model="search" type="text" placeholder="Cari nama desa/lokasi..." class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-500 text-sm">
            </div>

            <!-- Dropdown Filter -->
            <div class="flex items-center gap-3 w-full md:w-auto">
                <select x-model="selectedKab" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 bg-white font-medium">
                    <option value="all">Semua Kabupaten/Kota</option>
                    <option value="Kubu Raya">Kab. Kubu Raya</option>
                    <option value="Mempawah">Kab. Mempawah</option>
                    <option value="Sambas">Kab. Sambas</option>
                    <option value="Ketapang">Kab. Ketapang</option>
                    <option value="Pontianak">Kota Pontianak</option>
                    <option value="Sintang">Kab. Sintang</option>
                    <option value="Kapuas Hulu">Kab. Kapuas Hulu</option>
                </select>
                <button class="px-4 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-semibold flex items-center gap-2">
                    <i class="fa-solid fa-filter text-xs"></i> Filter
                </button>
            </div>

        </div>

        <!-- Interactive Map Placeholder Card -->
        <div class="bg-slate-900 rounded-3xl p-8 text-white relative overflow-hidden flex flex-col items-center justify-center text-center min-h-[280px]">
            <div class="space-y-3 relative z-10 max-w-md">
                <div class="w-14 h-14 rounded-2xl bg-emerald-500/20 border border-emerald-400/30 text-emerald-400 flex items-center justify-center text-2xl mx-auto">
                    <i class="fa-solid fa-map-location-dot"></i>
                </div>
                <h3 class="text-xl font-bold">Peta GIS Sebaran Lokasi Proklim</h3>
                <p class="text-xs text-slate-400">Integrasi WebGIS dengan Sistem Registrasi Nasional (SRN) KLHK secara real-time.</p>
            </div>
        </div>

        <!-- Sample Data Table -->
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-wider">
                            <th class="py-4 px-6">No</th>
                            <th class="py-4 px-6">Nama Lokasi / Dusun</th>
                            <th class="py-4 px-6">Kabupaten / Kota</th>
                            <th class="py-4 px-6">Kategori</th>
                            <th class="py-4 px-6">Fokus Utama Aksi</th>
                            <th class="py-4 px-6">Status SRN</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6 font-semibold text-slate-400">01</td>
                            <td class="py-4 px-6 font-bold text-slate-900">Desa Rasau Jaya Tiga</td>
                            <td class="py-4 px-6 text-slate-600">Kab. Kubu Raya</td>
                            <td class="py-4 px-6"><span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">Utama</span></td>
                            <td class="py-4 px-6 text-xs text-slate-500">Pencegahan Karhutla & Biogas</td>
                            <td class="py-4 px-6"><span class="text-xs font-semibold text-emerald-600"><i class="fa-solid fa-circle-check"></i> Terverifikasi</span></td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6 font-semibold text-slate-400">02</td>
                            <td class="py-4 px-6 font-bold text-slate-900">Desa Pasir Mempawah</td>
                            <td class="py-4 px-6 text-slate-600">Kab. Mempawah</td>
                            <td class="py-4 px-6"><span class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">Madya</span></td>
                            <td class="py-4 px-6 text-xs text-slate-500">Konservasi Mangrove Pesisir</td>
                            <td class="py-4 px-6"><span class="text-xs font-semibold text-emerald-600"><i class="fa-solid fa-circle-check"></i> Terverifikasi</span></td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6 font-semibold text-slate-400">03</td>
                            <td class="py-4 px-6 font-bold text-slate-900">Kelurahan Bansir Laut</td>
                            <td class="py-4 px-6 text-slate-600">Kota Pontianak</td>
                            <td class="py-4 px-6"><span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-900 text-white">Lestari</span></td>
                            <td class="py-4 px-6 text-xs text-slate-500">Bank Sampah & Penghijauan Kota</td>
                            <td class="py-4 px-6"><span class="text-xs font-semibold text-emerald-600"><i class="fa-solid fa-circle-check"></i> Terverifikasi</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>
@endsection

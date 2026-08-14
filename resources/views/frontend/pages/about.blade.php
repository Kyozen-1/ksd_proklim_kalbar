@extends('frontend.layouts.main')

@section('title', 'Profil & Kategori - Proklim Kalimantan Barat')

@section('content')
<!-- Header Banner -->
<section class="bg-gradient-to-r from-emerald-900 to-slate-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl space-y-4">
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                Tentang Program
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight">
                Profil Program Kampung Iklim (Proklim)
            </h1>
            <p class="text-emerald-100/90 text-base leading-relaxed">
                Inisiatif nasional Kementerian Lingkungan Hidup dan Kehutanan yang dilaksanakan secara masif di Provinsi Kalimantan Barat.
            </p>
        </div>
    </div>
</section>

<!-- Content Body -->
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
        
        <!-- Visi & Misi -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                    Latar Belakang & Tujuan Utama
                </h2>
                <p class="text-slate-600 leading-relaxed text-sm sm:text-base">
                    Program Kampung Iklim (PROKLIM) adalah program berlingkup nasional yang dikelola oleh KLHK dalam rangka meningkatkan keterlibatan masyarakat dan pemangku kepentingan untuk melakukan penguatan kapasitas adaptasi terhadap dampak perubahan iklim dan penurunan emisi GRK.
                </p>
                <div class="space-y-4 pt-2">
                    <div class="flex items-start gap-4 p-4 rounded-xl bg-white border border-slate-100 shadow-xs">
                        <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold shrink-0">
                            1
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900">Meningkatkan Ketahanan Masyarakat</h4>
                            <p class="text-xs text-slate-500">Mendorong adaptasi terhadap ancaman kekeringan, kenaikan air laut, dan fenomena cuaca ekstrem.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 rounded-xl bg-white border border-slate-100 shadow-xs">
                        <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold shrink-0">
                            2
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900">Kontribusi Penurunan Emisi GRK</h4>
                            <p class="text-xs text-slate-500">Pengelolaan sampah, pencegahan Karhutla pada lahan gambut, dan perlindungan kawasan mangrove.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl overflow-hidden shadow-xl border border-slate-200">
                <img src="https://images.unsplash.com/photo-1511497584788-8767611136f6?q=80&w=1000&auto=format&fit=crop" alt="Hutan Kalbar" class="w-full h-[400px] object-cover">
            </div>
        </div>

        <!-- Levels / Categories of Proklim -->
        <div>
            <div class="text-center max-w-2xl mx-auto mb-12 space-y-2">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Kategori Penghargaan Proklim</h2>
                <p class="text-sm text-slate-500">Klasifikasi tingkatan berdasarkan komponen penilaian aksi adaptasi & mitigasi.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 space-y-3">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">Level 1</span>
                    <h3 class="text-lg font-bold text-slate-900">Proklim Pratama</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Tahap inisiasi aksi adaptasi dan mitigasi dasar dengan nilai nilai verifikasi awal.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-200 space-y-3">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">Level 2</span>
                    <h3 class="text-lg font-bold text-slate-900">Proklim Madya</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Telah melakukan tindakan adaptasi-mitigasi secara berkelanjutan dengan kelembagaan aktif.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-emerald-200 bg-gradient-to-b from-emerald-50/50 to-white space-y-3">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-600 text-white">Level 3</span>
                    <h3 class="text-lg font-bold text-slate-900">Proklim Utama</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Mendapat Trophy / Sertifikat Penghargaan Nasional atas pencapaian luar biasa.</p>
                </div>

                <div class="bg-slate-900 text-white p-6 rounded-2xl space-y-3">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-500 text-slate-950">Level 4</span>
                    <h3 class="text-lg font-bold text-white">Proklim Lestari</h3>
                    <p class="text-xs text-slate-300 leading-relaxed">Tingkat tertinggi. Telah membina minimal 10 lokasi Proklim baru di sekitarnya.</p>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

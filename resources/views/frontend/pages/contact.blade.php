@extends('frontend.layouts.main')

@section('title', 'Hubungi Kami - Sekretariat Proklim Kalbar')

@section('content')
<!-- Header Banner -->
<section class="bg-gradient-to-r from-slate-900 to-emerald-950 text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-2xl space-y-3">
        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300">Hubungi Kami</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold">Sekretariat Pembina Proklim Kalbar</h1>
        <p class="text-slate-300 text-sm">Punya pertanyaan seputar pendaftaran Proklim atau pendampingan lokasi? Silakan konsultasi dengan kami.</p>
    </div>
</section>

<!-- Form & Info Section -->
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- Left Info -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-xs space-y-6">
                    <h3 class="text-xl font-bold text-slate-900">Dinas LHK Provinsi Kalbar</h3>
                    
                    <div class="space-y-4 text-sm text-slate-600">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold shrink-0">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900">Alamat Kantor</h4>
                                <p class="text-xs text-slate-500 mt-0.5">Jl. Sultan Abdurrahman No. 137, Akcaya, Kec. Pontianak Selatan, Kota Pontianak, Kalimantan Barat 78121</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold shrink-0">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900">Email Sekretariat</h4>
                                <p class="text-xs text-slate-500 mt-0.5">proklim@kalbarprov.go.id</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold shrink-0">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900">Telepon / Fax</h4>
                                <p class="text-xs text-slate-500 mt-0.5">(0561) 736239</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Form -->
            <div class="lg:col-span-7">
                <form action="#" method="POST" class="bg-white p-8 rounded-2xl border border-slate-200 shadow-xs space-y-5">
                    @csrf
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Kirim Pesan Konsultasi</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Nama Lengkap</label>
                            <input type="text" required placeholder="Masukkan nama..." class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-600">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Alamat Email</label>
                            <input type="email" required placeholder="email@domain.com" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-600">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Kabupaten / Kota Perwakilan</label>
                        <input type="text" placeholder="Contoh: Kubu Raya" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-600">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Pesan / Topik Konsultasi</label>
                        <textarea rows="4" required placeholder="Tuliskan detail pertanyaan atau pengajuan lokasi..." class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-600 resize-none"></textarea>
                    </div>

                    <button type="submit" class="w-full py-3.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm shadow-md transition-colors">
                        <i class="fa-solid fa-paper-plane mr-2"></i> Kirim Pesan Now
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>
@endsection

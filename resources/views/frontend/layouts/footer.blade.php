<footer class="bg-[#F9F9F9] text-slate-700 pt-14 pb-8 border-t border-slate-200/80 mt-12">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 pb-12 border-b border-slate-200/80">
            
            <!-- Col 1: Brand Info (5 cols) -->
            <div class="md:col-span-5 space-y-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('frontend/img/logo_pemprov_kalbar.webp') }}" 
                         alt="Logo Pemprov Kalbar" 
                         class="h-10 w-auto object-contain">
                    <div class="flex flex-col">
                        <span class="text-sm font-extrabold text-slate-900 tracking-tight leading-none uppercase">DLHK PROKLIM</span>
                        <span class="text-[11px] font-bold text-[#00E58F] tracking-wide leading-tight uppercase mt-0.5">KALIMANTAN BARAT</span>
                    </div>
                </div>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-sm">
                    Sistem Informasi Terpadu Program Kampung Iklim (PROKLIM) Dinas Lingkungan Hidup dan Kehutanan Provinsi Kalimantan Barat. Mendorong adaptasi tangguh bencana dan dekarbonisasi tingkat tapak.
                </p>
            </div>

            <!-- Col 2: Akses Cepat (3 cols) -->
            <div class="md:col-span-3 space-y-3">
                <h4 class="text-xs sm:text-sm font-bold text-slate-900 tracking-wide">Akses Cepat</h4>
                <ul class="space-y-2 text-xs text-slate-600 font-medium">
                    <li><a href="{{ route('about') }}" class="hover:text-[#00E58F] transition-colors">Edukasi</a></li>
                    <li><a href="{{ route('data') }}" class="hover:text-[#00E58F] transition-colors">PROKLIM</a></li>
                    <li><a href="{{ route('data') }}" class="hover:text-[#00E58F] transition-colors">IGRK</a></li>
                    <li><a href="{{ route('pslb3pp') }}" class="hover:text-[#00E58F] transition-colors">Sampah</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-[#00E58F] transition-colors">Kualitas Lingkungan</a></li>
                    <li><a href="{{ route('pslb3pp') }}" class="hover:text-[#00E58F] transition-colors">LB3</a></li>
                    <li><a href="{{ route('regulasi') }}" class="hover:text-[#00E58F] transition-colors">Dokumen Resmi</a></li>
                    <li><a href="{{ route('berita') }}" class="hover:text-[#00E58F] transition-colors">Berita</a></li>
                    <li><a href="{{ route('galeri') }}" class="hover:text-[#00E58F] transition-colors">Galeri</a></li>
                    <li><a href="{{ route('pslb3pp') }}" class="hover:text-[#00E58F] transition-colors">Tentang PSLB3PP</a></li>
                </ul>
            </div>

            <!-- Col 3: Kontak & Layanan Publik (4 cols) -->
            <div class="md:col-span-4 space-y-3">
                <h4 class="text-xs sm:text-sm font-bold text-slate-900 tracking-wide">Kontak & Layanan Publik</h4>
                <div class="space-y-2.5 text-xs text-slate-600 font-medium">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-regular fa-envelope text-[#00E58F] text-sm"></i>
                        <span>dlhk@kalbarprov.go.id</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-phone text-[#00E58F] text-sm"></i>
                        <span>+62561734029</span>
                    </div>
                    <p class="text-xs text-slate-600 pt-1 leading-relaxed max-w-xs">
                        Jl. Sultan Abdurrahman No.137, Sungai Bangkong, Kec. Pontianak Kota, Kota Pontianak, Kalimantan Barat 78113
                    </p>
                </div>
            </div>

        </div>

        <!-- Copyright -->
        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-slate-500 font-medium">
            <p>&copy; {{ date('Y') }} Dinas Lingkungan Hidup dan Kehutanan Provinsi Kalimantan Barat.</p>
            <p>Pemerintahan Daerah Kalimantan Barat</p>
        </div>
    </div>
</footer>

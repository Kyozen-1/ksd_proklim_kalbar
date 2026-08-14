@extends('frontend.layouts.main')

@section('title', 'Edukasi Lingkungan - DLHK Proklim Kalimantan Barat')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 space-y-16 py-8 sm:py-12">

    <!-- HERO TITLE SECTION -->
    <section class="text-center space-y-4 max-w-4xl mx-auto">
        <div class="inline-block">
            <span class="px-4 py-1.5 rounded-full border-2 border-[#00E58F] text-[#00E58F] text-xs font-bold uppercase tracking-widest bg-[#00E58F]/5">
                EDUKASI
            </span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-snug">
            Portal Edukasi Lingkungan: Regulasi Aksi Hijau,<br class="hidden sm:inline" />
            Manajemen TPS 3R, dan Adaptasi Mitigasi Iklim
        </h1>
        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-3xl mx-auto font-normal">
            Dapatkan panduan praktis, materi edukasi, dan regulasi penting yang dapat Anda gunakan di tingkat desa, sekolah, maupun komunitas lokal dalam mendukung adaptasi tangguh bencana dan dekarbonisasi tingkat tapak.
        </p>
    </section>

    <!-- SECTION 1: ADAPTASI DAN MITIGASI PERUBAHAN IKLIM (1:1 EXACT MATCH) -->
    <section class="space-y-4">
        <!-- Section Header outside card -->
        <div class="space-y-1.5">
            <h2 class="text-[20px] font-bold text-slate-900 leading-[100%] tracking-normal font-sans">
                1. Adaptasi dan Mitigasi Perubahan Iklim
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 font-medium pt-0.5">
                Dua tiang aksi utama dalam menyeimbangkan ketahanan ekosistem
            </p>
        </div>

        <!-- Big Card Container -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-6 sm:p-8 space-y-8 shadow-xs">

            <!-- PART A: ADAPTASI PERUBAHAN IKLIM -->
            <div class="space-y-5">
                <!-- Definition Banner -->
                <div class="bg-[#F2FCF7] rounded-xl p-5 space-y-1.5">
                    <h3 class="text-base font-extrabold text-[#00A86B] flex items-center gap-2">
                        <span class="text-base">•</span> Definisi Adaptasi Perubahan Iklim
                    </h3>
                    <p class="text-sm text-slate-700 font-semibold leading-relaxed">
                        Tindakan penyesuaian diri untuk mengantisipasi dampak buruk dari perubahan iklim ekstrem (seperti banjir, kekeringan, kenaikan air laut, dan badai) agar kerugian dan kerusakan di tingkat desa dapat diminimalisir.
                    </p>
                </div>

                <!-- Sub-heading -->
                <div class="pt-1">
                    <h4 class="text-xs font-extrabold text-[#00A86B]">
                        Contoh konkret pelaksanaan di Kampung Iklim Kalbar
                    </h4>
                </div>

                <!-- 3 Grid Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <!-- Card A1 -->
                    <div class="bg-[#FAFAFA] border border-slate-200/70 rounded-xl p-5 space-y-3">
                        <div class="w-10 h-10 rounded-lg bg-[#D8F5EA] text-[#00A86B] flex items-center justify-center text-lg font-bold shrink-0">
                            <i class="fa-solid fa-water"></i>
                        </div>
                        <h5 class="text-sm sm:text-base font-bold text-slate-900 leading-snug">
                            Pengendalian Kekeringan & Banjir
                        </h5>
                        <p class="text-xs text-slate-500 leading-relaxed font-normal">
                            Membuat sumur resapan, menggalakkan pembentukan lubang biopori, membuat bak penampungan air hujan (PAH) skala kepala keluarga, dan merehabilitasi tanggul alam di sekitar sungai pedesaan.
                        </p>
                    </div>

                    <!-- Card A2 -->
                    <div class="bg-[#FAFAFA] border border-slate-200/70 rounded-xl p-5 space-y-3">
                        <div class="w-10 h-10 rounded-lg bg-[#D8F5EA] text-[#00A86B] flex items-center justify-center text-lg font-bold shrink-0">
                            <i class="fa-solid fa-sprout"></i>
                        </div>
                        <h5 class="text-sm sm:text-base font-bold text-slate-900 leading-snug">
                            Ketahanan Pangan Lokal
                        </h5>
                        <p class="text-xs text-slate-500 leading-relaxed font-normal">
                            Menerapkan pertanian pola tumpang sari (agroforestry), menanam bibit lokal tangguh kekeringan/banjir, budidaya hidroponik skala pekarangan rumah, dan mendirikan lumbung pangan darurat.
                        </p>
                    </div>

                    <!-- Card A3 -->
                    <div class="bg-[#FAFAFA] border border-slate-200/70 rounded-xl p-5 space-y-3">
                        <div class="w-10 h-10 rounded-lg bg-[#D8F5EA] text-[#00A86B] flex items-center justify-center text-lg font-bold shrink-0">
                            <i class="fa-solid fa-shield-heart"></i>
                        </div>
                        <h5 class="text-sm sm:text-base font-bold text-slate-900 leading-snug">
                            Antisipasi Penyakit Terkait Iklim
                        </h5>
                        <p class="text-xs text-slate-500 leading-relaxed font-normal">
                            Penyediaan sistem sanitasi bersih anti-meluap, pemberantasan sarang nyamuk teratur di musim pancaroba ekstrem, penyediaan pos tanggap kesehatan darurat cuaca panas.
                        </p>
                    </div>
                </div>
            </div>

            <!-- PART B: MITIGASI PERUBAHAN IKLIM -->
            <div class="space-y-5 pt-4 border-t border-slate-100">
                <!-- Definition Banner -->
                <div class="bg-[#F2FCF7] rounded-xl p-5 space-y-1.5">
                    <h3 class="text-base font-extrabold text-[#00A86B] flex items-center gap-2">
                        <span class="text-base">•</span> Definisi Mitigasi Perubahan Iklim
                    </h3>
                    <p class="text-sm text-slate-700 font-semibold leading-relaxed">
                        Usaha aktif untuk menurunkan pembuangan emisi gas rumah kaca ke atmosfer bumi atau meningkatkan penyerapan kembali karbon guna memperlambat pemanasan global.
                    </p>
                </div>

                <!-- Sub-heading -->
                <div class="pt-1">
                    <h4 class="text-xs font-extrabold text-[#00A86B]">
                        Contoh konkret pelaksanaan di Kampung Iklim Kalbar
                    </h4>
                </div>

                <!-- 3 Grid Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <!-- Card B1 -->
                    <div class="bg-[#FAFAFA] border border-slate-200/70 rounded-xl p-5 space-y-3">
                        <div class="w-10 h-10 rounded-lg bg-[#D8F5EA] text-[#00A86B] flex items-center justify-center text-lg font-bold shrink-0">
                            <i class="fa-solid fa-trash-can"></i>
                        </div>
                        <h5 class="text-sm sm:text-base font-bold text-slate-900 leading-snug">
                            Pengolahan Sampah & Limbah domestik
                        </h5>
                        <p class="text-xs text-slate-500 leading-relaxed font-normal">
                            Mendirikan Bank Sampah rukun tetangga, memilah sampah dari dapur, mengolah sampah organik menjadi pupuk cair alami atau komposting maggot, mengurangi pembakaran sampah masal terbuka.
                        </p>
                    </div>

                    <!-- Card B2 -->
                    <div class="bg-[#FAFAFA] border border-slate-200/70 rounded-xl p-5 space-y-3">
                        <div class="w-10 h-10 rounded-lg bg-[#D8F5EA] text-[#00A86B] flex items-center justify-center text-lg font-bold shrink-0">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <h5 class="text-sm sm:text-base font-bold text-slate-900 leading-snug">
                            Penggunaan Energi Terbarukan
                        </h5>
                        <p class="text-xs text-slate-500 leading-relaxed font-normal">
                            Memasang panel surya mandiri masjid/kantor desa, mengolah kotoran sapi atau babi menjadi reaktor biogas memasak, menggunakan lampu jalan LED pintar hemat daya.
                        </p>
                    </div>

                    <!-- Card B3 -->
                    <div class="bg-[#FAFAFA] border border-slate-200/70 rounded-xl p-5 space-y-3">
                        <div class="w-10 h-10 rounded-lg bg-[#D8F5EA] text-[#00A86B] flex items-center justify-center text-lg font-bold shrink-0">
                            <i class="fa-solid fa-tree"></i>
                        </div>
                        <h5 class="text-sm sm:text-base font-bold text-slate-900 leading-snug">
                            Reboisasi & Penghentian Karhutla
                        </h5>
                        <p class="text-xs text-slate-500 leading-relaxed font-normal">
                            Menanam pohon pelindung tebing sungai, menghentikan pembakaran hutan saat pembukaan lahan ladang dengan metode PLTB, rehabilitasi hutan kemasyarakatan.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- SECTION 2: TEMPAT PENGOLAHAN SAMPAH REDUCE-REUSE-RECYCLE (1:1 EXACT MATCH) -->
    <section class="space-y-4">
        <!-- Section Header outside card -->
        <div class="space-y-1.5">
            <h2 class="text-[20px] font-bold text-slate-900 leading-[100%] tracking-normal font-sans">
                2. Tempat Pengolahan Sampah <span class="italic font-bold">Reduce-Reuse-Recycle</span>
            </h2>
        </div>

        <!-- Big Card Container -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-6 sm:p-8 space-y-7 shadow-xs">

            <!-- Definisi Callout Box -->
            <div class="bg-[#F2FCF7] rounded-xl p-5 space-y-1.5">
                <h3 class="text-base font-extrabold text-[#00A86B]">
                    Definisi
                </h3>
                <p class="text-sm text-slate-700 font-semibold leading-relaxed">
                    Sistem pengelolaan sampah skala kawasan atau komunal yang mengedepankan proses mengurangi (reduce), menggunakan kembali (reuse), dan mendaur ulang (recycle). Fasilitas ini bertujuan untuk mengolah sampah langsung dari sumbernya guna menekan volume sampah yang dikirim ke Tempat Pemrosesan Akhir (TPA).
                </p>
            </div>

            <!-- Misi Utama -->
            <div class="space-y-3">
                <h4 class="text-xs font-extrabold text-[#00A86B]">
                    Misi Utama
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <!-- Card 1 -->
                    <div class="bg-[#FAFAFA] border border-slate-200/70 rounded-xl p-5 flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-[#D8F5EA] text-[#00A86B] flex items-center justify-center text-lg font-bold shrink-0">
                            <i class="fa-solid fa-trash-can"></i>
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed font-normal my-auto">
                            Mengurangi volume sampah yang masuk ke TPA (Tempat Pemrosesan Akhir) hingga 30-50%
                        </p>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-[#FAFAFA] border border-slate-200/70 rounded-xl p-5 flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-[#D8F5EA] text-[#00A86B] flex items-center justify-center text-lg font-bold shrink-0">
                            <i class="fa-solid fa-arrows-rotate"></i>
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed font-normal my-auto">
                            Mengkategorikan dan memproses sampah organik menjadi pupuk kompos atau pakan ternak (misalnya biokonversi maggot)
                        </p>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-[#FAFAFA] border border-slate-200/70 rounded-xl p-5 flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-[#D8F5EA] text-[#00A86B] flex items-center justify-center text-lg font-bold shrink-0">
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed font-normal my-auto">
                            Menjadi pusat pembelajaran (learning centre) bagi warga untuk menumbuhkan budaya peduli kebersihan dan memilah sampah dari rumah.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Alur Kerja Aliran Sampah di TPS 3R -->
            <div class="space-y-3 pt-2">
                <h4 class="text-xs font-extrabold text-[#00A86B]">
                    Alur Kerja Aliran Sampah di TPS 3R
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Step 1 -->
                    <div class="space-y-1.5">
                        <h5 class="text-base font-bold text-slate-900">1. Pilah dari Sumber</h5>
                        <p class="text-sm text-slate-500 leading-relaxed font-normal">
                            Sampah yang masuk idealnya sudah dipisah secara mandiri oleh warga menjadi kategori organik dan anorganik sebelum diangkut petugas.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="space-y-1.5">
                        <h5 class="text-base font-bold text-slate-900">2. Pemilahan Sekunder</h5>
                        <p class="text-sm text-slate-500 leading-relaxed font-normal">
                            Petugas TPS 3R memilah kembali sampah anorganik yang bernilai ekonomis (plastik, kertas, kaca, logam) dan memisahkan residu (sampah yang benar-benar tidak bisa diolah kembali)
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="space-y-1.5">
                        <h5 class="text-base font-bold text-slate-900">3. Proses Pengolahan</h5>
                        <div class="space-y-2 text-sm text-slate-500 leading-relaxed font-normal">
                            <p>• Sampah Organik: Diolah menjadi kompos (pupuk organik), media budidaya maggot BSF (Black Soldier Fly), atau bahan pupuk cair.</p>
                            <p>• Sampah Anorganik: Dicacah, dipak, dan disalurkan ke industri daur ulang atau Bank Sampah induk.</p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="space-y-1.5">
                        <h5 class="text-base font-bold text-slate-900">4. Pengangkutan Residu</h5>
                        <p class="text-sm text-slate-500 leading-relaxed font-normal">
                            Hanya sampah residu (seperti pampers bekas, pembalut, atau sisa kain yang rusak parah) yang diangkut oleh armada DLHK menuju ke TPA utama
                        </p>
                    </div>
                </div>
            </div>

            <!-- Jenis Produk yang Dihasilkan -->
            <div class="space-y-3 pt-2">
                <h4 class="text-xs font-extrabold text-[#00A86B]">
                    Jenis Produk yang Dihasilkan
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <!-- Product 1 -->
                    <div class="bg-[#FAFAFA] border border-slate-200/70 rounded-xl overflow-hidden space-y-3">
                        <div class="h-44 overflow-hidden rounded-t-xl bg-slate-100">
                            <img src="https://images.unsplash.com/photo-1589923188900-85dae523342b?q=80&w=600&auto=format&fit=crop" 
                                 alt="Kompos Organik" 
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="p-4 space-y-1">
                            <h5 class="text-sm font-bold text-slate-900">Kompos Organik</h5>
                            <p class="text-xs text-slate-500 leading-relaxed font-normal">
                                Digunakan untuk penghijauan taman kota oleh DLHK atau dijual kembali ke petani lokal
                            </p>
                        </div>
                    </div>

                    <!-- Product 2 -->
                    <div class="bg-[#FAFAFA] border border-slate-200/70 rounded-xl overflow-hidden space-y-3">
                        <div class="h-44 overflow-hidden rounded-t-xl bg-slate-100">
                            <img src="https://images.unsplash.com/photo-1516253593875-bd7ba052fbc5?q=80&w=600&auto=format&fit=crop" 
                                 alt="Maggot/Pakan Ternak" 
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="p-4 space-y-1">
                            <h5 class="text-sm font-bold text-slate-900">Maggot/Pakan Ternak</h5>
                            <p class="text-xs text-slate-500 leading-relaxed font-normal">
                                Hasil dari bio-konversi sampah organik makanan yang tinggi protein untuk pakan ikan dan unggas
                            </p>
                        </div>
                    </div>

                    <!-- Product 3 -->
                    <div class="bg-[#FAFAFA] border border-slate-200/70 rounded-xl overflow-hidden space-y-3">
                        <div class="h-44 overflow-hidden rounded-t-xl bg-slate-100">
                            <img src="https://images.unsplash.com/photo-1530587191325-3db32d826c18?q=80&w=600&auto=format&fit=crop" 
                                 alt="Kerajinan & Material Daur Ulang" 
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="p-4 space-y-1">
                            <h5 class="text-sm font-bold text-slate-900">Kerajinan & Material Daur Ulang</h5>
                            <p class="text-xs text-slate-500 leading-relaxed font-normal">
                                Hasil kerja sama dengan kelompok swadaya masyarakat (KSM) setempat
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- SECTION 3: KENALI GERAKAN 3S -->
    <section class="space-y-4">
        <!-- Section Header outside card -->
        <div class="space-y-1.5">
            <h2 class="text-[20px] font-bold text-slate-900 leading-[100%] tracking-normal font-sans">
                3. Kenali Gerakan 3S
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 font-medium pt-0.5">
                Simpan, Segregasi (Pilah), dan Salurkan
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Card 3S - 1 (Simpan) -->
            <div class="bg-[#FAFAFA] border border-slate-200/70 rounded-xl p-6 space-y-3">
                <div class="w-11 h-11 rounded-lg bg-[#D8F5EA] text-[#00A86B] flex items-center justify-center text-lg shrink-0">
                    <i class="fa-solid fa-trash-can"></i>
                </div>
                <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug">
                    Simpan
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed font-normal">
                    Menyediakan wadah sampah terpilah di berbagai titik agar masyarakat atau pegawai dapat langsung mengamankan sampah dari sumbernya sebelum dibuang
                </p>
            </div>

            <!-- Card 3S - 2 (Segregasi) -->
            <div class="bg-[#FAFAFA] border border-slate-200/70 rounded-xl p-6 space-y-3">
                <div class="w-11 h-11 rounded-lg bg-[#D8F5EA] text-[#00A86B] flex items-center justify-center text-lg shrink-0">
                    <i class="fa-solid fa-table-cells-large"></i>
                </div>
                <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug">
                    Segregasi (Pilah)
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed font-normal">
                    Kegiatan memisahkan sampah berdasarkan jenisnya sejak dari rumah, seperti memisahkan sampah organik (sisa makanan/daun), non-organik (plastik/kertas), dan residu (popok/tisu)
                </p>
            </div>

            <!-- Card 3S - 3 (Salurkan) -->
            <div class="bg-[#FAFAFA] border border-slate-200/70 rounded-xl p-6 space-y-3">
                <div class="w-11 h-11 rounded-lg bg-[#D8F5EA] text-[#00A86B] flex items-center justify-center text-lg shrink-0">
                    <i class="fa-solid fa-hand-holding-hand"></i>
                </div>
                <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug">
                    Salurkan
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed font-normal">
                    Mendistribusikan sampah yang telah dipilah ke fasilitas pengolahan lanjutan, seperti Bank Sampah, pusat komposter, atau Tempat Pengolahan Sampah Reuse-Reduce-Recycle (TPS-3R)
                </p>
            </div>
        </div>
    </section>

    <!-- SECTION 4: AKSI MENJAGA KUALITAS LINGKUNGAN (1:1 EXACT MATCH) -->
    <section class="space-y-4">
        <!-- Section Header outside card -->
        <div class="space-y-1.5">
            <h2 class="text-[20px] font-bold text-slate-900 leading-[100%] tracking-normal font-sans">
                4. Aksi Menjaga Kualitas Lingkungan
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 font-medium pt-0.5">
                Informasi panduan mengenai kontribusi nyata yang dapat dilakukan masyarakat secara mandiri di pekarangan atau lingkungan tempat tinggal
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Card 1 -->
            <a href="{{ route('aksi-lingkungan') }}" class="bg-[#FAFAFA] border border-slate-200/70 rounded-xl overflow-hidden flex flex-col group transition-all shadow-md hover:shadow-lg hover:scale-[1.02] block">
                <div class="relative h-48 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=600&auto=format&fit=crop" 
                         alt="Biopori & Resapan" 
                         class="w-full h-full object-cover">
                </div>
                <div class="p-5 flex-grow space-y-2">
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug group-hover:text-[#00A86B] transition-colors">
                        Pembuatan lubang biopori/peresapan air
                    </h3>
                    <p class="text-xs text-slate-400 font-normal leading-relaxed">
                        Lorem ipsum dolor sit amet consectetur. Volutpat vulputate a massa nulla eu et velit quis in. Adipiscing purus quis et nisl aliquet sagittis. Tortor sollicitudin...
                    </p>
                </div>
            </a>

            <!-- Card 2 -->
            <a href="{{ route('aksi-lingkungan') }}" class="bg-[#FAFAFA] border border-slate-200/70 rounded-xl overflow-hidden flex flex-col group transition-all shadow-md hover:shadow-lg hover:scale-[1.02] block">
                <div class="relative h-48 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1509423350716-97f9360b4e09?q=80&w=600&auto=format&fit=crop" 
                         alt="Tanaman Pembersih Udara" 
                         class="w-full h-full object-cover">
                </div>
                <div class="p-5 flex-grow space-y-2">
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug group-hover:text-[#00A86B] transition-colors">
                        Gerakan menanam pohon pembersih udara
                    </h3>
                    <p class="text-xs text-slate-400 font-normal leading-relaxed">
                        Lorem ipsum dolor sit amet consectetur. Volutpat vulputate a massa nulla eu et velit quis in. Adipiscing purus quis et nisl aliquet sagittis. Tortor sollicitudin...
                    </p>
                </div>
            </a>

            <!-- Card 3 -->
            <a href="{{ route('aksi-lingkungan') }}" class="bg-[#FAFAFA] border border-slate-200/70 rounded-xl overflow-hidden flex flex-col group transition-all shadow-md hover:shadow-lg hover:scale-[1.02] block">
                <div class="relative h-48 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1541888946425-d0fbb186a5b7?q=80&w=600&auto=format&fit=crop" 
                         alt="Penghematan Air" 
                         class="w-full h-full object-cover">
                </div>
                <div class="p-5 flex-grow space-y-2">
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug group-hover:text-[#00A86B] transition-colors">
                        Menghemat air bersih dan energi listrik sehari-hari
                    </h3>
                    <p class="text-xs text-slate-400 font-normal leading-relaxed">
                        Lorem ipsum dolor sit amet consectetur. Volutpat vulputate a massa nulla eu et velit quis in. Adipiscing purus quis et nisl aliquet sagittis. Tortor sollicitudin...
                    </p>
                </div>
            </a>
        </div>

        <!-- Center Action Button -->
        <div class="text-center pt-8">
            <a href="{{ route('aksi-lingkungan') }}" class="px-6 py-3 rounded-lg bg-[#00A86B] hover:bg-[#00905b] text-white font-extrabold text-xs sm:text-sm inline-flex items-center gap-2 shadow-md transition-all hover:scale-105">
                <span>Lihat info Lainnya</span>
                <i class="fa-solid fa-chevron-right text-[11px] text-white"></i>
            </a>
        </div>
    </section>

    <!-- SECTION 5: ALUR PENDAFTARAN DESA KE SRN LHK (1:1 EXACT MATCH) -->
    <section class="space-y-4">
        <!-- Section Header outside card -->
        <div class="space-y-1.5">
            <h2 class="text-[20px] font-bold text-slate-900 leading-[100%] tracking-normal font-sans">
                5. Alur Pendaftaran Desa ke SRN LHK
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 font-medium pt-0.5">
                Daftarkan rukun warga Anda agar terdeteksi di Dashboard Mitigasi Nasional
            </p>
        </div>

        <!-- Outer Card Container -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-6 sm:p-8 space-y-8 shadow-xs">
            <!-- 5 Step Columns (1 to 5) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                <!-- Step 1 -->
                <div class="space-y-3 text-left">
                    <div class="w-12 h-12 rounded-full border-[2.5px] border-[#7AE3BC] bg-white text-[#00A86B] font-black flex items-center justify-center text-xl shadow-xs">
                        1
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-[#E6F9F2] text-[#00A86B] text-[10px] font-extrabold border border-[#7AE3BC]/60 inline-block uppercase tracking-wide">
                        PERSYARATAN DASAR
                    </span>
                    <h4 class="text-sm font-bold text-slate-900 leading-snug">Pembentukan Pokja Lokal</h4>
                    <p class="text-xs text-slate-400 font-normal leading-relaxed">
                        Membentuk kelompok kerja / kepengurusan Program Kampung Iklim tingkat dusun/desa yang disahkan berupa Surat Keputusan (SK) Kepala Desa atau Lurah.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="space-y-3 text-left">
                    <div class="w-12 h-12 rounded-full border-[2.5px] border-[#7AE3BC] bg-white text-[#00A86B] font-black flex items-center justify-center text-xl shadow-xs">
                        2
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-[#E6F9F2] text-[#00A86B] text-[10px] font-extrabold border border-[#7AE3BC]/60 inline-block uppercase tracking-wide">
                        PENGUMPULAN DATA
                    </span>
                    <h4 class="text-sm font-bold text-slate-900 leading-snug">Inventarisasi Aksi & Lokasi</h4>
                    <p class="text-xs text-slate-400 font-normal leading-relaxed">
                        Mencatat jenis aksi nyata penyesuaian (seperti biopori, tampungan air) maupun aksi penurunan emisi (seperti pemilahan limbah dapur, penanaman pohon buah pelindung).
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="space-y-3 text-left">
                    <div class="w-12 h-12 rounded-full border-[2.5px] border-[#7AE3BC] bg-white text-[#00A86B] font-black flex items-center justify-center text-xl shadow-xs">
                        3
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-[#E6F9F2] text-[#00A86B] text-[10px] font-extrabold border border-[#7AE3BC]/60 inline-block uppercase tracking-wide">
                        DOKUMENTASI
                    </span>
                    <h4 class="text-sm font-bold text-slate-900 leading-snug">Pengisian Lembar Isian</h4>
                    <p class="text-xs text-slate-400 font-normal leading-relaxed">
                        Mengisi draf lembar kerja atau spreadsheet Excel resmi Proklim yang memuat data komponen iklim dan mitigasi, disandingkan dengan draf laporan deskripsi desa.
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="space-y-3 text-left">
                    <div class="w-12 h-12 rounded-full border-[2.5px] border-[#7AE3BC] bg-white text-[#00A86B] font-black flex items-center justify-center text-xl shadow-xs">
                        4
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-[#E6F9F2] text-[#00A86B] text-[10px] font-extrabold border border-[#7AE3BC]/60 inline-block uppercase tracking-wide">
                        SUBMIT DIGITAL
                    </span>
                    <h4 class="text-sm font-bold text-slate-900 leading-snug">Registrasi Online SRN KLHK</h4>
                    <p class="text-xs text-slate-400 font-normal leading-relaxed">
                        Operator mendaftarkan akun desa melalui situs resmi Sistem Registrasi Nasional (SRN) LHK, mengunggah draf isian dan SK pembentukan untuk diverifikasi pusat.
                    </p>
                </div>

                <!-- Step 5 -->
                <div class="space-y-3 text-left">
                    <div class="w-12 h-12 rounded-full border-[2.5px] border-[#7AE3BC] bg-white text-[#00A86B] font-black flex items-center justify-center text-xl shadow-xs">
                        5
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-[#E6F9F2] text-[#00A86B] text-[10px] font-extrabold border border-[#7AE3BC]/60 inline-block uppercase tracking-wide">
                        ASESMEN AKHIR
                    </span>
                    <h4 class="text-sm font-bold text-slate-900 leading-snug">Verifikasi & Validasi Lapangan</h4>
                    <p class="text-xs text-slate-400 font-normal leading-relaxed">
                        Petugas DLHK tingkat Provinsi maupun balai PPI wilayah Kalimantan akan berkunjung langsung menilai kecocokan dokumen kerja dengan aksi riil rukun warga.
                    </p>
                </div>
            </div>

            <!-- Bottom SRN Card inside the card container -->
            <div class="bg-[#033B26] text-white rounded-xl p-8 text-center space-y-4 max-w-3xl mx-auto shadow-md">
                <span class="text-xs font-bold uppercase tracking-wider text-[#00E58F]">SRN LHK</span>
                <h3 class="text-xl sm:text-2xl font-bold tracking-tight text-white">
                    Situs Resmi Registrasi Nasional
                </h3>
                <p class="text-xs text-slate-200/90 font-normal leading-relaxed max-w-2xl mx-auto">
                    srn.menlhk.go.id - Kementerian Lingkungan Hidup & Kehutanan
                </p>
                <div class="pt-2">
                    <a href="https://srn.menlhk.go.id" target="_blank" class="px-6 py-2.5 rounded-lg bg-white border-2 border-[#00E58F] hover:bg-[#00E58F]/5 text-[#00A86B] font-bold text-xs inline-flex items-center gap-2 shadow-sm transition-all hover:scale-105">
                        <span>Kunjungi Situs</span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-[#00A86B]"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection

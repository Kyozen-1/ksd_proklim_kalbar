@extends('frontend.layouts.main')

@section('title', 'Aksi Menjaga Kualitas Lingkungan - DLHK Proklim Kalimantan Barat')

@section('content')
<!-- Back Button Section -->
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 pt-6">
    <a href="{{ route('edukasi') }}" class="text-[#00A86B] hover:text-[#00905b] font-bold text-sm inline-flex items-center gap-1.5 transition-all">
        <i class="fa-solid fa-chevron-left text-xs"></i>
        <span>Kembali</span>
    </a>
</div>

<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 space-y-12 pb-16 pt-4">

    <!-- PAGE HEADER SECTION -->
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

    <!-- 3-COLUMN GRID LAYOUT (3 columns x 3 rows = 9 cards total) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        
        <!-- CARD Row 1 - 1 -->
        <a href="{{ route('aksi-lingkungan-detail') }}" class="bg-white border border-slate-200/70 rounded-xl overflow-hidden flex flex-col group transition-all shadow-md hover:shadow-lg block">
            <div class="relative h-48 overflow-hidden bg-slate-100">
                <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=600&auto=format&fit=crop" 
                     alt="Biopori & Resapan" 
                     class="w-full h-full object-cover">
            </div>
            <div class="p-5 space-y-2 flex-grow flex flex-col justify-between">
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug group-hover:text-[#00A86B] transition-colors">
                        Pembuatan lubang biopori/peresapan air
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 font-normal leading-relaxed mt-2">
                        Lorem ipsum dolor sit amet consectetur. Volutpat vulputate a massa nulla eu et velit quis in. Adipiscing purus quis et nisl aliquet sagittis. Tortor sollicitudin...
                    </p>
                </div>
            </div>
        </a>

        <!-- CARD Row 1 - 2 -->
        <a href="{{ route('aksi-lingkungan-detail') }}" class="bg-white border border-slate-200/70 rounded-xl overflow-hidden flex flex-col group transition-all shadow-md hover:shadow-lg block">
            <div class="relative h-48 overflow-hidden bg-slate-100">
                <img src="https://images.unsplash.com/photo-1509423350716-97f9360b4e09?q=80&w=600&auto=format&fit=crop" 
                     alt="Tanaman Pembersih Udara" 
                     class="w-full h-full object-cover">
            </div>
            <div class="p-5 space-y-2 flex-grow flex flex-col justify-between">
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug group-hover:text-[#00A86B] transition-colors">
                        Gerakan menanam pohon pembersih udara
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 font-normal leading-relaxed mt-2">
                        Lorem ipsum dolor sit amet consectetur. Volutpat vulputate a massa nulla eu et velit quis in. Adipiscing purus quis et nisl aliquet sagittis. Tortor sollicitudin...
                    </p>
                </div>
            </div>
        </a>

        <!-- CARD Row 1 - 3 -->
        <a href="{{ route('aksi-lingkungan-detail') }}" class="bg-white border border-slate-200/70 rounded-xl overflow-hidden flex flex-col group transition-all shadow-md hover:shadow-lg block">
            <div class="relative h-48 overflow-hidden bg-slate-100">
                <img src="https://images.unsplash.com/photo-1541888946425-d0fbb186a5b7?q=80&w=600&auto=format&fit=crop" 
                     alt="Penghematan Air" 
                     class="w-full h-full object-cover">
            </div>
            <div class="p-5 space-y-2 flex-grow flex flex-col justify-between">
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug group-hover:text-[#00A86B] transition-colors">
                        Menghemat air bersih dan energi listrik sehari-hari
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 font-normal leading-relaxed mt-2">
                        Lorem ipsum dolor sit amet consectetur. Volutpat vulputate a massa nulla eu et velit quis in. Adipiscing purus quis et nisl aliquet sagittis. Tortor sollicitudin...
                    </p>
                </div>
            </div>
        </a>

        <!-- CARD Row 2 - 1 -->
        <a href="{{ route('aksi-lingkungan-detail') }}" class="bg-white border border-slate-200/70 rounded-xl overflow-hidden flex flex-col group transition-all shadow-md hover:shadow-lg block">
            <div class="relative h-48 overflow-hidden bg-slate-100">
                <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=600&auto=format&fit=crop" 
                     alt="Biopori & Resapan" 
                     class="w-full h-full object-cover">
            </div>
            <div class="p-5 space-y-2 flex-grow flex flex-col justify-between">
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug group-hover:text-[#00A86B] transition-colors">
                        Pembuatan lubang biopori/peresapan air
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 font-normal leading-relaxed mt-2">
                        Lorem ipsum dolor sit amet consectetur. Volutpat vulputate a massa nulla eu et velit quis in. Adipiscing purus quis et nisl aliquet sagittis. Tortor sollicitudin...
                    </p>
                </div>
            </div>
        </a>

        <!-- CARD Row 2 - 2 -->
        <a href="{{ route('aksi-lingkungan-detail') }}" class="bg-white border border-slate-200/70 rounded-xl overflow-hidden flex flex-col group transition-all shadow-md hover:shadow-lg block">
            <div class="relative h-48 overflow-hidden bg-slate-100">
                <img src="https://images.unsplash.com/photo-1509423350716-97f9360b4e09?q=80&w=600&auto=format&fit=crop" 
                     alt="Tanaman Pembersih Udara" 
                     class="w-full h-full object-cover">
            </div>
            <div class="p-5 space-y-2 flex-grow flex flex-col justify-between">
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug group-hover:text-[#00A86B] transition-colors">
                        Gerakan menanam pohon pembersih udara
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 font-normal leading-relaxed mt-2">
                        Lorem ipsum dolor sit amet consectetur. Volutpat vulputate a massa nulla eu et velit quis in. Adipiscing purus quis et nisl aliquet sagittis. Tortor sollicitudin...
                    </p>
                </div>
            </div>
        </a>

        <!-- CARD Row 2 - 3 -->
        <a href="{{ route('aksi-lingkungan-detail') }}" class="bg-white border border-slate-200/70 rounded-xl overflow-hidden flex flex-col group transition-all shadow-md hover:shadow-lg block">
            <div class="relative h-48 overflow-hidden bg-slate-100">
                <img src="https://images.unsplash.com/photo-1541888946425-d0fbb186a5b7?q=80&w=600&auto=format&fit=crop" 
                     alt="Penghematan Air" 
                     class="w-full h-full object-cover">
            </div>
            <div class="p-5 space-y-2 flex-grow flex flex-col justify-between">
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug group-hover:text-[#00A86B] transition-colors">
                        Menghemat air bersih dan energi listrik sehari-hari
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 font-normal leading-relaxed mt-2">
                        Lorem ipsum dolor sit amet consectetur. Volutpat vulputate a massa nulla eu et velit quis in. Adipiscing purus quis et nisl aliquet sagittis. Tortor sollicitudin...
                    </p>
                </div>
            </div>
        </a>

        <!-- CARD Row 3 - 1 -->
        <a href="{{ route('aksi-lingkungan-detail') }}" class="bg-white border border-slate-200/70 rounded-xl overflow-hidden flex flex-col group transition-all shadow-md hover:shadow-lg block">
            <div class="relative h-48 overflow-hidden bg-slate-100">
                <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=600&auto=format&fit=crop" 
                     alt="Biopori & Resapan" 
                     class="w-full h-full object-cover">
            </div>
            <div class="p-5 space-y-2 flex-grow flex flex-col justify-between">
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug group-hover:text-[#00A86B] transition-colors">
                        Pembuatan lubang biopori/peresapan air
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 font-normal leading-relaxed mt-2">
                        Lorem ipsum dolor sit amet consectetur. Volutpat vulputate a massa nulla eu et velit quis in. Adipiscing purus quis et nisl aliquet sagittis. Tortor sollicitudin...
                    </p>
                </div>
            </div>
        </a>

        <!-- CARD Row 3 - 2 -->
        <a href="{{ route('aksi-lingkungan-detail') }}" class="bg-white border border-slate-200/70 rounded-xl overflow-hidden flex flex-col group transition-all shadow-md hover:shadow-lg block">
            <div class="relative h-48 overflow-hidden bg-slate-100">
                <img src="https://images.unsplash.com/photo-1509423350716-97f9360b4e09?q=80&w=600&auto=format&fit=crop" 
                     alt="Tanaman Pembersih Udara" 
                     class="w-full h-full object-cover">
            </div>
            <div class="p-5 space-y-2 flex-grow flex flex-col justify-between">
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug group-hover:text-[#00A86B] transition-colors">
                        Gerakan menanam pohon pembersih udara
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 font-normal leading-relaxed mt-2">
                        Lorem ipsum dolor sit amet consectetur. Volutpat vulputate a massa nulla eu et velit quis in. Adipiscing purus quis et nisl aliquet sagittis. Tortor sollicitudin...
                    </p>
                </div>
            </div>
        </a>

        <!-- CARD Row 3 - 3 -->
        <a href="{{ route('aksi-lingkungan-detail') }}" class="bg-white border border-slate-200/70 rounded-xl overflow-hidden flex flex-col group transition-all shadow-md hover:shadow-lg block">
            <div class="relative h-48 overflow-hidden bg-slate-100">
                <img src="https://images.unsplash.com/photo-1541888946425-d0fbb186a5b7?q=80&w=600&auto=format&fit=crop" 
                     alt="Penghematan Air" 
                     class="w-full h-full object-cover">
            </div>
            <div class="p-5 space-y-2 flex-grow flex flex-col justify-between">
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug group-hover:text-[#00A86B] transition-colors">
                        Menghemat air bersih dan energi listrik sehari-hari
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 font-normal leading-relaxed mt-2">
                        Lorem ipsum dolor sit amet consectetur. Volutpat vulputate a massa nulla eu et velit quis in. Adipiscing purus quis et nisl aliquet sagittis. Tortor sollicitudin...
                    </p>
                </div>
            </div>
        </a>

    </div>

    <!-- CENTERED PAGINATION AT THE BOTTOM -->
    <div class="pt-10 flex items-center justify-center gap-3 text-xs font-semibold text-slate-500 mt-6">
        <button class="w-8 h-8 rounded-lg border border-slate-200 flex items-center justify-center hover:text-[#00A86B] hover:border-[#00A86B] transition-all">
            <i class="fa-solid fa-chevron-left text-[10px]"></i>
        </button>
        
        <div class="flex items-center gap-1.5">
            <button class="w-8 h-8 rounded-lg bg-[#00A86B] text-white flex items-center justify-center font-bold">
                1
            </button>
            <button class="w-8 h-8 rounded-lg border border-slate-200 flex items-center justify-center hover:text-[#00A86B] hover:border-[#00A86B] transition-all">
                2
            </button>
            <button class="w-8 h-8 rounded-lg border border-slate-200 flex items-center justify-center hover:text-[#00A86B] hover:border-[#00A86B] transition-all">
                3
            </button>
            <button class="w-8 h-8 rounded-lg border border-slate-200 flex items-center justify-center hover:text-[#00A86B] hover:border-[#00A86B] transition-all">
                4
            </button>
        </div>

        <button class="w-8 h-8 rounded-lg border border-slate-200 flex items-center justify-center hover:text-[#00A86B] hover:border-[#00A86B] transition-all">
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
        </button>
    </div>

</div>
@endsection

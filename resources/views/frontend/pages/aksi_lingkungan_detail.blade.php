@extends('frontend.layouts.main')

@section('title', 'Detail Aksi Menjaga Kualitas Lingkungan - DLHK Proklim Kalimantan Barat')

@section('content')
<!-- Back Button Section to Catalog list -->
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 pt-6">
    <a href="{{ route('aksi-lingkungan') }}" class="text-[#00A86B] hover:text-[#00905b] font-bold text-sm inline-flex items-center gap-1.5 transition-all">
        <i class="fa-solid fa-chevron-left text-xs"></i>
        <span>Kembali ke Galeri Aksi</span>
    </a>
</div>

<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 space-y-12 pb-16 pt-4">

    <!-- PAGE HEADER SECTION -->
    <section class="text-center space-y-3 max-w-4xl mx-auto">
        <div class="inline-block">
            <span class="px-4 py-1.5 rounded-full border border-[#7AE3BC]/70 text-[#00A86B] text-[11px] font-extrabold uppercase tracking-widest bg-[#E6F9F2]">
                INFORMASI DETAIL LINGKUNGAN
            </span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-snug">
            Aksi Menjaga Kualitas Lingkungan
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed max-w-3xl mx-auto font-normal">
            Informasi panduan mengenai kontribusi nyata yang dapat dilakukan masyarakat secara mandiri di pekarangan atau lingkungan tempat tinggal
        </p>
    </section>

    <!-- TWO-COLUMN LAYOUT -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12">
        
        <!-- LEFT COLUMN: VERTICAL LIST OF MINI CARDS (4 Columns) -->
        <div class="lg:col-span-4 space-y-16">
            <!-- Card 1 -->
            <a href="{{ route('aksi-lingkungan-detail') }}" class="bg-white border border-slate-200/70 rounded-xl overflow-hidden flex flex-col group transition-all shadow-md hover:shadow-lg block">
                <div class="relative h-32 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=600&auto=format&fit=crop" 
                         alt="Biopori & Resapan" 
                         class="w-full h-full object-cover">
                </div>
                <div class="p-5 space-y-2">
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug group-hover:text-[#00A86B] transition-colors">
                        Pembuatan lubang biopori/peresapan air
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 font-normal leading-relaxed">
                        Lorem ipsum dolor sit amet consectetur. Volutpat vulputate a massa nulla eu et velit quis in. Adipiscing purus quis et nisl aliquet sagittis. Tortor sollicitudin...
                    </p>
                </div>
            </a>

            <!-- Card 2 -->
            <a href="{{ route('aksi-lingkungan-detail') }}" class="bg-white border border-slate-200/70 rounded-xl overflow-hidden flex flex-col group transition-all shadow-md hover:shadow-lg block">
                <div class="relative h-32 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1509423350716-97f9360b4e09?q=80&w=600&auto=format&fit=crop" 
                         alt="Tanaman Pembersih Udara" 
                         class="w-full h-full object-cover">
                </div>
                <div class="p-5 space-y-2">
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug group-hover:text-[#00A86B] transition-colors">
                        Gerakan menanam pohon pembersih udara
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 font-normal leading-relaxed">
                        Lorem ipsum dolor sit amet consectetur. Volutpat vulputate a massa nulla eu et velit quis in. Adipiscing purus quis et nisl aliquet sagittis. Tortor sollicitudin...
                    </p>
                </div>
            </a>

            <!-- Card 3 -->
            <a href="{{ route('aksi-lingkungan-detail') }}" class="bg-white border border-slate-200/70 rounded-xl overflow-hidden flex flex-col group transition-all shadow-md hover:shadow-lg block">
                <div class="relative h-32 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1541888946425-d0fbb186a5b7?q=80&w=600&auto=format&fit=crop" 
                         alt="Penghematan Air" 
                         class="w-full h-full object-cover">
                </div>
                <div class="p-5 space-y-2">
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug group-hover:text-[#00A86B] transition-colors">
                        Menghemat air bersih dan energi listrik sehari-hari
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 font-normal leading-relaxed">
                        Lorem ipsum dolor sit amet consectetur. Volutpat vulputate a massa nulla eu et velit quis in. Adipiscing purus quis et nisl aliquet sagittis. Tortor sollicitudin...
                    </p>
                </div>
            </a>
        </div>

        <!-- RIGHT COLUMN: DETAILED VIEW CARD (8 Columns) -->
        <div class="lg:col-span-8">
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-md hover:shadow-lg flex flex-col h-full overflow-hidden transition-all">
                
                <!-- Big Header Image attached directly to the top edge -->
                <div class="w-full h-64 sm:h-80 lg:h-96 bg-slate-100 shrink-0">
                    <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=1200&auto=format&fit=crop" 
                         alt="5 Langkah Mudah Jaga Bumi Setiap Hari" 
                         class="w-full h-full object-cover">
                </div>

                <!-- Padded Content Area below the image -->
                <div class="p-6 sm:p-8 flex flex-col flex-grow justify-between space-y-6">
                    
                    <!-- Text Area -->
                    <div class="space-y-4">
                        <h2 class="text-lg sm:text-xl font-bold text-slate-900">
                            5 Langkah Mudah Jaga Bumi Setiap Hari
                        </h2>
                        
                        <div class="space-y-4 text-xs sm:text-sm text-slate-500 leading-relaxed font-normal">
                            <p>
                                Lorem ipsum dolor sit amet consectetur. Nunc porta neque amet velit quis. Mattis suscipit fringilla quis metus sit in. Et odio viverra vel justo imperdiet tincidunt cursus sit adipiscing. Cras sed tristique mauris tortor pellentesque semper feugiat. Felis consequat tempor bibendum nulla ultrices vitae faucibus convallis sit. Sed consectetur sapien proin maecenas sed aliquet. Erat nulla tortor porta elementum amet posuere pharetra lobortis. Tempus eleifend sed facilisis pellentesque. Lacus vitae ipsum integer dignissim nibh eget duis sagittis.
                            </p>
                            <p>
                                Sagittis faucibus nunc pellentesque rhoncus mauris. Et mollis lorem tortor diam vitae neque dolor. Quis pulvinar integer purus ac lectus tempor a. Bibendum a neque accumsan lectus proin maecenas quam fermentum. Massa nisl nam accumsan cum risus orci.
                            </p>
                            <p>
                                Eu quis tellus tellus pellentesque dolor arcu ultricies. Libero non amet amet enim fringilla. Pretium ac aenean molestie nibh maecenas pulvinar elementum nunc. Nec mauris eget vel nec integer sed risus. Aliquam aliquet feugiat volutpat erat dui feugiat turpis. Mauris libero iaculis risus congue ipsum interdum odio. Cursus in interdum lacinia hendrerit sit elementum ultrices purus lectus. Enim sit fermentum proin odio. Diam nulla quam non tempor. Commodo ullamcorper scelerisque arcu in scelerisque nunc adipiscing eu. In imperdiet fermentum ac tellus. Aliquam scelerisque morbi nisl posuere id sapien eu ac semper...
                            </p>
                        </div>
                    </div>

                    <!-- Premium Pagination Component -->
                    <div class="pt-6 border-t border-slate-100 flex items-center justify-between sm:justify-end gap-3 text-xs font-semibold text-slate-500 mt-auto">
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

            </div>
        </div>

    </div>

</div>
@endsection

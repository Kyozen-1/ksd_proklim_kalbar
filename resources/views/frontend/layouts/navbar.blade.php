<header x-data="{ mobileOpen: false }" class="sticky top-0 z-50 bg-[#F9F9F9] border-b border-slate-200/80 shadow-xs">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10">
        <div class="flex items-center justify-between h-20">
            
            <!-- Left Brand Section -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group shrink-0">
                <img src="{{ asset('frontend/img/logo_pemprov_kalbar.webp') }}" 
                     alt="Logo Pemprov Kalbar" 
                     class="h-11 sm:h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                <div class="flex flex-col justify-center">
                    <span class="text-sm sm:text-base font-extrabold text-[#222222] tracking-tight leading-tight uppercase">
                        DLHK PROKLIM
                    </span>
                    <span class="text-[11px] sm:text-xs font-semibold text-[#00E58F] tracking-wide leading-tight uppercase">
                        KALIMANTAN BARAT
                    </span>
                </div>
            </a>

            <!-- Right Navigation Items (Desktop) -->
            <nav class="hidden xl:flex items-center space-x-1 lg:space-x-2">
                
                <!-- Beranda -->
                <a href="{{ route('home') }}" 
                   class="px-5 py-2 rounded-lg text-sm font-semibold transition-all duration-200 shadow-xs {{ request()->routeIs('home') ? 'bg-[#00E58F] text-white hover:bg-[#00d080]' : 'text-slate-800 hover:text-[#00E58F] hover:bg-slate-100' }}">
                    Beranda
                </a>

                <!-- PSLB3PP -->
                <a href="{{ route('pslb3pp') }}" 
                   class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 shadow-xs {{ request()->routeIs('pslb3pp') ? 'bg-[#00E58F] text-white hover:bg-[#00d080]' : 'text-slate-800 hover:text-[#00E58F] hover:bg-slate-100' }}">
                    PSLB3PP
                </a>

                <!-- Program dan Aksi Mega Dropdown Modal (Hover & Click) -->
                <div class="relative" 
                     x-data="{ dropdownOpen: false, hoverTimeout: null }"
                     @mouseenter="clearTimeout(hoverTimeout); dropdownOpen = true"
                     @mouseleave="hoverTimeout = setTimeout(() => { dropdownOpen = false }, 180)">
                    
                    <button @click="dropdownOpen = !dropdownOpen" 
                            type="button" 
                            class="px-4 py-2 rounded-lg text-sm font-semibold inline-flex items-center gap-1.5 transition-all focus:outline-none cursor-pointer {{ request()->routeIs(['edukasi', 'aksi-lingkungan', 'aksi-lingkungan-detail', 'data', 'about']) ? 'bg-[#00E58F] text-white' : 'text-slate-800 hover:text-[#00E58F] hover:bg-slate-100' }}"
                            :class="dropdownOpen ? ({{ request()->routeIs(['edukasi', 'aksi-lingkungan', 'aksi-lingkungan-detail', 'data', 'about']) ? 'false' : 'true' }} ? 'bg-[#D1FADF] text-[#00C875]' : 'bg-[#00E58F] text-white') : ''">
                        <span>Program dan Aksi</span>
                        <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200" :class="{ 'rotate-180': dropdownOpen }"></i>
                    </button>

                    <!-- Mega Dropdown Modal -->
                    <div x-show="dropdownOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-3 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-3 scale-95"
                         class="absolute left-1/2 -translate-x-1/2 md:left-0 md:translate-x-0 mt-3 w-[440px] sm:w-[480px] rounded-2xl bg-white shadow-2xl border border-slate-100/90 p-5 sm:p-6 z-50"
                         style="display: none;"
                         @click.away="dropdownOpen = false">
                        
                        <div class="grid grid-cols-2 gap-x-5 gap-y-5">
                            
                            <!-- Column 1 -->
                            <div class="space-y-6">
                                <!-- PROKLIM -->
                                <a href="{{ route('data') }}" class="flex items-start gap-3 group">
                                    <i class="fa-solid fa-chevron-right text-[#00E58F] text-xs mt-1 transition-transform group-hover:translate-x-1"></i>
                                    <div>
                                        <h4 class="text-sm font-bold text-[#1A1A1A] group-hover:text-[#00E58F] transition-colors leading-none">PROKLIM</h4>
                                        <p class="text-xs font-medium text-[#00E58F] mt-1.5 leading-snug">Program Kampung Iklim</p>
                                    </div>
                                </a>

                                <!-- IGRK -->
                                <a href="{{ route('data') }}" class="flex items-start gap-3 group">
                                    <i class="fa-solid fa-chevron-right text-[#00E58F] text-xs mt-1 transition-transform group-hover:translate-x-1"></i>
                                    <div>
                                        <h4 class="text-sm font-bold text-[#1A1A1A] group-hover:text-[#00E58F] transition-colors leading-none">IGRK</h4>
                                        <p class="text-xs font-medium text-[#00E58F] mt-1.5 leading-snug">Inventaris Gas Rumah Kaca</p>
                                    </div>
                                </a>

                                <!-- Sampah -->
                                <a href="{{ route('data') }}" class="flex items-start gap-3 group">
                                    <i class="fa-solid fa-chevron-right text-[#00E58F] text-xs mt-1 transition-transform group-hover:translate-x-1"></i>
                                    <div>
                                        <h4 class="text-sm font-bold text-[#1A1A1A] group-hover:text-[#00E58F] transition-colors leading-none">Sampah</h4>
                                        <p class="text-xs font-medium text-[#00E58F] mt-1.5 leading-snug">Informasi seputar Pengelolaan sampah</p>
                                    </div>
                                </a>
                            </div>

                            <!-- Column 2 -->
                            <div class="space-y-6">
                                <!-- Kualitas Lingkungan -->
                                <a href="{{ route('about') }}" class="flex items-start gap-3 group">
                                    <i class="fa-solid fa-chevron-right text-[#00E58F] text-xs mt-1 transition-transform group-hover:translate-x-1"></i>
                                    <div>
                                        <h4 class="text-sm font-bold text-[#1A1A1A] group-hover:text-[#00E58F] transition-colors leading-none">Kualitas Lingkungan</h4>
                                        <p class="text-xs font-medium text-[#00E58F] mt-1.5 leading-snug">Informasi seputar kualitas lingkungan</p>
                                    </div>
                                </a>

                                <!-- LB3 -->
                                <a href="{{ route('about') }}" class="flex items-start gap-3 group">
                                    <i class="fa-solid fa-chevron-right text-[#00E58F] text-xs mt-1 transition-transform group-hover:translate-x-1"></i>
                                    <div>
                                        <h4 class="text-sm font-bold text-[#1A1A1A] group-hover:text-[#00E58F] transition-colors leading-none">LB3</h4>
                                        <p class="text-xs font-medium text-[#00E58F] mt-1.5 leading-snug">Limbah Bahan Berbahaya Beracun</p>
                                    </div>
                                </a>

                                <!-- Edukasi -->
                                <a href="{{ route('edukasi') }}" class="flex items-start gap-3 group">
                                    <i class="fa-solid fa-chevron-right text-[#00E58F] text-xs mt-1 transition-transform group-hover:translate-x-1"></i>
                                    <div>
                                        <h4 class="text-sm font-bold text-[#1A1A1A] group-hover:text-[#00E58F] transition-colors leading-none">Edukasi</h4>
                                        <p class="text-xs font-medium text-[#00E58F] mt-1.5 leading-snug">Edukasi mengenai aksi hijau, manajemen TPS3R, dan adaptasi mitigasi iklim</p>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Regulasi -->
                <a href="{{ route('regulasi') }}" 
                   class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 shadow-xs {{ request()->routeIs('regulasi') ? 'bg-[#00E58F] text-white hover:bg-[#00d080]' : 'text-slate-800 hover:text-[#00E58F] hover:bg-slate-100' }}">
                    Regulasi
                </a>

                <!-- Berita -->
                <a href="{{ route('berita') }}" 
                   class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 shadow-xs {{ request()->routeIs(['berita', 'berita-detail']) ? 'bg-[#00E58F] text-white hover:bg-[#00d080]' : 'text-slate-800 hover:text-[#00E58F] hover:bg-slate-100' }}">
                    Berita
                </a>

                <!-- Galeri -->
                <a href="{{ route('galeri') }}" 
                   class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 shadow-xs {{ request()->routeIs('galeri') ? 'bg-[#00E58F] text-white hover:bg-[#00d080]' : 'text-slate-800 hover:text-[#00E58F] hover:bg-slate-100' }}">
                    Galeri
                </a>

                <!-- FAQ -->
                <a href="{{ route('faq') }}" 
                   class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 shadow-xs {{ request()->routeIs('faq') ? 'bg-[#00E58F] text-white hover:bg-[#00d080]' : 'text-slate-800 hover:text-[#00E58F] hover:bg-slate-100' }}">
                    FAQ
                </a>

                <!-- Laporan -->
                <a href="{{ route('laporan') }}" 
                   class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 shadow-xs {{ request()->routeIs('laporan') ? 'bg-[#00E58F] text-white hover:bg-[#00d080]' : 'text-slate-800 hover:text-[#00E58F] hover:bg-slate-100' }}">
                    Laporan
                </a>

            </nav>

            <!-- Mobile Hamburger Button -->
            <div class="flex xl:hidden items-center">
                <button @click="mobileOpen = !mobileOpen" 
                        type="button" 
                        class="inline-flex items-center justify-center p-2.5 rounded-xl text-slate-700 hover:text-[#00E58F] hover:bg-slate-100 focus:outline-none transition-colors">
                    <span class="sr-only">Buka Menu</span>
                    <i x-show="!mobileOpen" class="fa-solid fa-bars text-xl"></i>
                    <i x-show="mobileOpen" class="fa-solid fa-xmark text-xl" style="display: none;"></i>
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile Drawer -->
    <div x-show="mobileOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         id="mobile-menu" 
         class="xl:hidden border-b border-slate-200 bg-[#F9F9F9] px-4 pt-3 pb-6 space-y-1.5 shadow-lg"
         style="display: none;">
        
        <a href="{{ route('home') }}" 
           class="block px-4 py-2.5 rounded-lg text-base font-semibold {{ request()->routeIs('home') ? 'bg-[#00E58F] text-white' : 'text-slate-800 hover:bg-slate-100' }}">
            Beranda
        </a>

        <a href="{{ route('pslb3pp') }}" 
           class="block px-4 py-2.5 rounded-lg text-base font-medium text-slate-800 hover:bg-slate-100">
            PSLB3PP
        </a>

        <!-- Mobile Accordion for Program dan Aksi -->
        <div x-data="{ subOpen: false }">
            <button @click="subOpen = !subOpen" class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-base font-medium text-slate-800 hover:bg-slate-100">
                <span>Program dan Aksi</span>
                <i class="fa-solid fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': subOpen }"></i>
            </button>
            <div x-show="subOpen" class="pl-6 space-y-2 py-2">
                <a href="{{ route('data') }}" class="block text-sm font-semibold text-[#00E58F]">PROKLIM (Program Kampung Iklim)</a>
                <a href="{{ route('data') }}" class="block text-sm font-semibold text-[#00E58F]">IGRK (Inventaris Gas Rumah Kaca)</a>
                <a href="{{ route('data') }}" class="block text-sm font-semibold text-[#00E58F]">Sampah (Pengelolaan Sampah)</a>
                <a href="{{ route('about') }}" class="block text-sm font-semibold text-[#00E58F]">Kualitas Lingkungan</a>
                <a href="{{ route('about') }}" class="block text-sm font-semibold text-[#00E58F]">LB3 (Limbah Bahan Berbahaya Beracun)</a>
                <a href="{{ route('edukasi') }}" class="block text-sm font-semibold text-[#00E58F]">Edukasi Aksi Hijau</a>
            </div>
        </div>

        <a href="{{ route('regulasi') }}" 
           class="block px-4 py-2.5 rounded-lg text-base font-medium text-slate-800 hover:bg-slate-100">
            Regulasi
        </a>

        <a href="{{ route('berita') }}" 
           class="block px-4 py-2.5 rounded-lg text-base font-medium text-slate-800 hover:bg-slate-100">
            Berita
        </a>

        <a href="{{ route('galeri') }}" 
           class="block px-4 py-2.5 rounded-lg text-base font-medium text-slate-800 hover:bg-slate-100">
            Galeri
        </a>

        <a href="{{ route('faq') }}" 
           class="block px-4 py-2.5 rounded-lg text-base font-medium text-slate-800 hover:bg-slate-100">
            FAQ
        </a>

        <a href="{{ route('laporan') }}" 
           class="block px-4 py-2.5 rounded-lg text-base font-medium text-slate-800 hover:bg-slate-100">
            Laporan
        </a>
    </div>
</header>

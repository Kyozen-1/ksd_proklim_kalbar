<div class="left-side-menu">

    <div class="slimscroll-menu">
        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul class="metismenu" id="side-menu">
                @if (auth()->user()->role == 'superadmin' || auth()->user()->role == 'admin')
                    <li>
                        <a href="{{ route('cms.dashboard.index') }}">
                            <i class="mdi mdi-view-dashboard"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cms.kualitas-lingkungan.index') }}">
                            <i class="mdi mdi-leaf"></i>
                            <span> Kualitas Lingkungan </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cms.timbulan-lb3.index') }}">
                            <i class="mdi mdi-delete-alert"></i>
                            <span> Timbulan LB3 </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cms.berita.index') }}">
                            <i class="mdi mdi-newspaper"></i>
                            <span> Berita </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cms.kegiatan.index') }}">
                            <i class="mdi mdi-post-outline"></i>
                            <span> Kegiatan </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cms.anggota-pelaksana.index') }}">
                            <i class="mdi mdi-account-group"></i>
                            <span> Anggota Pelaksana </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cms.dokumen.index') }}">
                            <i class="mdi mdi-folder-open"></i>
                            <span> Dokumen </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cms.faq.index') }}">
                            <i class="mdi mdi-frequently-asked-questions"></i>
                            <span> FAQ </span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->role == 'superadmin')
                    <li>
                        <a href="{{ route('cms.landing-page.index') }}">
                            <i class="mdi mdi-view-dashboard-outline"></i>
                            <span> Landing Page </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);">
                            <i class="mdi mdi-format-list-bulleted"></i>
                            <span> Master Data </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level nav" aria-expanded="false">
                            <li><a href="{{ route('cms.master-data.kategori-proklim.index') }}">Kategori Proklim</a></li>
                            <li>
                                <a href="javascript: void(0);" aria-expanded="false">Emisi
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-third-level nav" aria-expanded="false">
                                    <li><a href="{{ route('cms.master-data.sektor-utama-emisi.index') }}">Sektor Utama Emisi</a></li>
                                    <li><a href="{{ route('cms.master-data.jenis-emisi.index') }}">Jenis Emisi</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('cms.master-data.kategori-sampah.index') }}">Kategori Sampah</a></li>
                            <li><a href="{{ route('cms.master-data.kategori-kualitas-lingkungan.index') }}">Kategori Kualitas Lingkungan</a></li>
                            <li><a href="{{ route('cms.master-data.sektor-lb3.index') }}">Sektor Lb3</a></li>
                            <li><a href="{{ route('cms.master-data.jabatan.index') }}">Jabatan</a></li>
                            <li><a href="{{ route('cms.master-data.section-landing-page.index') }}">Section Landing Page</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);">
                            <i class="mdi mdi-cog"></i>
                            <span> Pengaturan </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="{{ route('cms.pengaturan.api-client.index') }}">API Client</a></li>
                            <li><a href="{{ route('cms.pengaturan.api-permission.index') }}">API Permission</a></li>
                        </ul>
                    </li>
                @endif
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>

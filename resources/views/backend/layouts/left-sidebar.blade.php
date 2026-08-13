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
                        <a href="javascript: void(0);">
                            <i class="mdi mdi-format-list-bulleted"></i>
                            <span> Master Data </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="{{ route('cms.master-data.jabatan.index') }}">Jabatan</a></li>
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

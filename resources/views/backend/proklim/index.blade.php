@extends('backend.layouts.app')

@section('title', 'Daftar Proklim | PROKLIM Kalimantan Barat')
@section('header', 'Daftar Proklim')

@section('css')
    <link href="{{ asset('/backend_template/libs/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/datatables/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/datatables/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/datatables/select.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/custombox/custombox.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        .table th {
            text-align: center;
        }
        .table td {
            justify-content: center;
            text-align: center;
        }
        .select2-container .select2-selection--single {
            height: 38px;
            display: flex;
            align-items: center;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .select2-container--default
        .select2-selection--single
        .select2-selection__rendered {
            line-height: 38px;
            padding-left: 10px;
        }

        .select2-container--default
        .select2-selection--single
        .select2-selection__arrow {
            height: 38px;
            top: 0;
        }

        .select2-container--default
        .select2-selection--multiple
        .select2-selection__choice {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
        }

        .modal-xxl {
            max-width: 95%;
        }

        #proklim_map {
            width: 100%;
            height: 560px;
            min-height: 450px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        .map-wrapper {
            position: relative;
        }

        .map-search-box {
            position: absolute;
            top: 12px;
            left: 60px;
            right: 55px;
            z-index: 1000;
        }

        .map-search-box .input-group {
            box-shadow: 0 2px 8px rgba(0, 0, 0, .18);
        }

        .map-search-box .form-control {
            height: 42px;
        }

        .map-search-box .btn {
            height: 42px;
        }

        .map-coordinate-info {
            position: absolute;
            left: 12px;
            bottom: 12px;
            z-index: 1000;
            background: rgba(255, 255, 255, .95);
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .15);
        }

        .map-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .map-card-header h5 {
            margin-bottom: 2px;
        }

        .map-help {
            font-size: 12px;
            color: #6c757d;
            margin-top: 8px;
        }

        .coordinate-input {
            background-color: #f8f9fa !important;
            cursor: not-allowed;
        }

        .form-section-title {
            font-size: 14px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e9ecef;
        }

        .required {
            color: #dc3545;
        }

        .leaflet-control-layers {
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .18);
        }

        @media (max-width: 991.98px) {
            #proklim_map {
                height: 450px;
            }

            .map-search-box {
                left: 60px;
                right: 12px;
            }
        }

        #detail_map {
            width: 100%;
            height: 500px;
        }

        .detail-item {
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }

        .detail-item:last-child {
            border-bottom: 0;
        }

        .detail-label {
            font-size: 12px;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .detail-value {
            font-size: 14px;
            color: #343a40;
            line-height: 1.6;
        }

        .detail-description {
            white-space: pre-line;
        }

        @media (max-width: 991.98px) {
            #detail_map {
                height: 400px;
            }
        }
    </style>

@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box table-responsive">
                <div class="row mb-3">
                    <div class="col-md-7">
                        <h4 class="mt-0 header-title"> Daftar Proklim</h4>
                        <p class="text-muted mb-0"> Daftar Proklim berdasarkan kabupaten/kota, kecamatan, kelurahan, kategori dan tahun.</p>
                    </div>
                    <div class="col-md-5 text-right">
                        <button class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#createModal" id="create" name="create"><i class="fas fa-plus mr-1"></i> Tambah Data </button>
                    </div>
                </div>
                <div class="card border mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group mb-2">
                                    <label class="filter-label"> KABUPATEN / KOTA </label>
                                    <select id="filter_kabupaten_kota" class="form-control select2">
                                        <option value=""> Semua Kabupaten / Kota </option>
                                        @foreach ($kabupatenKotas as $kabupatenKota)
                                            <option value="{{ $kabupatenKota['id'] }}">{{ $kabupatenKota['nama'] }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="form-group mb-2">
                                    <label class="filter-label">Kecamatan</label>
                                    <select id="filter_kecamatan" class="form-control select2" disabled>
                                        <option value=""> Semua Kecamatan </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="form-group mb-2">
                                    <label class="filter-label"> Kelurahan </label>
                                    <select id="filter_kelurahan" class="form-control select2" disabled>
                                        <option value=""> Semua Kelurahan </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="form-group mb-2">
                                    <label class="filter-label">Kategori</label>
                                    <select id="filter_kategori" class="form-control select2">
                                        <option value=""> Semua Kategori </option>
                                        @foreach ($kategoriProklims as $kategoriProklim)
                                            <option value="{{ $kategoriProklim['id'] }}"> {{ $kategoriProklim['nama'] }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group mb-2">
                                    <label class="filter-label"> TAHUN </label>
                                    <select id="filter_tahun" class="form-control select2">
                                        <option value=""> Semua Tahun </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <label class="filter-label"> &nbsp; </label>
                                <button type="button" id="btn_reset_filter" class="btn btn-light btn-block" title="Reset Filter"> <i class="fas fa-sync-alt"></i> </button>
                            </div>
                        </div>
                    </div>
                </div>

                <table id="table_proklim" class="table table-bordered table-striped dt-responsive nowrap" width="100%">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Aksi</th>
                            <th>Kabupaten / Kota</th>
                            <th>Kecamatan</th>
                            <th>Kelurahan</th>
                            <th>Kategori</th>
                            <th>Nama</th>
                            <th>Tanggal Aktif</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div id="createModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xxl">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h4 class="modal-title mb-1" id="createModalLabel"> Tambah Data Proklim</h4>
                        <small class="text-muted"> Lengkapi informasi dan tentukan lokasi Proklim pada peta. </small>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> × </button>
                </div>

                <div class="modal-body">
                    <span id="form_result"></span>
                    <form class="form-horizontal" id="form_proklim" method="POST" data-parsley-validate novalidate>
                        @csrf
                        <input type="hidden" name="id" id="hidden_id">
                        <input type="hidden" name="aksi" id="aksi" value="Save">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="form-section-title">
                                    <i class="fas fa-info-circle mr-1"></i> Informasi Proklim
                                </div>
                                <div class="form-group">
                                    <label for="kabupaten_kota_id"> Kabupaten / Kota <span class="required">*</span> </label>
                                    <select name="kabupaten_kota_id" id="kabupaten_kota_id" class="form-control select2" required>
                                        <option value=""> Pilih Kabupaten / Kota </option>
                                        @foreach ($kabupatenKotas as $kabupatenKota)
                                            <option value="{{ $kabupatenKota['id'] }}"> {{ $kabupatenKota['nama'] }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="kecamatan_id"> Kecamatan <span class="required">*</span> </label>
                                    <select name="kecamatan_id" id="kecamatan_id" class="form-control select2" disabled required>
                                        <option value=""> Pilih Kecamatan </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="kelurahan_id"> Kelurahan <span class="required">*</span> </label>
                                    <select name="kelurahan_id" id="kelurahan_id" class="form-control select2" disabled required>
                                        <option value=""> Pilih Kelurahan </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="kategori_proklim_id"> Kategori Proklim <span class="required"> * </span> </label>
                                    <select name="kategori_proklim_id" id="kategori_proklim_id" class="form-control select2" required>
                                        <option value=""> Pilih Kategori Proklim </option>
                                        @foreach ($kategoriProklims as $kategoriProklim)
                                            <option value="{{ $kategoriProklim['id'] }}"> {{ $kategoriProklim['nama'] }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nama"> Nama <span class="required"> * </span> </label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama Proklim" required>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi <span class="required"> * </span> </label>
                                    <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control" placeholder="Masukkan deskripsi Proklim" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="alamat"> Alamat <span class="required"> * </span> </label>
                                    <textarea name="alamat" id="alamat" rows="4" class="form-control" placeholder="Masukkan alamat lokasi Proklim" required></textarea>
                                </div>
                                <div class="form-section-title mt-4"><i class="fas fa-map-marker-alt mr-1"></i> Koordinat Lokasi </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lng"> Longitude </label>
                                            <input type="text" class="form-control coordinate-input" id="lng" name="lng" placeholder="Otomatis dari peta" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lat"> Latitude </label>
                                            <input type="text" class="form-control coordinate-input" id="lat" name="lat" placeholder="Otomatis dari peta" readonly required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_aktif"> Tanggal Aktif <span class="required"> * </span></label>
                                    <input type="date" class="form-control" id="tanggal_aktif" name="tanggal_aktif" required>
                                </div>
                            </div>

                            <div class="col-lg-7">
                                <div class="form-section-title">
                                    <i class="fas fa-map mr-1"></i> Penentuan Lokasi
                                </div>
                                <div class="card border mb-0">
                                    <div class="card-body p-2">
                                        <div class="map-wrapper">
                                            <div class="map-search-box">
                                                <div class="input-group">
                                                    <input type="text" id="map_search" class="form-control" autocomplete="off" placeholder="Cari nama tempat, alamat, desa, kecamatan...">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-primary" id="btn_map_search" title="Cari lokasi"> <i class="fas fa-search"></i> </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="proklim_map"></div>
                                            <div class="map-coordinate-info">
                                                <i class="fas fa-crosshairs mr-1"></i>
                                                <span id="map_coordinate_text"> Belum ada lokasi dipilih </span>
                                            </div>
                                        </div>
                                        <div class="map-help">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Klik pada peta untuk menentukan lokasi Proklim. Anda juga dapat mencari lokasi menggunakan kotak pencarian di atas.
                                        </div>
                                    </div>
                                </div>
                                <div class="alert alert-light border mt-3 mb-0">
                                    <div class="d-flex">
                                        <div class="mr-2">
                                            <i class="fas fa-layer-group text-primary"></i>
                                        </div>
                                        <div>
                                            <strong>Pilihan tampilan peta</strong>
                                            <div class="small text-muted mt-1">
                                                Gunakan kontrol layer di kanan atas peta untuk memilih <strong>Street</strong>, <strong>Satellite</strong>, atau <strong>Topographic</strong>.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal"> Close </button>
                    <button type="submit" form="form_proklim" name="aksi_button" id="aksi_button" class="btn btn-primary waves-effect"> Save </button>
                </div>
            </div>
        </div>
    </div>

    <div id="detailModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xxl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="detailModalLabel">Detail Data Proklim </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div id="detail_result"></div>
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="card border mb-3">
                                <div class="card-header">
                                    <h5 class="mb-0">Informasi Proklim</h5>
                                </div>
                                <div class="card-body">
                                    <div class="detail-item">
                                        <div class="detail-label">Nama</div>
                                        <div class="detail-value" id="detail_nama"> - </div>
                                    </div>

                                    <div class="detail-item">
                                        <div class="detail-label">Kategori Proklim</div>
                                        <div class="detail-value" id="detail_kategori"> - </div>
                                    </div>

                                    <div class="detail-item">
                                        <div class="detail-label">Kabupaten / Kota</div>
                                        <div class="detail-value" id="detail_kabupaten"> - </div>
                                    </div>

                                    <div class="detail-item">
                                        <div class="detail-label"> Kecamatan </div>
                                        <div class="detail-value" id="detail_kecamatan"> - </div>
                                    </div>

                                    <div class="detail-item">
                                        <div class="detail-label"> Kelurahan </div>
                                        <div class="detail-value" id="detail_kelurahan"> - </div>
                                    </div>

                                    <div class="detail-item">
                                        <div class="detail-label"> Tanggal Aktif </div>
                                        <div class="detail-value" id="detail_tanggal_aktif"> - </div>
                                    </div>

                                    <div class="detail-item">
                                        <div class="detail-label"> Alamat </div>
                                        <div class="detail-value" id="detail_alamat"> - </div>
                                    </div>

                                    <div class="detail-item">
                                        <div class="detail-label"> Deskripsi </div>
                                        <div class="detail-value detail-description" id="detail_deskripsi"> - </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="card border">
                                <div class="card-header">
                                    <h5 class="mb-0"> Lokasi Proklim </h5>
                                </div>
                                <div class="card-body p-0">
                                    <div id="detail_map"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script src="{{ asset('/backend_template/libs/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/dataTables.select.min.js') }}"></script>

    <script src="{{ asset('/backend_template/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/pdfmake/vfs_fonts.js') }}"></script>

    <script src="{{ asset('/backend_template/js/pages/datatables.init.js') }}"></script>

    <script src="{{ asset('/backend_template/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('/backend_template/js/pages/form-validation.init.js') }}"></script>

    <script src="{{ asset('/backend_template/libs/dropify/dropify.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        let kecamatanOption = '';
        let kelurahanOption = '';

        $('.select2').select2({
            width: '100%'
        });

        const currentYear = new Date().getFullYear();
        const startYear = 2000;

        for (let year = currentYear; year >= startYear; year--) {
            $('#filter_tahun').append(
                `<option value="${year}">${year}</option>`
            );
        }

        var dataTables = $('#table_proklim').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('cms.proklim.datatable') }}",
                data: function(d) {
                    d.kabupaten_kota_id = $('#filter_kabupaten_kota').val();
                    d.kecamatan_id = $('#filter_kecamatan').val();
                    d.kelurahan_id = $('#filter_kelurahan').val();
                    d.kategori_proklim_id = $('#filter_kategori').val();
                    d.tahun = $('#filter_tahun').val();
                }
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'kabupaten_kota_id',
                    name: 'kabupaten_kota_id'
                },
                {
                    data: 'kecamatan_id',
                    name: 'kecamatan_id'
                },
                {
                    data: 'kelurahan_id',
                    name: 'kelurahan_id'
                },
                {
                    data: 'kategori_proklim_id',
                    name: 'kategori_proklim_id'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'tanggal_aktif',
                    name: 'tanggal_aktif'
                }
            ]
        });

        $('#filter_kabupaten_kota, #filter_kecamatan, #filter_kelurahan, #filter_kategori, #filter_tahun' ).on('change', function() {
                dataTables.ajax.reload();
            }
        );

        $('#btn_reset_filter').on( 'click', function() {
            $('#filter_kabupaten_kota').val('').trigger('change');
            $('#filter_kecamatan').val('').trigger('change');
            $('#filter_kelurahan').val('').trigger('change');
            $('#filter_kategori').val('').trigger('change');
            $('#filter_tahun').val('').trigger('change');
        });

        $('#filter_kabupaten_kota').change(function() {
            const id = $(this).val();
            if (id !== '') {
                $.ajax({
                    url: "{{ route('cms.proklim.get-kecamatan') }}",
                    method: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id
                    },
                    success: function(data) {
                        $('#filter_kecamatan').empty().prop('disabled', false).append('<option value="">Semua Kecamatan</option>');
                        $('#filter_kelurahan').empty().prop('disabled', true).append('<option value="">Semua Kelurahan</option>');
                        $.each(data, function(key, value) {
                            $('#filter_kecamatan').append(new Option(value.nama,value.id));
                        });
                        $('#filter_kecamatan').trigger('change');
                    }
                });
            } else {
                $('#filter_kecamatan').empty().prop('disabled', true).append('<option value="">Semua Kecamatan</option>').val('').trigger('change');
                $('#filter_kelurahan').empty().prop('disabled', true).append('<option value="">Semua Kelurahan</option>').val('').trigger('change');
            }
        });

        $('#filter_kecamatan').change(function() {
            const id = $(this).val();
            if (id !== '') {
                $.ajax({
                    url: "{{ route('cms.proklim.get-kelurahan') }}",
                    method: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id
                    },
                    success: function(data) {
                        $('#filter_kelurahan').empty().prop('disabled', false).append('<option value="">Semua Kelurahan</option>');
                        $.each(data,function(key, value) {
                            $('#filter_kelurahan').append(new Option(value.nama,value.id));
                        });
                        $('#filter_kelurahan').trigger('change');
                    }
                });
            } else {
                $('#filter_kelurahan').empty().prop('disabled', true).append('<option value="">Semua Kelurahan</option>').val('').trigger('change');
            }
        });

        let proklimMap = null;
        let proklimMarker = null;
        let mapInitialized = false;

        const defaultMapCenter = [0.1327,109.4059];
        const defaultMapZoom = 7;

        const streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        });

        const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri',
            maxZoom: 19
        });


        const topoLayer = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; OpenStreetMap contributors, SRTM | Map style &copy; OpenTopoMap',
            maxZoom: 17
        });

        function initializeProklimMap() {
            if (mapInitialized) {
                return;
            }

            proklimMap = L.map('proklim_map', {
                center: defaultMapCenter,
                zoom: defaultMapZoom,
                layers: [
                    streetLayer
                ],
                zoomControl: true
            });

            const baseMaps = {
                "Street": streetLayer,
                "Satellite": satelliteLayer,
                "Topographic": topoLayer
            };

            L.control.layers( baseMaps, null, {
                position: 'topright',
                collapsed: true
            }).addTo(proklimMap);

            proklimMap.on('click', function(e) {
                setProklimLocation(e.latlng.lat, e.latlng.lng, true);
            });
            mapInitialized = true;

            setTimeout( function() {
                proklimMap.invalidateSize();
            },300);
        }

        function setProklimLocation(lat, lng, moveMap = true) {
            lat = parseFloat(lat);
            lng = parseFloat(lng);

            if (isNaN(lat) || isNaN(lng)) {
                return;
            }

            $('#lat').val(lat.toFixed(7));
            $('#lng').val(lng.toFixed(7));
            $('#map_coordinate_text').text(
                'Lat: ' + lat.toFixed(7) + ' | Lng: ' + lng.toFixed(7)
            );
            const location = [lat, lng];

            if (proklimMarker) {
                proklimMarker.setLatLng(location);
            } else {
                proklimMarker = L.marker(location, {
                    draggable: false
                }).addTo(proklimMap);
            }
            if (moveMap) {
                proklimMap.setView(location, Math.max(proklimMap.getZoom(), 15));
            }
        }

        function clearProklimLocation() {
            $('#lat').val('');
            $('#lng').val('');
            $('#map_coordinate_text').text('Belum ada lokasi dipilih');
            if (proklimMarker) {
                proklimMap.removeLayer(proklimMarker);
                proklimMarker = null;
            }

            if (proklimMap) {
                proklimMap.setView(defaultMapCenter, defaultMapZoom);
            }
        }

        function searchMapLocation() {
            const keyword = $.trim($('#map_search').val());
            if (!keyword) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Lokasi belum diisi',
                    text:'Masukkan lokasi yang ingin dicari.'
                });
                return;
            }

            $('#btn_map_search').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

            $.ajax({
                url:'https://nominatim.openstreetmap.org/search',
                method: 'GET',
                dataType: 'json',
                data: {
                    q: keyword,
                    format: 'json',
                    limit: 1,
                    countrycodes: 'id',
                    addressdetails: 1
                },
                success: function(data) {
                    if (!data ||data.length === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Lokasi tidak ditemukan',
                            text: 'Lokasi yang Anda cari tidak ditemukan.'
                        });
                        return;
                    }
                    const result = data[0];
                    const lat = parseFloat(result.lat);
                    const lng = parseFloat(result.lon);
                    setProklimLocation(lat, lng, true);
                    $('#map_search').val(result.display_name || keyword);
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Pencarian gagal',
                        text: 'Lokasi tidak dapat dicari. Silakan coba lagi.'
                    });
                },
                complete: function() {
                    $('#btn_map_search').prop('disabled', false).html('<i class="fas fa-search"></i>');
                }
            });
        }

        $('#btn_map_search').on('click', function() {
            searchMapLocation();
        });

        $('#map_search').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                searchMapLocation();
            }
        });

        $('#createModal').on('shown.bs.modal', function() {
            initializeProklimMap();
            setTimeout(function() {
                proklimMap.invalidateSize();
            },300);
        });

        function resetProklimForm() {
            $('#form_proklim')[0].reset();
            $('#hidden_id').val('');
            $('#aksi').val('Save');
            $('#kabupaten_kota_id').val('').trigger('change');
            $('#kecamatan_id').empty().append('<option value="">Pilih Kecamatan</option>').val('').prop('disabled', true).trigger('change');
            $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>').val('').prop('disabled', true).trigger('change');
            $('#kategori_proklim_id').val('').trigger('change');
            $('#map_search').val('');
            clearProklimLocation();
            $('#form_result').html('');
            $('#aksi_button').text('Save').prop('disabled',false);
            $('#createModalLabel').text('Tambah Data Proklim');
        }

        $('#create').on('click', function() {
            resetProklimForm();
        });

        $('#kabupaten_kota_id').on('change', function() {
            const id = $(this).val();
            $('#kecamatan_id').empty().append('<option value="">Pilih Kecamatan</option>').val('').prop('disabled', true).trigger('change');
            $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>').val('').prop('disabled',true).trigger('change');
            if (!id) {
                return;
            }

            $.ajax({
                url:"{{ route('cms.proklim.get-kecamatan') }}",
                method:'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                success: function(data) {
                    $('#kecamatan_id').empty().append('<option value="">Pilih Kecamatan</option>').prop('disabled', false);
                    $.each(data, function(key, value) {
                        $('#kecamatan_id').append(new Option(value.nama, value.id));
                    });

                    if(kecamatanOption !== '')
                    {
                        let targetKecamatan = $.trim(kecamatanOption);
                        let valueKecamatan = $('#kecamatan_id option').filter(function() {
                            return $.trim($(this).text()) === targetKecamatan;
                        }).val();

                        if (!valueKecamatan) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Kecamatan tidak ditemukan',
                                text: 'Kecamatan dari data tidak tersedia pada pilihan form.'
                            });
                            return;
                        }
                        $('#kecamatan_id').val(valueKecamatan).trigger('change');
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Data kecamatan gagal dimuat.'
                    });
                }
            });
        });

        $('#kecamatan_id').on('change', function() {
            const id = $(this).val();
            $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>').val('').prop('disabled', true).trigger('change');

            if (!id) {
                return;
            }

            $.ajax({
                url:"{{ route('cms.proklim.get-kelurahan') }}",
                method:'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                success: function(data) {
                    $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>').prop('disabled', false);
                    $.each(data, function(key, value) {
                        $('#kelurahan_id').append(new Option(value.nama, value.id));
                    });

                    if(kelurahanOption !== '')
                    {
                        let targetKelurahan = $.trim(kelurahanOption);
                        let valueKelurahan = $('#kelurahan_id option').filter(function() {
                            return $.trim($(this).text()) === targetKelurahan;
                        }).val();

                        if (!valueKelurahan) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Kelurahan tidak ditemukan',
                                text: 'Kelurahan dari data tidak tersedia pada pilihan form.'
                            });
                            return;
                        }
                        $('#kelurahan_id').val(valueKelurahan).trigger('change');
                    }
                },
                error: function() {
                    Swal.fire({
                        icon:'error',
                        title:'Gagal',
                        text:'Data kelurahan gagal dimuat.'
                    });
                }
            });

        });

        $('#createModal').on('hidden.bs.modal', function() {
            resetProklimForm();
        });

        let detailProklimMap = null;
        let detailProklimMarker = null;

        $(document).on('click', '.detail', function() {
            const id = $(this).attr('id');
            $('#detail_result').html('');
            $('#detail_nama').text('-');
            $('#detail_kategori').text('-');
            $('#detail_kabupaten').text('-');
            $('#detail_kecamatan').text('-');
            $('#detail_kelurahan').text('-');
            $('#detail_tanggal_aktif').text('-');
            $('#detail_alamat').text('-');
            $('#detail_deskripsi').text('-');
            $('#detailModal').modal('show');

            $.ajax({
                url: "{{ route('cms.proklim.detail', ['id' => '__ID__']) }}" .replace('__ID__', id),
                method: "GET",
                dataType: "json",
                success: function(response) {
                    if (!response.success) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.errors || 'Data Proklim gagal dimuat.'
                        });
                        $('#detailModal').modal('hide');
                        return;
                    }
                    const data = response.result;
                    $('#detail_nama').text(data.nama || '-');
                    $('#detail_kategori').text(data.kategori_proklim || '-');
                    $('#detail_kabupaten').text(data.kabupaten_kota || '-');
                    $('#detail_kecamatan').text(data.kecamatan || '-');
                    $('#detail_kelurahan').text(data.kelurahan || '-');
                    $('#detail_tanggal_aktif').text(data.tanggal_aktif || '-');
                    $('#detail_alamat').text(data.alamat || '-');
                    $('#detail_deskripsi').text(data.deskripsi || '-');
                    initDetailProklimMap(data.lat, data.lng, data.nama);
                },
                error: function(xhr) {
                    let message = 'Data Proklim gagal dimuat.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        message =xhr.responseJSON.errors;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: message
                    });
                    $('#detailModal').modal('hide');
                }
            });
        });

        function initDetailProklimMap(lat, lng, nama) {
            lat = parseFloat(lat);
            lng = parseFloat(lng);
            if (isNaN(lat) || isNaN(lng)) {
                $('#detail_map').html(
                    '<div class="p-4 text-center text-muted">' +
                    'Lokasi belum tersedia.' +
                    '</div>'
                );

                return;
            }

            if (!detailProklimMap) {

                detailProklimMap = L.map(
                    'detail_map',
                    {
                        center: [lat, lng],
                        zoom: 16,
                        zoomControl: true,
                        attributionControl: true
                    }
                );

                const detailStreet = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution:'&copy; OpenStreetMap contributors'
                });


                const detailSatellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    maxZoom: 19,
                    attribution: 'Tiles &copy; Esri'
                });


                const detailTerrain = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png',{
                    maxZoom: 17,
                    attribution:'Map data &copy; OpenStreetMap contributors, SRTM | Map style &copy; OpenTopoMap'
                });

                detailStreet.addTo(detailProklimMap);

                L.control.layers({
                    "Street": detailStreet,
                    "Satellite": detailSatellite,
                    "Terrain": detailTerrain
                }).addTo(detailProklimMap);
            }

            detailProklimMap.setView([lat, lng], 16);

            if (detailProklimMarker) {
                detailProklimMap.removeLayer(detailProklimMarker);
            }

            detailProklimMarker = L.marker( [lat, lng]).addTo(detailProklimMap);

            detailProklimMarker.bindPopup(
                '<strong>' +
                escapeHtml(nama || 'Lokasi Proklim') +
                '</strong><br>' +
                'Latitude: ' +
                lat +
                '<br>' +
                'Longitude: ' +
                lng
            );

            setTimeout(function() {
                detailProklimMap.invalidateSize();
            }, 300);
        }

        function escapeHtml(value) {
            return $('<div>')
                .text(value)
                .html();
        }

        $('#form_proklim').on('submit', function(e) {
            e.preventDefault();
            const form = this;
            if (!$(form).parsley().validate()) {
                return;
            }

            if (!$('#lat').val() || !$('#lng').val()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Lokasi belum dipilih',
                    text: 'Silakan pilih lokasi pada peta terlebih dahulu.'
                });
                return;
            }

            const aksi = $('#aksi').val();
            let url = '';
            let successMessage = '';
            if (aksi === 'Save') {
                url = "{{ route('cms.proklim.store') }}";
                successMessage = 'Data Proklim berhasil disimpan.';
            } else if (aksi === 'Edit') {
                url = "{{ route('cms.proklim.update') }}";
                successMessage = 'Data Proklim berhasil diperbarui.';
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Mode tidak valid',
                    text: 'Mode form Proklim tidak dikenali.'
                });
                return;
            }

            $.ajax({
                url: url,
                method: "POST",
                data: $(form).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('#aksi_button').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...');
                    $('#form_result').html('');
                },
                success: function(data) {
                    if (data.success) {
                        $('#createModal').modal('hide');
                        $('#table_proklim').DataTable().ajax.reload(null, false);
                        resetProklimForm();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.success,
                            timer: 1800,
                            showConfirmButton: false
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        $('#form_result').html(
                            '<div class="alert alert-danger">' +
                            xhr.responseJSON.errors +
                            '</div>'
                        );
                        return;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Data Proklim gagal disimpan.'
                    });
                },
                complete: function() {
                    $('#aksi_button')
                        .prop('disabled', false)
                        .html(
                            aksi === 'Edit'
                                ? 'Update'
                                : 'Save'
                        );
                }
            });
        });

        $(document).on('click', '.edit', function() {
            const id = $(this).attr('id');
            resetProklimForm();
            $('#aksi').val('Edit');
            $('#hidden_id').val(id);
            $('#createModalLabel').text('Edit Data Proklim');
            $('#aksi_button').text('Memuat...').prop('disabled', true);
            $('#createModal').modal('show');
            let url = "{{ route('cms.proklim.edit', ['id' => ":id"]) }}";
            url = url.replace(":id", id);
            $.ajax({
                url: url,
                dataType: "json",
                success: function(response) {
                    const data = response.result;
                    $('#hidden_id').val(data.id);
                    $('#nama').val(data.nama);
                    $('#deskripsi').val(data.deskripsi);
                    $('#alamat').val(data.alamat);
                    $('#tanggal_aktif').val(data.tanggal_aktif);

                    let targetKategori = $.trim(data.kategori_proklim);
                    let valueKategori = $('#kategori_proklim_id option').filter(function() {
                        return $.trim($(this).text()) === targetKategori;
                    }).val();
                    $('#kategori_proklim_id').val(valueKategori).trigger('change');

                    let targetKabupaten = $.trim(data.kabupaten_kota);
                    let valueKabupaten = $('#kabupaten_kota_id option').filter(function() {
                        return $.trim($(this).text()) === targetKabupaten;
                    }).val();

                    if (!valueKabupaten) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Kabupaten tidak ditemukan',
                            text: 'Kabupaten/Kota dari data tidak tersedia pada pilihan form.'
                        });
                        return;
                    }
                    $('#kabupaten_kota_id').val(valueKabupaten).trigger('change');

                    kecamatanOption = data.kecamatan;
                    kelurahanOption = data.kelurahan;
                    $('#lat').val(data.lat);
                    $('#lng').val(data.lng);

                    setTimeout(function() {
                        if (data.lat && data.lng) {
                            setProklimLocation(parseFloat(data.lat), parseFloat(data.lng), true);
                        }
                    }, 500);
                    $('#aksi_button').text('Update').prop('disabled', false);
                },

                error: function(xhr) {
                    let message ='Data Proklim gagal dimuat.';

                    if ( xhr.responseJSON && xhr.responseJSON.errors) {
                        message = xhr.responseJSON.errors;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: message
                    });
                    $('#createModal').modal('hide');
                }
            });
        });

        $(document).on('click', '.delete',function(){
            var id = $(this).attr('id');
            var url = "{{ route('cms.proklim.destroy', ['id' => ":id"]) }}";
            url = url.replace(":id", id);
            return new swal({
                title: "Apakah Anda Yakin Menghapus Ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1976D2",
                confirmButtonText: "Ya"
            }).then((result)=>{
                if(result.value)
                {
                    $.ajax({
                        url: url,
                        dataType: "json",
                        beforeSend: function()
                        {
                            return new swal({
                                title: "Checking...",
                                text: "Harap Menunggu",
                                imageUrl: "{{ asset('/images/preloader.gif') }}",
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
                        },
                        success: function(data)
                        {
                            if(data.errors)
                            {
                                Swal.fire({
                                    icon: 'errors',
                                    title: data.errors,
                                    showConfirmButton: true
                                });
                            }
                            if(data.success)
                            {
                                $('#table_proklim').DataTable().ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: data.success,
                                    showConfirmButton: true
                                });
                            }
                        }
                    });
                }
            });
        });

    </script>

@endsection

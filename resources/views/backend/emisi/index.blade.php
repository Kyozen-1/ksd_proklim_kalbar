@extends('backend.layouts.app')

@section('title', 'Emisi | PROKLIM Kalimantan Barat')
@section('header', 'Emisi')

@section('css')

    <link href="{{ asset('/backend_template/libs/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/datatables/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/datatables/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/datatables/select.bootstrap4.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('/backend_template/libs/custombox/custombox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/backend_template/libs/dropify/dropify.min.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

    <style>

        .table th {
            text-align: center;
            vertical-align: middle;
        }

        .table td {
            vertical-align: middle;
        }

        .table .text-center {
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

        .filter-label {
            font-size: 12px;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .summary-card {
            border: 1px solid #e5e5e5;
            border-radius: 6px;
        }

        .summary-card .summary-icon {
            width: 45px;
            height: 45px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .summary-card .summary-title {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 3px;
        }

        .summary-card .summary-value {
            font-size: 20px;
            font-weight: 600;
            color: #343a40;
        }

        .dataTables_wrapper {
            margin-top: 10px;
        }

        #table_dynamic_emisi {
            vertical-align: middle;
        }

        #table_dynamic_emisi th {
            text-align: center;
            vertical-align: middle;
            background-color: #f8f9fa;
        }

        #table_dynamic_emisi td {
            vertical-align: middle;
        }

        #table_dynamic_emisi .form-control {
            height: 36px;
        }

        #table_dynamic_emisi .btn-hapus-baris {
            width: 34px;
            height: 34px;
            padding: 0;
        }

        .dynamic-row td {
            padding: 6px;
        }

    </style>

@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card-box summary-card">
                <div class="d-flex align-items-center">
                    <div class="summary-icon bg-primary text-white mr-3">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <div class="summary-title">
                            Kabupaten / Kota
                        </div>
                        <div class="summary-value">
                            <span id="total_kabupaten">
                                {{ $kabupatenKotas->count() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-box summary-card">
                <div class="d-flex align-items-center">
                    <div class="summary-icon bg-success text-white mr-3">
                        <i class="fas fa-industry"></i>
                    </div>
                    <div>
                        <div class="summary-title">
                            Jenis Emisi
                        </div>
                        <div class="summary-value">
                            <span id="total_jenis_emisi">
                                {{ $jenisEmisis->count() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-box summary-card">
                <div class="d-flex align-items-center">
                    <div class="summary-icon bg-warning text-white mr-3">
                        <i class="fas fa-database"></i>
                    </div>
                    <div>
                        <div class="summary-title">
                            Total Data
                        </div>
                        <div class="summary-value">
                            <span id="total_data">
                                {{ $countDataEmisi }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box table-responsive">
                <div class="row mb-3">
                    <div class="col-md-7">
                        <h4 class="mt-0 header-title">
                            Data Emisi
                        </h4>
                        <p class="text-muted mb-0">
                            Data emisi berdasarkan Kabupaten/Kota, jenis emisi dan tahun pendataan.
                        </p>
                    </div>
                    <div class="col-md-5 text-right">
                        <button class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#createModal" id="create" name="create"> <i class="fas fa-plus mr-1"></i> Tambah Data </button>
                    </div>
                </div>

                <div class="card border mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-2">
                                    <label class="filter-label"> KABUPATEN / KOTA </label>
                                    <select id="filter_kabupaten_kota" class="form-control select2">
                                        <option value=""> Semua Kabupaten / Kota </option>
                                        @foreach ($kabupatenKotas as $kabupatenKota)
                                            <option value="{{ $kabupatenKota['id'] }}"> {{ $kabupatenKota['nama'] }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group mb-2">
                                    <label class="filter-label"> SEKTOR UTAMA EMISI </label>
                                    <select id="filter_sektor" class="form-control select2">
                                        <option value=""> Semua Sektor </option>
                                        @foreach ($sektorUtamaEmisis as $sektor)
                                            <option value="{{ $sektor['id'] }}"> {{ $sektor['nama'] }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group mb-2">
                                    <label class="filter-label">JENIS EMISI</label>
                                    <select id="filter_jenis_emisi" class="form-control select2">
                                        <option value="">Semua Jenis Emisi</option>
                                        @foreach ($jenisEmisis as $jenis)
                                            <option value="{{ $jenis['id'] }}">{{ $jenis['nama'] }}</option>
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
                                <button type="button" id="btn_reset_filter" class="btn btn-light btn-block" title="Reset Filter">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <table id="table_emisi" class="table table-bordered table-striped dt-responsive nowrap" width="100%">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Aksi</th>
                            <th>Kabupaten / Kota</th>
                            <th>Sektor Utama</th>
                            <th>Jenis Emisi</th>
                            <th>Tahun</th>
                            <th>Nilai</th>
                            <th>Satuan</th>
                            <th>Tanggal Pendataan</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div id="createModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="createModalLabel"> Tambah Data Emisi </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form class="form-horizontal" id="form_emisi" method="POST" data-parsley-validate novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="kabupaten_kota_id" class="control-label">Kabupaten / Kota <span class="text-danger">*</span></label>
                            <select name="kabupaten_kota_id" id="kabupaten_kota_id" class="form-control select2" required>
                                <option value=""> Pilih Kabupaten / Kota </option>
                                @foreach ($kabupatenKotas as $kabupatenKota)
                                    <option value="{{ $kabupatenKota['id'] }}"> {{ $kabupatenKota['nama'] }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sektor_utama_emisi_id" class="control-label">Sektor Utama Emisi<span class="text-danger">*</span></label>
                            <select name="sektor_utama_emisi_id" id="sektor_utama_emisi_id" class="form-control select2" required>
                                <option value=""> Pilih Sektor Utama Emisi </option>
                                @foreach ($sektorUtamaEmisis as $sektor)
                                    <option value="{{ $sektor['id'] }}"> {{ $sektor['nama'] }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jenis_emisi_id" class="control-label">Jenis Emisi<span class="text-danger">*</span></label>
                            <select name="jenis_emisi_id" id="jenis_emisi_id" class="form-control select2" required disabled>
                                <option value="">Pilih Jenis Emisi</option>
                            </select>
                        </div>
                        <div id="informasi_jenis_emisi" class="alert alert-info"style="display:none;">
                            <strong>Satuan:</strong>
                            <span id="info_satuan">-</span>
                            &nbsp;&nbsp;|&nbsp;&nbsp;
                            <strong>Jenis Perhitungan:</strong>
                            <span id="info_perhitungan">-</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h5 class="mb-0">Data Emisi</h5>
                                <small class="text-muted">Masukkan data berdasarkan tahun.</small>
                            </div>
                            <button type="button" class="btn btn-sm btn-primary" id="btn_tambah_baris"> <i class="fas fa-plus mr-1"></i> Tambah Data Tahun </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm mb-0" id="table_dynamic_emisi">
                                <thead>
                                    <tr>
                                        <th width="20%">Tahun</th>
                                        <th width="30%">Nilai</th>
                                        <th width="30%">Tanggal Pendataan</th>
                                        <th width="20%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="dynamic_emisi_body"></tbody>
                            </table>
                        </div>
                        <input type="hidden" name="aksi" id="aksi" value="Save">

                        <input type="hidden" name="hidden_id" id="hidden_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect width-md waves-light" data-dismiss="modal">Close</button>
                    <button type="submit" form="form_emisi" name="aksi_button" id="aksi_button" class="btn btn-primary waves-effect width-md waves-light">Save</button>
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

    <script>

        let rowIndex = 0;
        const jenisEmisiData = @json($jenisEmisis);

        $('.select2').select2();

        const currentYear = new Date().getFullYear();
        const startYear = 2000;

        for (let year = currentYear; year >= startYear; year--) {
            $('#filter_tahun').append(
                `<option value="${year}">${year}</option>`
            );

        }

        $('#sektor_utama_emisi_id').on('change', function () {
            const sektorId = $(this).val();
            const sektorText = $(this).find(':selected').text().trim();
            const jenisEmisiSelect = $('#jenis_emisi_id');
            jenisEmisiSelect.empty();
            jenisEmisiSelect.append(
                '<option value="">Pilih Jenis Emisi</option>'
            );

            $('#info_satuan').text('-');
            $('#info_perhitungan').text('-');
            $('#informasi_jenis_emisi').hide();

            if (!sektorId) {
                jenisEmisiSelect.prop('disabled', true).trigger('change');
                return;
            }

            const jenisEmisiTerfilter = jenisEmisiData.filter(function (jenis) {
                return jenis.sektor_utama_emisi.trim() === sektorText;
            });

            jenisEmisiTerfilter.forEach(function (jenis) {
                jenisEmisiSelect.append(
                    $('<option>', {
                        value: jenis.id,
                        text: jenis.nama,
                        'data-satuan': jenis.satuan,
                        'data-perhitungan': jenis.jenis_perhitungan
                    })
                );
            });
            jenisEmisiSelect
                .prop('disabled', false)
                .trigger('change');
        });

        $('#jenis_emisi_id').on('change', function () {
            const option = $(this).find('option:selected');
            if (!option.val()) {
                $('#info_satuan').text('-');
                $('#info_perhitungan').text('-');
                $('#informasi_jenis_emisi').hide();
                return;
            }

            $('#info_satuan').text(
                option.attr('data-satuan') || '-'
            );

            $('#info_perhitungan').text(
                option.attr('data-perhitungan') || '-'
            );

            $('#informasi_jenis_emisi').show();
        });

        function filterJenisEmisiTable() {
            const sektorId = $('#filter_sektor').val();
            const sektorText = $('#filter_sektor').find(':selected').text().trim();
            const jenisSelect = $('#filter_jenis_emisi');
            const selectedJenis = jenisSelect.val();
            jenisSelect.empty();
            jenisSelect.append(
                $('<option>', {
                    value: '',
                    text: 'Semua Jenis Emisi'
                })
            );
            if (!sektorId) {
                jenisEmisiData.forEach(function (jenis) {
                    jenisSelect.append(
                        $('<option>', {
                            value: jenis.id,
                            text: jenis.nama
                        })
                    );
                });
            } else {
                jenisEmisiData.forEach(function (jenis) {
                    if (jenis.sektor_utama_emisi && jenis.sektor_utama_emisi.trim() === sektorText) {
                        jenisSelect.append(
                            $('<option>', {
                                value: jenis.id,
                                text: jenis.nama
                            })
                        );
                    }
                });
            }
            if (selectedJenis && jenisSelect.find('option[value="' + selectedJenis + '"]').length) {
                jenisSelect.val(selectedJenis);
            } else {
                jenisSelect.val('');
            }
            jenisSelect.trigger('change.select2');
        }

        $('#filter_sektor').on('change', function(){
            filterJenisEmisiTable();
            dataTables.ajax.reload();
        });

        var dataTables = $('#table_emisi').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('cms.emisi.datatable') }}",
                data: function(d) {
                    d.kabupaten_kota_id = $('#filter_kabupaten_kota').val();
                    d.jenis_emisi_id = $('#filter_jenis_emisi').val();
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
                    data: 'sektor_utama_emisi_id',
                    name: 'sektor_utama_emisi_id'
                },
                {
                    data: 'jenis_emisi_id',
                    name: 'jenis_emisi_id'
                },
                {
                    data: 'tahun',
                    name: 'tahun',
                    className: 'text-center'
                },
                {
                    data: 'nilai',
                    name: 'nilai',
                    className: 'text-right td-nilai'
                },
                {
                    data: 'satuan',
                    name: 'satuan',
                    className: 'text-center'
                },
                {
                    data: 'tanggal_pendataan',
                    name: 'tanggal_pendataan',
                    className: 'text-center'
                }
            ],
            order: [
                [5, 'desc']
            ]
        });

        $('#filter_kabupaten_kota, #filter_jenis_emisi, #filter_tahun').on('change', function(){
            dataTables.ajax.reload();
        });

        $('#btn_reset_filter').on('click', function(){
            $('#filter_kabupaten_kota').val('').trigger('change');
            $('#filter_sektor').val('').trigger('change');
            $('#filter_jenis_emisi').val('').trigger('change');
            $('#filter_tahun').val('').trigger('change');
        });

        function generateYearOptions() {
            let currentYear = new Date().getFullYear();
            let options = '<option value="">Pilih Tahun</option>';
            for (let year = currentYear; year >= 2000; year--) {
                options += '<option value="' + year + '">' + year + '</option>';
            }
            return options;
        }

        function tambahBaris(data = null) {
            rowIndex++;
            let tahun = data && data.tahun ? data.tahun : '';

            let nilai = data && data.nilai !== undefined ? data.nilai : '';

            let tanggal = data && data.tanggal_pendataan ? data.tanggal_pendataan : '';

            let row = `
                <tr class="dynamic-row" data-row="${rowIndex}">
                    <td>
                        <select name="tahun[]" class="form-control tahun-input s2" required>
                            ${generateYearOptions()}
                        </select>
                    </td>
                    <td>
                        <input type="number" name="nilai[]" class="form-control nilai-input" value="${nilai}" step="0.001" min="0" placeholder="Masukkan nilai" required>
                    </td>
                    <td>
                        <input type="date" name="tanggal_pendataan[]" class="form-control tanggal-input" value="${tanggal}" required>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm btn-hapus-baris" title="Hapus"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `;
            $('#dynamic_emisi_body').append(row);
            $('.s2').select2({ width: '100%' });
            if (tahun) {
                $('#dynamic_emisi_body tr:last').find('.tahun-input').val(tahun);
            }
        }

        $(document).on('click', '.btn-hapus-baris',
            function(){
                let totalRow = $('#dynamic_emisi_body .dynamic-row').length;

                if (totalRow <= 1) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data tidak dapat dihapus',
                        text: 'Minimal harus terdapat satu data Emisi.'
                    });
                    return;
                }

                $(this).closest('.dynamic-row').remove();
            }
        );

        $('#btn_tambah_baris').click(function(){
            tambahBaris();
        });

        function reset() {
            $('#form_emisi')[0].reset();
            $('#kabupaten_kota_id').val('').trigger('change');
            $('#sektor_utama_emisi_id').val('').trigger('change');
            $('#jenis_emisi_id').empty().append('<option value="">Pilih Jenis Emisi</option>').val('').prop('disabled', true).trigger('change');
            $('#info_satuan').text('-');
            $('#info_perhitungan').text('-');
            $('#informasi_jenis_emisi').hide();
            $('#dynamic_emisi_body').empty();
            rowIndex = 0;
            tambahBaris();
            $('#hidden_id').val('');
            $('#aksi').val('Save');
        }

        $('#create').click(function(){
            reset();
            $('#form_result').html('');
            $('#aksi_button').text('Save').prop('disabled', false).val('Save');
            $('#aksi').val('Save');
            $('#createModalLabel').text('Tambah Data Emisi');
        });

        $('#form_emisi').on('submit', function(e){
                e.preventDefault();
                if ($('#aksi').val() == 'Save') {
                    $.ajax({
                        url: "{{ route('cms.emisi.store') }}",
                        method: "POST",
                        data: $(this).serialize(),
                        dataType: "json",
                        beforeSend: function(){
                            $('#aksi_button').text('Menyimpan...').prop('disabled', true);
                        },
                        success: function(data){
                            var html = '';
                            if (data.errors) {
                                html = '<div class="alert alert-danger">' + data.errors +'</div>';
                                $('#aksi_button').prop('disabled', false).text('Save');
                            }
                            if (data.success) {
                                html = '<div class="alert alert-success">' + data.success +'</div>';
                                $('#aksi_button').prop('disabled', false).text('Save');
                                $('#table_emisi').DataTable().ajax.reload();
                                reset();
                            }
                            $('#form_result').html(html);
                        },
                        error: function(xhr){
                            $('#aksi_button').prop('disabled', false).text('Save');
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: 'Data gagal disimpan.'
                            });
                        }
                    });
                }
            }
        );

        $(document).on( 'click', '.edit', function(){
            var button = $(this);
            var id = button.attr('id');
            var rowElement = button.closest('tr');
            var row = dataTables.row(rowElement);
            var rowData = row.data();
            var nilai = String(rowData.nilai).replace(/\./g, '').replace(',', '.');
            var nilaiCell = rowElement.find('.td-nilai');

            if (nilaiCell.find('.input-nilai').length > 0) {
                return;
            }

            nilaiCell.html(`<input type="number" name="nilai" class="form-control input-nilai text-right" value="${nilai}" min="0" step="0.001" data-original-value="${nilai}">`);

            button.removeClass('edit btn-warning').addClass('save-nilai btn-success').attr('title', 'Simpan Perubahan').html('<i class="fas fa-save"></i>');
        });

        $(document).on( 'click', '.save-nilai', function(){
            var button = $(this);
            var id = button.attr('id');
            var rowElement = button.closest('tr');
            var nilaiInput = rowElement.find('.input-nilai');
            var nilai = nilaiInput.val();
            var nilaiAwal = nilaiInput.data('original-value');
            var nilaiCell = rowElement.find('.td-nilai');

            if (nilai === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Nilai belum diisi',
                    text: 'Silakan masukkan nilai emisi.'
                });
                nilaiInput.focus();
                return;
            }

            if (parseFloat(nilai) < 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Nilai tidak valid',
                    text: 'Nilai emisi tidak boleh kurang dari 0.'
                });
                nilaiInput.focus();
                return;
            }

            Swal.fire({
                title: 'Apakah Anda Yakin Mengubah Ini?',
                text: 'Nilai emisi akan diperbarui.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1976D2',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then(function(result){
                if (result.value) {
                    $.ajax({
                        url: "{{ route('cms.emisi.update') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id,
                            nilai: nilai
                        },
                        dataType: "json",
                        beforeSend: function(){
                            Swal.fire({
                                title: "Menyimpan...",
                                text: "Harap Menunggu",
                                imageUrl: "{{ asset('/images/preloader.gif') }}",
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
                        },
                        success: function(data){
                            if (data.errors) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: Array.isArray(data.errors)
                                        ? data.errors.join(', ')
                                        : data.errors
                                });
                                return;
                            }
                            if (data.success) {
                                dataTables.ajax.reload(
                                    null,
                                    false
                                );
                                Swal.fire({
                                    icon: 'success',
                                    title: data.success,
                                    showConfirmButton: true
                                });
                            }
                        },
                        error: function(xhr){
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: 'Data gagal diperbarui.'
                            });
                        }
                    });
                } else {
                    nilaiCell.text(nilaiAwal);
                    button
                        .removeClass('save-nilai btn-success')
                        .addClass('edit btn-warning')
                        .attr('title', 'Edit Nilai')
                        .html('<i class="fas fa-edit"></i>');
                }
            });
        });

        tambahBaris();
    </script>
@endsection

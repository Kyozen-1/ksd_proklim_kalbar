@extends('backend.layouts.app')

@section('title', 'Sampah | PROKLIM Kalimantan Barat')
@section('header', 'Sampah')

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

        #table_dynamic_sampah {
            vertical-align: middle;
        }

        #table_dynamic_sampah th {
            text-align: center;
            vertical-align: middle;
            background-color: #f8f9fa;
        }

        #table_dynamic_sampah td {
            vertical-align: middle;
        }

        #table_dynamic_sampah .form-control {
            height: 36px;
        }

        #table_dynamic_sampah .btn-hapus-baris {
            width: 34px;
            height: 34px;
            padding: 0;
        }

        .dynamic-empty-row {
            text-align: center;
            color: #6c757d;
            padding: 20px !important;
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
                        <div class="summary-title">Kabupaten / Kota</div>
                        <div class="summary-value">
                            <span id="total_kabupaten">{{$kabupatenKotas->count()}}</span>
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
                        <div class="summary-title">Kategori Sampah</div>
                        <div class="summary-value">
                            <span id="total_sektor">{{$kategoriSampahs->count()}}</span>
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
                        <div class="summary-title">Total Data</div>
                        <div class="summary-value">
                            <span id="total_data">{{$countDataSampah}}</span>
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
                        <h4 class="mt-0 header-title">Data Sampah</h4>
                        <p class="text-muted mb-0">Data Sampah berdasarkan Kabupaten/Kota, kategori dan tahun pendataan.</p>
                    </div>
                    <div class="col-md-5 text-right">
                        <button class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#createModal" id="create" name="create"> <i class="fas fa-plus mr-1"></i> Tambah Data </button>
                    </div>
                </div>
                <div class="card border mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label class="filter-label"> KABUPATEN / KOTA </label>
                                    <select id="filter_kabupaten" class="form-control select2">
                                        <option value=""> Semua Kabupaten / Kota </option>
                                        @foreach ($kabupatenKotas as $kabupatenKota)
                                            <option value="{{$kabupatenKota['id']}}">{{$kabupatenKota['nama']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label class="filter-label">Kategori Sampah</label>
                                    <select id="filter_kategori" class="form-control select2">
                                        <option value=""> Semua Kategori </option>
                                        @foreach ($kategoriSampahs as $kategoriSampah)
                                            <option value="{{$kategoriSampah['id']}}">{{$kategoriSampah['nama']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-2">
                                    <label class="filter-label">TAHUN</label>
                                    <select id="filter_tahun" class="form-control select2">
                                        <option value=""> Semua Tahun </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="filter-label">&nbsp;</label>
                                <button type="button" id="btn_reset_filter" class="btn btn-light btn-block"> <i class="fas fa-sync-alt mr-1"></i> Reset </button>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="table_sampah" class="table table-bordered table-striped dt-responsive nowrap" width="100%">
                    <thead>
                        <tr>
                            <th rowspan="2" width="5%"> No </th>
                            <th rowspan="2" width="10%"> Aksi </th>
                            <th rowspan="2"> Kabupaten / Kota </th>
                            <th rowspan="2"> Kategori</th>
                            <th rowspan="2"> Tahun </th>
                            <th colspan="3">(ton/tahun)</th>
                            <th rowspan="2"> Tanggal Pendataan </th>
                        </tr>
                        <tr>
                            <th> Nilai </th>
                            <th> Terkelola </th>
                            <th> Tidak Terkelola </th>
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
                    <h4 class="modal-title" id="createModalLabel">Tambah Data Sampah</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form class="form-horizontal" id="form_sampah" method="POST" data-parsley-validate novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="kabupaten_kota_id" class="control-label"> Kabupaten / Kota<span class="text-danger">*</span></label>
                            <select name="kabupaten_kota_id" id="kabupaten_kota_id" class="form-control select2" required>
                                <option value=""> Pilih Kabupaten / Kota </option>
                                @foreach ($kabupatenKotas as $kabupatenKota)
                                    <option value="{{$kabupatenKota['id']}}">{{$kabupatenKota['nama']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kategori_sampah_id" class="control-label"> Kategori Sampah <span class="text-danger">*</span></label>
                            <select name="kategori_sampah_id" id="kategori_sampah_id" class="form-control select2" required>
                                <option value=""> Pilih Kategori Sampah </option>
                                @foreach ($kategoriSampahs as $kategoriSampah)
                                    <option value="{{$kategoriSampah['id']}}">{{$kategoriSampah['nama']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h5 class="mb-0"> Data Sampah </h5>
                                <small class="text-muted"> Masukkan data berdasarkan tahun. </small>
                            </div>
                            <button type="button" class="btn btn-sm btn-primary" id="btn_tambah_baris">
                                <i class="fas fa-plus mr-1"></i>
                                Tambah Data Tahun
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm mb-0" id="table_dynamic_sampah">
                                <thead>
                                    <tr>
                                        <th width="20%"> Tahun </th>
                                        <th width="25%"> Nilai</th>
                                        <th width="25%"> Sampah Terkelola</th>
                                        <th width="20%"> Tanggal Pendataan </th>
                                        <th width="10%"> Aksi </th>
                                    </tr>
                                </thead>
                                <tbody id="dynamic_sampah_body"></tbody>
                            </table>
                        </div>
                        <input type="hidden" name="aksi" id="aksi" value="Save">
                        <input type="hidden" name="hidden_id" id="hidden_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect width-md waves-light" data-dismiss="modal">Close</button>
                    <button type="submit" form="form_sampah" name="aksi_button" id="aksi_button" class="btn btn-primary waves-effect width-md waves-light"> Save </button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')

    {{-- DataTables --}}
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

    {{-- Validation --}}
    <script src="{{ asset('/backend_template/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('/backend_template/js/pages/form-validation.init.js') }}"></script>

    {{-- Plugin --}}
    <script src="{{ asset('/backend_template/libs/dropify/dropify.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>

    <script>
        let rowIndex = 0;

        $('.select2').select2();

        const currentYear = new Date().getFullYear();
        const startYear = 2000;

        for (let year = currentYear; year >= startYear; year--) {
            $('#filter_tahun').append(
                `<option value="${year}">${year}</option>`
            );
        }

        var dataTables = $('#table_sampah').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('cms.sampah.datatable') }}",
                data: function (d) {
                    d.kabupaten_kota_id = $('#filter_kabupaten').val();
                    d.kategori_sampah_id = $('#filter_kategori').val();
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
                    data: 'kategori_sampah_id',
                    name: 'kategori_sampah_id'
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
                    data: 'sampah_terkelola',
                    name: 'sampah_terkelola',
                    className: 'text-right td-sampah-terkelola'
                },
                {
                    data: 'sampah_tidak_terkelola',
                    name: 'sampah_tidak_terkelola',
                    className: 'text-right'
                },
                {
                    data: 'tanggal_pendataan',
                    name: 'tanggal_pendataan',
                    className: 'text-center'
                }
            ],
            order: [
                [4, 'desc']
            ]
        });

        $('#filter_kabupaten, #filter_kategori, #filter_tahun').on('change', function () {
            dataTables.ajax.reload();
        });

        $('#btn_reset_filter').on('click', function () {
            $('#filter_kabupaten').val('').trigger('change');
            $('#filter_kategori').val('').trigger('change');
            $('#filter_tahun').val('').trigger('change');
        });

        function generateYearOptions() {
            let currentYear = new Date().getFullYear();
            let options = '<option value="">Pilih Tahun</option>';
            for ( let year = currentYear; year >= 2000; year-- ) {
                options += '<option value="' + year + '">' + year + '</option>';
            }
            return options;
        }

        function tambahBaris(data = null) {
            rowIndex++;
            let tahun = data && data.tahun ? data.tahun : '';
            let nilai = data && data.nilai ? data.nilai : '';
            let sampah_terkelola = data && data.sampah_terkelola ? data.sampah_terkelola : '';
            let tanggal = data && data.tanggal_pendataan ? data.tanggal_pendataan : '';
            let row = ` <tr class="dynamic-row" data-row="${rowIndex}">
                            <td> <select name="tahun[]" class="form-control tahun-input s2" required> ${generateYearOptions()} </select> </td>
                            <td> <input type="number" name="nilai[]" class="form-control nilai-input" value="${nilai}" step="0.001" min="0" placeholder="Masukkan nilai" required></td>
                            <td> <input type="number" name="sampah_terkelola[]" class="form-control sampah-terkelola-input" value="${sampah_terkelola}" step="0.001" min="0" placeholder="Masukkan sampah terkelola" required></td>
                            <td> <input type="date" name="tanggal_pendataan[]" class="form-control tanggal-input" value="${tanggal}" required> </td>
                            <td class="text-center"> <button type="button" class="btn btn-danger btn-sm btn-hapus-baris" title="Hapus"> <i class="fas fa-trash"></i> </button> </td>
                        </tr> `;
            $('#dynamic_sampah_body') .append(row);
            $('.s2').select2();
            if (tahun) {
                $('#dynamic_sampah_body tr:last') .find('.tahun-input') .val(tahun);
            }
        }

        $(document).on( 'click', '.btn-hapus-baris', function () {
            let totalRow = $('#dynamic_sampah_body .dynamic-row').length;
            if (totalRow <= 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data tidak dapat dihapus',
                    text: 'Minimal harus terdapat satu data Sampah.'
                });
                return;
            } $(this) .closest('.dynamic-row') .remove();
        } );

        $('#btn_tambah_baris').click(function () {
            tambahBaris();
        });

        function reset() {
            $('#form_sampah')[0].reset();
            $("[name='kabupaten_kota_id']") .val('') .trigger('change');
            $("[name='kategori_sampah_id']") .val('') .trigger('change');
            $('#dynamic_sampah_body') .empty(); rowIndex = 0;
            tambahBaris();
            $('#hidden_id').val('');
            $('#aksi').val('Save');
        }

        $('#create').click(function () {
            reset();
            $('#form_result').html('');
            $('#aksi_button') .text('Save') .prop('disabled', false) .val('Save');
            $('#aksi').val('Save');
            $('#createModalLabel') .text('Tambah Data Sampah');
        });

        $('#form_sampah').on( 'submit', function (e) {
            e.preventDefault();
            if ($('#aksi').val() == 'Save') {
                $.ajax({
                    url: "{{ route('cms.sampah.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    beforeSend: function () {
                        $('#aksi_button') .text('Menyimpan...') .prop('disabled', true);
                    },
                    success: function (data) {
                        var html = '';
                        if (data.errors) {
                            html = '<div class="alert alert-danger">' + data.errors + '</div>';
                            $('#aksi_button') .prop('disabled', false) .text('Save');
                        }
                        if (data.success) {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#aksi_button') .prop('disabled', false) .text('Save');
                            $('#table_sampah') .DataTable() .ajax .reload();
                            reset();
                        }
                        $('#form_result') .html(html);
                    },
                    error: function (xhr) {
                        $('#aksi_button') .prop('disabled', false) .text('Save');
                    }
                });
            }
        } );

        $(document).on('click', '.edit', function () {
            var button = $(this);
            var id = button.attr('id');
            var rowElement = button.closest('tr');
            var row = dataTables.row(rowElement);
            var rowData = row.data();
            var nilai = String(rowData.nilai).replace(/\./g, '').replace(',', '.');
            var nilaiCell = rowElement.find('.td-nilai');
            var sampahTerkelola = String(rowData.sampah_terkelola).replace(/\./g, '').replace(',', '.');
            var sampahTerkelolaCell = rowElement.find('.td-sampah-terkelola');

            if (nilaiCell.find('.input-nilai').length > 0) {
                return;
            }

            nilaiCell.html(`
                <input
                    type="number"
                    name="nilai"
                    class="form-control input-nilai text-right"
                    value="${nilai}"
                    min="0"
                    step="0.001"
                    data-original-value="${nilai}">
            `);

            if (sampahTerkelolaCell.find('.input-sampah-terkelola').length > 0) {
                return;
            }

            sampahTerkelolaCell.html(`
                <input
                    type="number"
                    name="sampah_terkelola"
                    class="form-control input-sampah-terkelola text-right"
                    value="${sampahTerkelola}"
                    min="0"
                    step="0.001"
                    data-original-value="${sampahTerkelola}">
            `);

            button
                .removeClass('edit btn-warning')
                .addClass('save-nilai btn-success')
                .attr('title', 'Simpan Perubahan')
                .html('<i class="fas fa-save"></i>');
        });

        $(document).on('click', '.save-nilai', function () {
            var button = $(this);
            var id = button.attr('id');
            var rowElement = button.closest('tr');

            var nilaiInput = rowElement.find('.input-nilai');
            var nilai = nilaiInput.val();
            var nilaiAwal = nilaiInput.data('original-value');
            var nilaiCell = rowElement.find('.td-nilai');

            var sampahTerkelolaInput = rowElement.find('.input-sampah-terkelola');
            var sampahTerkelola = sampahTerkelolaInput.val();
            var sampahTerkelolaAwal = sampahTerkelolaInput.data('original-value');
            var sampahTerkelolaCell = rowElement.find('.td-sampah-terkelola');

            if (nilai === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Nilai belum diisi',
                    text: 'Silakan masukkan nilai Sampah.'
                });
                nilaiInput.focus();
                return;
            }

            if (parseFloat(nilai) < 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Nilai tidak valid',
                    text: 'Nilai Sampah tidak boleh kurang dari 0.'
                });
                nilaiInput.focus();
                return;
            }

            if (sampahTerkelola === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'sampah terkelola belum diisi',
                    text: 'Silakan masukkan sampah terkelola.'
                });
                sampahTerkelolaInput.focus();
                return;
            }

            if (parseFloat(sampahTerkelola) < 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sampah terkelola tidak valid',
                    text: 'Sampah terkelola tidak boleh kurang dari 0.'
                });
                sampahTerkelolaInput.focus();
                return;
            }

            Swal.fire({
                title: 'Apakah Anda Yakin Mengubah Ini?',
                text: 'Nilai dan sampah terkelola akan diperbarui.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1976D2',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('cms.sampah.update') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id,
                            nilai: nilai,
                            sampah_terkelola: sampahTerkelola
                        },
                        dataType: "json",
                        beforeSend: function () {
                            Swal.fire({
                                title: "Menyimpan...",
                                text: "Harap Menunggu",
                                imageUrl: "{{ asset('/images/preloader.gif') }}",
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
                        },
                        success: function (data) {
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
                                dataTables.ajax.reload(null, false);
                                Swal.fire({
                                    icon: 'success',
                                    title: data.success,
                                    showConfirmButton: true
                                });
                            }
                        },

                        error: function (xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: 'Data gagal diperbarui.'
                            });
                        }
                    });
                }
                else {
                    nilaiCell.text(nilaiAwal);
                    button
                        .removeClass('save-nilai btn-success')
                        .addClass('edit btn-warning')
                        .attr('title', 'Edit Nilai')
                        .html('<i class="fas fa-edit"></i>');
                }
            });
        });
    </script>

@endsection

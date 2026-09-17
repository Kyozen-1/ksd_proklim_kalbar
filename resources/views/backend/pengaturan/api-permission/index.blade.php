@extends('backend.layouts.app')
@section('title', 'API Permission | Pengaturan | REDD++ Kalimantan Barat')
@section('header', 'API Permission | Pengaturan')

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
        }
        .table td {
            justify-content: center;
            text-align: center;
        }

        .select2-container .select2-selection--single {
            height: 38px;           /* samakan dengan input/select */
            display: flex;
            align-items: center;    /* center vertical */
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;   /* samakan dengan height */
            padding-left: 10px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px;
            top: 0;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #0d6efd; /* biru bootstrap */
            border-color: #0d6efd;
            color: white;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box table-responsive">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <h4 class="mt-0 header-title">
                            API Permission
                        </h4>
                    </div>
                    <div class="col-md-6 text-right">
                        <button
                            type="button"
                            class="btn btn-info btn-icon waves-effect waves-light"
                            id="btn-sync-permissions"
                        >
                            <i class="fas fa-sync-alt"></i>
                            Sinkronisasi API
                        </button>
                        <a href="{{ route('cms.pengaturan.api-permission.create') }}" class="btn btn-icon waves-effect waves-light btn-primary" title="Tambah API Permission">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>

                <table id="table_api_permission" class="table table-bordered table-bordered dt-responsive nowrap" width="100%">
                    <thead>
                        <tr>
                            <th width="5%"> No </th>
                            <th width="10%"> Aksi </th>
                            <th> Name </th>
                            <th> Route </th>
                            <th width="8%"> Method </th>
                            <th> Description </th>
                            <th width="10%"> Status </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- third party js -->
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
    <!-- third party js ends -->

    <!-- Datatables init -->
    <script src="{{ asset('/backend_template/js/pages/datatables.init.js') }}"></script>
    <!-- Validation js (Parsleyjs) -->
    <script src="{{ asset('/backend_template/libs/parsleyjs/parsley.min.js') }}"></script>

    <!-- validation init -->
    <script src="{{ asset('/backend_template/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/dropify/dropify.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        var dataTables = $('#table_api_permission').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('cms.pengaturan.api-permission.datatable') }}",
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'route_name',
                    name: 'route_name'
                },
                {
                    data: 'method',
                    name: 'method'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $(document).on('click', '.delete', function () {
            var id = $(this).attr('id');
            var url = "{{ route('cms.pengaturan.api-permission.destroy', ['id' => ':id']) }}";
            url = url.replace(':id', id);
            return new swal({
                title: "Apakah Anda Yakin Menghapus Ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1976D2",
                confirmButtonText: "Ya"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        dataType: "json",
                        beforeSend: function () {
                            return new swal({
                                title: "Checking...",
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
                                    title: data.errors,
                                    showConfirmButton: true
                                });
                            }

                            if (data.success) {
                                $('#table_api_permission')
                                    .DataTable()
                                    .ajax
                                    .reload();
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

        $(document).on('click', '.activate', function () {
            var id = $(this).attr('id');
            var url = "{{ route('cms.pengaturan.api-permission.activate', ['id' => ':id']) }}";
            url = url.replace(':id', id);
            return new swal({
                title: "Aktifkan API Permission ini?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#1976D2",
                confirmButtonText: "Ya"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        dataType: "json",
                        beforeSend: function () {
                            return new swal({
                                title: "Checking...",
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
                                    title: data.errors,
                                    showConfirmButton: true
                                });
                            }
                            if (data.success) {
                                $('#table_api_permission')
                                    .DataTable()
                                    .ajax
                                    .reload();

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

        $('#btn-sync-permissions').on('click', function () {
            const button = $(this);
            button.prop('disabled', true);
            $.ajax({
                url: "{{ route('cms.pengaturan.api-permission.sync') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    if (response.success) {
                        let message = response.message;

                        if (response.orphaned > 0) {
                            message +=
                                '<br><br>' +
                                '<span class="text-warning">' +
                                response.orphaned +
                                ' permission memiliki route yang sudah tidak tersedia.' +
                                '</span>';
                        }

                        Swal.fire({
                            icon: 'success',
                            title: 'Sinkronisasi Selesai',
                            html: message,
                            timer: 2500,
                            showConfirmButton: false
                        });
                        // Reload DataTable
                        $('#table_api_permission')
                            .DataTable()
                            .ajax.reload(null, false);
                    }

                },
                error: function (xhr) {
                    let message =
                        'Gagal melakukan sinkronisasi API Permission.';
                    if (xhr.responseJSON?.message) {
                        message = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: message
                    });
                },
                complete: function () {
                    button.prop('disabled', false);
                }
            });
        });
    </script>
@endsection

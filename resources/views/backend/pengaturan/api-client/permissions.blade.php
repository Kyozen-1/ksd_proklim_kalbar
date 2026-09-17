@extends('backend.layouts.app')
@section('title', 'Atur API Permission | API Client | Pengaturan | REDD++ Kalimantan Barat')
@section('header', 'Atur API Permission | API Client | Pengaturan')

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
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="card-title mb-1">Kelola API Permission</h4>
                                <p class="text-muted mb-0">Atur permission yang dapat digunakan oleh API Client.</p>
                            </div>
                            <a href="{{ route('cms.pengaturan.api-client.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i>Kembali</a>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- Informasi API Client --}}
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="font-weight-bold">Client Name</label>
                                <div class="form-control bg-light">{{ $apiClient->name }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="font-weight-bold">Client ID</label>
                                <div class="form-control bg-light">{{ $apiClient->client_id }}</div>
                            </div>
                        </div>
                        <hr>
                        {{-- Permission --}}
                        <div class="mb-3">
                            <h5 class="mb-1">API Permission</h5>
                            <p class="text-muted mb-3">Pilih permission yang akan diberikan kepada client ini.</p>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="check-all-permissions">
                                <label class="custom-control-label" for="check-all-permissions">
                                    <strong>Pilih Semua Permission</strong>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            @forelse ($permissions as $group => $groupPermissions)
                                <div class="col-12 mb-3">
                                    <div class="card border">
                                        <div class="card-header">
                                            <div class="custom-control custom-checkbox">
                                                <input
                                                    type="checkbox"
                                                    class="custom-control-input permission-group-checkbox"
                                                    id="group_{{ $group }}"
                                                    data-group="{{ $group }}"
                                                >
                                                <label
                                                    class="custom-control-label"
                                                    for="group_{{ $group }}"
                                                >
                                                    <strong>
                                                        {{ ucwords(str_replace(['-', '_'], ' ', $group)) }}
                                                    </strong>
                                                    <span class="text-muted ml-2">
                                                        ({{ $groupPermissions->count() }} permission)
                                                    </span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <div class="row">
                                                @foreach ($groupPermissions as $permission)
                                                    <div class="col-md-6 col-lg-4 mb-3">
                                                        <div class="custom-control custom-checkbox">
                                                            <input
                                                                type="checkbox"
                                                                class="custom-control-input permission-checkbox"
                                                                id="permission_{{ $permission->id }}"
                                                                name="permissions[]"
                                                                value="{{ $permission->id }}"
                                                                data-group="{{ $group }}"
                                                                {{ in_array($permission->id, $assignedPermissionIds) ? 'checked' : '' }}
                                                                {{
                                                                    (!$permission->route_exists || !$permission->route_method_matches)
                                                                        ? 'disabled'
                                                                        : ''
                                                                }}
                                                            >
                                                            <label
                                                                class="custom-control-label"
                                                                for="permission_{{ $permission->id }}"
                                                            >
                                                                <strong>
                                                                    {{ $permission->name }}
                                                                </strong>
                                                                <br>
                                                                <small class="text-muted">
                                                                    {{ $permission->method }}
                                                                    {{ $permission->route_name }}
                                                                </small>
                                                                @if (!$permission->route_exists)
                                                                    <br>
                                                                    <span class="badge badge-danger mt-1">
                                                                        Route tidak ditemukan
                                                                    </span>
                                                                @elseif (!$permission->route_method_matches)
                                                                    <br>
                                                                    <span class="badge badge-warning mt-1">
                                                                        Method route berubah
                                                                    </span>
                                                                @endif
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        Belum ada API Permission aktif.
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" class="btn btn-primary" id="btn-save-permissions"><i class="fas fa-save"></i> Simpan Permission</button>
                    </div>
                </div>
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
        $(document).ready(function () {

            function updateCheckAll() {
                const permissions = $('.permission-checkbox:not(:disabled)');
                const total = permissions.length;
                const checked = permissions.filter(':checked').length;

                $('#check-all-permissions').prop(
                    'checked',
                    total > 0 && total === checked
                );
            }

            function updateGroupCheckbox(group) {

                const permissions = $(
                    '.permission-checkbox[data-group="' + group + '"]:not(:disabled)'
                );

                const checked = permissions.filter(':checked');

                $('#group_' + group).prop(
                    'checked',
                    permissions.length > 0 &&
                    permissions.length === checked.length
                );

            }

            // Pilih semua permission
            $('#check-all-permissions').on('change', function () {

                const checked = $(this).is(':checked');

                $('.permission-checkbox:not(:disabled)')
                    .prop('checked', checked);

                $('.permission-group-checkbox').each(function () {

                    const group = $(this).data('group');

                    updateGroupCheckbox(group);

                });

            });

            // Pilih semua permission dalam group
            $('.permission-group-checkbox').on('change', function () {

                const group = $(this).data('group');
                const checked = $(this).is(':checked');

                $('.permission-checkbox[data-group="' + group + '"]')
                    .prop('checked', checked);

                updateCheckAll();

            });

            // Permission individual
            $('.permission-checkbox').on('change', function () {

                const group = $(this).data('group');

                updateGroupCheckbox(group);
                updateCheckAll();

            });

            // Kondisi awal
            $('.permission-group-checkbox').each(function () {

                const group = $(this).data('group');

                updateGroupCheckbox(group);

            });

            updateCheckAll();

            $('#btn-save-permissions').on('click', function () {
                const button = $(this);
                const permissions = $('.permission-checkbox:checked')
                    .map(function () {
                        return $(this).val();
                    })
                    .get();
                button.prop('disabled', true);

                let idApiClientEncrypted = "{{ $idApiClientEncrypted }}";
                var url = "{{ route('cms.pengaturan.api-client.update-permissions', ['id' => ':id']) }}";
                url = url.replace(":id", idApiClientEncrypted);
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        permissions: permissions
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function (xhr) {
                        let message = 'Gagal memperbarui API Permission.';
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
        });
    </script>
@endsection

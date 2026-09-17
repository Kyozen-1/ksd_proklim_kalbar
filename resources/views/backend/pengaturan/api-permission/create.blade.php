@extends('backend.layouts.app')
@section('title', 'Create | API Permission | Pengaturan | REDD++ Kalimantan Barat')
@section('header', 'Create | API Permission | Pengaturan')

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
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('cms.pengaturan.api-permission.store') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="control-label">Nama Permission</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" maxlength="100" required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="control-label">Route API</label>
                            <select name="route_name" id="route_name" class="form-control @error('route_name') is-invalid @enderror" required>
                                <option value=""> -- Pilih Route API -- </option>
                                @foreach ($routes as $route)
                                    <option value="{{ $route['name'] }}" data-method="{{ $route['method'] }}" {{ old('route_name') === $route['name'] ? 'selected' : '' }}> {{ $route['method'] }} {{ $route['uri'] }} — {{ $route['name'] }} </option>
                                @endforeach
                            </select>
                            @error('route_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="control-label"> HTTP Method </label>
                            <input type="text" id="method_display" class="form-control" readonly>
                            <input type="hidden" name="method" id="method">
                        </div>
                        <div class="mb-3">
                            <label class="control-label"> Description </label>
                            <textarea name="description" class="form-control" rows="4" maxlength="1000">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active"> Aktif </label>
                        </div>
                        <div class="row">
                            <div class="col-6 text-left">
                                <a href="{{ route('cms.pengaturan.api-permission.index') }}" class="btn btn-secondary"> Kembali </a>
                            </div>
                            <div class="col-6 text-right">
                                <button type="submit" class="btn btn-primary" >Simpan</button>
                            </div>
                        </div>
                    </form>
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
        $('#route_name').select2();

        $('#route_name').on('change', function () {
            const method = $(this)
                .find(':selected')
                .data('method') ?? '';

            $('#method_display').val(method);
        });
        const routeSelect = document.getElementById('route_name');
        const methodDisplay = document.getElementById('method_display');
        const methodInput = document.getElementById('method');

        function updateMethod() {

            const selected =
                routeSelect.options[routeSelect.selectedIndex];

            const method =
                selected?.dataset?.method ?? '';

            methodDisplay.value = method;
            methodInput.value = method;
        }

        routeSelect.addEventListener(
            'change',
            updateMethod
        );

        updateMethod();
    </script>
@endsection

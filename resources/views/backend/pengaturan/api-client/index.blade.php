@extends('backend.layouts.app')
@section('title', 'API Client | Pengaturan | REDD++ Kalimantan Barat')
@section('header', 'API Client | Pengaturan')

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
                        <h4 class="mt-0 header-title">Tabel Data</h4>
                    </div>
                    <div class="col-md-6 text-right">
                        <button class="btn btn-icon waves-effect waves-light btn-primary" data-toggle="modal" data-target="#createModal" id="create" name="create">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <table id="table_api_client" class="table table-bordered table-bordered dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Aksi</th>
                            <th>Name</th>
                            <th>Permission</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div> <!-- end row -->

    <div id="createModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="createModalLabel">Tambah Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form class="form-horizontal" id="form_api_client" method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="name" class="control-label">Nama Client<span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" parsley-trigger="change" required
                            placeholder="Masukan nama Client..." class="form-control">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect width-md waves-light" data-dismiss="modal">Close</button>
                    <input type="hidden" name="aksi" id="aksi" value="Save">
                    <input type="hidden" name="hidden_id" id="hidden_id">
                    <button type="submit" name="aksi_button" id="aksi_button" class="btn btn-primary waves-effect width-md waves-light">Save</button>
                </div>
            </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    {{-- <div id="notifikasi" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="notifikasiModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="detail-title">API Client Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="notifikasi_name" class="control-label col-md-6">Nama Client</label>
                        <div class="col-md-6">
                            <span id="notifikasi_name"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="notifikasi_client_id" class="control-label col-md-6">Client ID</label>
                        <div class="col-md-6">
                            <span id="notifikasi_client_id"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="notifikasi_client_secret" class="control-label col-md-6">Client Secret</label>
                        <div class="col-md-6">
                            <span id="notifikasi_client_secret"></span>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div> --}}
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
        var dataTables = $('#table_api_client').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('cms.pengaturan.api-client.datatable') }}",
            },
            columns:[
                {
                    data: 'DT_RowIndex'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'permissions_count',
                    name: 'permissions_count',
                    className: 'text-center'
                },
                {
                    data: 'status',
                    name: 'status'
                }
            ]
        });

        function reset()
        {
            $('#form_api_client')[0].reset();
        }

        $('#create').click(function(){
            reset();
            $('#aksi_button').text('Save');
            $('#aksi_button').prop('disabled', false);
            $('.modal-title').text('Tambah Data');
            $('#aksi_button').val('Save');
            $('#aksi').val('Save');
            $('#form_result').html('');
        });

        $('#form_api_client').on('submit', function(e){
            e.preventDefault();
            if($('#aksi').val() == 'Save')
            {
                $.ajax({
                    url: "{{ route('cms.pengaturan.api-client.store') }}",
                    method: "POST",
                    data: new FormData(this),
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function()
                    {
                        $('#aksi_button').text('Menyimpan...');
                        $('#aksi_button').prop('disabled', true);
                    },
                    success: function(data)
                    {
                        var html = '';
                        if(data.errors)
                        {
                            html = '<div class="alert alert-danger">'+data.errors+'</div>';
                            $('#aksi_button').prop('disabled', false);
                            reset();
                            $('#aksi_button').text('Save');
                            $('#table_api_client').DataTable().ajax.reload();
                        }
                        if(data.success)
                        {
                            $('#aksi_button').prop('disabled', false);
                            reset();
                            $('#aksi_button').text('Save');
                            $('#table_api_client').DataTable().ajax.reload();
                            $('#createModal').modal('hide');
                            let dataClient = data.data;
                            Swal.fire({
                                icon: 'success',
                                title: 'Client berhasil dibuat',
                                width: 650,
                                html: `
                                    <div class="text-start">

                                        <!-- Security Warning -->
                                        <div
                                            class="alert alert-warning mb-4"
                                            role="alert"
                                            style="
                                                display: flex;
                                                align-items: flex-start;
                                                gap: 10px;
                                                text-align: left;
                                                margin-left: 0;
                                                margin-right: 0;
                                            "
                                        >
                                            <i
                                                class="fas fa-shield-alt"
                                                style="
                                                    flex: 0 0 auto;
                                                    margin-top: 3px;
                                                    font-size: 20px;
                                                "
                                            ></i>

                                            <div style="flex: 1; text-align: left;">
                                                <div style="
                                                    font-weight: 600;
                                                    line-height: 1.4;
                                                ">
                                                    Simpan Client Secret dengan aman.
                                                </div>

                                                <div style="
                                                    font-size: 13px;
                                                    margin-top: 4px;
                                                    line-height: 1.4;
                                                ">
                                                    Client Secret hanya ditampilkan satu kali.
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Client Information -->
                                        <div class="border rounded-3 overflow-hidden">

                                            <!-- Name -->
                                            <div class="d-flex border-bottom p-3">
                                                <div class="fw-semibold text-muted" style="width: 140px;">
                                                    Name
                                                </div>
                                                <div class="flex-grow-1">
                                                    ${dataClient['name']}
                                                </div>
                                            </div>

                                            <!-- Client ID -->
                                            <div class="d-flex border-bottom p-3 align-items-center">
                                                <div class="fw-semibold text-muted" style="width: 140px;">
                                                    Client ID
                                                </div>

                                                <div class="flex-grow-1 d-flex align-items-center gap-2">
                                                    <code id="clientId"
                                                        class="text-break flex-grow-1">
                                                        ${dataClient['client_id']}
                                                    </code>

                                                    <button
                                                        type="button"
                                                        id="copyClientId"
                                                        class="btn btn-sm btn-outline-secondary"
                                                        title="Copy Client ID">
                                                        <i class="fas fa-copy"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Client Secret -->
                                            <div class="p-3">
                                                <div class="fw-semibold text-muted mb-2">
                                                    Client Secret
                                                </div>

                                                <div class="d-flex align-items-center gap-2">
                                                    <code id="clientSecret"
                                                        class="text-break flex-grow-1 p-2 bg-light rounded">
                                                        ${dataClient['client_secret']}
                                                    </code>

                                                    <button
                                                        type="button"
                                                        id="copyClientSecret"
                                                        class="btn btn-sm btn-primary"
                                                        title="Copy Client Secret">
                                                        <i class="fas fa-copy"></i>
                                                        Copy
                                                    </button>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Reminder -->
                                        <div class="text-muted small mt-3">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Pastikan Client Secret telah disimpan sebelum menutup dialog ini.
                                        </div>

                                    </div>
                                `,

                                confirmButtonText: 'Saya sudah menyimpan',
                                confirmButtonColor: '#198754',

                                allowOutsideClick: false,
                                allowEscapeKey: false,

                                customClass: {
                                    popup: 'rounded-4',
                                    confirmButton: 'px-4'
                                },

                                didOpen: () => {

                                    // Copy Client ID
                                    document
                                        .getElementById('copyClientId')
                                        .addEventListener('click', async function () {

                                            const value = document.getElementById('clientId').innerText.trim();

                                            try {
                                                await navigator.clipboard.writeText(value);

                                                const button = this;

                                                button.innerHTML = '<i class="fas fa-check"></i>';
                                                button.classList.remove('btn-outline-secondary');
                                                button.classList.add('btn-success');

                                                setTimeout(() => {
                                                    button.innerHTML = '<i class="fas fa-copy"></i>';
                                                    button.classList.remove('btn-success');
                                                    button.classList.add('btn-outline-secondary');
                                                }, 1500);

                                            } catch (error) {
                                                Swal.showValidationMessage(
                                                    'Gagal menyalin Client ID'
                                                );
                                            }
                                        });


                                    // Copy Client Secret
                                    document
                                        .getElementById('copyClientSecret')
                                        .addEventListener('click', async function () {

                                            const value = document
                                                .getElementById('clientSecret')
                                                .innerText
                                                .trim();

                                            try {
                                                await navigator.clipboard.writeText(value);

                                                const button = this;

                                                button.innerHTML = '<i class="fas fa-check"></i> Copied';
                                                button.classList.remove('btn-primary');
                                                button.classList.add('btn-success');

                                                setTimeout(() => {
                                                    button.innerHTML = '<i class="fas fa-copy"></i> Copy';
                                                    button.classList.remove('btn-success');
                                                    button.classList.add('btn-primary');
                                                }, 1500);

                                            } catch (error) {
                                                Swal.showValidationMessage(
                                                    'Gagal menyalin Client Secret'
                                                );
                                            }
                                        });
                                }
                            });
                        }

                        $('#form_result').html(html);
                    }
                });
            }
        });

        $(document).on('click', '.regenarate', function(){
            let id = $(this).data('id');

            return new swal({
                title: "Apakah Anda Yakin Regenarate Client Secret Ulang?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1976D2",
                confirmButtonText: "Ya"
            }).then((result)=>{
                if(result.value)
                {
                    $.ajax({
                        url: "{{ route('cms.pengaturan.api-client.regenarate') }}",
                        method: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id:id
                        },
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
                        success: function(data){
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
                                let dataClient = data.data;
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Client Secret berhasil diregenerate ulang',
                                    width: 650,
                                    html: `
                                        <div class="text-start">

                                            <!-- Security Warning -->
                                            <div
                                                class="alert alert-warning mb-4"
                                                role="alert"
                                                style="
                                                    display: flex;
                                                    align-items: flex-start;
                                                    gap: 10px;
                                                    text-align: left;
                                                    margin-left: 0;
                                                    margin-right: 0;
                                                "
                                            >
                                                <i
                                                    class="fas fa-shield-alt"
                                                    style="
                                                        flex: 0 0 auto;
                                                        margin-top: 3px;
                                                        font-size: 20px;
                                                    "
                                                ></i>

                                                <div style="flex: 1; text-align: left;">
                                                    <div style="
                                                        font-weight: 600;
                                                        line-height: 1.4;
                                                    ">
                                                        Simpan Client Secret dengan aman.
                                                    </div>

                                                    <div style="
                                                        font-size: 13px;
                                                        margin-top: 4px;
                                                        line-height: 1.4;
                                                    ">
                                                        Client Secret hanya ditampilkan satu kali.
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Client Information -->
                                            <div class="border rounded-3 overflow-hidden">

                                                <!-- Name -->
                                                <div class="d-flex border-bottom p-3">
                                                    <div class="fw-semibold text-muted" style="width: 140px;">
                                                        Name
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        ${dataClient['name']}
                                                    </div>
                                                </div>

                                                <!-- Client ID -->
                                                <div class="d-flex border-bottom p-3 align-items-center">
                                                    <div class="fw-semibold text-muted" style="width: 140px;">
                                                        Client ID
                                                    </div>

                                                    <div class="flex-grow-1 d-flex align-items-center gap-2">
                                                        <code id="clientId"
                                                            class="text-break flex-grow-1">
                                                            ${dataClient['client_id']}
                                                        </code>

                                                        <button
                                                            type="button"
                                                            id="copyClientId"
                                                            class="btn btn-sm btn-outline-secondary"
                                                            title="Copy Client ID">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- Client Secret -->
                                                <div class="p-3">
                                                    <div class="fw-semibold text-muted mb-2">
                                                        Client Secret
                                                    </div>

                                                    <div class="d-flex align-items-center gap-2">
                                                        <code id="clientSecret"
                                                            class="text-break flex-grow-1 p-2 bg-light rounded">
                                                            ${dataClient['client_secret']}
                                                        </code>

                                                        <button
                                                            type="button"
                                                            id="copyClientSecret"
                                                            class="btn btn-sm btn-primary"
                                                            title="Copy Client Secret">
                                                            <i class="fas fa-copy"></i>
                                                            Copy
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Reminder -->
                                            <div class="text-muted small mt-3">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Pastikan Client Secret telah disimpan sebelum menutup dialog ini.
                                            </div>

                                        </div>
                                    `,

                                    confirmButtonText: 'Saya sudah menyimpan',
                                    confirmButtonColor: '#198754',

                                    allowOutsideClick: false,
                                    allowEscapeKey: false,

                                    customClass: {
                                        popup: 'rounded-4',
                                        confirmButton: 'px-4'
                                    },

                                    didOpen: () => {

                                        // Copy Client ID
                                        document
                                            .getElementById('copyClientId')
                                            .addEventListener('click', async function () {

                                                const value = document.getElementById('clientId').innerText.trim();

                                                try {
                                                    await navigator.clipboard.writeText(value);

                                                    const button = this;

                                                    button.innerHTML = '<i class="fas fa-check"></i>';
                                                    button.classList.remove('btn-outline-secondary');
                                                    button.classList.add('btn-success');

                                                    setTimeout(() => {
                                                        button.innerHTML = '<i class="fas fa-copy"></i>';
                                                        button.classList.remove('btn-success');
                                                        button.classList.add('btn-outline-secondary');
                                                    }, 1500);

                                                } catch (error) {
                                                    Swal.showValidationMessage(
                                                        'Gagal menyalin Client ID'
                                                    );
                                                }
                                            });


                                        // Copy Client Secret
                                        document
                                            .getElementById('copyClientSecret')
                                            .addEventListener('click', async function () {

                                                const value = document
                                                    .getElementById('clientSecret')
                                                    .innerText
                                                    .trim();

                                                try {
                                                    await navigator.clipboard.writeText(value);

                                                    const button = this;

                                                    button.innerHTML = '<i class="fas fa-check"></i> Copied';
                                                    button.classList.remove('btn-primary');
                                                    button.classList.add('btn-success');

                                                    setTimeout(() => {
                                                        button.innerHTML = '<i class="fas fa-copy"></i> Copy';
                                                        button.classList.remove('btn-success');
                                                        button.classList.add('btn-primary');
                                                    }, 1500);

                                                } catch (error) {
                                                    Swal.showValidationMessage(
                                                        'Gagal menyalin Client Secret'
                                                    );
                                                }
                                            });
                                    }
                                });
                            }
                        }
                    });
                }
            });
        });

        $(document).on('click', '.delete',function(){
            var id = $(this).attr('id');
            var url = "{{ route('cms.pengaturan.api-client.destroy', ['id' => ":id"]) }}";
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
                                $('#table_api_client').DataTable().ajax.reload();
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

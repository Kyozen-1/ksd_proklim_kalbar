@extends('backend.layouts.app')
@section('title', 'Manajemen Akun | Pengaturan | PROKLIM Kalimantan Barat')
@section('header', 'Manajemen Akun | Pengaturan')

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
                            Manajemen Akun
                        </h4>
                    </div>
                    <div class="col-md-6 text-right">
                        <button class="btn btn-icon waves-effect waves-light btn-primary" data-toggle="modal" data-target="#createModal" id="create" name="create">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>

                <table id="table_manajemen_akun" class="table table-bordered table-bordered dt-responsive nowrap" width="100%">
                    <thead>
                        <tr>
                            <th width="5%"> No </th>
                            <th width="10%"> Aksi </th>
                            <th> Nama </th>
                            <th> Email </th>
                            <th> Role </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div id="createModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="createModalLabel">Tambah Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form class="form-horizontal" id="form_akun" method="POST" data-parsley-validate novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="name" class="control-label">Nama<span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" parsley-trigger="change" required
                            placeholder="Masukan nama..." class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label">Email<span class="text-danger">*</span></label>
                            <input type="text" name="email" id="email" parsley-trigger="change" required
                            placeholder="Masukan nama..." class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label">Role<span class="text-danger">*</span></label>
                            <select name="role" id="role" class="form-control" parsley-trigger="change" required>
                                <option value="">Pilih Role</option>
                                <option value="superadmin">Superadmin</option>
                                <option value="admin">Admin</option>
                            </select>
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
        var dataTables = $('#table_manajemen_akun').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('cms.pengaturan.manajemen-akun.datatable') }}",
            },
            columns:[
                {
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
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
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'role',
                    name: 'role'
                }
            ]
        });

        function reset()
        {
            $('#form_akun')[0].reset();
            $("[name='role']").val('').trigger('change');
        }

        $('#create').click(function(){
            reset()
            $('#aksi_button').text('Save');
            $('#aksi_button').prop('disabled', false);
            $('.modal-title').text('Tambah Data');
            $('#aksi_button').val('Save');
            $('#aksi').val('Save');
            $('#form_result').html('');
        });

        $('#form_akun').on('submit', function(e){
            e.preventDefault();
            if($('#aksi').val() == 'Save')
            {
                $.ajax({
                    url: "{{ route('cms.pengaturan.manajemen-akun.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
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
                            reset()
                            $('#aksi_button').text('Save');
                            $('#table_manajemen_akun').DataTable().ajax.reload();
                        }
                        if(data.success)
                        {
                            $('#aksi_button').prop('disabled', false);
                            reset()
                            $('#aksi_button').text('Save');
                            $('#table_manajemen_akun').DataTable().ajax.reload();
                            $('#createModal').modal('hide');
                            let password = data.password;
                            Swal.fire({
                                icon: 'success',
                                title: 'Akun berhasil dibuat',
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
                                                    Simpan password dengan aman.
                                                </div>

                                                <div style="
                                                    font-size: 13px;
                                                    margin-top: 4px;
                                                    line-height: 1.4;
                                                ">
                                                    Password hanya ditampilkan satu kali.
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Account Information -->
                                        <div class="border rounded-3 overflow-hidden">

                                            <!-- Password -->
                                            <div class="p-3">
                                                <div class="fw-semibold text-muted mb-2">
                                                    Password
                                                </div>

                                                <div class="d-flex align-items-center gap-2">
                                                    <code
                                                        id="accountPassword"
                                                        class="text-break flex-grow-1 p-2 bg-light rounded"
                                                    >
                                                        ${password}
                                                    </code>

                                                    <button
                                                        type="button"
                                                        id="copyPassword"
                                                        class="btn btn-sm btn-primary"
                                                        title="Copy Password"
                                                    >
                                                        <i class="fas fa-copy"></i>
                                                        Copy
                                                    </button>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Reminder -->
                                        <div class="text-muted small mt-3">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Pastikan password telah disimpan sebelum menutup dialog ini.
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

                                    // Copy Password
                                    document
                                        .getElementById('copyPassword')
                                        .addEventListener('click', async function () {

                                            const value = document
                                                .getElementById('accountPassword')
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
                                                    'Gagal menyalin password'
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
            if($('#aksi').val() == 'Edit')
            {
                $.ajax({
                    url: "{{ route('cms.pengaturan.manajemen-akun.update') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    beforeSend: function(){
                        $('#aksi_button').text('Mengubah...');
                        $('#aksi_button').prop('disabled', true);
                    },
                    success: function(data)
                    {
                        var html = '';
                        if(data.errors)
                        {
                            html = '<div class="alert alert-danger">'+data.errors+'</div>';
                            $('#aksi_button').prop('disabled', false);
                            $('#aksi_button').text('Edit');
                        }
                        if(data.success)
                        {
                            reset()
                            $('#aksi_button').prop('disabled', false);
                            $('#aksi_button').text('Save');
                            $('#table_manajemen_akun').DataTable().ajax.reload();
                            $('#createModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil di ubah',
                                showConfirmButton: true
                            });
                        }

                        $('#form_result').html(html);
                    }
                });
            }
        });

        $(document).on('click', '.change-password',function(){
            var id = $(this).attr('id');
            return new swal({
                title: "Apakah Anda Yakin Merubah Password?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1976D2",
                confirmButtonText: "Ya"
            }).then((result)=>{
                if(result.value)
                {
                    $.ajax({
                        url: "{{ route('cms.pengaturan.manajemen-akun.ubah-password') }}",
                        method: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id
                        },
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
                                $('#table_manajemen_akun').DataTable().ajax.reload();
                                let password = data.password;
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Akun berhasil dibuat',
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
                                                        Simpan password dengan aman.
                                                    </div>

                                                    <div style="
                                                        font-size: 13px;
                                                        margin-top: 4px;
                                                        line-height: 1.4;
                                                    ">
                                                        Password hanya ditampilkan satu kali.
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Account Information -->
                                            <div class="border rounded-3 overflow-hidden">

                                                <!-- Password -->
                                                <div class="p-3">
                                                    <div class="fw-semibold text-muted mb-2">
                                                        Password
                                                    </div>

                                                    <div class="d-flex align-items-center gap-2">
                                                        <code
                                                            id="accountPassword"
                                                            class="text-break flex-grow-1 p-2 bg-light rounded"
                                                        >
                                                            ${password}
                                                        </code>

                                                        <button
                                                            type="button"
                                                            id="copyPassword"
                                                            class="btn btn-sm btn-primary"
                                                            title="Copy Password"
                                                        >
                                                            <i class="fas fa-copy"></i>
                                                            Copy
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Reminder -->
                                            <div class="text-muted small mt-3">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Pastikan password telah disimpan sebelum menutup dialog ini.
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

                                        // Copy Password
                                        document
                                            .getElementById('copyPassword')
                                            .addEventListener('click', async function () {

                                                const value = document
                                                    .getElementById('accountPassword')
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
                                                        'Gagal menyalin password'
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

        $(document).on('click', '.edit', function(){
            var id = $(this).attr('id');
            var url = "{{ route('cms.pengaturan.manajemen-akun.edit', ['id' => ":id"]) }}";
            url = url.replace(":id", id);

            $('#form_result').html('');
            $.ajax({
                url: url,
                dataType: "json",
                success: function(data)
                {
                    $('#name').val(data.result.name);
                    $('#email').val(data.result.email);
                    $("[name='role']").val(data.result.role).trigger('change');
                    $('#hidden_id').val(id);
                    $('.modal-title').text('Edit Data');
                    $('#aksi_button').text('Edit');
                    $('#aksi_button').prop('disabled', false);
                    $('#aksi_button').val('Edit');
                    $('#aksi').val('Edit');
                    $('#createModal').modal('show');
                }
            });
        });

        $(document).on('click', '.delete',function(){
            var id = $(this).attr('id');
            var url = "{{ route('cms.pengaturan.manajemen-akun.destroy', ['id' => ":id"]) }}";
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
                                $('#table_manajemen_akun').DataTable().ajax.reload();
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

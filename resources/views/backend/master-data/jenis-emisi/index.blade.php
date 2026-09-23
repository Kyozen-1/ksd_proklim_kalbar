@extends('backend.layouts.app')
@section('title', 'Jenis Emisi | Master Data | PROKLIM Kalimantan Barat')
@section('header', 'Jenis Emisi | Master Data')

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
                <table id="table_md_jenis_emisi" class="table table-bordered table-bordered dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Aksi</th>
                            <th>Sektor Utama</th>
                            <th>Nama</th>
                            <th>Jenis Perhitungan</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div> <!-- end row -->

    <div id="createModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="createModalLabel">Tambah Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form class="form-horizontal" id="form_md_jenis_emisi" method="POST" data-parsley-validate novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="sektor_utama_emisi_id" class="control-label">Sektor Utama Emisi</label>
                            <select name="sektor_utama_emisi_id" id="sektor_utama_emisi_id" class="form-control" required>
                                <option value="">Pilih</option>
                                @foreach ($sektorUtamaEmisis as $sektorUtamaEmisi)
                                    <option value="{{$sektorUtamaEmisi['id']}}">{{$sektorUtamaEmisi['nama']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama" class="control-label">Nama Jenis Emisi<span class="text-danger">*</span></label>
                            <input type="text" name="nama" id="nama" parsley-trigger="change" required
                            placeholder="Masukan nama Jenis Emisi..." class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="jenis_perhitungan" class="control-label">Jenis Perhitungan</label>
                            <select name="jenis_perhitungan" id="jenis_perhitungan" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="tambah">Tambah</option>
                                <option value="kurang">Kurang</option>
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

    <div id="detail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="detailModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="detail-title">Detail Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="detail_sektor_utama_emisi" class="control-label col-md-6">Sektor Utama Emisi</label>
                        <div class="col-md-6">
                            <span id="detail_sektor_utama_emisi"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="detail_nama" class="control-label col-md-6">Nama Jenis Emisi</label>
                        <div class="col-md-6">
                            <span id="detail_nama"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="detail_jenis_perhitungan" class="control-label col-md-6">Jenis Perhitungan</label>
                        <div class="col-md-6">
                            <span id="detail_jenis_perhitungan"></span>
                        </div>
                    </div>
                </div>
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
        $('#sektor_utama_emisi_id').select2();

        var dataTables = $('#table_md_jenis_emisi').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('cms.master-data.jenis-emisi.datatable') }}",
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
                    data: 'sektor_utama_emisi',
                    name: 'sektor_utama_emisi'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'jenis_perhitungan',
                    name: 'jenis_perhitungan'
                }
            ]
        });

        function reset()
        {
            $('#form_md_jenis_emisi')[0].reset();
            $("[name='sektor_utama_emisi_id']").val('').trigger('change');
            $("[name='jenis_perhitungan']").val('').trigger('change');
        }

        $('#create').click(function(){
            reset();
            $('#form_result').html('');
            $('#aksi_button').text('Save');
            $('#aksi_button').prop('disabled', false);
            $('.modal-title').text('Add Data');
            $('#aksi_button').val('Save');
            $('#aksi').val('Save');
        });

        $(document).on('click', '.detail', function(){
            var id = $(this).attr('id');
            var url = "{{ route('cms.master-data.jenis-emisi.show', ['id' => ":id"]) }}";
            url = url.replace(":id", id);
            $.ajax({
                url: url,
                dataType: "json",
                success: function(data)
                {
                    $('#detail-title').text('Detail Data');
                    $('#detail_sektor_utama_emisi').text(data.result.sektor_utama_emisi);
                    $('#detail_nama').text(data.result.nama);
                    $('#detail_jenis_perhitungan').text(data.result.jenis_perhitungan);
                    $('#detail').modal('show');
                }
            });
        });

        $('#form_md_jenis_emisi').on('submit', function(e){
            e.preventDefault();
            if($('#aksi').val() == 'Save')
            {
                $.ajax({
                    url: "{{ route('cms.master-data.jenis-emisi.store') }}",
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
                            $('#table_md_jenis_emisi').DataTable().ajax.reload();
                        }
                        if(data.success)
                        {
                            html = '<div class="alert alert-success">'+data.success+'</div>';
                            $('#aksi_button').prop('disabled', false);
                            reset()
                            $('#aksi_button').text('Save');
                            $('#table_md_jenis_emisi').DataTable().ajax.reload();
                        }

                        $('#form_result').html(html);
                    }
                });
            }
            if($('#aksi').val() == 'Edit')
            {
                $.ajax({
                    url: "{{ route('cms.master-data.jenis-emisi.update') }}",
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
                            reset();
                            $('#aksi_button').prop('disabled', false);
                            $('#aksi_button').text('Save');
                            $('#table_md_jenis_emisi').DataTable().ajax.reload();
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

        $(document).on('click', '.edit', function(){
            var id = $(this).attr('id');
            var url = "{{ route('cms.master-data.jenis-emisi.edit', ['id' => ":id"]) }}";
            url = url.replace(":id", id);

            $('#form_result').html('');
            $.ajax({
                url: url,
                dataType: "json",
                success: function(data)
                {
                    let targetSektorUtamaEmisi = data.result.sektor_utama_emisi;
                    let valueSektorUtamaEmisi = $('#sektor_utama_emisi_id option').filter(function () {
                        return $(this).text() === targetSektorUtamaEmisi;
                    }).val();
                    $("[name='sektor_utama_emisi_id']").val(valueSektorUtamaEmisi).trigger('change');

                    $('#nama').val(data.result.nama);

                    $("[name='jenis_perhitungan']").val(data.result.jenis_perhitungan).trigger('change');

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
            var url = "{{ route('cms.master-data.jenis-emisi.destroy', ['id' => ":id"]) }}";
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
                                $('#table_md_jenis_emisi').DataTable().ajax.reload();
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

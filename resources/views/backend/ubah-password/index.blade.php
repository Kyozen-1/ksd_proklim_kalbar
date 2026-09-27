@extends('backend.layouts.app')
@section('title', 'Ubah Password | PROKLIM Kalimantan Barat')
@section('header', 'Ubah Password')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <form action="{{route('cms.ubah-password.store')}}" class="form-horizontal" data-parsley-validate novalidate method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="current-password" class="control-label">Password Terkini<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" name="current-password" id="current-password" class="form-control" parsley-trigger="change" placeholder="Password terkini..." required>
                            <span class="input-group-text toggle-password" data-target="#current-password" style="cursor:pointer;"><i class="fas fa-eye"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new-password" class="control-label">Password Baru<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" name="new-password" id="new-password" class="form-control" parsley-trigger="change" placeholder="Password baru..." required>
                            <span class="input-group-text toggle-password" data-target="#new-password" style="cursor:pointer;"><i class="fas fa-eye"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new-password-confirm" class="control-label">Konfirmasi Password Baru<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" name="new-password-confirm" id="new-password-confirm" class="form-control" parsley-trigger="change" placeholder="Konfirmasi password baru..." required>
                            <span class="input-group-text toggle-password" data-target="#new-password-confirm" style="cursor:pointer;"><i class="fas fa-eye"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info" id="btn_submit" disabled> Ganti Password </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            // Toggle password
            $(document).on('click', '.toggle-password', function () {

                let input = $($(this).data('target'));
                let icon = $(this).find('i');

                // Toggle input type
                input.attr(
                    'type',
                    input.attr('type') === 'password' ? 'text' : 'password'
                );

                // Toggle Font Awesome icon
                icon.toggleClass('fa-eye fa-eye-slash');

            });

            // Validasi minimal 8 karakter
            $('#new-password').on('keyup', function(){

                if($(this).val().length < 8){
                    $('#btn_submit').prop('disabled', true);
                    $('#max_new_password').show();
                } else {
                    $('#btn_submit').prop('disabled', false);
                    $('#max_new_password').hide();
                }

            });

        });
    </script>
@endsection

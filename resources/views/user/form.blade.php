@extends('layouts.master', ['title' => $title])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{ $title }}</div>

            <div class="card-body">
                <form action="{{ $action }}" method="post" enctype="multipart/form-data">
                    @method($method)
                    @csrf
                    <div class="form-group mb-3">
                        <label for="uid"><sup class="text-danger">*</sup> UID</label>
                        <input type="text" name="uid" id="uid" class="form-control" value="{{ $user->uid ?? old('uid') }}">

                        @error('uid')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="username"><sup class="text-danger">*</sup> Username</label>
                        <input type="text" name="username" id="username" class="form-control" value="{{ $user->username ?? old('username') }}">

                        @error('username')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="nama"><sup class="text-danger">*</sup> Nama</label>
                        <input type="text" name="name" id="nama" class="form-control" value="{{ $user->name ?? old('name') }}">

                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="password"><sup class="text-danger">*</sup> Password</label>
                        <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}">

                        @error('password')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="telepon"><sup class="text-danger">*</sup> Telepon</label>
                        <input type="number" name="telepon" id="telepon" class="form-control" value="{{ $user->telepon ?? old('telepon') }}">

                        @error('telepon')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="alamat"><sup class="text-danger">*</sup> Alamat</label>
                        <select name="alamat" id="alamat" class="form-control">
                            <option disabled selected>-- Pilih Alamat --</option>
                            @foreach($alamat as $almt)
                            <option {{ $user->alamat == $almt->id ? 'selected' : '' }} value="{{ $almt->id }}">{{ $almt->alamat }}</option>
                            @endforeach
                            <option {{ $user->alamat == null ? 'selected' : '' }} value="custom">Tulis Alamat Manual</option>
                        </select>

                        @error('alamat')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="extends d-none">
                        <div class="form-group mb-3">
                            <label for="nama_gedung"><sup class="text-danger">*</sup> Nama Gedung</label>
                            <input type="text" name="nama_gedung" id="nama_gedung" class="form-control" value="{{ $user->nama_gedung ?? old('nama_gedung') }}">

                            @error('nama_gedung')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="no_kamar"><sup class="text-danger">*</sup> No Kamar</label>
                            <input type="text" name="no_kamar" id="no_kamar" class="form-control" value="{{ $user->no_kamar ?? old('no_kamar') }}">

                            @error('no_kamar')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="alamat-lengkap d-none">
                        <div class="form-group mb-3">
                            <label for="alamat_lengkap"><sup class="text-danger">*</sup> Alamat Lengkap</label>
                            <textarea name="alamat_lengkap" id="alamat_lengkap" rows="3" class="form-control">{{ $user->alamat_lengkap ?? old('alamat_lengkap') }}</textarea>

                            @error('alamat_lengkap')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="level"><sup class="text-danger">*</sup> Level</label>
                        <select name="level" id="level" class="form-control">
                            <option disabled selected>-- Pilih Level --</option>
                            <option {{ $user->level == 'Admin' ? 'selected' : '' }} value="Admin">Admin</option>
                            <option {{ $user->level == 'User' ? 'selected' : '' }} value="User">User</option>
                        </select>

                        @error('level')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="foto"><sup class="text-danger">*</sup> Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control" value="{{ old('foto') }}">

                        @error('foto')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <button type="submit" class="btn btn-primary"><i class="fe fe-save"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@push('script')
<script>
    $(document).ready(function() {
        let alamat = $("#alamat").val();

        if (alamat != 'custom') {
            $(".extends").removeClass("d-none")
            $(".alamat-lengkap").addClass("d-none")
        } else {
            $(".alamat-lengkap").removeClass("d-none")
            $(".extends").addClass("d-none")
        }
    })

    $("#alamat").on('change', function() {
        let almt = $(this).val()

        if (almt != 'custom') {
            $(".extends").removeClass("d-none")
            $(".alamat-lengkap").addClass("d-none")
        } else {
            $(".alamat-lengkap").removeClass("d-none")
            $(".extends").addClass("d-none")
        }
    })
</script>
@endpush
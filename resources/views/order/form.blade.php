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
                        <label for="level"><sup class="text-danger">*</sup> Level</label>
                        <select name="level" id="level" class="form-control">
                            <option disabled selected>-- Pilih Level --</option>
                            <option {{ $user->level == 'Admin' ? 'selected' : '' }} value="Admin">Admin</option>
                            <option {{ $user->level == 'Staff' ? 'selected' : '' }} value="Staff">Staff</option>
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
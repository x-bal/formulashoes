@extends('layouts.master', ['title' => $title])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{ $title }}</div>

            <div class="card-body">
                <form action="{{ route('profile.update', $user->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="level" value="User">

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
                        <label for="password"> Password Baru</label>
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
                        <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control">
                        {{ $user->alamat ?? old('alamat') }}
                        </textarea>

                        @error('alamat')
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
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
                        <label for="id_device"><sup class="text-danger">*</sup> Id Device</label>
                        <input type="text" name="id_device" id="id_device" class="form-control" value="{{ $device->id_device ?? old('id_device') }}">

                        @error('id_device')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="nama_device"><sup class="text-danger">*</sup> Nama Device</label>
                        <input type="text" name="nama_device" id="nama_device" class="form-control" value="{{ $device->nama_device ?? old('nama_device') }}">

                        @error('nama_device')
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
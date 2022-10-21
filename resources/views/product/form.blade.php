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
                        <label for="nama_product"><sup class="text-danger">*</sup> Nama Product</label>
                        <input type="text" name="nama_product" id="nama_product" class="form-control" value="{{ $product->nama_product ?? old('nama_product') }}">

                        @error('nama_product')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="deskripsi"><sup class="text-danger">*</sup> Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" cols="30" rows="10" class="form-control">{{ $product->deskripsi ?? old('deskripsi') }}</textarea>

                        @error('deskripsi')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="harga"><sup class="text-danger">*</sup> Harga</label>
                        <input type="number" name="harga" id="harga" class="form-control" value="{{ $product->harga ?? old('harga') }}">

                        @error('harga')
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
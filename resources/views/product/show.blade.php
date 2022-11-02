@extends('layouts.master', ['title' => 'Detail Product'])

@section('content')
<div class="row">
    <div class="col-12 col-lg-10 col-xl-8">

        <div class="card shadow">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-4 text-center">
                        <img src="{{ asset('storage/' . $product->foto) }}" class="img-fluid" alt="..." width="100%">
                    </div>
                    <div class="col-md-8">
                        <h2 class="mb-0 text-uppercase">{{ $product->nama_product }}</h2>
                        <p class="text-muted"> {{ $product->deskripsi }}</p>
                        <div class="btn btn-sm btn-primary">Rp. {{ number_format($product->harga, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@extends('layouts.master', ['title' => 'Dashboard'])

@section('content')
<div class="alert alert-success">
    Hallo {{ auth()->user()->name }} Selamat datang di Formulashoe, Have a nice day!
</div>
@if(isUser())
@if(auth()->user()->alamat == null)
<div class="alert alert-info">Mohon lengkapi profile untuk bisa membuka semua menu, silahkan <a href="{{ route('profile') }}">Klik disini.</a></div>
@else
<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Total Order</h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="fe fe-clock" style="font-size: 30px;"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ $order }}</h1>
                <div class="mb-0">
                    <span class="text-muted">Since last month</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Total Cart</h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="fe fe-shopping-cart" style="font-size: 30px;"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ $cart }}</h1>
                <div class="mb-0">
                    <span class="text-muted">Since last month</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@else
<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Total Order</h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="fe fe-clock" style="font-size: 30px;"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ $order }}</h1>
                <div class="mb-0">
                    <span class="text-muted">Since last month</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Total Amount</h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="fe fe-dollar-sign" style="font-size: 30px;"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">Rp. {{ number_format($cart, 0,',', '.') }}</h1>
                <div class="mb-0">
                    <span class="text-muted">Since last month</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@stop
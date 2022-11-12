@extends('layouts.master', ['title' => 'Order Detail'])

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8">
        @if($order->payment_status == 1)
        <div class="alert alert-primary">Menunggu pembayaran</div>
        @endif

        @if($order->payment_status == 2)
        <div class="alert alert-success">Sudah dibayar</div>
        @endif

        @if($order->payment_status == 3)
        <div class="alert alert-warning">Pending</div>
        @endif

        @if($order->payment_status == 4)
        <div class="alert alert-danger">Gagal</div>
        @endif

        @can('isUser')
        <div class="row align-items-center mb-4">
            <div class="col">
                <h2 class="h5 page-title"><small class="text-muted text-uppercase">Invoice</small><br />{{ $order->no_order }}</h2>
            </div>
            <div class="col-auto">
                @if($order->payment_status == 1 || $order->payment_status == 3)
                <button type="button" class="btn btn-primary" id="pay-button">Pay</button>
                @endif
            </div>
        </div>
        @endcan

        <div class="card shadow">
            <div class="card-body p-5">
                <div class="row mb-3">
                    <div class="col-12 text-center mb-4">
                        <img src="{{ asset('/') }}assets/images/formulashoe.png" alt="" class="navbar-brand-img mb-4" width="140">
                        <h2 class="mb-0 text-uppercase">Invoice</h2>
                        <p class="text-muted"> Formula Shoes</p>
                    </div>
                </div>
                <div class="row mb-3 d-flex justify-content-center">
                    <div class="col-6 mb-0 text-uppercase text-left">
                        {{ $order->no_order }} <br>
                        {{ $order->user->name }} <br>
                        {{ $order->user->telepon }}
                    </div>
                    <div class="col-6 mb-0 text-uppercase text-right">
                        {{ Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i:s') }} <br>
                        {{ $order->user->alamat }} <br>
                        {{ $order->device->nama_device ?? '-' }}
                    </div>
                </div>
                <table class="table table-borderless table-striped">
                    <thead>
                        <tr>
                            <th scope="col" class="text-dark">#</th>
                            <th scope="col" class="text-dark">Description</th>
                            <th scope="col" class="text-right text-dark">Price</th>
                            <th scope="col" class="text-right text-dark">Qty</th>
                            <th scope="col" class="text-right text-dark">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $total = 0;
                        @endphp
                        @foreach($order->products as $product)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td> {{ $product->nama_product }}<br />
                                <span class="small text-muted">{{ Str::limit($product->deskripsi, 35) }}</span>
                            </td>
                            <td class="text-right">{{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td class="text-right">{{ $product->pivot->qty }}</td>
                            <td class="text-right">{{ number_format($product->harga * $product->pivot->qty, 0, ',', '.') }}</td>

                            @php
                            $total += $product->harga * $product->pivot->qty;
                            @endphp
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4">Total</th>
                            <th class="text-right">Rp. {{ number_format($total, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>

                <div class="content text-center mt-5">
                    <h4>Attachment</h4>
                    <div class="row justify-content-between">
                        <div class="col-md-6">
                            <h6>Image From Upload</h6>
                            <img src="{{ asset('/storage/' . $order->foto) }}" alt="" class="img-fluid">
                        </div>
                        <div class="col-md-6">
                            <h6>Image From Device</h6>
                            <img src="{{ asset('/storage/' . $order->after_laundry) }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@push('script')
@if(config('midtrans.is_production') == false)
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
@else
<script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
@endif
<script>
    function status(payment_status) {
        let order_id = "{{ $order->no_order }}";

        $.ajax({
            url: '/api/order/status/' + order_id,
            type: 'GET',
            data: {
                status: payment_status
            },
            success: function(response) {
                document.location.href = response.message
            }
        })
    }

    const payButton = document.querySelector('#pay-button');
    payButton.addEventListener('click', function(e) {
        e.preventDefault();

        snap.pay('{{ $order->snap_token }}', {
            // Optional
            onSuccess: function(result) {
                status(2)
            },
            // Optional
            onPending: function(result) {
                status(3)
                console.log(result)
            },
            // Optional
            onError: function(result) {
                status(4)
            }
        });
    });
</script>
@endpush
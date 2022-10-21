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

        @if($order->payment_status == 3)
        <div class="alert alert-danger">Gagal</div>
        @endif

        <div class="row align-items-center mb-4">
            <div class="col">
                <h2 class="h5 page-title"><small class="text-muted text-uppercase">Invoice</small><br />{{ $order->no_order }}</h2>
            </div>
            <div class="col-auto">
                @if($order->payment_status == 1)
                <button type="button" class="btn btn-primary" id="pay-button">Pay</button>
                @endif
            </div>
        </div>
        <div class="card shadow">
            <div class="card-body p-5">
                <div class="row mb-5">
                    <div class="col-12 text-center mb-4">
                        <img src="./assets/images/logo.svg" class="navbar-brand-img brand-sm mx-auto mb-4" alt="...">
                        <h2 class="mb-0 text-uppercase">Invoice</h2>
                        <p class="text-muted"> Formula Shoes</p>
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
                        @foreach($order->products as $product)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td> {{ $product->nama_product }}<br />
                                <span class="small text-muted">{{ Str::limit($product->deskripsi, 35) }}</span>
                            </td>
                            <td class="text-right">{{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td class="text-right">{{ $product->pivot->qty }}</td>
                            <td class="text-right">{{ number_format($product->harga * $product->pivot->qty, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@push('script')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
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
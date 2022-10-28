<div class="table-responsive">
    <table class="table table-bordered table-striped" id="table">
        <thead>
            <tr>
                <th class="text-dark">No</th>
                <th class="text-dark">Tanggal</th>
                <th class="text-dark">No Order</th>
                <th class="text-dark">Total</th>
                <th class="text-dark">Status Pembayaran</th>
                <th class="text-dark">Status Laundry</th>
            </tr>
        </thead>

        <tbody>
            @foreach($orders as $order)
            <tr>
                <td class="text-center">
                    {{ $loop->iteration }}
                </td>
                <td>
                    {{ Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i:s') }}
                </td>
                <td>
                    <a href="{{ route('orders.show', $order->no_order) }}">{{ $order->no_order }}</a>
                </td>
                <td>Rp. {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td>
                    @if($order->payment_status == 1)
                    <div class="badge badge-primary text-white p-2">Menunggu Pembayaran</div>
                    @endif
                    @if($order->payment_status == 2)
                    <div class="badge badge-success text-white p-2">Sudah Dibayar</div>
                    @endif
                    @if($order->payment_status == 3)
                    <div class="badge badge-warning text-white p-2">Pending</div>
                    @endif
                    @if($order->payment_status == 4)
                    <div class="badge badge-danger text-white p-2">Pembayaran Gagal</div>
                    @endif
                </td>
                <td>
                    @if($order->status_laundry == 'Booked')
                    <div class="badge badge-primary text-white p-2">{{ $order->status_laundry }}</div>
                    @endif
                    @if($order->status_laundry == 'Sedang Diproses')
                    <div class="badge badge-warning text-white p-2">{{ $order->status_laundry }}</div>
                    @endif
                    @if($order->status_laundry == 'Selesai')
                    <div class="badge badge-success text-white p-2">{{ $order->status_laundry }}</div>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
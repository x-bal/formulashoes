<div class="table-responsive">
    <table class="table table-bordered table-striped" id="table">
        <thead>
            <tr>
                <th class="text-dark">No</th>
                <th class="text-dark">Tanggal</th>
                <th class="text-dark">No Order</th>
                <th class="text-dark">Nama</th>
                <th class="text-dark">Total</th>
                <th class="text-dark text-center">Payment Status</th>
                <th class="text-dark text-center">Laundry Status</th>
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
                <td>
                    {{ $order->user->name }}
                </td>
                <td>Rp. {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td class="text-center">
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
                <td class="text-center">
                    @if($order->status_laundry == 'Booked')
                    <button type="button" class="btn btn-sm btn-primary btn-laundry text-white" data-toggle="modal" data-target="#modalStatusLaundry" data-id="{{ $order->no_order }}" data-status="{{ $order->status_laundry }}">{{ $order->status_laundry }}</button>
                    @endif
                    @if($order->status_laundry == 'Sedang Diproses')
                    <button type="button" class="btn btn-sm btn-warning btn-laundry text-white" data-toggle="modal" data-target="#modalStatusLaundry" data-id="{{ $order->no_order }}" data-status="{{ $order->status_laundry }}">{{ $order->status_laundry }}</button>
                    @endif
                    @if($order->status_laundry == 'Selesai')
                    <button type="button" class="btn btn-sm btn-success btn-laundry text-white" data-toggle="modal" data-target="#modalStatusLaundry" data-id="{{ $order->no_order }}" data-status="{{ $order->status_laundry }}">{{ $order->status_laundry }}</button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
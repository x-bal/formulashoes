<form action="" method="get" class="row mb-3">
    <div class="col-md-3">
        <label for="">From</label>
        <input type="date" name="from" id="from" class="form-control" value="{{ request('from') }}">
    </div>
    <div class="col-md-3">
        <label for="">To</label>
        <input type="date" name="to" id="to" class="form-control" value="{{ request('to') }}">
    </div>
    <div class="col-md-3 mt-1">
        <button type="submit" class="btn btn-primary mt-4">Submit</button>
        <a href="{{ route('orders.index') }}" class="btn btn-success text-white mt-4">Reset</a>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-bordered table-striped" id="table">
        <thead>
            <tr>
                <th>No</th>
                <th>No Urut</th>
                <th>Tanggal</th>
                <th>No Order</th>
                <th>Total</th>
                <th class=" text-center">Status Pembayaran</th>
                <th class=" text-center">Status Laundry</th>
            </tr>
        </thead>

        <tbody>
            @foreach($orders as $order)
            <tr>
                <td class="text-center">
                    {{ $loop->iteration }}
                </td>
                <td>
                    @if($order->status_laundry == 'Booked')
                    <input type="number" name="" data-id="{{ $order->no_order }}" class="form-control form-control-sm no-urut" value="{{ $order->no_urut }}" min="1" max="{{ count($orders) }}">
                    @else
                    {{ $order->no_urut }}
                    @endif
                </td>
                <td>
                    {{ Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i:s') }}
                </td>
                <td>
                    <a href="{{ route('orders.show', $order->no_order) }}">{{ $order->no_order }}</a>
                </td>
                <td>Rp. {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td class="text-center">
                    @if($order->payment_status == 1)
                    <div class="badge badge-primary text-white p-2 pay-button" id="{{ $order->no_order }}" data-token="{{ $order->snap_token }}" style="cursor: pointer;">Bayar</div>
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
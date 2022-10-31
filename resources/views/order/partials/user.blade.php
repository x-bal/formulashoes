<div class="alert alert-info">
    List order default tanggal sekarang. <br>
    Untuk no urut mohon di isi secara berurutan dan tidak melebihi jumlah order.
</div>

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
                <th class="text-dark">No</th>
                <th class="text-dark">No Urut</th>
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
                    <input type="number" name="" id="" class="form-control form-control-sm" value="{{ $order->no_urut }}">
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
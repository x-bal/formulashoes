<form action="" class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="date-input1">Tanggal</label>
            <input type="text" name="tanggal" class="form-control datetimes" />
        </div>
    </div>
</form>

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


<div class="modal fade" id="modalStatusLaundry" tabindex="-1" role="dialog" aria-labelledby="modalStatusLaundryLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalStatusLaundryLabel">Ubah Status Laundry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('orders.status') }}" method="post">
                @csrf
                <input type="hidden" id="no_order" name="no_order" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status_laundry">Status Laundry</label>
                        <select name="status_laundry" id="status_laundry" class="form-control">
                            <option value="Booked">Booked</option>
                            <option value="Sedang Diproses">Sedang Diproses</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn mb-2 btn-primary">Ubah Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
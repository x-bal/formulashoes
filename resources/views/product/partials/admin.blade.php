<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Data Product</div>

            <div class="card-body">
                <a href="{{ route('products.create') }}" class="btn btn-primary mb-3 align-middle"><i class="fe fe-plus-circle"></i> Tambah Product</a>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="table">
                        <thead>
                            <tr>
                                <th class="text-dark">No</th>
                                <th class="text-dark">Foto</th>
                                <th class="text-dark">Nama Product</th>
                                <th class="text-dark">Deskripsi</th>
                                <th class="text-dark">Harga</th>
                                <th class="text-dark">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    <img src="{{ asset('storage/'. $product->foto) }}" alt="" class="avatar-img rounded" width="50">
                                </td>
                                <td>{{ $product->nama_product }}</td>
                                <td>{{ Str::limit($product->deskripsi, 50) }}</td>
                                <td>Rp. {{ number_format($product->harga, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-success text-light"><i class="fe fe-edit align-middle"></i></a>
                                    <form id="form-delete" action="{{ route('products.destroy', $product->id) }}" method="post" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button type="button" class="btn btn-danger btn-delete"><i class="fe fe-trash align-middle"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
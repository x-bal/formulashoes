<div class="row">
    @foreach($products as $product)
    <div class="col-md-4">
        <div class="card shadow mb-4" style="min-width: 18rem;">
            <a href="{{ route('products.show', $product->id) }}" class="car-img-top">
                <img src="{{ asset('/storage/'. $product->foto) }}" alt="{{ $product->nama_product }}" class="avatar-img rounded" width="100%" style="object-fit: cover; object-position: center; height: 200px;">
            </a>
            <div class="card-body text-center">
                <div class="card-text my-2">
                    <strong class="card-title my-0">{{ $product->nama_product }} </strong>
                    <p class="small text-muted mb-4">{{ Str::limit($product->deskripsi, 70) }}</p>
                </div>
            </div>
            <div class="card-footer">
                <div class="row d-flex align-items-center justify-content-between">
                    <div class="col-auto">
                        <span class="text-dark"><b>Rp. {{ number_format($product->harga, 0, ',', '.') }}</b></span>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-primary btn-sm btn-cart" data-toggle="modal" data-target="#cartModel" data-id="{{ $product->id }}">
                            <i class="fe fe-shopping-cart mr-2"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <div class="modal fade" id="cartModel" tabindex="-1" role="dialog" aria-labelledby="cartModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModelLabel">Add to Cart</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('products.cart') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="product_id[]" class="product_id" value="">
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <button type="button" class="btn btn-outline-primary btn-number" disabled="disabled" data-type="minus" data-field="quant">
                                    <span class="fe fe-minus"></span>
                                </button>
                            </span>
                            <input type="text" name="quant" class="form-control input-number text-center" value="1" min="1" max="20">
                            <span class="input-group-append">
                                <button type="button" class="btn btn-outline-primary btn-number" data-type="plus" data-field="quant">
                                    <span class="fe fe-plus"></span>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn mb-2 btn-primary">Add to Cart</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
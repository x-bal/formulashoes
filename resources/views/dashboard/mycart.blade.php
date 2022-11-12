@extends('layouts.master', ['title' => $title])
@push('style')
<style>
    .input-group {
        width: 100px;
        margin-top: 10px;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{ $title }}</div>

            <div class="card-body">
                <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#defaultModal"><i class="fe fe-arrow-right"></i> Proses Order</button>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-dark text-center">
                                    <input type="checkbox" id="check-all">
                                </th>
                                <th class="text-dark text-center">Item</th>
                                <th class="text-dark text-center">Total</th>
                                <th class="text-dark text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($user->products as $product)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" class="check-product" data-id="{{ $product->id }}" data-qty="{{ $product->pivot->qty }}">
                                </td>
                                <td class="text-center">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <img src="{{ asset('/storage/'. $product->foto) }}" alt="{{ $product->nama_product }}" class="avatar-img rounded" width="80">
                                        </div>
                                        <div class="col-auto">
                                            <small><strong>{{ $product->nama_product }}</strong></small>
                                            <br>
                                            <small>{{ Str::limit($product->deskripsi, 30) }}</small>
                                            <br>
                                            <small class="text-dark"><b>Rp. {{ number_format($product->harga, 0, ',', '.') }}</b></small>
                                            <br>

                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <button type="button" class="btn btn-outline-primary btn-sm btn-number" data-type="minus" data-field="quant" data-id="{{ $product->id }}">
                                                        <span class="fe fe-minus"></span>
                                                    </button>
                                                </span>

                                                <input type="text" name="quant" class="form-control form-control-sm input-number text-center" value="{{ $product->pivot->qty }}" min="1" max="20">

                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-outline-primary btn-sm btn-number" data-type="plus" data-field="quant" data-id="{{ $product->id }}">
                                                        <span class="fe fe-plus"></span>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <small class="text-dark"><b>Rp. {{ number_format($product->harga * $product->pivot->qty, 0, ',', '.') }}</b></small>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('products.remove') }}?user={{ $product->pivot->user_id }}&product={{ $product->id }}" class="btn btn-danger"><i class="fe fe-trash"></i></a>
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

<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="defaultModalLabel">Upload Foto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('orders.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-target"></div>
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                <div class="modal-body">
                    <div class="form-group">
                        <label for="foto">Foto</label><br>
                        <input type="file" name="foto" id="foto">

                        @error('foto')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn mb-2 btn-primary">Checkout</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@push('script')
<script>
    $(".product_id").val("");

    $(".card").on('click', '.btn-cart', function() {
        let product_id = $(this).attr('data-id');

        $(".product_id").val(product_id);
    });
</script>

<script>
    $('.table').on('click', '.btn-number', function(e) {
        e.preventDefault();

        fieldName = $(this).attr('data-field');
        type = $(this).attr('data-type');
        var input = $("input[name='" + fieldName + "']");
        var currentVal = parseInt(input.val());
        let product_id = $(this).attr('data-id');
        let user_id = "{{ auth()->user()->id }}";

        if (!isNaN(currentVal)) {
            if (type == 'minus') {

                if (currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();

                    $.ajax({
                        url: '/api/products/cart',
                        type: 'POST',
                        method: 'POST',
                        data: {
                            product_id: product_id,
                            user_id: user_id,
                            qty: currentVal - 1
                        },
                        success: function(response) {
                            location.reload()
                        }
                    })
                }
                if (parseInt(input.val()) == input.attr('min')) {
                    $(this).attr('disabled', true);
                }

            } else if (type == 'plus') {

                if (currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();

                    $.ajax({
                        url: '/api/products/cart',
                        type: 'POST',
                        method: 'POST',
                        data: {
                            product_id: product_id,
                            user_id: user_id,
                            qty: currentVal + 1
                        },
                        success: function(response) {
                            location.reload()
                        }
                    })
                }

                if (parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }

            }
        } else {
            input.val(0);
        }
    });

    $('.input-number').focusin(function() {
        $(this).data('oldValue', $(this).val());
    });

    $('.input-number').change(function() {

        minValue = parseInt($(this).attr('min'));
        maxValue = parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());

        name = $(this).attr('name');
        if (valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if (valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }
    });

    $(".input-number").keydown(function(e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
</script>

<script>
    $("#check-all").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
        var ischecked = $(this).is(':checked');
        let id = '{{ auth()->user()->id }}';

        if (ischecked == true) {
            $.ajax({
                url: '/api/products/mycart/' + id,
                type: 'GET',
                success: function(response) {
                    $('.form-target').empty()
                    $.each(response.products, function(index, item) {
                        $('.form-target').append('<input type="hidden" name="product_id[]" id="product-' + item.id + '" value="' + item.id + '"/>');
                        $('.form-target').append('<input type="hidden" name="qty[]" id="qty-' + item.id + '" value="' + item.pivot.qty + '"/>');
                    });
                }
            })
        } else {
            $.ajax({
                url: '/api/products/mycart/' + id,
                type: 'GET',
                success: function(response) {
                    $.each(response.products, function(index, item) {
                        $('#product-' + item.id).remove();
                        $('#qty-' + item.id).remove();
                    });
                }
            })
        }
    });

    $('.table').on('click', '.check-product', function() {
        var ischecked = $(this).is(':checked');
        let id = $(this).attr('data-id');
        let qty = $(this).attr('data-qty');

        if (ischecked == false) {
            $('#product-' + id).remove();
            $('#qty-' + id).remove();
        } else {
            $('.form-target').append('<input type="hidden" name="product_id[]" id="product-' + id + '" value="' + id + '"/>');
            $('.form-target').append('<input type="hidden" name="qty[]" id="qty-' + id + '" value="' + qty + '"/>');
        }
    })
</script>
@endpush
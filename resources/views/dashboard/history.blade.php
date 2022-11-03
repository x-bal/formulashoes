@extends('layouts.master', ['title' => $title])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{ $title }}</div>

            <div class="card-body">
                @can('isAdmin')
                @include('order.partials.admin')
                @else
                @include('order.partials.user')
                @endcan
            </div>
        </div>
    </div>
</div>
@stop

@push('script')
<script src="{{ asset('/') }}js/daterangepicker.js"></script>

@if(isAdmin())
<script>
    $(document).ready(function() {
        $(".table").on('click', '.btn-laundry', function() {
            let no_order = $(this).attr('data-id');
            let status = $(this).attr('data-status');

            $("#status_laundry").val(status).change()
            $("#no_order").val(no_order);
        })
    })
</script>
@else
<script>
    $(document).ready(function() {

        $(".table").on('change', '.no-urut', function() {
            let id = $(this).attr('data-id');
            let nourut = $(this).val();

            $.ajax({
                url: 'api/order/nourut',
                type: 'GET',
                method: 'GET',
                data: {
                    id: id,
                    nourut: nourut,
                    user_id: "{{ auth()->user()->id }}"
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $(".target-alert").append(`<div class="alert alert-success alert-on">
                    ` + response.message + `</div>`)

                        setTimeout(function() {
                            $(".alert-on").remove()
                            location.reload()
                        }, 2000)
                    }

                    if (response.status == 'failed') {
                        location.reload()
                        $(".target-alert").append(`<div class="alert alert-danger alert-off">
                    ` + response.message + `</div>`)

                        setTimeout(function() {
                            $(".alert-off").remove()
                        }, 2000)
                    }
                }
            })
        });
    })
</script>

@if(config('midtrans.is_production') == false)
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
@else
<script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
@endif
<script>
    function status(payment_status, order_id) {

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

    $(".table").on('click', '.pay-button', function() {
        let token = $(this).attr('data-token');
        let order_id = $(this).attr('id');

        snap.pay(token, {
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
    })
</script>
@endif

@endpush
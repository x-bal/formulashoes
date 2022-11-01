@extends('layouts.master', ['title' => $title])

@push('style')
<link rel="stylesheet" href="{{ asset('/') }}css/daterangepicker.css">
@endpush

@section('content')
<div class="target-alert"></div>

@if(isUser())
<div class="alert alert-info">
    List order default tanggal sekarang. <br>
    Untuk no urut mohon di isi secara berurutan dan tidak melebihi jumlah order. <br>
    Jika status laundry "Sedang diproses" no urut tidak bisa diubah.
</div>
@endif
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
                        $(".target-alert").append(`<div class="alert alert-success">
                        ` + response.message + `</div>`)
                    }

                    if (response.status == 'failed') {
                        $(".target-alert").append(`<div class="alert alert-danger">
                        ` + response.message + `</div>`)
                    }
                }
            })
        });
    })
</script>
@endif

@endpush
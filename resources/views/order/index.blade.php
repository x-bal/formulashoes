@extends('layouts.master', ['title' => $title])

@push('style')
<link rel="stylesheet" href="{{ asset('/') }}css/daterangepicker.css">
@endpush

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
@endpush
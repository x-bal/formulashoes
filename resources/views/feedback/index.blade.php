@extends('layouts.master', ['title' => $title])

@section('content')
@can('isAdmin')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{ $title }}</div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Feedback</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($feedbacks as $feedback)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $feedback->user->name }}</td>
                                <td>{{ $feedback->feedback }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row">
    <div class="col-md-12">
        @if(auth()->user()->feedback == null)
        <form action="{{ route('feedback.store') }}" method="post">
            @csrf

            <input type="hidden" name="user" value="{{ auth()->user()->id }}">
            <div class="form-group mb-3">
                <label for="feedback">Feedback</label>
                <textarea name="feedback" id="feedback" cols="30" rows="5" class="form-control"></textarea>

                @error('feedback')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fe fe-send"></i> Send</button>
            </div>
        </form>
        @else
        <div class="alert alert-success">
            Terima kasih telah memberikan feedback kepada kami.
        </div>
        @endif
    </div>
</div>
@endcan
@stop
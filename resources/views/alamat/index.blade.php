@extends('layouts.master', ['title' => $title])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{ $title }}</div>

            <div class="card-body">
                <a href="{{ route('alamat.create') }}" class="btn btn-primary mb-3 align-middle"><i class="fe fe-plus-circle"></i> Tambah Alamat</a>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Alamat</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($alamats as $alamat)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $alamat->alamat }}</td>
                                <td>
                                    <a href="{{ route('alamat.edit', $alamat->id) }}" class="btn btn-success text-light"><i class="fe fe-edit align-middle"></i></a>
                                    <form id="form-delete" action="{{ route('alamat.destroy', $alamat->id) }}" method="post" class="d-inline">
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
@stop
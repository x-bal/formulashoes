@extends('layouts.master', ['title' => $title])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{ $title }}</div>

            <div class="card-body">
                <a href="{{ route('devices.create') }}" class="btn btn-primary mb-3 align-middle"><i class="fe fe-plus-circle"></i> Tambah Device</a>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Id Device</th>
                                <th>Nama Device</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($devices as $device)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $device->id_device }}</td>
                                <td>{{ $device->nama_device }}</td>
                                <td>{{ $device->status }}</td>
                                <td>
                                    <a href="{{ route('devices.edit', $device->id) }}" class="btn btn-success text-light"><i class="fe fe-edit align-middle"></i></a>
                                    <form id="form-delete" action="{{ route('devices.destroy', $device->id) }}" method="post" class="d-inline">
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
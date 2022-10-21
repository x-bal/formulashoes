@extends('layouts.master', ['title' => 'Data User'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Data User</div>

            <div class="card-body">
                <a href="{{ route('users.create') }}" class="btn btn-primary mb-3 align-middle"><i class="fe fe-plus-circle"></i> Tambah User</a>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="table">
                        <thead>
                            <tr>
                                <th class="text-dark">No</th>
                                <th class="text-dark">Foto</th>
                                <th class="text-dark">Username</th>
                                <th class="text-dark">Nama</th>
                                <th class="text-dark">Level</th>
                                <th class="text-dark">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    <img src="{{ asset('storage/'. $user->foto) }}" alt="" class="avatar-img rounded-circle" width="50">
                                </td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->level }}</td>
                                <td>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success text-light"><i class="fe fe-edit align-middle"></i></a>
                                    <form id="form-delete" action="{{ route('users.destroy', $user->id) }}" method="post" class="d-inline">
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
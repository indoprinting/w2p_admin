@extends('layouts.main')
@section('main')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
            <div class="float-right"><a href="javascript:void(0);" data-toggle="modal" data-target="#addAdmin">Tambah Admin</a></div>
        </div>
        <div class="card-body">
            <x-alert />
            <x-validate-error />
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Nama admin</th>
                        <th>username</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $admin)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->username }}</td>
                            <td>{{ $admin->role }}</td>
                            <td>
                                @role([1])
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#updateAdmin{{ $loop->index }}">Ubah</a>
                                    <a href="{{ route('admin.delete', $admin->id) }}" class="ml-3" onclick="javascript:return confirm('Hapus admin')">Hapus</a>
                                @endrole
                            </td>
                            @include('developer.admin._modal_update')
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('developer.admin._modal_create')
@endsection

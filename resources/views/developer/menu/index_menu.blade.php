@extends('layouts.main')
@section('main')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
            <div class="float-right">
                <a href="javascript:void(0);" data-toggle="modal" data-target="#addMenu">Tambah Menu</a>
                <a href="javascript:void(0);" class="ml-4" data-toggle="modal" data-target="#roleAccess">Role Access</a>
            </div>
        </div>
        <div class="card-body">
            <x-alert />
            <x-validate-error />
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Nama</th>
                        <th width="15px">Icon</th>
                        <th width="10%">Route</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menus as $menu)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $menu->name }}</td>
                            <td><i class="{{ $menu->icon }}"></i></td>
                            <td>{{ $menu->route }}</td>
                            <td>
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#updateMenu{{ $loop->index }}">Ubah</a>
                                <a href="{{ route('menu.delete', ['id' => $menu->id]) }}" class="ml-3" onclick="javascript:return confirm('Hapus menu')">Hapus</a>
                            </td>
                            @include('developer.menu._modal_update')
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('developer.menu._modal_create')
    @include('developer.menu._modal_role_access')
@endsection

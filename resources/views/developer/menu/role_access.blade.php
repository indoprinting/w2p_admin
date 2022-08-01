@extends('layouts.main')
@section('main')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                </div>
                <div class="card-body">
                    <x-alert />
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Nama Menu</th>
                                <th>Access</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td class="text-bold">{{ $category->name }}</td>
                                    <td class="h4">
                                        <a href="{{ route('access.category', ['category_id' => $category->id, 'role_id' => $role, 'granted' => $category->access->granted ?? 0]) }}">
                                            <i class="{{ isset($category->access->granted) && $category->access->granted ? 'fas fa-check' : 'fas fa-times' }}"></i>
                                        </a>
                                    </td>
                                </tr>
                                @foreach ($category->menu as $menu)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td class="pl-4">{{ $menu->name }}</td>
                                        <td class="h4">
                                            <a href="{{ route('access.menu', ['menu_id' => $menu->id, 'role_id' => $role, 'granted' => $menu->access->granted ?? 0]) }}">
                                                <i class="{{ isset($menu->access->granted) && $menu->access->granted ? 'fas fa-check' : 'fas fa-times' }}"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

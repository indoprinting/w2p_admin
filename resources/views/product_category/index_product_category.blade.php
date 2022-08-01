@extends('layouts.main')
@section('main')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Category</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <x-validate-error />
                    <form action="{{ isset($category) ? route('category.product.update', $category->id_category) : route('category.product.store') }}" method="POST">
                        @csrf
                        @isset($category)
                            @method('PUT')
                        @endisset
                        <div class="form-group">
                            <label for="category">Nama kategori</label>
                            <x-input type="text" name="name" value="{{ $category->name ?? old('name') }}" />
                        </div>
                        <div>
                            <button class="btn btn-secondary float-right" type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card">
                <x-alert />
                <div class="card-header">
                    <h3 class="card-title">Tabel kategori </h3>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th>Nama kategori</th>
                            <th style="width: 25%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->name }}</td>
                                <td class="text-center">
                                    <a href="{{ route('category.product.edit', $category->id_category) }}" class="btn btn-info">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
        @endsection

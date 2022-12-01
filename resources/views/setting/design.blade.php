@extends('layouts.main')
@section('main')
    <div class="card">
        <x-alert />
        <div class="card-header">
            <h3 class="card-title">
                <i class="ion ion-bag"></i>
                {{ $title }}
            </h3>
            <div class="float-right">
                <a href="#" class="btn btn-info" data-toggle="modal" data-target="#addDesign">Tambah Design</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th width="100px">#</th>
                        <th>Invoice</th>
                        <th>Nama</th>
                        <th>File Design</th>
                        <th class="text-center" width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($designs as $design)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $design->invoice }}</td>
                            <td>{{ $design->name }}</td>
                            <td width="20%"><img src="{{ asset('images/design/' . $design->preview) }}" alt="" width="100%"></td>
                            <td class="text-center">
                                <a href="{{ route('destroy.design', ['id' => $design->id]) }}" class="btn btn-danger" onclick="javascript:return confirm('Hapus design?')">Hapus</a>
                                <a href="#" class="btn btn-info" data-toggle="modal" data-target="#editDesign{{ $loop->index }}">Edit</a>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="editDesign{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="editDesignTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('update.design') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $design->id }}">
                                            <div class="form-group row">
                                                <label class="col-sm-3">Invoice</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" type="text" name="invoice" value="{{ old('invoice') ?? $design->invoice }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3">Nama</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" type="text" name="name" value="{{ old('name') ?? $design->name }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3">Design</label>
                                                <div class="col-sm-9">
                                                    <input type="file" name="design">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3">Preview</label>
                                                <div class="col-sm-9">
                                                    <input type="file" name="preview">
                                                </div>
                                            </div>
                                            <div class="text-right mt-5">
                                                <button class="btn btn-primary w-100">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="addDesign" tabindex="-1" role="dialog" aria-labelledby="addDesignTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('store.design') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3">Invoice</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="invoice">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3">Nama</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3">Design</label>
                            <div class="col-sm-9">
                                <input type="file" name="design">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3">Preview</label>
                            <div class="col-sm-9">
                                <input type="file" name="preview">
                            </div>
                        </div>
                        <div class="text-right mt-5">
                            <button class="btn btn-primary w-100">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

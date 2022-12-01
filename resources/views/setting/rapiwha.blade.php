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
                <a href="#" class="btn btn-info" data-toggle="modal" data-target="#addPhone">Tambah Nomor</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th width="100px">#</th>
                        <th>No. Telepon</th>
                        <th>Nama</th>
                        <th class="text-center" width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($phones as $phone)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $phone->phone }}</td>
                            <td>{{ $phone->name }}</td>
                            <td class="text-center">
                                <a href="{{ route('rapiwha.delete', ['id' => $phone->id]) }}" class="btn btn-danger" onclick="javascript:return confirm('Hapus nomor ini?')">Hapus</a>
                                <a href="#" class="btn btn-info" data-toggle="modal" data-target="#editPhone{{ $loop->index }}">Edit Nomor</a>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="editPhone{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="editPhoneTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('rapiwha.edit') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $phone->id }}">
                                            <div class="form-group row">
                                                <label class="col-sm-3">No Telepon</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" type="text" name="phone" value="{{ $phone->phone }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3">Nama</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" type="text" name="name" value="{{ $phone->name }}">
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
    <div class="modal fade" id="addPhone" tabindex="-1" role="dialog" aria-labelledby="addPhoneTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('rapiwha.store') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3">No Telepon</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="phone">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3">Nama</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="name">
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

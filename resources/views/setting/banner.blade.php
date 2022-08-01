@extends('layouts.main')
@section('main')
    <div class="card">
        <x-alert />
        <div class="card-header">
            <h3 class="card-title">Banner halaman depan</h3>
            <div class="float-right"><a href="javascript:void(0);" data-toggle="modal" data-target="#uploadFile">Tambah banner</a></div>
        </div>
        <div class="card-body">
            <form action="{{ route('banner.shorting') }}" method="POST">
                @csrf
                <table class="table table-bordered" id="datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th width="40%">Gambar</th>
                            <th width="10%">Main banner</th>
                            <th>Active</th>
                            <th width="10%">
                                <button type="submit" class="btn btn-primary">Simpan urutan</button>
                            </th>
                            <th>Link</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($banners as $banner)
                            <tr class="text-center">
                                <td>
                                    <a href="{{ route('banner.delete', $banner->id) }}" class="h2 text-danger"><i class="far fa-trash-alt"></i></a>
                                </td>
                                <td>
                                    <img src="{{ asset("images/banner/{$banner->img}") }}" alt="" class="mw-100">
                                </td>
                                <td>
                                    <a href="{{ route('banner.main', ['id' => $banner->id, 'main' => $banner->main]) }}" class="h2">
                                        <i class="{!! $banner->main == 1 ? 'far fa-check-square text-success' : 'far fa-times-square text-danger' !!}"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('banner.active', ['id' => $banner->id, 'active' => $banner->active]) }}" class="h2">
                                        <i class="{!! $banner->active == 1 ? 'far fa-check-square text-success' : 'far fa-times-square text-danger' !!}"></i>
                                    </a>
                                </td>
                                <td>
                                    <input type="number" name="urutan{{ $banner->id }}" value="{{ $banner->urutan }}">
                                </td>
                                <td>{{ $banner->link }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    <!-- Modal upload-->
    <div class="modal fade" id="uploadFile" tabindex="-1" role="dialog" aria-labelledby="uploadFileTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadFileTitle"><b>Unggah banner</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="far fa-times-square"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <ol>
                            <li>File harus berupa gambar dengan ekstensi jpg / png / jpeg.</li>
                        </ol>
                    </div>
                    <hr>
                    <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label">Link</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="link" placeholder="Link" autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label">Gambar banner</label>
                            <div class="col-sm-8">
                                <input type="file" name="banner" id="unggah">
                            </div>
                        </div>
                        <div class="float-right">
                            <button type="submit" class="btn btn-info">Unggah</button>
                        </div>
                    </form>
                    <div style="text-align: center;margin-top:20px;">
                        <img src="" alt="" id="upload-preview" style="max-width: 100%;">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

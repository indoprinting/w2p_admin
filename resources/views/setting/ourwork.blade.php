@extends('layouts.main')
@section('main')
    <div class="card">
        <x-alert />
        <div class="card-header">
            <div class="float-right"><a href="javascript:void(0);" data-toggle="modal" data-target="#uploadFile">Tambah gambar</a></div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" style="overflow-x:auto;" id="datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th width="50%">Gambar</th>
                            <th>Nama kegiatan</th>
                            <th width="3%" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($images as $image)
                            <tr>
                                <td width="2%">{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ asset('images/our-work/' . $image->img) }}" alt="" class="mw-100">
                                </td>
                                <td>{{ $image->name }}</td>
                                <td>
                                    <a href="{{ route('ourwork.destroy', ['id' => $image->id]) }}" class="h3" onclick="javascript:return confirm('Hapus gambar ?')">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal upload-->
    <div class="modal fade" id="uploadFile" tabindex="-1" role="dialog" aria-labelledby="uploadFileTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadFileTitle"><b>Upload our-work</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="far fa-times-square"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <ol>
                            <li>File harus berupa gambar dengan ekstensi jpg / png / jpeg.</li>
                            <li>Ukuran maksimal 512 KB.</li>
                        </ol>
                    </div>
                    <hr>
                    <form action="{{ route('ourwork.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label">Nama</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" placeholder="Nama Kegiatan" autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label">Gambar banner</label>
                            <div class="col-sm-8">
                                <input type="file" name="img" id="unggah">
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-info w-100">Unggah</button>
                        </div>
                    </form>
                    <div style="text-align: center;margin-top:20px;">
                        <img src="" alt="" id="img-preview" style="max-width: 100%;">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

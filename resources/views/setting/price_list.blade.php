@extends('layouts.main')
@section('main')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="ion ion-bag"></i>
                {{ $title }}
            </h3>
            <div class="float-right">
                <a href="#" class="btn btn-info" data-toggle="modal" data-target="#addFile">Tambah File</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th width="100px">#</th>
                        <th>File</th>
                        <th class="text-center" width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($images as $image)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ asset('images/price-list/' . $image->filename) }}" class="w-25">
                            </td>
                            <td>
                                <a href="{{ route('price.list.delete', ['id' => $image->id]) }}" class="btn btn-danger" onclick="javascript:return confirm('Hapus file?')">Hapus</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="addFile" tabindex="-1" role="dialog" aria-labelledby="addFileTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('price.list.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <label class="col-sm-3">File</label>
                            <div class="col-sm-9">
                                <input type="file" name="file">
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

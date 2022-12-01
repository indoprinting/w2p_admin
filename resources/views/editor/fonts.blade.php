@extends('layouts.main')
@section('main')
    <div class="card">
        <div class="card-body">
            <x-alert />
            <h3 class="text-center text-bold mb-3 bg-warning py-2 mt-5">FONTS W2P</h3>
            <div class="row">
                <div class="col-sm-6">
                    <div class="table-responsive ">
                        <table class="table table-bordereless" id="datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Font</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fonts as $font)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $font->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-6">
                    <h5 class="text-center mb-2">Tambah font</h5>
                    <div class="mb-4 text-danger">
                        <h6>PASTIKAN FILE FONT BEREKSTENSI .OTF DAN .TTF</h6>
                    </div>
                    <form action="{{ route('store.font') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="" class="col-sm-3">Nama Font</label>
                            <div class="col-sm-9">
                                <x-input name="name" value="{{ old('name') }}" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3">Upload File</label>
                            <div class="col-sm-9">
                                <input type="file" name="font" type=".tff,.otf" class="d-block">
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

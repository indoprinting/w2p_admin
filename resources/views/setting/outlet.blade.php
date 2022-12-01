@extends('layouts.main')
@section('main')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="ion ion-bag"></i>
                Outlet
            </h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Outlet</th>
                        <th>Alamat</th>
                        <th>No. Telp</th>
                        <th>Email</th>
                        <th>Jam kerja</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($outlets as $outlet)
                        <tr>
                            <td>
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#outlet{{ $loop->index }}">Ubah</a>
                                <br>
                                <a class="text-danger" href="{{ route('set.active', ['id' => $outlet->id, 'active' => $outlet->active == 0 ? 1 : 0]) }}">{{ $outlet->active ? 'Active' : 'Not Active' }}</a>
                            </td>
                            <td>{{ $outlet->name }}</td>
                            <td>{{ $outlet->address }}</td>
                            <td>{{ $outlet->phone }}</td>
                            <td>{{ $outlet->email }}</td>
                            <td>{!! $outlet->working_hours !!}</td>
                        </tr>
                        <!-- Modal upload-->
                        <div class="modal fade" id="outlet{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="outletTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered w-100" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="outletTitle"><b>Edit outlet</b></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i class="far fa-times-square"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('outlet.update') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $outlet->id }}">
                                            <div class="form-group row">
                                                <label for="ket" class="col-sm-4 col-form-label">Nama Outlet</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text" name="name" value="{{ $outlet->name }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="ket" class="col-sm-4 col-form-label">Alamat</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text" name="address" value="{{ $outlet->address }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="ket" class="col-sm-4 col-form-label">Link Google Maps</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text" name="google_maps" value="{{ $outlet->google_maps }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="ket" class="col-sm-4 col-form-label">No. Telp</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text" name="phone" value="{{ $outlet->phone }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="ket" class="col-sm-4 col-form-label">E-mail</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="email" name="email" value="{{ $outlet->email }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="ket" class="col-sm-4 col-form-label">Jam kerja</label>
                                                <div class="col-sm-8">
                                                    <textarea name="hour" class="textarea">{!! $outlet->working_hours !!}</textarea>
                                                </div>
                                            </div>
                                            <div class="float-right">
                                                <button class="btn btn-info" type="submit">Submit</button>
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
    <script>
        $(document).ready(function() {
            $('.textarea').summernote({
                lineHeights: ['0', '0.1', '0.2', '0.3', '0.4', '0.5', '0.6', '0.8', '1.0', '1.5', '2.0', '3.0'],
                fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Merriweather'],
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['style', ['style', 'codeview']]

                ]
            });
        });
    </script>
@endsection

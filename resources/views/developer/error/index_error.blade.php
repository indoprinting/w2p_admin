@extends('layouts.main')
@section('main')
    <div class="card-header">
        <h3 class="card-title">{{ $title }}</h3>
    </div>
    <div class="card-body">
        <x-alert />
        <table class="table table-bordered datatable">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Lokasi Error</th>
                    <th>Detail Error</th>
                    <th>Messages Exception</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($errors as $error)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $error->location }}</td>
                        <td>{{ $error->detail }}</td>
                        <td>{{ $error->messages }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

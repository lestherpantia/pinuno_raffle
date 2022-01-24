@extends('layout.header')

@section('content')
    <style>
        body {
            background: #dfe6e9 !important;
        }
    </style>

    <div class="container d-flex align-items-center justify-content-center" style="height: 100vh">
        <div class="card">
            <div class="card-header">
                Import Excel
            </div>
            <div class="class-body p-3">
                <form method="POST" action="{{ asset('import/data') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="file" class="form-control-file" name="file">
                    <button class="btn btn-info form-control mt-3">Process</button>
                </form>
            </div>
        </div>
    </div>
@stop

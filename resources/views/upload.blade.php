@extends('layouts.app')
@section('navbar')
    @include('layouts.nav')
@stop
@section('content')
        <div class="card-deck mb-3">
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-bold">.CSV uploaden</h4>
                </div>
                <form action="{{ url('/upload') }}" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="file" class="form-control-file" id="database" name="_db">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-dark">Upload</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
@stop
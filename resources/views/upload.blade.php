@extends('layouts.app')
@section('content')
    <form action="{{ url('/upload') }}" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            {{ csrf_field() }}
            <input type="file" class="form-control-file" id="database" name="_db">
            <button type="submit" class="btn btn-dark">Upload</button>
        </div>
    </form>
@stop
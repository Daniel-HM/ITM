@extends('layouts.app')
@section('content')
    <div class="col-lg-6 col-sx-4 offset-sx-4">
        <div class="card-deck mb-3 text-center">
            <div class="card mb-4 box-shadow">
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
    </div>
@stop
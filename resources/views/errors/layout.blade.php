@extends('layouts.app')
@section('content')
    <div class="card-deck mb-3 text-center">
        <div class="card box-shadow">
            <div class="card-header">
                <h1 class="display-1">@yield('title')</h1>
                <div>
                    <p>@yield('message')</p>
                    <p>@yield('button')</p>
                    <p></p>
                </div>
            </div>
        </div>
    </div>
@stop

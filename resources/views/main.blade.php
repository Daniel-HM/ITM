@extends('layouts.app')
@section('search')
    @include('layouts.search')
@stop
@section('content')
    @isset($artikel)
        @if(count($artikel) === 1)
            @include('artikel.artikel')
        @elseif(count($artikel) > 1)
            @include('artikel.listartikel')
        @endif
    @endisset
@stop
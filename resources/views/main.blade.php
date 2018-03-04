@extends('layouts.app')
@section('navbar')
    @include('layouts.nav')
@stop
@section('content')
    {{--@isset($artikel)--}}
        {{--@if(count($artikel) === 1)--}}
            {{--@include('artikel.show')--}}
        {{--@elseif(count($artikel) > 1)--}}
            {{--@include('artikel.showlist')--}}
        {{--@endif--}}
    {{--@endisset--}}
    {{--@isset($promoArtikel)--}}
        {{--@include('artikel.promo')--}}
    {{--@endisset--}}
@stop
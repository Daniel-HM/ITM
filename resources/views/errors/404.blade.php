@extends('errors.layout')

@section('title', '404')
@section('message' , 'Pagina kon niet gevonden worden..')
@section('button')
    <a class="btn btn-block btn-outline-info" href="{{ url('/') }}">Keer terug naar de homepage.</a>
@stop
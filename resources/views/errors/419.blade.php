@extends('errors.layout')

@section('title', '419')
@section('message', 'Pagina is vervallen, probeer het opnieuw.')
@section('button')
    <a class="btn btn-block btn-outline-info" href="{{ route('home') }}">Keer terug naar de homepage.</a>
@stop
@extends('errors.layout')

@section('title', '500')
@section('message' , 'Hmm, er is iets fout gegaan..')
@section('button')
    <a class="btn btn-block btn-outline-info" href="{{ route('home') }}">Keer terug naar de homepage.</a>
@stop
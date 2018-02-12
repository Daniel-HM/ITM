@extends('layouts.app')
@section('search')
    @include('layouts.search')
@stop
@section('content')
    <div class="col-lg-6 col-sx-4 offset-sx-4">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="card-deck mb-3 text-center">
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Statistieken</h4>
                </div>
                <table class="table">
                    <tr>
                        <td><strong>Artikels in DB</strong></td>
                        <td>{{ $data['artikelCount'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>Leveranciers in DB</strong></td>
                        <td>{{ $data['leverancierCount'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>Clayre & Eef afbeeldingen</strong></td>
                        <td>{{ $data['clayreImageCount'] }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection

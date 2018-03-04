@extends('layouts.app')
@section('navbar')
    @include('layouts.nav')
@stop
@section('content')
    <div class="card-deck mb-3">
        <div class="card mb-4 box-shadow">
            <div class="card-header">
                <h4 class="my-0 font-weight-bold">Leveranciers</h4>
            </div>
            <table id="productsTable" class="table table-striped table-sm" data-searching="true">
                <thead>
                <tr>
                    <th scope="col">Naam</th>
                </tr>
                </thead>
                <tbody>
                @foreach($leverancier as $single)
                    <tr>
                        <td><a class="link-unstyled"
                                           href="{{ url('/leverancier/'. $single->leverancier_id) }}">{{ $single->naam }}</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
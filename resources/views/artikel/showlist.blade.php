@extends('layouts.app')
@section('content')
    <div class="card-deck mb-3">
        <div class="card mb-4 box-shadow">
            <div class="card-header">
                <h4 class="my-0 font-weight-bold"></h4>
                <small class="form-text text-muted">{{ count($artikel) }} resultaten</small>
            </div>
            <div class="table-responsive">
                <table id="productsTable" class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th scope="col">Omschrijving</th>
                        <th>Prijs</th>
                        @if($showLeverancierCol == true)
                            <th class="d-none d-sm-block">Leverancier</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($artikel as $single)
                        <tr>
                            <th scope="row">
                                <div><a class="link-unstyled"
                                        href="{{ url('/artikel/'. $single->ean) }}">{{ $single->omschrijving }}</a>
                                    @isset($single->image->name)
                                        <span class="badge badge-secondary">*</span>
                                    @endisset
                                </div>
                                <div>
                                    <small class="text-muted">{{ $single->ean }}</small>
                                </div>
                            </th>
                            <td>€{{ number_format($single->vkprijs, 2) }}</td>
                            @if($showLeverancierCol == true)
                                <td class="d-none d-sm-block">
                                    @isset($single->leverancier->naam)
                                        <a class="link-unstyled"
                                           href="{{ url('/leverancier/' . $single->leverancier_id) }}">{{ $single->leverancier->naam }}</a>
                                    @else
                                        Onbekend
                                    @endisset
                                </td>
                            @endif


                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
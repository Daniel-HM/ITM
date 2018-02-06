@extends('layouts.app')
@section('content')
    @isset($artikel)
        @if(count($artikel) === 1)
            <div class="col-lg-6 col-sx-4 offset-sx-4">
                <div class="card-deck mb-3 text-center">
                    <div class="card mb-4 box-shadow">
                        <div class="card-header">
                            <h4 class="my-0 font-weight-normal">{{ $artikel->omschrijving }}</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title">&euro;{{ $artikel->vkprijs }}</h1>
                            @isset($artikel->promotie->naam)
                                <h6>{{ $artikel->promotie->omschrijving }}</h6>
                                <h5>{{ $artikel->promotie->naam }}</h5>
                            @endisset
                            <hr>
                            <h5><img src="data:image/png;base64,{{ base64_encode($barcode) }}"></h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $artikel->ean }}</h6>

                            <ul class="list-unstyled mt-3 mb-4">
                                <li>{{ $artikel->subgroep->omschrijving }}</li>
                                <li>{{ $artikel->subgroep->groep->omschrijving }}</li>
                            </ul>
                            <ul class="list-unstyled mt-3 mb-4">
                                @isset($artikel->leverancier->naam)
                                    <li>
                                        <strong><a class="link-unstyled"
                                                   href="{{ url('/leverancier/' . $artikel->leverancier_id) }}">{{ $artikel->leverancier->naam }}</a></strong>
                                    </li>
                                @else
                                    <li><strong>Leverancier onbekend</strong></li>
                                @endisset
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @elseif(count($artikel) > 1)
            <div class="col">
                <table id="productsTable" class="table table-dark table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Omschrijving</th>
                        <th>Prijs</th>
                        <th>EAN</th>
                        <th class="d-none d-sm-block">Leverancier</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($artikel as $single)
                        <tr>
                            <th scope="row"><a class="link-unstyled"
                                               href="{{ url('/ean/'. $single->ean) }}">{{ $single->omschrijving }}</a>
                            </th>
                            <td>€{{ number_format($single->vkprijs, 2) }}</td>
                            <td>
                                <small>{{ $single->ean }}</small>
                            </td>
                            <td class="d-none d-sm-block">
                                @isset($single->leverancier->naam)
                                    {{ $single->leverancier->naam }}
                                @else
                                    Onbekend
                                @endisset
                            </td>


                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endisset
    @isset($leverancierArtikels)
        <div class="col">
            <table id="productsTable" class="table table-dark table-striped">
                <thead>
                <tr>
                    <th scope="col">Omschrijving</th>
                    <th>Prijs</th>
                    <th>EAN</th>
                </tr>
                </thead>
                <tbody>
                @foreach($leverancierArtikels as $single)
                    <tr>
                        <th scope="row"><a class="link-unstyled"
                                           href="{{ url('/ean/'. $single->ean) }}">{{ $single->omschrijving }}</a>
                        </th>
                        <td>€{{ number_format($single->vkprijs, 2) }}</td>
                        <td>
                            <small>{{ $single->ean }}</small>
                        </td>


                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endisset
@stop
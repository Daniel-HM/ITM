@extends('layouts.app')
@section('content')
    <div class="card-deck mb-3 text-center">
        <div class="card mb-4 box-shadow">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">{{ $artikel->omschrijving }}</h4>
            </div>
            <div class="card-body">
                @isset($artikel->promotie->naam)
                    @if($artikel->promotie->startdatum <= date('Y-m-d') && $artikel->promotie->einddatum >= date('Y-m-d'))

                        <div class="alert alert-success" role="alert">
                            <h1 class="card-title pricing-card-title oude-prijs">&euro;{{ $artikel->vkprijs }}</h1>
                            <h6>{{ $artikel->promotie->omschrijving }}</h6>
                        </div>
                    @endisset
                @else

                    <h1 class="card-title pricing-card-title">&euro;{{ $artikel->vkprijs }}</h1>
                @endif

                @if(auth()->user()->isAdmin())
                    <p>
                        <small>Inkoop: €{{ $artikel->inkprijs }}</small>
                    </p>
                @endif
                @isset($artikel->promotie->naam)
                    @if($artikel->promotie->startdatum < date('Y-m-d') && $artikel->promotie->einddatum > date('Y-m-d'))
                        <div class="alert alert-success" role="alert">
                            <h5>{{ $artikel->promotie->naam }}</h5>
                            Promotie geldig van {{ $artikel->promotie->startdatum }}
                            tot {{ $artikel->promotie->einddatum }}
                        </div>
                    @endif
                @endisset

                <hr>
                <h5><img src="data:image/png;base64,{{ base64_encode($barcode) }}"></h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ $artikel->ean }}</h6>
                <p class="text-muted">Artikelnr. {{ $artikel->artikelnr }}</p>

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
                @isset($artikel->image->name)
                    <img src="/images/clayre/{{ $artikel->image->name }}" class="img-fluid">
                @endisset
            </div>
        </div>
    </div>
@stop
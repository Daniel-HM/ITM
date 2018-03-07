@extends('scanner.layout')
@section('content')
    <div class="col-auto">
        @isset($artikel)
            <div class="row">
                <div class="card scan-card">
                    <div class="card-header">
                        <h4 class="font-weight-bold">{{ $artikel->omschrijving }}</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">&euro;{{ $artikel->vkprijs }}</h1>
                        @isset($artikel->promotie->naam)
                            @if($artikel->promotie->startdatum < date('Y-m-d') && $artikel->promotie->einddatum > date('Y-m-d'))
                                <div class="alert alert-success" role="alert">
                                    <h5>{{ $artikel->promotie->naam }}</h5>
                                    {{ $artikel->promotie->startdatum }}
                                    tot {{ $artikel->promotie->einddatum }}
                                </div>
                            @endif
                        @endisset
                        <ul class="list-unstyled mt-3 mb-4">
                            @isset($artikel->leverancier->naam)
                                <li>
                                    <strong>{{ $artikel->leverancier->naam }}</strong>
                                </li>
                            @else
                                <li><strong>Leverancier onbekend</strong></li>
                            @endisset
                        </ul>
                        <p class="text-muted">Artikelnr. {{ $artikel->artikelnr }}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="card scan-card">
                    <img class="img-fluid barcode" src="/images/barcode.svg">
                </div>
            </div>
        @endisset
        <div class="row">
            <div class="card scan-card scanner">
                <form method="POST" action="{{ route('scanner') }}">
                    <input type="number" name="ean" autofocus>
                    <button type="submit" class="btn btn-primary">Zoeken</button>
                </form>
            </div>
        </div>
    </div>
@stop
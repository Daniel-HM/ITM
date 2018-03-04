@extends('layouts.app')
@section('navbar')
    @include('layouts.nav')
@stop
@section('content')
    @isset($kosten)
                <div class="card-deck mb-3 text-center">
                    <div class="card box-shadow">
                        <div class="card-header">
                            <h3>&euro;{{ $kosten }}</h3>
                            <h6>{{ $kilometer*2 }} KM</h6>
                            <div>
                                <h6><strong>Van</strong></h6>
                                <p>
                                    <small>{{ $origin }}</small>
                                </p>
                            </div>
                            <div>
                                <h6><strong>Naar</strong></h6>
                                <p>
                                    <small>{{ $destination }}</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
        <div class="row">
            <div class="col align-content-center">
                <div class="card-deck text-center">
                    <div class="card box-shadow">
                        <iframe
                                width="100%"
                                height="250px"
                                frameborder="0"
                                src="{{ $embedUrl }}" allowfullscreen>
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <a href="{{ route('leveringskosten') }}" class="btn btn-light">Wijzigen</a>
            </div>
        </div>
    @else
        <div class="card-deck mb-3">
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-bold">Leveringskosten berekenen</h4>
                </div>
                <form method="POST" action="{{ route('leveringskosten')  }}" class="p-3">
                    <p>
                        <small>Vul het adres van de bestemming in, en vink de vestiging vanwaar de levering
                            plaatsvind
                            aan.
                        </small>
                    </p>
                    <div class="form-row form-group">
                        {{ csrf_field() }}
                        <div class="col">
                            <input type="text" name="straat" class="form-control" id="straat"
                                   placeholder="Straatnaam" autofocus value="{{ old('straat') }}">
                        </div>
                        <div class="col-4">
                            <input type="text" name="nummer" class="form-control" id="nummer" placeholder="#"
                                   value="{{ old('nummer') }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <input type="text" name="stad" class="form-control mb-2" id="stad"
                                   placeholder="Stad/Gemeente" value="{{ old('stad') }}">
                        </div>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="vanuit" id="vanuit1"
                               value="lovendegem" @if(old('vanuit') == 'lovendegem') checked @endif>
                        <label class="form-check-label" for="vanuit1">Lovendegem&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <input type="radio" class="form-check-input" name="vanuit" id="vanuit2"
                               @if(old('vanuit') == 'maldegem') checked @elseif(old('vanuit') == null) checked
                               @endif
                               value="maldegem">
                        <label class="form-check-label" for="vanuit2">Maldegem</label>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="submit"></label>
                            <button class="btn btn-sm btn-primary btn-block btn-primary col-4" name="submit"
                                    type="submit">
                                Berekenen
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    @endisset


@stop
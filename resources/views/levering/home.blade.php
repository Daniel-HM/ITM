@extends('layouts.app')
@section('content')
    <div class="col-lg-6 col-sx-4 offset-sx-4">
        <form method="POST" action="{{ url('/levering') }}">
            <div class="form-row form-group">
                {{ csrf_field() }}
                <div class="col">
                    <input type="text" name="straat" class="form-control" id="straat"
                           placeholder="Straatnaam" value="{{ old('straat') }}">
                </div>
                <div class="col-2">
                    <input type="text" name="nummer" class="form-control" id="nummer" placeholder="#" size="2em"
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
                       @if(old('vanuit') == 'maldegem') checked @elseif(old('vanuit') == null) checked @endif
                       value="maldegem">
                <label class="form-check-label" for="vanuit2">Maldegem</label>
            </div>
            <div class="form-row">
                <div class="col">
                    <button class="btn btn-sm btn-primary btn-block btn-primary " type="submit">Leveringskosten
                        weergeven
                    </button>
                </div>
            </div>

        </form>
        @isset($kosten)
            <div class="row mt-5">
                <div class="col">
                    <div class="card-deck mb-3 text-center">
                        <div class="card mb-4 box-shadow">
                            <div class="card-header">
                                <h3>&euro;{{ $kosten }}</h3>
                                <h6>{{ $kilometer*2 }} KM</h6>
                                <dl class="row">
                                    <dt class="col-sm-2">Van</dt>
                                    <dd class="col-sm-4">
                                        <small>{{ $origin }}</small>
                                    </dd>

                                    <dt class="col-sm-2">Naar</dt>
                                    <dd class="col-sm-4">
                                        <small>{{ $destination }}</small>
                                    </dd>
                                </dl>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endisset
        <div class="row ">
            <div class="col">
                <a class="btn btn-success" href="{{ route('home') }}" role="button">Terug</a>
            </div>
        </div>
    </div>

@stop
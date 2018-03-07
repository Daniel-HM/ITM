@extends('layouts.app')
@section('navbar')
    @include('layouts.nav')
@stop
@section('content')
    <div class="card-deck mb-3">
        <div class="card mb-4 box-shadow">
            <div class="card-header">
                <h4 class="my-0 font-weight-bold">BTW nummer controleren</h4>
            </div>
            <div class="card-body">
                @isset($valid)
                    @if($valid === true)
                        <div class="alert alert-success" role="alert">
                            BTW nummer is geldig!
                        </div>
                        <div>
                            <ul class="list-group">
                                <li class="list-group-item"><strong>{{ $data->name }}</strong></li>
                                <li class="list-group-item">{!! $data->address !!}</li>
                                <li class="list-group-item">{{ mb_strtoupper($data->countryCode).$data->vatNumber }}</li>
                            </ul>
                        </div>
                    @elseif($valid === false)
                        <div class="alert alert-warning" role="alert">
                            BTW nummer is niet geldig! Kloppen de gegevens?
                        </div>
                        <div><a href="{{ route('btw') }}" class="btn btn-success">Terug</a></div>
                    @endisset
                @else
                    <form action="{{ route('btw') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <select class="form-control" name="countryCode">
                                        <option value="be" @if(old('countryCode') == 'be') {{ 'selected' }}@endif>BE</option>
                                        <option value="nl" @if(old('countryCode') == 'nl') {{ 'selected' }}@endif>NL</option>
                                    </select></div>
                            </div>
                            <input type="text" id="vatNumber" name="vatNumber" class="form-control" autocomplete="off"
                                   placeholder="BTW nummer" required value="{{ old('vatNumber') }}">
                        </div>
                        <button class="btn btn-primary" type="submit">Controleer</button>
                    </form>
                @endif
            </div>
        </div>
    </div>

@stop

@extends('layouts.app')
@section('navbar')
    @include('layouts.nav')
@stop
@section('content')
    <div class="card-deck mb-3">
        <div class="card mb-4 box-shadow">
            <form action="{{ url('add_user') }}" method="post">
                <div class="card-header">
                    <h4 class="my-0 font-weight-bold">Gebruiker toevoegen</h4>
                </div>

                <div class="card-body">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Naam</label>

                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"
                               required autofocus>

                        @if ($errors->has('name'))
                            <span class="help-block">
            <strong>{{ $errors->first('name') }}</strong>
            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">E-mail</label>

                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                               required>

                        @if ($errors->has('email'))
                            <span class="help-block">
            <strong>{{ $errors->first('email') }}</strong>
            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Wachtwoord</label>

                        <input id="password" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Toevoegen
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
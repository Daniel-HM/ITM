<div class="row justify-content-md-center">

<form class="form-search" action="{{ url('/') }}" method="POST">
    <label for="query" class="sr-only">EAN13/Omschrijving</label>
    <input type="text" id="query" name="query" class="form-control" autocomplete="off"
           placeholder="EAN13 / Omschrijving" required
           autofocus>
    @isset($artikel)
        @if(count($artikel) > 1)
            <small class="form-text text-muted">{{ count($artikel) }} resultaten</small>
        @endif
    @endisset
    @isset($leverancierArtikels)
        @if(count($leverancierArtikels) > 1)
            <small class="form-text text-muted">{{ count($leverancierArtikels) }} resultaten</small>
        @endif
    @endisset
    {{ csrf_field() }}
    <button class="btn btn-lg btn-primary btn-block btn-dark" type="submit" hidden>Zoeken</button>
</form>
</div>
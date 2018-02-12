<div class="row justify-content-md-center">
    <form id="search" class="form-search" action="{{ url('/') }}" method="POST">
        <div class="align-items-center">
            <div class="col-auto">
                <label for="query" class="sr-only">EAN13/Omschrijving</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-search"></i></div>
                    </div>
                    <input type="text" id="query" name="query" class="form-control" autocomplete="off"
                           placeholder="EAN13 / Omschrijving" required
                           autofocus>
                </div>
                @isset($artikel)
                    @if(count($artikel) > 1)
                        <small class="form-text text-muted">{{ count($artikel) }} resultaten</small>
                    @endif
                @endisset
            </div>
            {{ csrf_field() }}
            <button class="btn btn-lg btn-primary btn-block btn-dark" type="submit" hidden>Zoeken</button>
        </div>
    </form>
</div>
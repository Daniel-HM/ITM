<nav class="navbar navbar-expand navbar-dark bg-dark justify-content-md-center">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSearch"
            aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSearch">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="mainMenu" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">Menu</a>
                <div class="dropdown-menu" aria-labelledby="mainMenu">
                    <a class="dropdown-item" href="{{ route('home') }}">Home</a>
                    <a class="dropdown-item" href="{{ route('artikels-in-promotie') }}">Promoties</a>
                    <a class="dropdown-item" href="{{ route('laatst-nieuwe-artikels') }}">Laatst nieuwe artikels</a>
                    <a class="dropdown-item" href="{{ route('leveranciers') }}">Leveranciers</a>
                    <a class="dropdown-item" href="{{ route('leveringskosten') }}">Leveringskosten</a>
                    <a class="dropdown-item" href="{{ route('btw') }}">BTW nummer controleren</a>
                    @if(auth()->user()->isAdmin())
                        <a class="dropdown-item" href="{{ route('scanner') }}">Scanner</a>
                        <a class="dropdown-item" href="{{ route('upload') }}">Upload</a>
                        <a class="dropdown-item" href="{{ route('add_user') }}">Gebruiker toevoegen</a>
                    @endif
                    <a class="dropdown-item" href="{{ route('logout') }}"><strong>Logout</strong></a>
                </div>
            </li>
        </ul>
        <form class="form-inline my-2 my-md-0" id="search" action="{{ url('/') }}" method="POST">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        {{--<i class="fas fa-search"></i>--}}
                        <select class="form-control" name="searchOption" id="searchOption">
                            <option value="ean" @if(old('searchOption') == 'ean') {{ 'selected' }}@endif>EAN</option>
                            <option value="naam" @if(old('searchOption') == 'naam') {{ 'selected' }}@endif>Naam</option>
                            <option value="artikelnr" @if(old('searchOption') == 'artikelnr') {{ 'selected' }}@endif>Artikelnr.</option>
                            <option value="leverancier" @if(old('searchOption') == 'leverancier') {{ 'selected' }}@endif>Leverancier</option>
                        </select></div>
                </div>
                <input type="number" id="query" name="query" class="form-control" autocomplete="off"
                       placeholder="" required
                       @if(Route::currentRouteName() != 'leveringskosten') {{ 'autofocus' }}@endif>
                {{ csrf_field() }}
            </div>
            <button class="btn" type="submit" hidden>Zoeken</button>
        </form>
    </div>
</nav>
@extends('layouts.app')
@section('content')
    <div class="card-deck mb-3">
        <div class="card mb-4 box-shadow">
            <div class="card-header">
                <h4 class="my-0 font-weight-bold">Artikels in promotie</h4>
                @isset($promoArtikel)
                    @if(count($promoArtikel) > 1)
                        <small class="form-text text-muted">{{ count($promoArtikel) }} resultaten</small>
                    @endif
                @endisset
            </div>
            <div class="table-responsive">
                <table id="productsTable" class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th scope="col">Omschrijving</th>
                        <th>Prijs</th>
                        <th>Promo</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($promoArtikel as $single)
                        <tr>
                            <th scope="row">
                                <div><a class="link-unstyled"
                                        href="{{ url('/artikel/'. $single->ean) }}">{{ $single->omschrijving }}</a>
                                    @isset($single->image->name)
                                        <span class="badge badge-secondary">*</span>
                                    @endisset
                                </div>
                                <div>
                                    <small class="text-muted">{{ $single->ean }}</small>
                                </div>
                            </th>
                            <td>€{{ number_format($single->vkprijs, 2) }}</td>
                            <td>@isset($single->promotie->omschrijving){{ $single->promotie->omschrijving }}@endisset</td>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
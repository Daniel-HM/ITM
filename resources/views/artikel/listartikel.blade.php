<div class="col">
    <table id="productsTable" class="table table-dark table-striped">
        <thead>
        <tr>
            <th scope="col">Omschrijving</th>
            <th>Prijs</th>
            <th>EAN</th>
            @empty($noLeverancierCol)
                <th class="d-none d-sm-block">Leverancier</th>
            @endempty
        </tr>
        </thead>
        <tbody>
        @foreach($artikel as $single)
            <tr>
                <th scope="row"><a class="link-unstyled"
                                   href="{{ url('/artikel/'. $single->ean) }}">{{ $single->omschrijving }}</a>
                    @isset($single->image->name)
                        <span class="badge badge-secondary">*</span>
                    @endisset
                </th>
                <td>€{{ number_format($single->vkprijs, 2) }}</td>
                <td>
                    <small>{{ $single->ean }}</small>
                </td>
                @empty($noLeverancierCol)
                    <td class="d-none d-sm-block">
                        @isset($single->leverancier->naam)
                            <a class="link-unstyled"
                               href="{{ url('/leverancier/' . $single->leverancier_id) }}">{{ $single->leverancier->naam }}</a>
                        @else
                            Onbekend
                        @endisset
                    </td>
                @endempty


            </tr>
        @endforeach
        </tbody>
    </table>
</div>
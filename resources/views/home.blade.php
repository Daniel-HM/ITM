@extends('layouts.app')
@section('content')
    <div class="card-deck mb-3">
        <div class="card mb-4 box-shadow">
            <div class="card-header">
                <h4 class="my-0 font-weight-bold">Home</h4>
            </div>
            <div class="card-body">
                <p class="lead">Artikelen die nog nooit een voorraad van meer of minder dan 0 gehad hebben kan je hier niet vinden!</p>
                <p>Een aanrader om het gebruik van deze website gemakkelijker te maken is <a target="_blank"
                                                                                             href="https://play.google.com/store/apps/details?id=com.tecit.android.barcodekbd.demo">Barcode
                        Scanner Keyboard</a>.</p>
            </div>

            <div class="card-header">
                <h4 class="my-0 font-weight-normal text-center">Statistieken</h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td><strong>Artikels</strong></td>
                        <td>{{ $data['artikelCount'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>Leveranciers</strong></td>
                        <td>{{ $data['leverancierCount'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>Artikels in promotie</strong></td>
                        <td>{{ $data['activePromotieCount'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>Laatste database update</strong></td>
                        <td>{{ $data['lastArtikelDatabaseUpdate'] }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection

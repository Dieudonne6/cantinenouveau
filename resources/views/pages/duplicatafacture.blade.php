@php
use Carbon\Carbon;
@endphp

@extends('layouts.master')
@section('content')

<div class="card-8">

    <div class="row ">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <div class="page-title"><h4>Reçus de paiement</h4></div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="table-responsive">
                                <table id="myTable" class="table custom-table">
                                    <thead>
                                        <tr>
                                            <th>Type de Facture</th>
                                            <th>Classe</th>
                                            <th>Eleve</th>
                                            <th>Date de paiement</th>
                                            {{-- <th>Reference</th> --}}
                                            <th>Facture</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($duplicatafactures as $duplicatafacture)

                                            <tr>
                                                <td>{{ $duplicatafacture['reference'] }}</td>
                                                <td>{{ $duplicatafacture['classe'] }}</td>
                                                <td>{{ $duplicatafacture['nomeleve'] }}</td>
                                                
                                                @php
                                                $dateInput = $duplicatafacture['datepaiement'];

if (Carbon::hasFormat($dateInput, 'Y-m-d H:i:s')) {
    $dateFormatted = Carbon::createFromFormat('Y-m-d H:i:s', $dateInput)->format('d/m/Y H:i:s');
} elseif (Carbon::hasFormat($dateInput, 'd/m/Y H:i:s')) {
    $dateFormatted = Carbon::createFromFormat('d/m/Y H:i:s', $dateInput)->format('d/m/Y H:i:s');
} else {
    $dateFormatted = 'Format de date non supporté';
}
@endphp

<td>{{ $dateFormatted }}</td>
                                                {{-- <td>{{ $duplicatafacture['datepaiement'] }}</td> --}}
                                                {{-- <td>{{ $duplicatafacture['reference'] }}</td> --}}
                                                <td>
                                                    {{-- {{ public_path('qrcodes/' . $fileNameqrcode) }} --}}
                                                    <a href="{{ url('/dowloadduplfac/'.$duplicatafacture['id']) }}" class="btn btn-primary btn-sm mb-1" target="_blank">
                                                        <i class="far">Télécharger</i> 
                                                    </a>
                                                </td>
                                            </tr>
                       
                                        @endforeach
                               
                                        <!-- Repeat similar <tr> blocks for other students -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-">
                    <!-- Affichage des liens de pagination -->
                    {{-- {{ $duplicatafactures->appends(request()->query())->links() }} --}}
                </div>
                {{-- <div class="col-sm-6">
                    <!-- Formulaire stylisé pour sélectionner le nombre de données par page -->
                    <div class="data-per-page">
                        <form method="GET" action="{{ url()->current() }}">
                            <label for="per_page" class="d-none">Afficher par page :</label>
                            <select name="per_page" id="per_page" class="form-control custom-select" onchange="this.form.submit()">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </form>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

</div>


@endsection
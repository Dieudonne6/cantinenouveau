@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="tab-content col-md-12" id="nav-tabContent">
                <!-- Onglet principal -->
                <div class="tab-pane fade show active" id="nav-cantine" role="tabpanel" aria-labelledby="nav-cantine-tab">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab1" role="tablist">
                            <button class="nav-link active" id="nav-etatdroitconstate-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-etatdroitconstate" type="button" role="tab"
                                aria-controls="nav-etatdroitconstate" aria-selected="true">Duplicata Facture</button>
                        </div>
                    </nav>
                    <br><br>

                    <!-- Contenu de l'onglet -->
                    <div class="tab-content" id="nav-tabContent1">
                        <div class="tab-pane fade active show" id="nav-etatdroitconstate" role="tabpanel"
                            aria-labelledby="nav-etatdroitconstate-tab">
                            <div class="col-lg-12 grid-margin">

                                <!-- Formulaire de filtrage -->
                                <form method="POST" action="{{ route('filterduplicata') }}">
                                    @csrf
                                    <div class="row">
                                        <!-- Sélection de l'élève -->
                                        <div class="col-3">
                                            <select class="js-example-basic-multiple w-100" id="eleve-select"
                                                name="eleve_id">
                                                <option value="">Sélectionnez un élève</option>
                                                @foreach ($eleves as $eleve)
                                                    <option value="{{ $eleve->MATRICULE }}">
                                                        {{ $eleve->NOM }}{{ $eleve->PRENOM }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Sélection du type de facture -->
                                        <div class="col-3">
                                            <select class="js-example-basic-multiple w-100" id="facture-type-select"
                                                name="facture_type">
                                                <option value="">Sélectionnez un type de facture</option>
                                                <option value="facturenormalises">Facture de paiement</option>
                                                <option value="contrat">Facture d'inscription</option>
                                            </select>
                                        </div>

                                        <!-- Bouton pour afficher les résultats -->
                                        <div class="col-3">
                                            <button type="submit" id="afficher-btn" class="btn btn-primary w-100">
                                                Afficher
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <!-- Tableau pour afficher les factures -->
                                @if (isset($factures) && $factures->count() > 0)
                                    <div class="table-responsive pt-3">
                                        <div id="mytable">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>N° de facture</th>
                                                        <th>Date de facture</th>
                                                        <th>Montant Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($factures as $facture)
                                                        <tr>
                                                            <td>{{ $facture->nim }}/{{ $facture->counters }}</td>
                                                            <td>{{ $facture->dateHeure }}</td>
                                                            <td>{{ $facture->montant_total }}</td>
                                                            <td>
                                                                <a href="{{ url('pdfduplicatapaie/'.$facture->idcontrat) }}"
                                                                    class="btn btn-primary">
                                                                    Imprimer
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($contrats) && $contrats->count() > 0)
                                    <div class="table-responsive pt-3">
                                        <div id="mytable">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>N° de facture</th>
                                                        <th>Date de facture</th>
                                                        <th>Montant Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        @foreach ($contrats as $contrat)
                                                            <td>{{ $contrat->eleve_contrat }}</td>
                                                            <td>{{ $contrat->datecreation_contrat }}</td>
                                                            <td>{{ $contrat->cout_contrat }}</td>
                                                            <td>
                                                                <a href="{{ url('pdfduplicatacontrat/'.$contrat->id_contrat) }}"
                                                                    class="btn btn-primary">
                                                                    Imprimer
                                                                </a>


                                                            </td>
                                                        @endforeach
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif



                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- JavaScript pour filtrer les données -->
            {{-- <script>
                document.getElementById('afficher-btn').addEventListener('click', function(e) {
                    e.preventDefault(); // Empêcher la soumission du formulaire pour gérer le filtrage en JavaScript
                    var eleveId = document.getElementById('eleve-select').value;
                    var factureType = document.getElementById('facture-type-select').value;

                    var facturesPaiement = @json($facturesPaiement);
                    var facturesInscription = @json($facturesInscription);

                    var tableContent = '';
                    var filteredFactures = [];

                    if (factureType === 'facturenormalises') {
                        filteredFactures = facturesPaiement.filter(function(facture) {
                            return facture.eleve_id == eleveId;
                        });
                    } else if (factureType === 'contrat') {
                        filteredFactures = facturesInscription.filter(function(facture) {
                            return facture.eleve_id == eleveId;
                        });
                    }

                    var tableElement = document.getElementById('mytable');
                    tableElement.innerHTML = ''; // Effacer le contenu actuel du tableau

                    if (filteredFactures.length > 0) {
                        tableContent +=
                            '<table class="table table-bordered"><thead><tr><th>N° de facture</th><th>Date de facture</th><th>Référence</th><th>Action</th></tr></thead><tbody>';
                        filteredFactures.forEach(function(facture) {
                            tableContent += '<tr><td>' + facture.id + '</td><td>' + facture.dateHeure +
                                '</td><td>' +
                                facture.montant_total +
                                '</td><td><button type="button" class="btn btn-primary">Imprimer</button></td></tr>';
                        });
                        tableContent += '</tbody></table>';
                    } else {
                        tableContent = '<p>Aucune facture trouvée.</p>';
                    }

                    tableElement.innerHTML = tableContent;
                });
            </script> --}}
        </div>
    </div>
@endsection

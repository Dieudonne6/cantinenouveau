<?php use Carbon\Carbon; ?>

@extends('layouts.master')
@section('content')
<style>
  /* Suppression du padding et margin pour le tableau */
  table.dataTable {
    margin: 0 !important;
    padding: 0;
    border-collapse: collapse !important;
  }
  
  /* Suppression du padding et margin pour les cellules */
  table.dataTable th,
  table.dataTable td {
    margin: 0 !important;
    padding: 10px;
    border-collapse: collapse !important;
    font-size: 13px;
  }
  
  #myTable td:nth-child(n+2) {
    width: 100px;
    word-wrap: break-word;
    white-space: normal;
  }
  /* Masquer la ligne des totaux par défaut */
  .totals-row {
    display: none;
  }
  
  /* Afficher la ligne des totaux uniquement lors de l'impression */
  @media print {
    .totals-row {
      display: table-row;
    }
  }
  
</style>

<body>
  
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Etats des droits constatés</h4>
        {{-- <form action="{{url('/filteretat')}}" method="POST">
          {{csrf_field()}}
          <div class="form-group row">
            <div class="col-lg-3">
              <select class="form-control w-100" name="annee">
                <option value="">Sélectionnez une année</option>
                @foreach ($anne as $annees)
                <option value="{{$annees}}">{{$annees}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-lg-3">
              <select class="form-control w-100" name="classe">
                <option value="">Sélectionnez une classe</option>
                @foreach ($class as $classes)
                <option value="{{$classes->CODECLAS}}">{{$classes->CODECLAS}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-lg-2">
              <button type="submit" class="btn btn-primary">Afficher</button>
            </div>
            
          </div>
        </form>  --}}
        <div class="col-lg-2">
          <button onclick="imprimePage()" class="btn btn-primary">Imprimer</button>
        </div>
        <div id="contenu">
          
          <div class="table-responsive pt-3">
            {{-- <table id="myTable" class="table table-striped table-sm" > --}}
              <table id="myTable" class="table table-bordered" >
                <thead>
                  <tr>
                    <th>N </th>
                    <th>Elève</th>
                    <th>Classe</th>
                    @foreach ($moisContrat as $mois)
                    @if ($mois->nom_moiscontrat != 'Juillet' && $mois->nom_moiscontrat != 'Aout')
                    <th>{{ $mois->nom_moiscontrat }}</th>
                    @endif
                    @endforeach         
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($eleves as $index => $eleve)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="space-nom">{{ $eleve->NOM }} {{ $eleve->PRENOM }}</td>
                    <td>{{ $eleve->CODECLAS }}</td>
                    
                    @php
                    $totalMois = [];
                    @endphp
                    @foreach ($moisContrat as $mois)
                    @if ($mois->nom_moiscontrat != 'Juillet' && $mois->nom_moiscontrat != 'Aout')
                    @php
                    $totalMois[$mois->id_moiscontrat] = 0;
                    $montantTotalMois = 0;
                    $paiementTrouve = false;
                    @endphp
                    <td>
                      @foreach ($eleve->contrats as $contrat)
                      @foreach ($contrat->paiements as $paiement)
                      @if ($paiement->mois_paiementcontrat == $mois->id_moiscontrat)
                      {{ \Carbon\Carbon::parse($paiement->date_paiementcontrat)->format('d/m/Y') }}</br></br>
                      {{ $paiement->montant_paiementcontrat }}
                      @php
                      $montantTotalMois += $paiement->montant_paiementcontrat;
                      $paiementTrouve = true;
                      @endphp
                      @endif
                      @endforeach
                      @endforeach
                      @if (!$paiementTrouve)
                      @if ($mois->id_moiscontrat != 13)
                      Pas inscrit
                      @else
                      0
                      @endif
                      @php
                      $totalMois[$mois->id_moiscontrat] += $montantTotalMois;
                      @endphp
                      @else
                      @php
                      $totalMois[$mois->id_moiscontrat] += $montantTotalMois;
                      @endphp
                      @endif
                      
                    </td>
                    @endif
                    @endforeach
                    <td>{{ array_sum($totalMois) }}</td>
                  </tr>
                  @endforeach
                </tbody>
                
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  @endsection
  <script>
    function imprimePage() {
      let table = $('#myTable').DataTable();
      let currentPage = table.page();  
      table.destroy();// Sauvegarder la page actuelle
      
      setTimeout(function() {
        // Créer un élément invisible pour l'impression
        let printDiv = document.createElement('div');
        printDiv.innerHTML = '<h1 style="font-size: 20px; text-transform: uppercase; text-align: center;">Etat des droits constatés - année académique {{ $annee }}{{ $anneesuivant }} | classe {{ $classe }}</h1>' +
        document.getElementById('contenu').innerHTML;
        
        // Appliquer des styles pour l'impression
        let style = document.createElement('style');
        style.innerHTML = `@page { size: landscape; }
              @media print {
                  body * { visibility: hidden; }
                  #printDiv, #printDiv * { visibility: visible; }
                  #printDiv { position: absolute; top: 0; left: 0; width: 100%; }
                  .dt-end { display: none !important; }
                  .dt-start { display: none !important; }
                  .table td:nth-child(n+2) {
                   margin: 0 !important;
                      padding: 5px 0 5px 5px !important;
                      width: 500px !important;
                      word-wrap: break-word !important;
                      white-space: normal !important;
                  }
                   table th {
                   font-weight: bold !important;
  
                   }
                                      
                  table th, table td {
                      font-size: 9px !important;
                      margin: 0 !important;
                      padding: 0 !important;
                      border-collapse: collapse !important;
                  }
                      table {
                  width: 100%;
                  border-collapse: collapse;
              }
              th, td {
              margin: 0 !important;
                      padding: 0 !important;
                  border: 1px solid #ddd;
              }
              tbody tr:nth-child(even) {
                  background-color: #f1f3f5;
              }
              tbody tr:nth-child(odd) {
                  background-color: #ffffff;
              }
              }
          `;
        document.head.appendChild(style);
        document.body.appendChild(printDiv);
        printDiv.setAttribute("id", "printDiv");
        
        window.print();
        
        $('#myTable').DataTable({
          "pageLength": 10,  // Remettre la pagination à 10 par défaut (ou la valeur souhaitée)
        });
        
        // Nettoyer après l'impression
        document.body.removeChild(printDiv);
        document.head.removeChild(style);
      }, 200);
    }
    
  </script>
  {{-- 
  <script>
    function imprimePage() {
    let table = $('#myTable').DataTable();
    let currentPage = table.page();  
    table.page.len(-1).draw();  
    setTimeout(function() {
    let printWindow = window.open('', '', 'height=800,width=600');
    printWindow.document.write('<html><head><title>Impression</title>');
      printWindow.document.write('<style>@page { size: landscape; }</style>');
      
      printWindow.document.write('<style>@media print { .dt-end { display: none !important; } }</style>');
      printWindow.document.write('<style>@media print { td { font-size: 13px; } }</style>');
      printWindow.document.write('<style>@media print { .dt-start { display: none !important; } .table td:nth-child(n+2) {width: 500px !important; word-wrap: break-word !important; white-space: normal !important;} table {margin: 0 !important; padding: 0 !important; border-collapse: collapse !important;} table th, table td {margin: 0 !important; padding: 10px 0 5px 5px !important; border-collapse: collapse !important;} }</style>');
      printWindow.document.write('<style>table th, table td {margin: 0 !important; padding: 10px 0 5px 5px !important; border-collapse: collapse !important;} table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid #ddd;} tbody tr:nth-child(even) { background-color: #f1f3f5; } tbody tr:nth-child(odd) { background-color: #ffffff; } </style>');
      
      printWindow.document.write('</head><body>');
        printWindow.document.write('<h1 style="font-size: 20px; text-transform: uppercase; text-align: center;">Etat des droits constates - annee academique {{ $annee }} - {{ $anneesuivant }} | classe ({{ $classe }})</h1>');
        
        printWindow.document.write('<div>' + document.getElementById('contenu').innerHTML + '</div>');
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        
        printWindow.onload = function() {
        printWindow.print();
        printWindow.close();
        
        table.page.len(10).draw();  
        table.page(currentPage).draw(false); 
        };
        }, 200);
        }
        
      </script> --}}
      
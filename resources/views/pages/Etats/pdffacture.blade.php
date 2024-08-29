@extends('layouts.master')
@section('content')

<style>

    body {
        font-family: Arial, sans-serif;
    }
    @media print {
        .ko {
            background-color: blue;
        }
    
    }
    
    p {
    
        font-size: 15px;
    }
    
    
    
    
    #mecef p {
        font-size: 12px;
    }
    
    
    .page-break {
        display: none; /* Masquer les éléments de saut de page lors de l'impression */
    }
    
    
    .facture-container1 {
        display: flex;
        justify-content: space-between; /* Optionnel : espace entre les blocs */
        gap: 50px; /* Optionnel : espace entre les blocs */
        border-radius: 5px;
        margin-left: 40px;
        margin-right: 30px;
        margin-top: -1.8rem;
    }
    
    .facture-container2 {
        display: flex;
        justify-content: space-between; /* Optionnel : espace entre les blocs */
        gap: 50px; /* Optionnel : espace entre les blocs */
        margin-left: 40px;
        margin-right: 30px;
    }
    
    .facture-container5 {
        display: flex;
        justify-content: space-between; /* Optionnel : espace entre les blocs */
        gap: 50px; /* Optionnel : espace entre les blocs */
        margin-left: 0px;
        margin-right: 40px;
    }
    
    .info {
        flex: 1; /* Les deux blocs auront la même largeur */
        padding: 10px;
        /* border: 1px solid #ddd; */
        border-radius: 5px;
        margin-top: 2rem;
    }
    
    .table4 {
        width: 600px; /* Largeur fixe du conteneur */
        overflow: auto; /* Ajouter un défilement si nécessaire */
    }
    
    #customers4 {
        width: 100%; /* Largeur du tableau prend la largeur du conteneur */
        border-collapse: collapse; /* Fusionner les bordures */
    }
    
    #customers4 th, #customers4 td {
        border: 1px solid #ddd; /* Bordure des cellules */
        padding: 8px; /* Espacement intérieur des cellules */
        text-align: left; /* Alignement du texte */
    }
    
    #customers4 th {
        background-color: #f2f2f2; /* Couleur de fond de l'en-tête */
    }
    
    #customers4 td p {
        margin: 0; /* Supprimer les marges des paragraphes */
    }
    
    
    .invoice {
        width: 60%;
        height: 59rem;
        background-color: #ffff;
        padding: 0;
        page-break-before: always;
        margin: 10px auto;

    }
    
    .entete {
        border: 1px solid #ccc;
        font-size: 15px;
        background: #cccccc34;
    }
    
    /* .logo {
        margin-left: 20px;
        margin-top: 20px;
        width: 300px;
        height: 300px;
    } */
    
    .logoimg {
        width: 40%;
        /* margin-top: 0.5rem; */
    }
    
    /* .info {
        margin-left: 26rem;
        margin-top: -20rem;
    } */
    
    .bas {
        margin-top: 20px;
        border: 1px solid #ccc;
        font-size: 15px;
        background: #cccccc34;
    }
    
    .titre {
        margin: 20px auto;
        font-size: 15px;
    }
    
    h2 {
        color: #333;
    }
    
    ul {
        list-style-type: none;
        padding: 0;
    }
    
    .title {
        font-size: 17px;
        font-weight: bold;
        text-align: center;
    }
    
    .entreprise {
        margin-left: 40px;
        border: 1px solid black;
        background: #aeadad35;
        width: 14rem;
        height: 9rem;
        text-align: center;
        margin-top: 2rem;
    }
    
    .client {
        margin-top: -9.4rem;
        margin-left: 28rem;
        border: 1px solid black;
        width: 14rem;
        height: 9rem;
        text-align: center;
    }
    
    .infomecef {
        border: 1px solid black;
        width: 80%;
        margin: 2px auto;
        padding: 30px;
    }
    
    .qcode {
        /* margin-left: 70px; */
        padding: 0px 20px 20px 5px;
        margin-top: -1.3rem;
    }
    
    .mecef {
        margin-top: -8.5rem;
        margin-left: 8rem;
        font-size: 10px;
        padding: 2px 2px;
    }
    
    .textmontant {
        margin-left: 40px;
        margin-top: 20px;
    }
    
    .textremerciement {
        margin-left: 18px;
        /* margin-top: 6px; */
    }
    
    .logo1 {
        margin-left: 18px;
    }
    
    .info1 {
        margin-top: -1.5rem;
        margin-left: 28.5rem;
    }
    
    .prix {
        font-weight: bold;
        color: black;
        font-size: 16px;
        text-align: center;
        padding: 6px 6px;
    }
    
    @media print {
        /* .ko {
            background-color: red !important; 
        } */
        @page { size: portrait; } 

        /* #customers3 th {
            color: #a5d5e9;
        } */
    }
    
    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 90%;
        margin-left: 40px;
        margin-top: 2rem;
    }
    
    #customers2 {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 150%;
        margin-left: 40px;
        
        margin-top: 2rem;
    }
    
    #customers8 {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 20%;
        margin-right: 0px;
        
        margin-top: 2rem;
    }
    
    #customers3 {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 90%;
        margin-left: 40px;
        margin-top: 2rem;
    }
    
    #customers td,
    #customers th {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
        max-width: 200px; /* Taille maximale des colonnes */
        word-wrap: break-word; /* Permet de couper les mots et de passer à la ligne */
        word-break: break-all; /* Casse les mots plus longs que la taille de la colonne */
    }
    
    #customers2 td,
    #customers2 th {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
        max-width: 200px; /* Taille maximale des colonnes */
        word-wrap: break-word; /* Permet de couper les mots et de passer à la ligne */
        word-break: break-all; /* Casse les mots plus longs que la taille de la colonne */
    }
    
    #customers3 td,
    #customers3 th {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
        max-width: 200px; /* Taille maximale des colonnes */
        word-wrap: break-word; /* Permet de couper les mots et de passer à la ligne */
        word-break: break-all; /* Casse les mots plus longs que la taille de la colonne */
    }
    
    
    #customers tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    
    #customers2 tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    #customers3 tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    
    #customers tr:hover {
        background-color: #ddd;
    }
    
    #customers2 tr:hover {
        background-color: #ddd;
    }
    
    #customers3 tr:hover {
        background-color: #ddd;
    }
    
    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        background-color: #a5d5e9;
        color: black;
    }
    
    #customers2 th {
        padding-top: 12px;
        padding-bottom: 12px;
        background-color: #a5d5e9;
        color: black;
    }
    
    #customers3 th {
        padding-top: 12px;
        padding-bottom: 12px;
        background-color: #a5d5e9;
        color: black;
    }
    
    .table2 {
        margin-top: -0.5rem;
        
    }
    
    .table3 {
        margin-top: -0.5rem;
    }
    
    .telecharger {
        width: 8rem;
        height: 2.4rem;
        text-align: center;
        margin-top: 20px;
        margin-left: 10px;
    }
    
</style>


<body>
    <a class="telecharger btn btn-success" href="{{ url('/facturenormalise/' . $nomcompleteleve) }}" target="_blank">Imprimer</a>

    <div class="invoice">

        <section>


            <div class="facture-container1">
                <div class="info">
                    <div class="logo">
                        <img src="data:image/jpeg;base64,{{ base64_encode($logoUrl) }}" alt="Logo" class="logoimg">
                    </div>
                </div>
            <div class="info">
                <h4><strong>FACTURE DE VENTE</strong></h4>
                <p><strong>Facture # {{ $reffacture }} </strong></p>
                <p>Date :
                    {{
                        \Carbon\Carbon::hasFormat($datepaiementcontrat, 'Y-m-d H:i:s') 
                        ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $datepaiementcontrat)->format('d/m/Y') 
                        : (\Carbon\Carbon::hasFormat($datepaiementcontrat, 'd/m/Y H:i:s') 
                        ? \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $datepaiementcontrat)->format('d/m/Y') 
                        : 'Format de date non supporté')
                      }}
                </p>
                <p>Vendeur : SFE en ligne</p>
                {{-- <p>Réference fact. originale :</p> --}}
            </div>
        </div>
    </section>
    
    <section>
        <div class="facture-container2">
            <div class="table4">
                <table id="customers4">
                    <thead>
                        <tr>
                            <th>Informations de l'établissement</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <p>Nom : {{ $NOMETAB }}</p>
                                <p>IFU : {{ $ifuEcoleFacture }}</p>
                                {{-- <p>RCCM :</p>
                                <p>Adresse :</p>
                                <p>Contact :</p> --}}
                                <p>VMCF : {{ $nim }}</p>
        
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="table4">
                        <table id="customers4">
                            <thead>
                                <tr>
                                    <th>Informations du client</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                <p>Nom : {{ $nomcompleteleve }}</p>
                                <p>Classe : {{ $classeeleve }}</p>
                                {{-- <p>IFU :</p>
                                <p>Adresse :</p> --}}
                                {{-- <p>Contact :</p> --}}
        
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <div class="table2">
                <table id="customers">
                    <thead>
                        <tr>
                            <th>Désignation</th>
                            <th>Montant HT</th>
                            <th>Montant T.T.C</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td >{{ $nameItemFacture }} </td>
                            <td >{{ $prixTotalItemFacture }}</td>
                            <td>{{ $prixTotalItemFacture }} <strong>[-A]</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>


        <div class="table2">
            <table id="customers">
                <thead>
                    <tr>
                        <th scope="col">Montant total HT</th>
                        <th scope="col">Net à Payer</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $prixTotalItemFacture }}</td>
                        <td>{{ $prixTotalItemFacture }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- <div class="facture-container5">
            <div class="table2">
                <table id="customers2">
                    <thead>
                        <tr>
                            <th>Groupe</th>
                            <th>Total</th>
                            <th>Imposable</th>
                            <th>Impôt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>A - EXHONERER</td>
                            <td>{{ $facture->montant_total }}</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="customers8" class="table2">
                <hr class="line">
                <h3> Total : {{ $facture->montant_total }}</h3>
                <hr  class="line2">
            </div>
        </div> --}}

        <div class="table3">
            <table id="customers3">
                <thead>
                    <tr>
                        <th>Type de paiement</th>
                        <th>Payé</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ESPECE</td>
                        <td>{{ $prixTotalItemFacture }}</td>
                    </tr>
                </tbody>
            </table>
        </div>


        <p class="textmontant">Arrêtée, la présente facture à la somme de <span class="prix"> {{ $prixTotalItemFacture }}</span> FCFA.</p>
        <br>
        <div class="table2">
            <div class="infomecef">
                <div class="qcode">
                    <img src="data:image/jpeg;base64,{{ base64_encode($qrcodecontent) }}" alt="QR Code">
                </div>
                <div id="mecef" class="mecef">
                    <p><strong>Code MECeF/DGI:</strong> {{ $factureconfirm['codeMECeFDGI'] }}</p>
                    <p><strong>MECeF NIM:</strong> {{ $factureconfirm['nim'] }}</p>
                    <p><strong>MECeF Compteur:</strong> {{ $factureconfirm['counters'] }}</p>
                    <p><strong>MECeF Heure:</strong> {{ $factureconfirm['dateTime'] }}</p>
                </div>
            </div>
        </div>
        <div class="bas">
            <div class="logo1">
                <p><strong>{{ $NOMETAB }}</strong></p>
            </div>
            <div class="info1">
                <p>Fait à Cotonou le, <strong>{{ $factureconfirm['dateTime'] }}</strong></p>
            </div>
            <p class="textremerciement"><i>Merci d'avoir choisi le {{ $NOMETAB }}</i></p>
        </div>
    </div>
</body>

    @endsection


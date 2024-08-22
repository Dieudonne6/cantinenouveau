@extends('layouts.master')
@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .invoice {
            width: 55%;
            margin: 20px auto;
            border: 1px solid #ccc;
            background-color: #fffff;
            padding: 0;
            height: 100%
        }

        .entete {
            /* margin:20px  auto; */
            border: 1px solid #ccc;
            font-size: 15px;
            background: #cccccc34;
        }

        .logo {
            margin-left: 22px;
            /* margin-top: 20px; */
            width: 30%;
            height: 30%;
        }

        .logoimg {
        width: 35%;
        margin-top: 5px;
    }

        /* .info {
        margin-left: 26rem;
        margin-top: -20rem;
    } */

        .info {
            margin-left: 22rem;
            margin-top: -3rem;
        }

        .bas {
            margin-top: 20px;
            border: 1px solid #ccc;
            font-size: 15px;
            background: #cccccc34;
        }

        .titre {
            margin: 20px auto;
            /* border: 1px solid #ccc; */
            font-size: 15px;
            /* background: #ccc; */
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



        /* .info{
                                            float: left;
                                        } */

        .entreprise {
            margin-left: 40px;
            border: 1px solid black;
            background: #aeadad35;
            width: 11rem;
            text-align: center;
            margin-top: 2rem;

        }


        .client {
            margin-top: -7rem;
            margin-left: 25rem;
            border: 1px solid black;
            width: 11rem;
            text-align: center;

        }

        .infomecef {
            border: 1px solid black;
            width: 90%;
            margin-left: 40px;
            margin-top: 0.4rem;

        }

        .qcode {
            margin-left: 80px;
            padding: 20px 5px;
        }

        .mecef {
            margin-top: -8.6rem;
            margin-left: 15rem;
            font-size: 10px;
            padding: 2px 2px;
        }

        .textmontant {
            margin-left: 40px;
            margin-top: 20px;
        }

        .textremerciement {
            margin-left: 18px;
            /* text-align: center; */
            margin-top: 6px;

        }

        .logo1 {
            margin-top: 10px;
            margin-left: 18px;
        }

        .info1 {
            margin-top: -2.5rem;
            margin-left: 28.5rem;
        }


        .prix {
            background: rgb(27, 27, 27);
            color: white;
            font-size: 16px;
            text-align: center;
            padding: 6px 6px
                /* background-size: 50px */
                /* height: 50px;
                                            width: 50px; */
        }

        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 90%;
            margin-left: 40px;
            margin-top: 1.5rem;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }

        .table2 {
            margin-top: 20px;
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
            <div class="entete">
                <div class="logo">

                    @if($logoUrl)
                    <img src="data:image/jpeg;base64,{{ base64_encode($logoUrl) }}" alt="Logo" class="logo">
                    @else
                        <p>Aucun logo disponible.</p>
                    @endif
                    {{-- <img src="{{ 'assets/images/glasmorphism.jpg' }}" alt="logo" class="logoimg"> --}}
                    {{-- <img src="" alt=""> --}}
                </div>

                <div class="info">
                    <p>Facture de Paiement </p>
                    <p>Reference:<strong>{{ $reffacture }}</strong></p>
                </div>
            </div>

            <div class="titre">

                <div class="entreprise">
                    <p><i class="title">Ecole</i></p>
                    <p>IFU:<strong>{{ $ifuEcoleFacture }}</strong></p>
                    <p>Ecole:<strong> {{ $NOMETAB }} </strong></p>
                </div>



                <div class="client">
                    <p><i class="title">Eleve</i></p>
                    {{-- <p>IFU:<strong> {{ $facturedetaille['ifu'] }}</strong></p> --}}
                    <p>Nom : <strong>{{ $nomcompleteleve }}</strong></p>
                    <p>Classe : <strong>{{ $classeeleve }}</strong></p>
                </div>

            </div>





            {{-- <h2>code mecef {{ $factureconfirm['codeMECeFDGI'] }} </h2>
        <h2>Facture</h2>
        <ul>
            <li><strong>IFU:</strong> {{ $facturedetaille['ifu'] }}</li>
            <li><strong>Type:</strong> {{ $facturedetaille['type'] }}</li>
        </ul> --}}

            <div class="tableau">
                <table id="customers">
                    <thead>
                        <tr>
                            <th scope="col">Designation </th>
                            {{-- <th scope="col">Prix unitaire</th> --}}
                            {{-- <th scope="col">Quantite</th> --}}
                            <th scope="col">Montant HT</th>
                            {{-- <th scope="col">TVA</th> --}}
                            {{-- <th scope="col">Mois</th> --}}
                        </tr>
                    </thead>
                    <tbody>


                            <tr>
                                <td>
                                    {{ $nameItemFacture }}
                                </td>


                                <td>
                                    {{ $prixTotalItemFacture }}
                                </td>

                                {{-- <td>
                                    {{ $tva }}
                                </td> --}}
{{-- 
                                <td>
                                    {{ $toutmoiscontrat }}
                                </td> --}}

                            </tr>
                    </tbody>
                </table>

            </div>

            <div class="table2">
                <table id="customers">
                    <thead>
                        <tr>
                            
                            <th scope="col">Montant total HT</th>
                            <th scope="col">Net a Payer</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            

                            <td>
                                {{ $prixTotalItemFacture }}
                            </td>

                            <td>
                                {{ $prixTotalItemFacture }}
                            </td>


                        </tr>
                    </tbody>
                </table>

            </div>
            <p class="textmontant">Arretée, la presente facture a la somme de <span
                    class="prix">{{ $prixTotalItemFacture }}</span> FCFA .</p>

            {{-- <h2>Operator: {{ $facturedetaille['operator']['name'] }}</h2> --}}

            <div class="infomecef">

                <div class="qcode">
                    <div >
                            <img src="data:image/jpeg;base64,{{ base64_encode($qrcodecontent) }}" alt="qrcode">
                            {{-- <img src="{{ $filePath }}"   alt=""> --}}
                    </div>
                </div>

                <div class="mecef">
                    <p><strong>Code MECeF/DGI:</strong> {{ $factureconfirm['codeMECeFDGI'] }}</p>
                    <p><strong>MECeF NIM:</strong> {{ $factureconfirm['nim'] }}</p>
                    <p><strong>MECeF Compteur:</strong> {{ $factureconfirm['counters'] }}</p>
                    <p><strong>MECeF Heure:</strong> {{ $factureconfirm['dateTime'] }}</p>
                </div>
            </div>

            <div class="bas">
                <div class="logo1">
                    <p><strong>complexe scolaire petiti poucet</strong> </p>
                    {{-- <p><strong>{{ $nometab }}</strong> </p> --}}
                    {{-- <img src="" alt=""> --}}
                </div>

                <div class="info1">
                    <p>Fait a cotonou le , <strong>{{ $factureconfirm['dateTime'] }} </strong></p>
                    {{-- <p>Fait a {{$villeetab}} le , <strong>{{ $factureconfirm['dateTime'] }} </strong></p> --}}
                    {{-- <p>Reference 909090909090   </p> --}}
                </div>
                <p class="textremerciement"><i>Merci d'avoir choisi le complexe scolaire petit poucet </i> </p>
                {{-- <p class="textremerciement"><i>Merci d'avoir choisi le {{ $nometab }} </i> </p> --}}

            </div>
        </div>
    </body>

        {{-- <a class="telecharger btn btn-success" href="{{ url('telechargerfacture') }}">Imprimer</a> --}}
        {{-- <button onclick="window.print()">Imprimer</button> --}}
        {{-- <button onclick="printContent()">Imprimer</button> --}}


        {{-- <h2> Merci pour votre confiance votre facture a ete generer et vous serras envoyer lors dee la livraison de votre commande</h2> --}}
        {{-- {{ dd($factureconfirm) }} --}}
        {{-- 

    @endsection

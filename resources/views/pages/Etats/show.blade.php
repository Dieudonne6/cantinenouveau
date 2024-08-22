<style>
    body {
        font-family: Arial, sans-serif;
    }

    .invoice {
        width: 100%;
        background-color: #fffff;
        padding: 0;
        page-break-before: always;
    }

    .entete {
        border: 1px solid #ccc;
        font-size: 15px;
        background: #cccccc34;
    }

    .logo {
        margin-left: 20px;
        margin-top: 20px;
        width: 300px;
        height: 300px;
    }

    .logoimg {
        width: 25%;
        margin-top: -1rem;
    }

    .info {
        margin-left: 26rem;
        margin-top: -20rem;
    }

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
        margin: 40px auto;
        padding: 30px;
    }

    .qcode {
        margin-left: 70px;
        padding: 0px 20px 20px 5px;
        margin-top: -1rem;
    }

    .mecef {
        margin-top: -7.8rem;
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
        font-weight: bold;
        color: black;
        font-size: 16px;
        text-align: center;
        padding: 6px 6px;
    }

    @media print {
        .ko {
            background-color: red !important; 
        }
    }

    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 90%;
        margin-left: 40px;
        margin-top: 4rem;
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


    #customers tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #customers tr:hover {
        background-color: #ddd;
    }

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        background-color: #04AA6D;
        color: black;
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

<body onload="window.print();">
    <div class="invoice">
        <div class="entete">
            <div class="logo">
                @if($logoUrl)
                    <img src="data:image/jpeg;base64,{{ base64_encode($logoUrl) }}" alt="Logo" class="logoimg">
                @else
                    <p>Aucun logo disponible.</p>
                @endif
            </div>
            <div class="info">
                <p>Facture de Paiement</p>
                <p>Référence: <strong>{{ $facture->id }}</strong></p>
            </div>
        </div>

        <div class="titre">
            <div class="entreprise">
                <p><i class="title">Ecole</i></p>
                <p>IFU: <strong>{{ $facture->ifuEcole }}</strong></p>
                <p>Ecole: <strong>{{ $NOMETAB }}</strong></p>
            </div>
            <div class="client">
                <p><i class="title">Elève</i></p>
                <p>Nom: <strong>{{ $facture->nom }}</strong></p>
                <p>Classe: <strong>{{ $facture->classe }}</strong></p>
            </div>
        </div>

        <div class="tableau">
            <table id="customers">
                <thead>
                    <tr>
                        <th scope="col">Désignation</th>
                        <th scope="col">Montant HT</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td >Frais de cantine pour <span>{{ $facture->moispayes }}</span></td>
                        <td >{{ $facture->montant_total }}</td>
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
                        <td>{{ $facture->montant_total }}</td>
                        <td>{{ $facture->montant_total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="textmontant">Arrêtée, la présente facture à la somme de <span class="prix">{{ $facture->montant_total }}</span> FCFA.</p>
        <div class="infomecef">
            <div class="qcode">
                <img src="data:image/jpeg;base64,{{ base64_encode($facture->qrcode) }}" alt="QR Code">
            </div>
            <div class="mecef">
                <p><strong>Code MECeF/DGI:</strong> {{ $facture->codemecef }}</p>
                <p><strong>MECeF NIM:</strong> {{ $facture->nim }}</p>
                <p><strong>MECeF Compteur:</strong> {{ $facture->counters }}</p>
                <p><strong>MECeF Heure:</strong> {{ $facture->dateHeure }}</p>
            </div>
        </div>
        <div class="bas">
            <div class="logo1">
                <p><strong>Complexe Scolaire Petit Poucet</strong></p>
            </div>
            <div class="info1">
                <p>Fait à Cotonou le, <strong>{{ $facture->dateHeure }}</strong></p>
            </div>
            <p class="textremerciement"><i>Merci d'avoir choisi le Complexe Scolaire Petit Poucet</i></p>
        </div>
    </div>
</body>
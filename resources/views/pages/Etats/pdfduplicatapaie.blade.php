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
        display: none;
        /* Masquer les éléments de saut de page lors de l'impression */
    }


    .facture-container1 {
        display: flex;
        justify-content: space-between;
        /* Optionnel : espace entre les blocs */
        gap: 50px;
        /* Optionnel : espace entre les blocs */
        border-radius: 5px;
        margin-left: 40px;
        margin-right: 30px;
        margin-top: -1.8rem;
    }

    .facture-container2 {
        display: flex;
        justify-content: space-between;
        /* Optionnel : espace entre les blocs */
        gap: 50px;
        /* Optionnel : espace entre les blocs */
        margin-left: 40px;
        margin-right: 30px;
    }

    .facture-container5 {
        display: flex;
        justify-content: space-between;
        /* Optionnel : espace entre les blocs */
        gap: 50px;
        /* Optionnel : espace entre les blocs */
        margin-left: 0px;
        margin-right: 40px;
    }

    .info {
        flex: 1;
        /* Les deux blocs auront la même largeur */
        padding: 10px;
        /* border: 1px solid #ddd; */
        border-radius: 5px;
    }

    .table4 {
        width: 600px;
        /* Largeur fixe du conteneur */
        overflow: auto;
        /* Ajouter un défilement si nécessaire */
    }

    #customers4 {
        width: 100%;
        /* Largeur du tableau prend la largeur du conteneur */
        border-collapse: collapse;
        /* Fusionner les bordures */
    }

    #customers4 th,
    #customers4 td {
        border: 1px solid #ddd;
        /* Bordure des cellules */
        padding: 8px;
        /* Espacement intérieur des cellules */
        text-align: left;
        /* Alignement du texte */
    }

    #customers4 th {
        background-color: #f2f2f2;
        /* Couleur de fond de l'en-tête */
    }

    #customers4 td p {
        margin: 0;
        /* Supprimer les marges des paragraphes */
    }


    .invoice {
        /* width: 100%; */
        background-color: #ffff;
        padding: 0;
        page-break-before: always;
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
        width: 50%;
        margin-top: 1rem;
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
        margin: 20px auto;
        padding: 30px;
    }

    .qcode {
        margin-left: 70px;
        padding: 0px 20px 20px 5px;
        margin-top: -1rem;
    }

    .mecef {
        margin-top: -9rem;
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

        /* .ko {
            background-color: red !important;
        } */
        @page {
            size: portrait;
        }

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
        max-width: 200px;
        /* Taille maximale des colonnes */
        word-wrap: break-word;
        /* Permet de couper les mots et de passer à la ligne */
        word-break: break-all;
        /* Casse les mots plus longs que la taille de la colonne */
    }

    #customers2 td,
    #customers2 th {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
        max-width: 200px;
        /* Taille maximale des colonnes */
        word-wrap: break-word;
        /* Permet de couper les mots et de passer à la ligne */
        word-break: break-all;
        /* Casse les mots plus longs que la taille de la colonne */
    }

    #customers3 td,
    #customers3 th {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
        max-width: 200px;
        /* Taille maximale des colonnes */
        word-wrap: break-word;
        /* Permet de couper les mots et de passer à la ligne */
        word-break: break-all;
        /* Casse les mots plus longs que la taille de la colonne */
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

<body onload="window.print();">
    <div class="invoice">

        <section>


            <div class="facture-container1">
                <div class="info">
                    <div class="logo">
                        <img src="data:image/jpeg;base64,{{ base64_encode($logo) }}" alt="Logo" class="logoimg">
                    </div>
                </div>
                <div class="info">
                    @php
                        $typefa = $facturePaie->counters;

                        // echo($typefa)
                    @endphp
                    @if ( substr(($typefa), -2) === 'FA' )

                    <h1><strong>FACTURE D'AVOIR</strong></h1>
                    
                    @else
                    
                    <h1><strong>FACTURE DE VENTE</strong></h1>

                    @endif
                    


                    <p><strong>Facture # {{ $facturePaie->id }} </strong></p>
                    <p>Date :
                        {{ \Carbon\Carbon::hasFormat($facturePaie->datepaiementcontrat, 'Y-m-d H:i:s')
                            ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $facturePaie->datepaiementcontrat)->format('d/m/Y')
                            : (\Carbon\Carbon::hasFormat($facturePaie->datepaiementcontrat, 'd/m/Y H:i:s')
                                ? \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $facturePaie->datepaiementcontrat)->format('d/m/Y')
                                : 'Format de date non supporté') }}
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
                                    <p>Nom : {{ $nomecole }}</p>
                                    <p>IFU : {{ $facturePaie->ifuEcole }}</p>
                                    {{-- <p>RCCM :</p>
                                <p>Adresse :</p>
                                <p>Contact :</p> --}}
                                    <p>VMCF : {{ $facturePaie->nim }}</p>

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
                                    <p>Nom : {{ $facturePaie->nom }}</p>
                                    <p>Classe : {{ $facturePaie->classe }}</p>
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
                        <td>{{ $facturePaie->designation }} </td>
                        <td>{{ $facturePaie->montant_total }}</td>
                        <td>{{ $facturePaie->montant_total }}</td>
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
                        <td>{{ $facturePaie->montant_total }}</td>
                        <td>{{ $facturePaie->montant_total }}</td>
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
                        <td>{{ $facturePaie->montant_total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>


        <p class="textmontant">Arrêtée, la présente facture à la somme de <span class="prix">
                {{ $facturePaie->montant_total }}</span> FCFA.</p>
        <br>
        <div class="table2">
            <div class="infomecef">
                <div class="qcode">
                    <img src="data:image/jpeg;base64,{{ base64_encode($facturePaie->qrcode) }}" alt="QR Code">
                </div>
                <div id="mecef" class="mecef">
                    <p><strong>Code MECeF/DGI:</strong> {{ $facturePaie->codemecef }}</p>
                    <p><strong>MECeF NIM:</strong> {{ $facturePaie->nim }}</p>
                    <p><strong>MECeF Compteur:</strong> {{ $facturePaie->counters }}</p>
                    <p><strong>MECeF Heure:</strong> {{ $facturePaie->dateHeure }}</p>
                </div>
            </div>
        </div>
        <div class="bas">
            <div class="logo1">
                <p><strong>{{ $nomecole }}</strong></p>
            </div>
            <div class="info1">
                <p>Fait à Cotonou le, <strong>{{ $facturePaie->dateHeure }}</strong></p>
            </div>
            <p class="textremerciement"><i>Merci d'avoir choisi le {{ $nomecole }}</i></p>
        </div>
    </div>
</body>





{{-- 


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="styles.css">
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
    /* width: 100%; */
    background-color: #ffff;
    padding: 0;
    page-break-before: always;
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
    width: 25%;
    margin-top: 5rem;
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
    margin-left: 23rem;
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
    margin-top: 10px;
    
}

.table3 {
    margin-top: 10px;
}

.telecharger {
    width: 8rem;
    height: 2.4rem;
    text-align: center;
    margin-top: 20px;
    margin-left: 10px;
}

    </style>
</head>

<body onload="window.print();">

    
        <div class="invoice">
            <section>


                <div class="facture-container1">
                    <div class="info">
                        <div class="logo">
                            <img src="img/cbox1.png" alt="Logo" class="logoimg">
                    </div>
                    </div>
                    <div class="info">
                        <h1><strong>FACTURE DE VENTE</strong></h1>
                        <p><strong>Facture # EM01398964-8</strong></p>
                        <p>Date : 05/04/2024</p>
                        <p>Vendeur : SFE en ligne</p>
                        <p>Réference fact. originale :</p>
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
                            <p>Nom :</p>
                            <p>IFU :</p>
                            <p>RCCM :</p>
                            <p>Adresse :</p>
                            <p>Contact :</p>
                            <p>VMCF :</p>
    
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="table4">
                    <table id="customers4">
                        <thead>
                            <tr>
                                <th>Informations de l'élève</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                            <p>Nom :</p>
                            <p>Classe :</p>
                            <p>IFU :</p>
                            <p>Adresse :</p>
                            <p>Contact :</p>
    
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    
            <!-- <div class="titre">
                <div class="entreprise">
                    <p><i class="title">Ecole</i></p>
                    <p>IFU: <strong>ifu</strong></p>
                    <p>Ecole: <strong>nom</strong></p>
                </div>
                <div class="client">
                    <p><i class="title">Elève</i></p>
                    <p>Nom: <strong>nom</strong></p>
                    <p>Classe: <strong>classe</strong></p>
                </div>
            </div> -->
    
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
                            <td >designation </td>
                            <td >montant total</td>
                            <td>montant total ttc</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="facture-container5">
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
                                <td>Groupe</td>
                                <td>total</td>
                                <td>Imposable</td>
                                <td>Impôt</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="customers8" class="table2">
                    <hr class="line">
                    <h3> Total : 136300</h3>
                    <hr  class="line2">
                </div>
            </div>
                
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
                            <td>Groupe</td>
                            <td>total</td>
                        </tr>
                    </tbody>
                </table>
            </div>











            <p class="textmontant">Arrêtée, la présente facture à la somme de <span class="prix"> montant total</span> FCFA.</p>
            <br>
            <div class="table2">
                <div class="infomecef">
                    <div class="qcode">
                        <img src="data:image/jpeg;base64,{{ base64_encode($facture->qrcode) }}" alt="QR Code">
                    </div>
                    <div id="mecef" class="mecef">
                        <p><strong>Code MECeF/DGI:</strong> codemecef</p>
                        <p><strong>MECeF NIM:</strong> nim</p>
                        <p><strong>MECeF Compteur:</strong> Numero compteur</p>
                        <p><strong>MECeF Heure:</strong>Heure Facture</p>
                    </div>
                </div>
            </div>
            <div class="bas">
                <div class="logo1">
                    <p><strong>Complexe Scolaire Petit Poucet</strong></p>
                </div>
                <div class="info1">
                    <p>Fait à Cotonou le, <strong>Heure Facture</strong></p>
                </div>
                <p class="textremerciement"><i>Merci d'avoir choisi le Complexe Scolaire Petit Poucet</i></p>
            </div>
        </div>


</body>
</html>

#customers3 th

--}}

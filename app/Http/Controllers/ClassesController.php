<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Eleve;
use App\Models\Classes;
use App\Models\Contrat;
use App\Models\Paramcontrat;
use App\Models\Duplicatafacture;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Inscriptioncontrat;
use App\Models\Paiementglobalcontrat;
use App\Models\Paiementcontrat;
use App\Models\Moiscontrat;
use App\Models\Facturenormalise;
use App\Models\Usercontrat;
use App\Models\User;
use App\Models\Paramsfacture;
use App\Models\Qrcode;
use App\Models\Params2;
use GuzzleHttp\Client;
use App\Http\Requests\InscriptionCantineRequest;
use App\Http\Requests\PaiementCantineRequest;
use Illuminate\Support\Facades\Validator;

// use Barryvdh\DomPDF\PDF;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use DateTime;
use Carbon\Carbon;



// use Endroid\QrCode\Response\QrCodeResponse;
// use Endroid\QrCode\Writer\PngWriter;
// use Endroid\QrCode\Encoding\Encoding;
// use Endroid\QrCode\writeFile\writeFile;
// use Endroid\QrCode\ErrorCorrectionLevel;
// use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\Writer\FileWriter;


class ClassesController extends Controller
{
    public function classe(Request $request){
        if(Session::has('account')){
            $elev = Eleve::get();

        // Récupérer les matricules des élèves dont le statut de contrat est égal à 1
        $contratValideMatricules = Contrat::where('statut_contrat', 1)->pluck('eleve_contrat');

        // Récupérer les noms et prénoms des élèves correspondants
        $eleves = Eleve::whereIn('MATRICULE', $contratValideMatricules)
            ->select('MATRICULE', 'NOM', 'PRENOM', 'CODECLAS')
            ->orderBy('NOM', 'asc')
            ->get();
            // dd($eleves);

            // Les noms des classes à exclure
            $classesAExclure = ['NON', 'DELETE'];

            // Récupérer toutes les classes sauf celles à exclure
            $classes = Classes::whereNotIn('CODECLAS', $classesAExclure)->get();
            // $classes = Classes::get();
            $fraiscontrat = Paramcontrat::first(); 
            Session::put('eleves', $eleves);
            Session::put('classes', $classes);
            Session::put('fraiscontrats', $fraiscontrat);
            // Convertir une chaîne de latin1 à UTF-8

            return view('pages.classes')->with('eleve', $eleves)->with('classe', $classes)->with('fraiscontrats', $fraiscontrat)->with('elev', $elev);
        } 
        return redirect('/');
    }

    // page liste de tout les contrat disponible 

    public function listecontrat() {
        if(Session::has('account')){
            $elev = Eleve::get();

        // Récupérer les matricules des élèves dont le statut de contrat est égal à 1
        $contratValideMatricules = Contrat::where('statut_contrat', 1)->pluck('eleve_contrat');

        // Récupérer les noms et prénoms des élèves correspondants
        $eleves = Eleve::whereIn('MATRICULE', $contratValideMatricules)
            ->select('MATRICULE', 'NOM', 'PRENOM', 'CODECLAS')
            ->orderBy('NOM', 'asc')
            ->get();
            // dd($eleves);

            // Les noms des classes à exclure
            $classesAExclure = ['NON', 'DELETE'];

            // Récupérer toutes les classes sauf celles à exclure
            $classes = Classes::whereNotIn('CODECLAS', $classesAExclure)->get();
            // $classes = Classes::get();
            $fraiscontrat = Paramcontrat::first(); 
            Session::put('eleves', $eleves);
            Session::put('classes', $classes);
            Session::put('fraiscontrats', $fraiscontrat);
            // Convertir une chaîne de latin1 à UTF-8

            // -------------------------------------------------

                    // // Liste des mots à exclure
                    // $excludedWords = ["DELETE", 'NON'];
                        
                    // // Construire la requête initiale
                    // $query = Classes::query();

                    // // Ajouter des conditions pour exclure les mots
                    // foreach ($excludedWords as $word) {
                    //     $query->where('CODECLAS', 'not like', '%' . $word . '%');
                    // }

                    // // Récupérer les résultats
                    // $class = $query->get();
                   

            // -------------------------------------------------

            return view('pages.listecontrat')->with('eleve', $eleves)->with('classe', $classes)->with('fraiscontrats', $fraiscontrat)->with('elev', $elev);
        } 
        return redirect('/');
    }
    

    public function filterEleve($CODECLAS){
        $eleves = Eleve::orderBy('NOM', 'asc')->get();
        // Les noms des classes à exclure
        $classesAExclure = ['NON', 'DELETE'];

        // Récupérer toutes les classes sauf celles à exclure
        $classes = Classes::whereNotIn('CODECLAS', $classesAExclure)->get();
        // $classes = Classes::get();
        $fraiscontrat = Paramcontrat::first(); 

        // Récupérer les matricules des élèves dont le statut de contrat est égal à 1
        $contratValideMatricules = Contrat::where('statut_contrat', 1)->pluck('eleve_contrat');

        // Récupérer les noms et prénoms des élèves correspondants
        $filterEleves = Eleve::whereIn('MATRICULE', $contratValideMatricules)
            ->where('CODECLAS', $CODECLAS)
            ->select('MATRICULE', 'NOM', 'PRENOM', 'CODECLAS')
            ->orderBy('NOM', 'asc')
            ->get();

        // $filterEleves = Eleve::where('CODECLAS', $CODECLAS)
        // ->orderBy('NOM', 'asc')
        // ->get();
        Session::put('fraiscontrats', $fraiscontrat);
        Session::put('fill', $filterEleves);
        
        // dd($fill);
        return view('pages.filterEleve')->with("filterEleve", $filterEleves)->with('classe', $classes)->with('eleve', $eleves)->with('fraiscontrats', $fraiscontrat);
    }
    
  
    
    

    public function paiementcontrat(Request $request, $CODECLAS, $MATRICULE){

        // $fill = Session::get('fill');

        // dd($CODECLAS);

            

            // dd($moisCorrespondants);

         // Afficher les mois correspondants à chaque ID du tableau $difference
            // foreach ($moisCorrespondants as $id_moiscontrat => $nom_moiscontrat) {
            //     echo"<br> <br> <br> <br>";
            //     echo "ID Moiscontrat : $id_moiscontrat, Mois : $nom_moiscontrat <br>";
            // }


            // $allmoiscontratarray = $allmoiscontrat->toArray();
            // dd($allmoiscontratarray);


            // $moisContratArray = $inscriptioncontrats->toArray();
            // dd($moisContratArray);
    
                // $moiscontrat = $inscriptioncontrat->id_moiscontrat;
                // dd($inscriptioncontrat->id_moiscontrat) ;
                // dd($moiscontrat);


            // $moiscontrat = $inscriptioncontrat->id_moiscontrat;
            // dd($idcontrateleve);

            Session::put('matricule', $MATRICULE);

            $contrat = Contrat::where('eleve_contrat', $MATRICULE)->first();
            $eleveCon = Eleve::where('MATRICULE', $MATRICULE)->first();
            $nomCompletEleveCon = $eleveCon->NOM .' '. $eleveCon->PRENOM;
            // dd($nomCompletEleveCon);

            if ($contrat){

                // echo("oui L'eleve existe dans la table contrat !!!!!!!!!! ");
                $idcontrateleve = $contrat->id_contrat;
                Session::put('idcontratEleve', $idcontrateleve);


                // $inscriptioncontrats = Inscriptioncontrat::where('id_contrat', $idcontrateleve)->get(['id_moiscontrat']);
                // $inscriptioncontrats = Inscriptioncontrat::where('id_contrat', $idcontrateleve)->pluck('id_moiscontrat')->toArray();
                // $allmoiscontrat = Moiscontrat::pluck('nom_moiscontrat', 'id_moiscontrat')->take(12)->toArray();
                // // dd($allmoiscontrat);

                // $difference = array_diff(array_keys($allmoiscontrat), $inscriptioncontrats);

                // // dd($difference);
                // $moisCorrespondants = [];
                // foreach ($difference as $id_moiscontrat) {
                //     if (array_key_exists($id_moiscontrat, $allmoiscontrat)) {
                //         $moisCorrespondants[$id_moiscontrat] = $allmoiscontrat[$id_moiscontrat];
                //     }
                // }
                




                // Récupérer les mois d'inscription du contrat de l'élève
                $inscriptioncontrats = Inscriptioncontrat::where('id_contrat', $idcontrateleve)
                    ->pluck('id_moiscontrat')
                    ->toArray();

                // Récupérer tous les mois disponibles et les limiter aux 12 premiers mois
                $allmoiscontrat = Moiscontrat::take(12)
                    ->pluck('nom_moiscontrat', 'id_moiscontrat')
                    ->toArray();

                // Définir l'ordre des mois de septembre à août
                $order = [
                    'Septembre', 'Octobre', 'Novembre', 'Decembre',
                    'Janvier', 'Fevrier', 'Mars', 'Avril',
                    'Mai', 'Juin'
                ];

                // Filtrer les mois qui ne sont pas dans les contrats d'inscription
                $moisNonPayes = array_diff_key($allmoiscontrat, array_flip($inscriptioncontrats));

                // Réorganiser les mois selon l'ordre défini
                $moisCorrespondants = [];
                foreach ($order as $mois) {
                    foreach ($moisNonPayes as $id => $nom) {
                        if ($nom === $mois) {
                            $moisCorrespondants[$id] = $nom;
                            break;
                        }
                    }
                }

                // dd($moisCorrespondants);



                if (($CODECLAS === "MAT1") || ($CODECLAS === "MAT2")  || ($CODECLAS === "MAT2II")  || ($CODECLAS === "MAT3")  || ($CODECLAS === "MAT3II")  || ($CODECLAS === "PREMATER")) {

                    // echo("oui l'eleve est de la maternelle");

                    $pramcontrat = Paramcontrat::first();
                    $fraismensuelle = $pramcontrat->fraisinscription2_paramcontrat;
                    // dd($fraismensuelle);

                    if($inscriptioncontrats){
                        // echo("le contrat existe dans la table inscriptioncontrat");
                        // dd($inscriptioncontrat);
                        // dd($moiscontrat);
                        
                        return view('pages.paiementcontrat')->with('fraismensuelle', $fraismensuelle)->with('moisCorrespondants', $moisCorrespondants)->with('nomCompletEleveCon', $nomCompletEleveCon);

                    }
                    else {
                        // $moisCorrespondants = Moiscontrat::pluck('nom_moiscontrat', 'id_moiscontrat')->toArray();

                        // echo("le contrat n'existe pas dans la table inscriptioncontrat");
                        
                        return view('pages.paiementcontrat')->with('fraismensuelle', $fraismensuelle)->with('moisCorrespondants', $moisCorrespondants)->with('nomCompletEleveCon', $nomCompletEleveCon);

                    }


                }else{

                    // echo("non l'eleve n'est pas de la maternelle");

                    $pramcontrat = Paramcontrat::first();
                    $fraismensuelle = $pramcontrat->coutmensuel_paramcontrat;
                    // dd($fraismensuelle);

                    if($inscriptioncontrats){
                        // echo("le contrat existe dans la table inscriptioncontrat");
                        // dd($inscriptioncontrat);
                        // dd($moiscontrat);
                        
                        return view('pages.paiementcontrat')->with('fraismensuelle', $fraismensuelle)->with('moisCorrespondants', $moisCorrespondants)->with('nomCompletEleveCon', $nomCompletEleveCon);

                    }
                    else {
                        // $moisCorrespondants = Moiscontrat::pluck('nom_moiscontrat', 'id_moiscontrat')->toArray();

                        return view('pages.paiementcontrat')->with('fraismensuelle', $fraismensuelle)->with('moisCorrespondants', $moisCorrespondants)->with('nomCompletEleveCon', $nomCompletEleveCon);

                    }

                    


                    // return view('pages.paiementcontrat')->with('fraismensuelle', $fraismensuelle);

                }
            } else {
                // return view('pages.inscriptioncontrat');
                return back()->with('status','Le contrat n\'existe pas.Veuillez créer un contrat pour l\'eleve');

            }


}


    
        
public function savepaiementcontrat(PaiementCantineRequest $request) {

                $idcontratEleve = Session::get('idcontratEleve');
                $moisCoches = $request->input('moiscontrat');
                $montantmoiscontrat = $request->input('montantcontrat');
                $montanttotal = $request->input('montanttotal');
                $datepaiementcontrat = $request->input('date');
                $id_usercontrat = Session::get('id_usercontrat');
                // $id_usercontrat = $request->input('id_usercontrat');

                // dd($montanttotal);
                $anneeActuelle = date('Y');

                // generer une valeur aleatoire comprise entre 10000000 et 99999999 et verifier si elle existe deja dans la table.
                // Si la valeur est déjà présente, exists() renverra true, et la boucle continuera à s'exécuter pour générer une nouvelle valeur.
                // Si la valeur n'est pas présente (c'est-à-dire qu'elle est unique), la condition exists() renverra false, et la boucle s'arrêtera.

                // do {
                //      // Génère un nombre aléatoire entre 10000000 et 99999999
                //     $valeurDynamiqueNumerique = mt_rand(10000000, 99999999);
                // } while (DB::table('paiementcontrat')->where('reference_paiementcontrat', $valeurDynamiqueNumerique)->exists());
                
                // recuperer le debut de l'anne scolaire en cours et forme l'annee scolaire en cours

                $infoParamContrat = Paramcontrat::first();
                $debutAnneeEnCours = $infoParamContrat->anneencours_paramcontrat;
                $anneeSuivante = $debutAnneeEnCours + 1;
                $anneeScolaireEnCours = $debutAnneeEnCours.'-'.$anneeSuivante;
                // dd($annneScolaireEnCours);

                // Trouver la dernière référence pour l'année scolaire en cours
                $derniereReference = DB::table('paiementcontrat')
                ->where('reference_paiementcontrat', 'like', '%/'.$anneeScolaireEnCours)
                ->orderBy('id_paiementcontrat', 'desc')
                ->value('reference_paiementcontrat');

                // Extraire et incrémenter la partie numérique
                if ($derniereReference) {
                $numeroActuel = (int) explode('/', $derniereReference)[0];
                $nouveauNumero = $numeroActuel + 1;
                } else {
                $nouveauNumero = 1; // Commencer à 1 si aucune référence n'existe pour cette année
                }

                // Générer la nouvelle référence
                $nouvelleReference = str_pad($nouveauNumero, 7, '0', STR_PAD_LEFT) . '/' . $anneeScolaireEnCours;

                // dd($nouvelleReference);




                // recuperer les nom des mois cochee

                // Array des noms des mois
                $nomsMoisCoches = [];
                if (is_array($moisCoches)) {

                    // Parcourir les ID des mois cochés et obtenir leur nom correspondant
                    foreach ($moisCoches as $id_moiscontrat) {
                        // Ici, vous pouvez récupérer le nom du mois à partir de votre modèle Mois
                        $mois = Moiscontrat::where('id_moiscontrat', $id_moiscontrat)->first();
                        
                        // Vérifiez si le mois existe
                        if ($mois) {
                            // Ajouter le nom du mois à l'array
                            $nomsMoisCoches[] = $mois->nom_moiscontrat;
                        }
                    }
                }
                // Convertir le tableau en une chaîne de caractères
                $moisConcatenes = implode(',', $nomsMoisCoches);
                // dd($moisConcatenes);
                // Récupérer la somme des montants de paiement précédents
                $soldeavant_paiementcontrat = DB::table('paiementglobalcontrat')
                ->where('id_contrat', $idcontratEleve)
                ->sum('montant_paiementcontrat');

                // dd($soldeavant_paiementcontrat);
                // Calculer le solde après le paiement en ajoutant le montant du paiement actuel à la somme des montants précédents
                $soldeapres_paiementcontrat = $soldeavant_paiementcontrat + $montanttotal;
                // dd($soldeapres_paiementcontrat);




                



        // echo('paiement effectuer avec succes');



        // GESTION DE LA FACTURE NORMALISE

    $matriculeeleve = Session::get('matricule');
    $nomeleve = Eleve::where('MATRICULE', $matriculeeleve)->value('NOM');
    $prenomeleve = Eleve::where('MATRICULE', $matriculeeleve)->value('PRENOM');
    $classeeleve = Eleve::where('MATRICULE', $matriculeeleve)->value('CODECLAS');
    $nomcompleteleve = $nomeleve .' '. $prenomeleve;

    $parametrefacture = Params2::first();
    $ifuentreprise = $parametrefacture->ifu;
    $tokenentreprise = $parametrefacture->token;
    $taxe = $parametrefacture->taxe;
    $type = $parametrefacture->typefacture;

    $parametreetab = Params2::first();
    // $nometab = $parametreetab->NOMETAB;
    // $villeetab = $parametreetab->VILLE;

    


    // dd($classeeleve);

    $infocontrateleve = Paiementglobalcontrat::where('id_contrat', $idcontratEleve)
    ->orderBy('id_paiementcontrat', 'desc')->first();

    // $toutmoiscontrat = $infocontrateleve->mois_paiementcontrat;
    $moisavecvirg = implode(',', $nomsMoisCoches);
    $toutmoiscontrat = $moisavecvirg;


    // dd($toutmoiscontrat);


    // $invoiceItems = 
    //      [
    //         [
    //                 // 'date' => $infocontrateleve->date_paiementcontrat,
    //                 // 'montantpaiement' => intval($infocontrateleve->montant_paiementcontrat), // Convertir le prix en entier
    //                 // 'mois' => $infocontrateleve->mois_paiementcontrat,
    //                 // 'eleve' => $nomcompleteleve,
    //                 // 'classe' => $classeeleve,
    //                 // 'taxGroup' => 'B', // La taxe reste la même, adaptez si nécessaire

    //                 'name' => 'contrat de cantine',
    //                 // 'price' => intval($infocontrateleve->montant_paiementcontrat),
    //                 'price' => intval($montanttotal), 
    //                 'quantity' => 1,
    //                 'taxGroup' => $taxe, // La taxe reste la même, adaptez si nécessaire
    //         ]
    //             ];
        
        
            
    //         $invoiceRequestDto = [
    //             "ifu" => $ifuentreprise, // ici on doit rendre la valeur de l'ifu dynamique
    //             "type" => $type,
    //             "items" => $invoiceItems,
    //             "operator" => [
    //                 // "name" => $nomecole
    //                 "name" => "test"
    //             ]
    //         ];
    
    //         // dd($invoiceRequestDto);
    
    //         $jsonData = json_encode($invoiceRequestDto, JSON_UNESCAPED_UNICODE);

        
                    // -------------------------------
                        //  CREATION DE LA FACTURE
                    // -------------------------------
    
            // Préparez les données JSON pour l'API
            $jsonData = json_encode([
                "ifu" => $ifuentreprise, // ici on doit rendre la valeur de l'ifu dynamique
                // "aib" => "A",
                "type" => $type,
                "items" => [
                    [
                        'name' => 'Frais cantine pour :'.$toutmoiscontrat,
                        // 'price' => intval($infocontrateleve->montant_paiementcontrat),
                        'price' => intval($montanttotal), 
                        'quantity' => 1,
                        'taxGroup' => $taxe,
                    ]
                ],
                "client" => [
                    // "ifu" => "string",
                    "name"=>  $nomcompleteleve,
                    // "contact" => "string",
                    // "address"=> "string"
                ],
                "operator" => [
                    "name" => "test"
                ],
                "payment" => [
                    [
                    "name" => "ESPECES",
                    //   "amount": 0
                    ]
                  ],
            ]);
            // $jsonDataliste = json_encode($jsonData, JSON_FORCE_OBJECT);


            // dd($jsonData);
    
            // Définissez l'URL de l'API de facturation
            $apiUrl = 'https://developper.impots.bj/sygmef-emcf/api/invoice';
    
            // Définissez le jeton d'authentification
            $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6IjAyMDIzODU5MTExMzh8VFMwMTAxMTQ3MiIsInJvbGUiOiJUYXhwYXllciIsIm5iZiI6MTcyNDI1NzQyMywiZXhwIjoxNzM3NDE0MDAwLCJpYXQiOjE3MjQyNTc0MjMsImlzcyI6ImltcG90cy5iaiIsImF1ZCI6ImltcG90cy5iaiJ9.sRcSeEbIuQNSgFebRRaxW4zPLCqlF6PQXc90e2xfHCs';
            // $token = $tokenentreprise;
    
            // Effectuez la requête POST à l'API
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
            ));
            curl_setopt($ch, CURLOPT_CAINFO, storage_path('certificates/cacert.pem'));
    
            // Exécutez la requête cURL et récupérez la réponse
    $response = curl_exec($ch);
    // dd($response);
    
    // Vérifiez les erreurs de cURL
    if (curl_errno($ch)) {
        // echo 'Erreur cURL : ' . curl_error($ch);
        return back()->with('erreur','Erreur curl , mauvaise connexion a l\'API');
    }
    
    // Fermez la session cURL
    curl_close($ch);
    
    // Affichez la réponse de l'API
    $decodedResponse = json_decode($response, true);
    // dd($decodedResponse);
    
    // Vérifiez si l'UID est présent dans la réponse
    if (isset($decodedResponse['uid'])) {
        // L'UID de la demande
        $uid = $decodedResponse['uid'];
        // $taxb = 0.18;
    
        // Affichez l'UID
        // echo "L'UID de la demande est : $uid";

        
                // -------------------------------
                    //  RECUPERATION DE LA FACTURE PAR SON UID
                // -------------------------------

            // Définissez l'URL de l'API de confirmation de facture
            $recuperationUrl = 'https://developper.impots.bj/sygmef-emcf/api/invoice/'.$uid;
    
            // Configuration de la requête cURL pour la confirmation
            $chRecuperation = curl_init($recuperationUrl);
            curl_setopt($chRecuperation, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chRecuperation, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($chRecuperation, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
                'Content-Length: 0'
            ]);
            curl_setopt($chRecuperation, CURLOPT_CAINFO, storage_path('certificates/cacert.pem'));

            // Exécutez la requête cURL pour la confirmation
            $responseRecuperation = curl_exec($chRecuperation);
            // dd($responseConfirmation);
            // Vérifiez les erreurs de cURL pour la confirmation


            // Fermez la session cURL pour la confirmation
            curl_close($chRecuperation);

        // Convertissez la réponse JSON en tableau associatif PHP
        $decodedDonneFacture = json_decode($responseRecuperation, true);
        // dd($decodedDonneFacture);

        $facturedetaille = json_decode($jsonData, true);
        $ifuEcoleFacture = $decodedDonneFacture['ifu'];
        $itemFacture = $decodedDonneFacture['items'];
        $doneeDetailleItemFacture = $itemFacture['0'];
        $nameItemFacture = $doneeDetailleItemFacture['name'];
        $prixTotalItemFacture = $doneeDetailleItemFacture['price'];
        $quantityItemFacture = $doneeDetailleItemFacture['quantity'];
        $taxGroupItemFacture = $doneeDetailleItemFacture['taxGroup'];
        // $idd = $responseRecuperation.ifu;
        $nameClient = $decodedDonneFacture['client']['name'];
        // dd($prixTotalItemFacture);

    
                // -------------------------------
                    //  CONFIRMATION DE LA FACTURE 
                // -------------------------------

        // ACTION pour la confirmation
        $actionConfirmation = 'confirm';
    
        // Définissez l'URL de l'API de confirmation de facture
        $confirmationUrl = 'https://developper.impots.bj/sygmef-emcf/api/invoice/'.$uid.'/'.$actionConfirmation;
    
        // Configuration de la requête cURL pour la confirmation
        $chConfirmation = curl_init($confirmationUrl);
        curl_setopt($chConfirmation, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chConfirmation, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($chConfirmation, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Length: 0'
        ]);
        curl_setopt($chConfirmation, CURLOPT_CAINFO, storage_path('certificates/cacert.pem'));
    
        // Exécutez la requête cURL pour la confirmation
        $responseConfirmation = curl_exec($chConfirmation);
    
        // Vérifiez les erreurs de cURL pour la confirmation
        if (curl_errno($chConfirmation)) {
            // echo 'Erreur cURL pour la confirmation : ' . curl_error($chConfirmation);/
            return redirect('classes')->with('erreur','Erreur curl pour la confirmation');

        }
    
        // Fermez la session cURL pour la confirmation
        curl_close($chConfirmation);
    
    // Convertissez la réponse JSON en tableau associatif PHP
    $decodedResponseConfirmation = json_decode($responseConfirmation, true);
    // dd($decodedResponseConfirmation);
    
    
        $codemecef = $decodedResponseConfirmation['codeMECeFDGI'];

        $counters = $decodedResponseConfirmation['counters'];

        $nim = $decodedResponseConfirmation['nim'];

        $dateTime = $decodedResponseConfirmation['dateTime'];

        // dd($decodedResponseConfirmation);

        // Générer le code QR
        $qrCodeString = $decodedResponseConfirmation['qrCode'];

        $reffactures = $nim.'-'.$counters;

        $reffacture = explode('/', $reffactures)[0];

        // $reffactures = rtrim($reffacture, " FV");

        // dd($reffactures);
        // $reffacture = $nim.'_'.$counters;





                // Effectuer lrs enregistrement dans les tables inscriptioncontrat, paiementglobalcontrat et paiementcontrat ici pour etre sur que c'est apres que tout soit bien passe que les enregistrement dans ces tables sont effectue
        
                // ENREGISTREMENT DANS LA TABLE INSCRIPTIONCONTRAT
                // Parcourir les mois cochés et insérer chaque id de mois dans la table Inscriptioncontrat
                foreach ($moisCoches as $id_moiscontrat) {
                    Inscriptioncontrat::create([
                        'id_contrat' => $idcontratEleve, 
                        'id_moiscontrat' => $id_moiscontrat,
                        'anne_inscrption' => $anneeActuelle
                    ]);
                }




           

                // ENREGISTREMENT DANS LA TABLE PAIEMENTCONTRAT

                // dd($soldeavant_paiementcontrat);

                // dd($id_usercontrat);
                // Parcourir les mois cochés et insérer chaque id de mois dans la table Inscriptioncontrat
                foreach ($moisCoches as $id_moiscontrat) {

                    Paiementcontrat::create([
                        // 'id_paiementcontrat ' => $valeurDynamiqueidpaiemnetcontrat, 
                        'soldeavant_paiementcontrat' => $montantmoiscontrat,
                        'montant_paiementcontrat' => $montantmoiscontrat,
                        'soldeapres_paiementcontrat' => 0,
                        'id_contrat' => $idcontratEleve,
                        'date_paiementcontrat' => $datepaiementcontrat,
                        'id_usercontrat' => $id_usercontrat,
                        'mois_paiementcontrat' => $id_moiscontrat,
                        'anne_paiementcontrat' => $anneeActuelle,
                        'reference_paiementcontrat' => $nouvelleReference,
                        'statut_paiementcontrat' => 1,
                        // 'datesuppr_paiementcontrat' => $anneeActuelle,
                        // 'idsuppr_usercontrat' => $anneeActuelle,
                        // 'motifsuppr_paiementcontrat' => $anneeActuelle,
                        // 'id_paiementglobalcontrat' => 90,
                        'montanttotal' => $montanttotal,

                    ]);
                }


                // gestion du code qr sous forme d'image

                $fileNameqrcode = $nomcompleteleve . time() . '.png';
                $result = Builder::create()
                    ->writer(new PngWriter())
                    ->data($qrCodeString)
                    ->size(100)
                    // ->margin(10)
                    ->build();
        
                    $qrcodecontent = $result->getString();
        
                    $facturenormalise = new Facturenormalise();
                    $facturenormalise->id = $reffacture;
                    $facturenormalise->codemecef = $codemecef;
                    $facturenormalise->counters = $counters;
                    $facturenormalise->nim = $nim;
                    $facturenormalise->dateHeure = $dateTime;
                    $facturenormalise->ifuEcole = $ifuEcoleFacture;
                    $facturenormalise->MATRICULE = $matriculeeleve;
                    $facturenormalise->idcontrat = $idcontratEleve;
                    $facturenormalise->moispayes = $moisConcatenes;
                    $facturenormalise->classe = $classeeleve;
                    $facturenormalise->nom = $nameClient;
                    $facturenormalise->designation = $nameItemFacture;
                    $facturenormalise->montant_total = $prixTotalItemFacture;
                    $facturenormalise->datepaiementcontrat = $datepaiementcontrat;
                    $facturenormalise->qrcode = $qrcodecontent;
                    $facturenormalise->statut = 1;
        
                    $facturenormalise->save();



        $paramse = Params2::first(); 

        $logoUrl = $paramse ? $paramse->logoimage: null; 
    
        $NOMETAB = $paramse->NOMETAB;

    
            // $id = $fileNameqrcode;
            // $qrcodesin = Qrcode::find($id);
    
            // $qrcodecontent = $qrcodesin->qrcode;
    
        Session::put('factureconfirm', $decodedResponseConfirmation);
        Session::put('fileNameqrcode', $fileNameqrcode);
        Session::put('facturedetaille', $facturedetaille);
        Session::put('reffacture', $reffacture);
        Session::put('classeeleve', $classeeleve);
        Session::put('nomcompleteleve', $nomcompleteleve);
        Session::put('toutmoiscontrat', $toutmoiscontrat);
        Session::put('nameItemFacture', $nameItemFacture);
        Session::put('prixTotalItemFacture', $prixTotalItemFacture);
        Session::put('quantityItemFacture', $quantityItemFacture);
        Session::put('taxGroupItemFacture', $taxGroupItemFacture);
        Session::put('ifuEcoleFacture', $ifuEcoleFacture);
        Session::put('qrCodeString', $qrCodeString);
        Session::put('qrcodecontent', $qrcodecontent);
        Session::put('NOMETAB', $NOMETAB);
        Session::put('nim', $nim);
        Session::put('datepaiementcontrat', $datepaiementcontrat);
        // Session::put('nometab', $nometab);
        // Session::put('villeetab', $villeetab);



    
        return view('pages.Etats.pdffacture', [
            'factureconfirm' => $decodedResponseConfirmation,
            'fileNameqrcode' => $fileNameqrcode,
            'facturedetaille' => $facturedetaille,
            'reffacture' => $reffacture,
            'ifuEcoleFacture' => $ifuEcoleFacture,
            'nameItemFacture' => $nameItemFacture,
            'prixTotalItemFacture' => $prixTotalItemFacture,
            'quantityItemFacture' => $quantityItemFacture,
            'taxGroupItemFacture' => $taxGroupItemFacture,
            'classeeleve' => $classeeleve,
            'nomcompleteleve' => $nomcompleteleve,
            'toutmoiscontrat' => $toutmoiscontrat,
            'qrCodeString' => $qrCodeString,
            'logoUrl' => $logoUrl,
            'qrcodecontent' => $qrcodecontent,
            'NOMETAB' => $NOMETAB,
            'nim' => $nim,
            'datepaiementcontrat' => $datepaiementcontrat,
            // 'villeetab' => $villeetab,
            // 'qrCodeImage' => $qrCodeImage,
    
                 ]);

                 
    
    
    
    }

    
}



        


        // debut facture normalisee pour tous les paiements de l'annee 2023_2024
        public function genererfacture() {
            // $paiements = DB::table('paiementcontrat')->where('montant_paiementcontrat', '>', 0)->get();
    
            $paiements = DB::table('paiementcontrat')
            ->select('id_contrat', 'mois_paiementcontrat', 'montant_paiementcontrat', 'date_paiementcontrat')
            ->where('montant_paiementcontrat', '>', 0)
            ->where('statut_paiementcontrat', 1)
            ->get()
            ->groupBy('id_contrat')
            ->map(function ($rows) {
                return [
                    'id_contrat' => $rows->first()->id_contrat,
                    'mois' => $rows->pluck('mois_paiementcontrat')->toArray(),
                    'montant_total' => $rows->sum('montant_paiementcontrat'),
                    // 'date_paiementcontrat' => $rows['date_paiementcontrat'],
                    'details' => $rows->map(function ($row) {
                        return [
                            'mois' => $row->mois_paiementcontrat,
                            'montant_paye' => $row->montant_paiementcontrat,
                            'date_paiementcontrat' => $row->date_paiementcontrat,
                        ];
                    })->toArray(),
                ];
            });
    
    
    
    
            foreach ($paiements as $paiement) {
    
                // dd($paiement['montant_total']);
    
                try {
                    set_time_limit(300); // Augmente le temps d'exécution à 300 secondes (5 minutes)
                    // Appeler la fonction de création de facture normalisée
                    $facture = $this->savepaiementcontrat2($paiement);
    
                    // // Enregistrer la facture dans la base de données
                    // DB::table('factures')->insert([
                    //     'id_paiement' => $paiement->id,
                    //     'facture_data' => json_encode($facture),
                    //     'created_at' => now(),
                    //     'updated_at' => now(),
                    // ]);
    
                    Log::info("Facture générée avec succès pour le paiement ID: " );
    
                } catch (\Exception $e) {
                    // Gérer les erreurs de génération de facture
                    Log::error("Erreur lors de la génération de la facture pour le paiement ID: " );
                }
            }
    
         return response()->json(['message' => 'Factures générées avec succès.']);
        }
        
    
    
    
        private function savepaiementcontrat2($paiement){
            $idcontratEleve = $paiement['id_contrat'];
            // $moiscont =  DB::table('paiementcontrat')->where('id_contrat', $idcontratEleve)->pluck('mois_paiementcontrat');
            // dd($moiscont);
    
            $moisCoches = $paiement['mois'];
            
    
            // $nombreElements = $moiscont->count();
            $montantmoiscontrat = $paiement['montant_total'];
            
            $montanttotal = $paiement['montant_total'];
            $datepaiementcontrat = date('Y-m-d H:i:s');
            $id_usercontrat = Session::get('id_usercontrat');
            // dd($datepaiementcontrat);
            // dd($id_usercontrat);
            $anneeActuelle = date('Y');
    
           
            
    
    
            // recuperer les nom des mois cochee
    
            // Array des noms des mois
            $nomsMoisCoches = [];
            if (is_array($moisCoches)) {
                // Parcourir les ID des mois cochés et obtenir leur nom correspondant
                foreach ($moisCoches as $id_moiscontrat) {
                    // Ici, vous pouvez récupérer le nom du mois à partir de votre modèle Mois
                    $mois = Moiscontrat::where('id_moiscontrat', $id_moiscontrat)->first();
    
                    // Vérifiez si le mois existe
                    if ($mois) {
                        // Ajouter le nom du mois à l'array
                        $nomsMoisCoches[] = $mois->nom_moiscontrat;
                    }
                }
    
            }
            // Convertir le tableau en une chaîne de caractères
            $moisConcatenes = implode(',', $nomsMoisCoches);
    
    
                        // GESTION DE LA FACTURE NORMALISE
    
                    $matriculeeleve = Contrat::where('id_contrat', $idcontratEleve)->value('eleve_contrat');
                    $nomeleve = Eleve::where('MATRICULE', $matriculeeleve)->value('NOM');
                    $prenomeleve = Eleve::where('MATRICULE', $matriculeeleve)->value('PRENOM');
                    $classeeleve = Eleve::where('MATRICULE', $matriculeeleve)->value('CODECLAS');
                    $nomcompleteleve = $nomeleve .' '. $prenomeleve;
    
                    $parametrefacture = Params2::first();
                    $ifuentreprise = $parametrefacture->ifu;
                    $tokenentreprise = $parametrefacture->token;
                    $taxe = $parametrefacture->taxe;
                    $type = $parametrefacture->typefacture;
                    // dd($ifuentreprise);
                    $parametreetab = Params2::first();
                    // $nometab = $parametreetab->NOMETAB;
                    // $villeetab = $parametreetab->VILLE;
    
    
    
    
                    // -------------------------------
                        //  CREATION DE LA FACTURE
                    // -------------------------------
    
                        // Préparez les données JSON pour l'API
                            $jsonData = json_encode([
                                "ifu" => $ifuentreprise, // ici on doit rendre la valeur de l'ifu dynamique
                                // "aib" => "A",
                                "type" => $type,
                                "items" => [
                                    [
                                        'name' => 'Frais cantine pour :'.$moisConcatenes,
                                        // 'price' => intval($infocontrateleve->montant_paiementcontrat),
                                        'price' => intval($montanttotal), 
                                        'quantity' => 1,
                                        'taxGroup' => $taxe,
                                    ]
                                ],
                                "client" => [
                                    // "ifu" => "string",
                                    "name"=>  $nomcompleteleve,
                                    // "contact" => "string",
                                    // "address"=> "string"
                                ],
                                "operator" => [
                                    "name" => "test"
                                ],
                                "payment" => [
                                    [
                                    "name" => "ESPECES",
                                      "amount" => intval($montanttotal), 
                                    ]
                                  ],
                            ]);
                        // $jsonDataliste = json_encode($jsonData, JSON_FORCE_OBJECT);
    
    
                        //  dd($jsonData);
    
                        // Définissez l'URL de l'API de facturation
                        $apiUrl = 'https://developper.impots.bj/sygmef-emcf/api/invoice';
    
                        // Définissez le jeton d'authentification
                        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6IjAyMDIzODU5MTExMzh8VFMwMTAxMTQ3MiIsInJvbGUiOiJUYXhwYXllciIsIm5iZiI6MTcyNDI1NzQyMywiZXhwIjoxNzM3NDE0MDAwLCJpYXQiOjE3MjQyNTc0MjMsImlzcyI6ImltcG90cy5iaiIsImF1ZCI6ImltcG90cy5iaiJ9.sRcSeEbIuQNSgFebRRaxW4zPLCqlF6PQXc90e2xfHCs';
                        // $token = $tokenentreprise;
    
                        // Effectuez la requête POST à l'API
                        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        $ch = curl_init($apiUrl);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Content-Type: application/json',
                            'Authorization: Bearer ' . $token
                        ));
                        curl_setopt($ch, CURLOPT_CAINFO, storage_path('certificates/cacert.pem'));
    
                    // Exécutez la requête cURL et récupérez la réponse
            $response = curl_exec($ch);
            // dd($response);
    
            // Vérifiez les erreurs de cURL
            if (curl_errno($ch)) {
                // echo 'Erreur cURL : ' . curl_error($ch);
                return back()->with('erreur','Erreur curl , mauvaise connexion a l\'API');
            }

            // {
            //     "ifu": "string",
            //     "aib": "A",
            //     "type": "FV",
            //     "items": [
            //       {
            //         "code": "string",
            //         "name": "string",
            //         "price": 0,
            //         "quantity": 0,
            //         "taxGroup": "A",
            //         "taxSpecific": 0,
            //         "originalPrice": 0,
            //         "priceModification": "string"
            //       }
            //     ],
            //     "client": {
            //       "ifu": "string",
            //       "name": "string",
            //       "contact": "string",
            //       "address": "string"
            //     },
            //     "operator": {
            //       "id": "string",
            //       "name": "string"
            //     },
            //     "payment": [
            //       {
            //         "name": "ESPECES",
            //         "amount": 0
            //       }
            //     ],
            //     "reference": "string",
            //     "innat": "NA",
            //     "usconf": true
            //   }
    
            // Fermez la session cURL
            curl_close($ch);
    
            // Affichez la réponse de l'API
            $decodedResponse = json_decode($response, true);
            //  dd($decodedResponse);
    
            // Vérifiez si l'UID est présent dans la réponse
            if (isset($decodedResponse['uid'])) {
                // L'UID de la demande
                $uid = $decodedResponse['uid'];
                // $taxb = 0.18;
    
                // Affichez l'UID
                // echo "L'UID de la demande est : $uid";
    
               
    

                // -------------------------------
                    //  RECUPERATION DE LA FACTURE PAR SON UID
                // -------------------------------

                // Définissez l'URL de l'API de confirmation de facture
                $recuperationUrl = 'https://developper.impots.bj/sygmef-emcf/api/invoice/'.$uid;
    
                // Configuration de la requête cURL pour la confirmation
                $chRecuperation = curl_init($recuperationUrl);
                curl_setopt($chRecuperation, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($chRecuperation, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt($chRecuperation, CURLOPT_HTTPHEADER, [
                    'Authorization: Bearer ' . $token,
                    'Content-Length: 0'
                ]);
                curl_setopt($chRecuperation, CURLOPT_CAINFO, storage_path('certificates/cacert.pem'));
    
                // Exécutez la requête cURL pour la confirmation
                $responseRecuperation = curl_exec($chRecuperation);
                // dd($responseConfirmation);
                // Vérifiez les erreurs de cURL pour la confirmation

    
                // Fermez la session cURL pour la confirmation
                curl_close($chRecuperation);
    
            // Convertissez la réponse JSON en tableau associatif PHP
            $decodedDonneFacture = json_decode($responseRecuperation, true);
    
            // $facturedetaille = json_decode($jsonData, true);
            $ifuEcoleFacture = $decodedDonneFacture['ifu'];
            // dd($ifuEcoleFacture);
            $itemFacture = $decodedDonneFacture['items'];
            $doneeDetailleItemFacture = $itemFacture['0'];
            $nameItemFacture = $doneeDetailleItemFacture['name'];
            $prixTotalItemFacture = $doneeDetailleItemFacture['price'];
            $quantityItemFacture = $doneeDetailleItemFacture['quantity'];
            $taxGroupItemFacture = $doneeDetailleItemFacture['taxGroup'];
            // $idd = $responseRecuperation.ifu;
            $nameClient = $decodedDonneFacture['client']['name'];
            // dd($decodedDonneFacture);



                // -------------------------------
                    //  CONFIRMATION DE LA FACTURE 
                // -------------------------------

                 // ACTION pour la confirmation
                 $actionConfirmation = 'confirm';

                // Définissez l'URL de l'API de confirmation de facture
                $confirmationUrl = 'https://developper.impots.bj/sygmef-emcf/api/invoice/'.$uid.'/'.$actionConfirmation;
            
                // Configuration de la requête cURL pour la confirmation
                $chConfirmation = curl_init($confirmationUrl);
                curl_setopt($chConfirmation, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($chConfirmation, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($chConfirmation, CURLOPT_HTTPHEADER, [
                    'Authorization: Bearer ' . $token,
                    'Content-Length: 0'
                ]);
                curl_setopt($chConfirmation, CURLOPT_CAINFO, storage_path('certificates/cacert.pem'));
            
                // Exécutez la requête cURL pour la confirmation
                $responseConfirmation = curl_exec($chConfirmation);
            
            
                // Fermez la session cURL pour la confirmation
                curl_close($chConfirmation);
            
            // Convertissez la réponse JSON en tableau associatif PHP
            $decodedResponseConfirmation = json_decode($responseConfirmation, true);
            // dd($decodedResponseConfirmation);

    
                $codemecef = $decodedResponseConfirmation['codeMECeFDGI'];
    
                $counters = $decodedResponseConfirmation['counters'];
    
                $nim = $decodedResponseConfirmation['nim'];
    
                $dateTime = $decodedResponseConfirmation['dateTime'];
    
    
                // Générer le code QR
                $qrCodeString = $decodedResponseConfirmation['qrCode'];
    
                $reffactures = $nim.'-'.$counters;
                // explode('/', $chaine)[0]

                $reffacture = explode('/', $reffactures)[0];
    
                // dd($reffacture);

            // gestion du code qr sous forme d'image
    
            // $fileNameqrcode = $nomcompleteleve . time() . '.png';
            $result = Builder::create()
                ->writer(new PngWriter())
                ->data($qrCodeString)
                ->size(100)
                // ->margin(10)
                ->build();
    
                $qrcodecontent = $result->getString();
    
                // dd($qrcodecontent);

            // ENREGISTREMENT DE LA FACTURE
            $facturenormalise = new Facturenormalise();
            $facturenormalise->id = $reffacture;
            $facturenormalise->codemecef = $codemecef;
            $facturenormalise->counters = $counters;
            $facturenormalise->nim = $nim;
            $facturenormalise->dateHeure = $dateTime;
            $facturenormalise->ifuEcole = $ifuEcoleFacture;
            $facturenormalise->MATRICULE = $matriculeeleve;
            $facturenormalise->idcontrat = $idcontratEleve;
            $facturenormalise->moispayes = $moisConcatenes;
            $facturenormalise->classe = $classeeleve;
            $facturenormalise->nom = $nameClient;
            $facturenormalise->designation = $nameItemFacture;
            $facturenormalise->montant_total = $prixTotalItemFacture;
            $facturenormalise->datepaiementcontrat = $datepaiementcontrat;
            $facturenormalise->qrcode = $qrcodecontent;
            $facturenormalise->statut = 1;
        
            $facturenormalise->save();

    
             }
    
    
    
    
    }

    public function listefacture() {
        $factures = DB::table('facturenormalises')->where('statut', 1)->get();
        // dd($factures);
        return view('pages.Etats.listefacture')->with('factures', $factures);
    }

    public function avoirfacture($codemecef){

        $factureoriginale = DB::table('facturenormalises')->where('codemecef', $codemecef)->first();
        $ifuentreprise = $factureoriginale->ifuEcole;
        $montanttotal = $factureoriginale->montant_total;
        $nomcompleteleve = $factureoriginale->nom;
        $moisConcatenes = $factureoriginale->moispayes;
        $matriculeeleve = $factureoriginale->MATRICULE;
        $idcontratEleve = $factureoriginale->idcontrat;
        $classeeleve = $factureoriginale->classe;
        $datepaiementcontrat = $factureoriginale->datepaiementcontrat;
        // dd($ifuentreprise);
                    // -------------------------------
                        //  CREATION DE LA FACTURE
                    // -------------------------------
    
                        // Préparez les données JSON pour l'API
                        $jsonData = json_encode([
                            "ifu" => $ifuentreprise, // ici on doit rendre la valeur de l'ifu dynamique
                            // "aib" => "A",
                            "type" => 'FA',
                            "items" => [
                                [
                                    'name' => 'Frais cantine pour :'.$moisConcatenes,
                                    // 'price' => intval($infocontrateleve->montant_paiementcontrat),
                                    'price' => intval($montanttotal), 
                                    'quantity' => 1,
                                    'taxGroup' => 'D',
                                ]
                            ],
                            "client" => [
                                // "ifu" => "string",
                                "name"=>  $nomcompleteleve,
                                // "contact" => "string",
                                // "address"=> "string"
                            ],
                            "operator" => [
                                "name" => "test"
                            ],
                            "payment" => [
                                [
                                "name" => "ESPECES",
                                  "amount" => intval($montanttotal), 
                                ]
                              ],
                              "reference" => $codemecef,
                        ]);
                    // $jsonDataliste = json_encode($jsonData, JSON_FORCE_OBJECT);


                    //  dd($jsonData);

                    // Définissez l'URL de l'API de facturation
                    $apiUrl = 'https://developper.impots.bj/sygmef-emcf/api/invoice';

                    // Définissez le jeton d'authentification
                    $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6IjAyMDIzODU5MTExMzh8VFMwMTAxMTQ3MiIsInJvbGUiOiJUYXhwYXllciIsIm5iZiI6MTcyNDI1NzQyMywiZXhwIjoxNzM3NDE0MDAwLCJpYXQiOjE3MjQyNTc0MjMsImlzcyI6ImltcG90cy5iaiIsImF1ZCI6ImltcG90cy5iaiJ9.sRcSeEbIuQNSgFebRRaxW4zPLCqlF6PQXc90e2xfHCs';
                    // $token = $tokenentreprise;

                    // Effectuez la requête POST à l'API
                    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $ch = curl_init($apiUrl);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . $token
                    ));
                    curl_setopt($ch, CURLOPT_CAINFO, storage_path('certificates/cacert.pem'));

                // Exécutez la requête cURL et récupérez la réponse
        $response = curl_exec($ch);
        // dd($response);

        $decodedResponse = json_decode($response, true);

            // Vérifiez si l'UID est présent dans la réponse
            if (isset($decodedResponse['uid'])) {
                // L'UID de la demande
                $uid = $decodedResponse['uid'];
                // $taxb = 0.18;

                                // -------------------------------
                    //  RECUPERATION DE LA FACTURE PAR SON UID
                // -------------------------------

                // Définissez l'URL de l'API de confirmation de facture
                $recuperationUrl = 'https://developper.impots.bj/sygmef-emcf/api/invoice/'.$uid;
    
                // Configuration de la requête cURL pour la confirmation
                $chRecuperation = curl_init($recuperationUrl);
                curl_setopt($chRecuperation, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($chRecuperation, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt($chRecuperation, CURLOPT_HTTPHEADER, [
                    'Authorization: Bearer ' . $token,
                    'Content-Length: 0'
                ]);
                curl_setopt($chRecuperation, CURLOPT_CAINFO, storage_path('certificates/cacert.pem'));
    
                // Exécutez la requête cURL pour la confirmation
                $responseRecuperation = curl_exec($chRecuperation);
                // dd($responseConfirmation);
                // Vérifiez les erreurs de cURL pour la confirmation

    
                // Fermez la session cURL pour la confirmation
                curl_close($chRecuperation);
    
            // Convertissez la réponse JSON en tableau associatif PHP
            $decodedDonneFacture = json_decode($responseRecuperation, true);
    
            // $facturedetaille = json_decode($jsonData, true);
            $ifuEcoleFacture = $decodedDonneFacture['ifu'];
            // dd($ifuEcoleFacture);
            $itemFacture = $decodedDonneFacture['items'];
            $doneeDetailleItemFacture = $itemFacture['0'];
            $nameItemFacture = $doneeDetailleItemFacture['name'];
            $prixTotalItemFacture = $doneeDetailleItemFacture['price'];
            $quantityItemFacture = $doneeDetailleItemFacture['quantity'];
            $taxGroupItemFacture = $doneeDetailleItemFacture['taxGroup'];
            // $idd = $responseRecuperation.ifu;
            $nameClient = $decodedDonneFacture['client']['name'];
            // dd($decodedDonneFacture);

             // -------------------------------
                    //  CONFIRMATION DE LA FACTURE 
                // -------------------------------

                 // ACTION pour la confirmation
                 $actionConfirmation = 'confirm';

                // Définissez l'URL de l'API de confirmation de facture
                $confirmationUrl = 'https://developper.impots.bj/sygmef-emcf/api/invoice/'.$uid.'/'.$actionConfirmation;
            
                // Configuration de la requête cURL pour la confirmation
                $chConfirmation = curl_init($confirmationUrl);
                curl_setopt($chConfirmation, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($chConfirmation, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($chConfirmation, CURLOPT_HTTPHEADER, [
                    'Authorization: Bearer ' . $token,
                    'Content-Length: 0'
                ]);
                curl_setopt($chConfirmation, CURLOPT_CAINFO, storage_path('certificates/cacert.pem'));
            
                // Exécutez la requête cURL pour la confirmation
                $responseConfirmation = curl_exec($chConfirmation);
            
            
                // Fermez la session cURL pour la confirmation
                curl_close($chConfirmation);
            
            // Convertissez la réponse JSON en tableau associatif PHP
            $decodedResponseConfirmation = json_decode($responseConfirmation, true);
            // dd($decodedResponseConfirmation);

    
                $codemecefavoir = $decodedResponseConfirmation['codeMECeFDGI'];
    
                $counters = $decodedResponseConfirmation['counters'];
    
                $nim = $decodedResponseConfirmation['nim'];
    
                $dateTime = $decodedResponseConfirmation['dateTime'];
    
                      // Générer le code QR
                      $qrCodeString = $decodedResponseConfirmation['qrCode'];
    
                      $reffactures = $nim.'-'.$counters;

                      $reffacture = explode('/', $reffactures)[0];

                      
          
                      // dd($reffacture);
      
                  // gestion du code qr sous forme d'image
          
                  // $fileNameqrcode = $nomcompleteleve . time() . '.png';
                  $result = Builder::create()
                      ->writer(new PngWriter())
                      ->data($qrCodeString)
                      ->size(100)
                      // ->margin(10)
                      ->build();
          
                      $qrcodecontent = $result->getString();
          
     // ENREGISTREMENT DE LA FACTURE
     $facturenormalise = new Facturenormalise();
     $facturenormalise->id = $reffacture;
     $facturenormalise->codemecef = $codemecefavoir;
     $facturenormalise->codemeceffacoriginale = $codemecef;
     $facturenormalise->counters = $counters;
     $facturenormalise->nim = $nim;
     $facturenormalise->dateHeure = $dateTime;
     $facturenormalise->ifuEcole = $ifuEcoleFacture;
     $facturenormalise->MATRICULE = $matriculeeleve;
     $facturenormalise->idcontrat = $idcontratEleve;
     $facturenormalise->moispayes = $moisConcatenes;
     $facturenormalise->classe = $classeeleve;
     $facturenormalise->nom = $nameClient;
     $facturenormalise->designation = $nameItemFacture;
     $facturenormalise->montant_total = $prixTotalItemFacture;
     $facturenormalise->datepaiementcontrat = $datepaiementcontrat;
     $facturenormalise->qrcode = $qrcodecontent;
     $facturenormalise->statut = 0;
 
     $facturenormalise->save();

     


return back()->with('status', "Facture d'avoir generer avec succes");

 
        }
        
    }


public function factures() {
    $paramse = Params2::first(); 

    $logoUrl = $paramse ? $paramse->logoimage: null; 

    $NOMETAB = $paramse->NOMETAB;
    $factures = DB::table('facturenormalises')->get();

    // dd($facturesParEleve);

    // $facturesParEleve = DB::table('facturenormalises')
    // ->orderBy('MATRICULE')
    // ->get()
    // ->groupBy('MATRICULE');
    // dd($facturesParEleve);

    return view('pages.Etats.fact', compact('factures', 'logoUrl', 'NOMETAB'));

}

public function show($id)
{
    $paramse = Params2::first(); 
    // dd($id);
    $logoUrl = $paramse ? $paramse->logoimage: null;
    $NOMETAB = $paramse->NOMETAB;
 
    // Récupérer toutes les factures pour un élève spécifique
    $facture = DB::table('facturenormalises')->where('idcontrat', $id)->first();
    // dd($factures->id);

    // Passer les données à la vue
    return view('pages.Etats.show', compact('facture', 'logoUrl', 'NOMETAB'));
}
        // fin facture normalisee pour tous les paiements de l'annee 2023_2024



    public function telechargerfacture() {
        $decodedResponseConfirmation = Session::get('factureconfirm');
        $facturedetaille = Session::get('facturedetaille');
        $reffacture = Session::get('reffacture');
        $classeeleve = Session::get('classeeleve');
        $nomcompleteleve = Session::get('nomcompleteleve');
        $toutmoiscontrat = Session::get('toutmoiscontrat');
        $qrCodeString = Session::get('qrCodeString');
        $qrcodecontent = Session::get('qrcodecontent');
        $fileNameqrcode = Session::get('fileNameqrcode');
        // $reffacture = Session::get('reffacture');

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pages.facture', [
                'factureconfirm' => $decodedResponseConfirmation,
                'fileNameqrcode' => $fileNameqrcode,
                'facturedetaille' => $facturedetaille, 
                'reffacture' => $reffacture,
                'classeeleve' => $classeeleve,
                'nomcompleteleve' => $nomcompleteleve,
                'toutmoiscontrat' => $toutmoiscontrat,
                'qrCodeString' => $qrCodeString,
                'qrcodecontent' => $qrcodecontent,
            ]);        
            return $pdf->download('facture.pdf');
        // return view('Essai.mercccii');
    }

    public function facturenormalise(Request $request) {
        $decodedResponseConfirmation = Session::get('factureconfirm');
        $facturedetaille = Session::get('facturedetaille');
        $reffacture = Session::get('reffacture');
        $classeeleve = Session::get('classeeleve');
        $nomcompleteleve = Session::get('nomcompleteleve');
        $toutmoiscontrat = Session::get('toutmoiscontrat');
        $nameItemFacture = Session::get('nameItemFacture');
        $prixTotalItemFacture = Session::get('prixTotalItemFacture');
        $quantityItemFacture = Session::get('quantityItemFacture');
        $taxGroupItemFacture = Session::get('taxGroupItemFacture');
        $ifuEcoleFacture = Session::get('ifuEcoleFacture');
        $qrCodeString = Session::get('qrCodeString');
        $fileNameqrcode = Session::get('fileNameqrcode');
        $qrcodecontent = Session::get('qrcodecontent');
        $fileNameqrcode = Session::get('fileNameqrcode');
        $nim = Session::get('nim');
        $datepaiementcontrat = Session::get('datepaiementcontrat');

        $paramse = Params2::first(); 

        $logoUrl = $paramse ? $paramse->logoimage: null;
        $NOMETAB = $paramse->NOMETAB; 
        // dd($NOMETAB);
        // $villeetab = Session::get('villeetab');
        // $nometab = Session::get('nometab');


                    // // Générer le PDF

                    // $data = [
                    //     'decodedResponseConfirmation' => $decodedResponseConfirmation,
                    //     'facturedetaille' => $facturedetaille,
                    //     'reffacture' => $reffacture,
                    //     'classeeleve' => $classeeleve,
                    //     'nomcompleteleve' => $nomcompleteleve,
                    //     'toutmoiscontrat' => $toutmoiscontrat,
                    //     'qrCodeString' => $qrCodeString,
                    //     'fileNameqrcode' => $fileNameqrcode,
                    //     'logoUrl' => $logoUrl,
                    //     'qrcodecontent' => $qrcodecontent,
                    // ];

                    // $datepaiement = $decodedResponseConfirmation['dateTime'];
                    // // dd($datepaiement);
                
                    // // Spécifiez le nom du fichier avec un timestamp pour garantir l'unicité
                    // $fileName = $nomcompleteleve . time() . '.pdf';
                
                    // // Spécifiez le chemin complet vers le sous-dossier pdfs dans public
                    // $filePaths = public_path('pdfs/' . $fileName);
                
                    // // Assurez-vous que le répertoire pdfs existe, sinon créez-le
                    // if (!file_exists(public_path('pdfs'))) {
                    //     mkdir(public_path('pdfs'), 0755, true);
                    // }
                
                    // Générer et enregistrer le PDF dans le sous-dossier pdfs
                    // $pdf = PDF::loadView('pages.Etats.essaipdf', $data);
                    // $pdfcontent = $pdf->output();
                
                
                    //    // Enregistrer le chemin du PDF dans la base de données
                    //                 $duplicatafacture = new Duplicatafacture();
                    //                 $duplicatafacture->url = $pdfcontent;
                    //                 $duplicatafacture->nomeleve = $nomcompleteleve;
                    //                 $duplicatafacture->classe = $classeeleve;
                    //                 $duplicatafacture->reference = 'Facture de paiement';
                    //                 $duplicatafacture->datepaiement = $datepaiement;
                    //                 $duplicatafacture->save();


// dd($fileName);
        return view('pages.Etats.facturenormalise',  [
            'factureconfirm' => $decodedResponseConfirmation,
            'facturedetaille' => $facturedetaille, 
            'reffacture' => $reffacture,
            'classeeleve' => $classeeleve,
            'nomcompleteleve' => $nomcompleteleve,
            'toutmoiscontrat' => $toutmoiscontrat,
            'prixTotalItemFacture' => $prixTotalItemFacture,
            'quantityItemFacture' => $quantityItemFacture,
            'nameItemFacture' => $nameItemFacture,
            'taxGroupItemFacture' => $taxGroupItemFacture,
            'ifuEcoleFacture' => $ifuEcoleFacture,
            'qrCodeString' => $qrCodeString,
            'logoUrl' => $logoUrl,
            'NOMETAB' => $NOMETAB,
            'fileNameqrcode' => $fileNameqrcode,
            'qrcodecontent' => $qrcodecontent,
            'nim' => $nim,
            'datepaiementcontrat' => $datepaiementcontrat,

            // 'nometab' => $nometab,
            // 'villeetab' => $villeetab,
        ]);        
    }


    public function duplicatainscription() {
        $amount = Session::get('amount');
        $classe = Session::get('classe');
        $logoUrl = Session::get('logoUrl');
        $dateContrat = Session::get('dateContrat');
        $elevyo = Session::get('elevyo');
        $nometab = Session::get('nometab');
        $ifu = Session::get('ifu');

        // dd($nometab);


        $data = [
            'amount' => $amount,
            'classe' => $classe,
            'logoUrl' => $logoUrl,
            'dateContrat' => $dateContrat,
            'elevyo' => $elevyo,
        ];

       
    
        // Spécifiez le nom du fichier avec un timestamp pour garantir l'unicité
        $fileName = $elevyo . time() . '.pdf';
    
        // Spécifiez le chemin complet vers le sous-dossier pdfs dans public
        $filePaths = public_path('pdfs/' . $fileName);
    
        // Assurez-vous que le répertoire pdfs existe, sinon créez-le
        if (!file_exists(public_path('pdfs'))) {
            mkdir(public_path('pdfs'), 0755, true);
        }

                // Générer et enregistrer le PDF dans la base de donne
                // $pdfdupinscri = PDF::loadView('pages.Etats.doubleinscriptionpdf', $data);
                // $pdfcontentdupinscri = $pdfdupinscri->output();
    
        // Générer et enregistrer le PDF dans le sous-dossier pdfs
       // $pdf = PDF::loadView('pages.Etats.doubleinscriptionpdf', $data)->save($filePaths);
    
    
           // Enregistrer le chemin du PDF dans la base de données
                        // $duplicatafacture = new Duplicatafacture();
                        // $duplicatafacture->url = $pdfcontentdupinscri;
                        // $duplicatafacture->nomeleve = $elevyo;
                        // $duplicatafacture->classe = $classe;
                        // $duplicatafacture->reference = 'Facture d\'inscription';

                        // $duplicatafacture->datepaiement = $dateContrat;
                        // $duplicatafacture->save();
                        return view('pages.Etats.duplicatainscription', [
                            'amount' => $amount,
                            'classe' => $classe,
                            'logoUrl' => $logoUrl,
                            'dateContrat' => $dateContrat,
                            'elevyo' => $elevyo,
                            'nometab' => $nometab,
                            'ifu' => $ifu,
                
                        ]);  
        
    }


    public function doubleinscriptionpdf() {

        $amount = Session::get('amount');
        $classe = Session::get('classe');
        $dateContrat = Session::get('dateContrat');
        $elevyo = Session::get('elevyo');
    
        $paramse = Paramsfacture::first(); 
    
        $logoUrl = $paramse ? $paramse->logo: null; 
    }

public function essaipdf() {

    $decodedResponseConfirmation = Session::get('factureconfirm');
    $facturedetaille = Session::get('facturedetaille');
    $reffacture = Session::get('reffacture');
    $classeeleve = Session::get('classeeleve');
    $nomcompleteleve = Session::get('nomcompleteleve');
    $toutmoiscontrat = Session::get('toutmoiscontrat');
    $qrCodeString = Session::get('qrCodeString');

    $paramse = Paramsfacture::first(); 

    $logoUrl = $paramse ? $paramse->logo: null; 
}


public function etat() {
    $annees = Paramcontrat::distinct()->pluck('anneencours_paramcontrat'); 
    $classes = Classes::get();
    return view('pages.etat')->with('annee', $annees)->with('classe', $classes);
}

















































































































   

    // public function traiter(Request $request)
    // {
    //     // Récupérer l'ID de l'élève à partir de la requête
    //     $eleveNom = $request->input('eleveNom');
    //     dd($eleveNom);

    //     // Utiliser l'ID de l'élève pour effectuer des opérations dans votre contrôleur
    //     // Par exemple, charger les détails de l'élève à partir de la base de données
        
    //     // Retourner une réponse (si nécessaire)
    //     return response()->json(['message' => 'Informations de l\'élève traitées avec succès.']);
    // }
    // public function getElevesByClasse($CODECLAS) {
    //     $elevess = Eleve::where('CODECLAS', $CODECLAS)->get();
        
    //     // dd($elevess);// Récupérer les élèves de la classe sélectionnée en fonction de $codeClasse
    //     return view('pages.partial')->with('elevess', $elevess);
    //   }
 
    // public function creercontrat(Request $request){
    //     $matricules = $request->input('matricules');
    //     $existingContrat = Contrat::where('eleve_contrat', $matricules)->exists();
    //     if($existingContrat) {
    //         return back()->with('status', 'Un contrat existe déjà pour cet élève.');
    //     }
    //     $contra = new Contrat();
    //     $contra->eleve_contrat = $matricules;
    //     $contra->cout_contrat = $request->input('montant');

    //     $contra->datecreation_contrat = $request->input('date');
    //     $contra->save();
    
    //     return back()->with('status','Contrat enregistré avec succès');
    // }


    public function creercontrat(InscriptionCantineRequest $request){
        // Récupérer les informations de la requête

        // validation des donne 

           
            
                $data = $request->validated();
                // recuperer les donne entrer par l'utilisateur
                $classes = $request->input('classes');
                $eleveId = $request->input('matricules');
                $montant = $request->input('montant');
                $idUserContrat = $request->input('id_usercontrat');
                // $dateContrat = $request->input('date');
       
        // $dateContrat = $request->input('date');
        // Récupérer la date avec l'heure depuis la requête
        $dateContrt = $request->input('date');

        // Convertir en objet Carbon
        $dateContratt = Carbon::parse($dateContrt);

        // Formater la date pour l'affichage
        $dateContrat = $dateContratt->format('Y-m-d H:i:s');


        // Si la date n'est pas spécifiée, utiliser la date du jour
        if (empty($dateContrat)) {
            $dateContrat = date('Y-m-d H:i:s');
        }
        // Trouver l'élève en fonction de la classe (CODECLAS)
         $elevy = Eleve::where('MATRICULE', $eleveId)->get();
        
                // Si la date n'est pas spécifiée, utiliser la date du jour
                if (empty($dateContrat)) {
                    $dateContrat = date('Y-m-d');
                }
        
                // Trouver l'élève en fonction de la classe (CODECLAS)
                $elevy = Eleve::where('MATRICULE', $eleveId)->get();
                
                $nom = Eleve::where('MATRICULE', $eleveId)->value('NOM');
                $prenom = Eleve::where('MATRICULE', $eleveId)->value('PRENOM');
                $elevyo = $nom .' '. $prenom;



                if ($eleveId) {
                    // $eleveId = $eleve->MATRICULE;
        
                    // Chercher un contrat existant pour cet élève avec statut_contrat = 0
                    $contratExistant = Contrat::where('eleve_contrat', $eleveId)
                                               ->where('statut_contrat', 0)
                                               ->first();
        
                                               $paramse = Params2::first(); 
        
                                               $logoUrl = $paramse ? $paramse->logoimage: null; 
                                               $nometab = $paramse->NOMETAB; 
                                               $ifu = $paramse->ifu; 

                                            //    dd($ifu);
                    if ($contratExistant) {
                        // Mettre à jour le contrat existant
                        $contratExistant->cout_contrat = $montant;
                        $contratExistant->id_usercontrat = $idUserContrat;
                        $contratExistant->statut_contrat = 1;
                        $contratExistant->datecreation_contrat = $dateContrat;
                        $contratExistant->save();
                        Session::put('amount', $montant);
                        Session::put('classe', $classes);
                        Session::put('logoUrl', $logoUrl);
                        Session::put('dateContrat', $dateContrat);
                        Session::put('elevyo', $elevyo);
                        Session::put('nometab', $nometab);
                        Session::put('ifu', $ifu);
        
                        return view('pages.Etats.pdfinscription')
                        ->with('amount', $montant)
                        ->with('classe', $classes )
                        ->with('logoUrl', $logoUrl )
                        ->with('dateContrat', $dateContrat)
                        ->with('elevyo', $elevyo)
                        ->with('nometab', $nometab)
                        ->with('ifu', $ifu);
                        
                        return back()->with('status', 'Contrat mis à jour avec succès');
                    } else {
                        // Créer un nouveau contrat
                        $nouveauContrat = new Contrat();
                        $nouveauContrat->eleve_contrat = $eleveId;
                        $nouveauContrat->cout_contrat = $montant;
                        $nouveauContrat->id_usercontrat = $idUserContrat;
                        $nouveauContrat->statut_contrat = 1;
                        $nouveauContrat->datecreation_contrat = $dateContrat;
                        $nouveauContrat->save();
                        Session::put('amount', $montant);
                        Session::put('classe', $classes);
                        Session::put('logoUrl', $logoUrl);
                        Session::put('dateContrat', $dateContrat);
                        Session::put('elevyo', $elevyo);
                        Session::put('nometab', $nometab);
                        Session::put('ifu', $ifu);
                        return view('pages.Etats.pdfinscription')
                        ->with('amount', $montant)
                        ->with('classe', $classes )
                        ->with('logoUrl', $logoUrl )
                        ->with('dateContrat', $dateContrat)
                        ->with('nometab', $nometab)
                        ->with('ifu', $ifu)
                        ->with('elevyo', $elevyo);
                        return redirect()->back()->with('success', 'Élève ajouté avec succès');
                    }
                } else {
                    return redirect()->back()->with('errors', 'Élève non trouvé');
                    // return back()->with('errors', 'Élève non trouvé');
                }

            // }




         
        
    }
    
   


                
       
                
                public function pdffacture(){
                    return view('pages.pdffacture');
                }
                
    
                public function supprimercontrat($MATRICULE){

                        // $existingContrat = Contrat::where('eleve_contrat', $matricules)->exists();

                    $contratss = Contrat::where('eleve_contrat', $MATRICULE)->first();
                    if($contratss){

                        $idcontrat = $contratss['id_contrat'];
                        // dd($idcontrat);
                        // passage du statut a 0
                        $contratss->update(['statut_contrat' => 0]);


                        // suppression du contrat de la table paiementcontrat
                        
                        // $paiementcontrat = Paiementcontrat::where('id_contrat', $idcontrat)->get();
                        // // dd($paiementcontrat);
                        // // Vérifier si des enregistrements existent
                        // if ($paiementcontrat->count() > 0) {
                        //     // Parcourir chaque modèle et appeler delete() sur chaque modèle
                        //     foreach ($paiementcontrat as $paiement) {
                        //         $paiement->update(['statut_paiementcontrat' => 0]);
                        //     }
                        // }else{

                        //     return back()->with("status", "Le contrat n'existe pas,  veuiller d'abord le creer pour l'eleve");
                        // }


                        // suppression du contrat de la table inscriptioncontrat

                        // $inscriptioncontratspe = Inscriptioncontrat::where('id_contrat', $idcontrat)->get();
                        // // dd($paiementcontrat);
                        // // Vérifier si des enregistrements existent
                        // if ($inscriptioncontratspe->count() > 0) {
                        //     // Parcourir chaque modèle et appeler delete() sur chaque modèle
                        //     foreach ($inscriptioncontratspe as $paiementinscri) {
                        //         $paiementinscri->delete();
                        //     }
                        // }else{

                        //     return back()->with("status", "Le contrat n'existe pas,  veuiller d'abord le creer pour l'eleve");
                        // }


                        // suppression du contrat de la table paiementglobalcontrat

                        // $paiementglobal = Paiementglobalcontrat::where('id_contrat', $idcontrat)->get();
                        // // dd($paiementcontrat);
                        // // Vérifier si des enregistrements existent
                        // if ($paiementglobal->count() > 0) {
                        //     // Parcourir chaque modèle et appeler delete() sur chaque modèle
                        //     foreach ($paiementglobal as $paiementglob) {
                        //         $paiementglob->update(['statut_paiementcontrat' => 0]);
                        //     }
                        // }else{

                        //     return back()->with("status", "Le contrat n'existe pas,  veuiller d'abord le creer pour l'eleve");
                        // }

                        // $paiementcontrat->delete();
                        return back()->with("status", "Le contrat a ete supprimer avec succes");

                    }else{
                        return back()->with("status", "Le contrat n'existe pas,  veuiller d'abord le creer pour l'eleve");

                    }
                
            }
                

            public function traitementetatpaiement(Request $request){


                $debut = $request->input('debut');
                $fin = $request->input('fin');
            
                // Récupérer les paiements entre les dates spécifiées
                $paiements = Paiementcontrat::whereBetween('date_paiementcontrat', [$debut, $fin])->where('statut_paiementcontrat', '=', 1)->get();
            
                // Collection pour stocker les informations de paiement avec les noms d'élève
                $paiementsAvecEleves = collect([]);
            
                // dd($paiements);
                // Itérer sur chaque paiement
                foreach ($paiements as $paiement) {
                    if ($paiement->mois_paiementcontrat == 13 && $paiement->montant_paiementcontrat == 0) {
                        continue; // Saute cet enregistrement
                    }
                    // Récupérer l'id_contrat de ce paiement
                    $idContrat = $paiement->id_contrat;
            
                    // Récupérer le matricule de l'élève à partir de la table Contrat
                    $contrat = Contrat::find($idContrat);

                    if ($contrat) {
                        $matriculeEleve = $contrat->eleve_contrat;
                        $iduser = $contrat->id_usercontrat;

                        // dd($iduser);
                        // Récupérer le nom de l'élève à partir de la table Eleve
                        $eleve = Eleve::where('MATRICULE', $matriculeEleve)->first();
                        $users = User::where('id', '=', $iduser)->first();
                        // dd($users);

                        if ($eleve) {
                            $moisContrat = Moiscontrat::where('id_moiscontrat', $paiement->mois_paiementcontrat)->first();

                            // Chercher si cet élève a déjà des paiements enregistrés pour cette date et cette référence
                            $existingPaiementIndex = $paiementsAvecEleves->search(function ($item) use ($eleve, $paiement) {
                                return $item['nomcomplet_eleve'] === $eleve->NOM . ' ' . $eleve->PRENOM &&
                                       $item['date_paiement'] === $paiement->date_paiementcontrat;
                            });
            
                            if ($existingPaiementIndex !== false) {
 // Si un paiement existe déjà pour cet élève à cette date et cette référence, on met à jour les mois et la somme des montants
 $updatedPaiement = $paiementsAvecEleves->get($existingPaiementIndex);
 $updatedPaiement['mois'] .= ', ' . ($moisContrat ? $moisContrat->nom_moiscontrat : 'Mois inconnu');
 $updatedPaiement['montant'] += $paiement->montant_paiementcontrat;

 // Remplacer l'ancien élément avec l'élément mis à jour
 $paiementsAvecEleves->put($existingPaiementIndex, $updatedPaiement);
                            } else {
            
                            // Ajouter les informations de paiement avec le nom de l'élève à la collection
                            $paiementsAvecEleves->push([
                                // dd($user->login),
                                // 'user' => $users->login,
                                'id_contrat' => $idContrat,
                                'nomcomplet_eleve' => $eleve->NOM .' '. $eleve->PRENOM,
                                'classe_eleve' => $eleve->CODECLAS,
                                'id_paiementcontrat' => $paiement->id_paiementcontrat,
                                'date_paiement' => $paiement->date_paiementcontrat,
                                'montant' => $paiement->montant_paiementcontrat,
                                'mois' => $moisContrat ? $moisContrat->nom_moiscontrat : 'Mois inconnu',
                                'reference' => $paiement->reference_paiementcontrat,
                                // Ajoutez d'autres informations de paiement si nécessaire
                            ]);
                        }
                    }
                    }
                }
            
                // dd($paiementsAvecEleves);
                // Convertir la date en objet DateTime
                $dateObjdebut = DateTime::createFromFormat('Y-m-d', $debut);
                $dateObjfin = DateTime::createFromFormat('Y-m-d', $fin);

                // Formatter la date selon le format JJ/MM/AAAA
                $dateFormateedebut = $dateObjdebut->format('d/m/Y');
                $dateFormateefin = $dateObjfin->format('d/m/Y');

                // Vérifiez si des paiements ont été trouvés
                Session::put('paiementsAvecEleves', $paiementsAvecEleves);
                Session::put('dateFormateedebut', $dateFormateedebut);
                Session::put('dateFormateefin', $dateFormateefin);

                if ($paiementsAvecEleves->isEmpty()) {
                    // Aucun paiement trouvé pour les dates spécifiées
                    return redirect('etatpaiement')->with('status', 'Aucun paiement trouvé pour la periode spécifiées.')->with('paiementsAvecEleves', $paiementsAvecEleves);
                } else {
                    // Afficher les résultats avec les noms des élèves
                    return view('pages.etatpaiement1')->with('paiementsAvecEleves', $paiementsAvecEleves)->with('dateFormateedebut', $dateFormateedebut)->with('dateFormateefin', $dateFormateefin);
                }


            }


            public function etatpaiement1 (){
                $paiementsAvecEleves = Session::get('paiementsAvecEleves', collect()); // Déclaration avec une collection vide par défaut
                $dateFormateedebut = Session::get('dateFormateedebut'); 
                $dateFormateefin = Session::get('dateFormateefin'); 
                // dd($debut);
        
                return view('pages.etatpaiement1')->with('paiementsAvecEleves', $paiementsAvecEleves)->with('dateFormateedebut', $dateFormateedebut)->with('dateFormateefin', $dateFormateefin);
            }
            
            public function supprimerpaiement($id_paiementcontrat){

                $paiementsAvecEleves = Session::get('paiementsAvecEleves', collect()); // Déclaration avec une collection vide par défaut

                // $paiementsAvecEleves = Session::get('paiementsAvecEleves');
                                // suppression du contrat de la table paiementglobalcontrat

                                $paiementglobal = Paiementglobalcontrat::where('id_paiementcontrat', $id_paiementcontrat)->get();
                                // dd($paiementcontrat);
                                // Vérifier si des enregistrements existent
                                if ($paiementglobal->count() > 0) {
                                    // Parcourir chaque modèle et appeler delete() sur chaque modèle
                                    foreach ($paiementglobal as $paiementglob) {
                                        $paiementglob->update(['statut_paiementcontrat' => 0]);
                                    }
                                    // return view('pages.etatpaiement1')->with("statuspaiement", "Le paiement a ete supprimer avec succes")->with('paiementsAvecEleves', $paiementsAvecEleves);


                                    $paiementcontrat = Paiementcontrat::where('id_paiementglobalcontrat', $id_paiementcontrat)->get();
                                    // dd($paiementsAvecEleves);
                                    // Vérifier si des enregistrements existent
                                    if ($paiementcontrat->count() > 0) {
                                        // Parcourir chaque modèle et appeler delete() sur chaque modèle
                                        foreach ($paiementcontrat as $paiement) {
                                            $paiement->update(['statut_paiementcontrat' => 0]);
                                        }
                                        $message = "Le paiement a été supprimé avec succès.";
                                        return redirect('etatpaiement1')->with("statuspaiement", $message);                                    
                                    
                                    }else{
                                        return redirect('etatpaiement1')->with("statuspaiement", "Pas de paiement pour cet eleve,  veuillez dabord effectue un paiement");

                                    }
                    

                                    
                                }else{
                
                                    return redirect('etatpaiement1')->with("statuspaiement", "Pas de paiement pour cet eleve,  veuillez dabord effectue un paiement");
                                }

    }


    public function imprimerfiche($idpaiementcontrat){

        // dd($idpaiementcontrat);
        $lignepaiement = Paiementglobalcontrat::where('id_paiementcontrat', $idpaiementcontrat)->first();
        // dd($lignepaiement);

        $solde = $lignepaiement->montant_paiementcontrat;
        $id_contrat = $lignepaiement->id_contrat;
        $date_paiementcontrat = $lignepaiement->date_paiementcontrat;
        $anne_paiementcontrat = $lignepaiement->anne_paiementcontrat;
        $mois = $lignepaiement->mois_paiementcontrat;

        // recuperation des information de l'eleve

        $infocontrat = Contrat::where('id_contrat', $id_contrat)->first();
        $id_eleve = $infocontrat->eleve_contrat;

        $infoeleves = Eleve::where('MATRICULE', $id_eleve)->first();
        $nomcompeleve = $infoeleves->NOM .' '. $infoeleves->PRENOM;
        $classeeleve = $infoeleves->CODECLAS;
        // dd($classeeleve);

        return view('pages.etat.imprimerfiche')
        ->with('solde', $solde)
        ->with('date_paiementcontrat', $date_paiementcontrat)
        ->with('mois', $mois)
        ->with('nomcompeleve', $nomcompeleve)
        ->with('classeeleve', $classeeleve);
    }


 
                
                // public function traiter(Request $request)
                // {
                    //     // Récupérer l'ID de l'élève à partir de la requête
                    //     $eleveNom = $request->input('eleveNom');
                    //     dd($eleveNom);
                    
                    //     // Utiliser l'ID de l'élève pour effectuer des opérations dans votre contrôleur
                    //     // Par exemple, charger les détails de l'élève à partir de la base de données
                    
                    //     // Retourner une réponse (si nécessaire)
                    //     return response()->json(['message' => 'Informations de l\'élève traitées avec succès.']);
                    // }
                    // public function getElevesByClasse($CODECLAS) {
                        //     $elevess = Eleve::where('CODECLAS', $CODECLAS)->get();
                        
                        //     // dd($elevess);// Récupérer les élèves de la classe sélectionnée en fonction de $codeClasse
                        //     return view('pages.partial')->with('elevess', $elevess);
                        //   }
                        
                        // public function creercontrat(Request $request){
                            //     $matricules = $request->input('matricules');
                            //     $existingContrat = Contrat::where('eleve_contrat', $matricules)->exists();
                            //     if($existingContrat) {
                                //         return back()->with('status', 'Un contrat existe déjà pour cet élève.');
                                //     }
                                //     $contra = new Contrat();
                                //     $contra->eleve_contrat = $matricules;
                                //     $contra->cout_contrat = $request->input('montant');
                                
                                //     $contra->datecreation_contrat = $request->input('date');
                                //     $contra->save();
                                
                                //     return back()->with('status','Contrat enregistré avec succès');
                                // }
                     
  

        // fin facture normalisee pour tous les paiements de l'annee 2023_2024                     
                            
}
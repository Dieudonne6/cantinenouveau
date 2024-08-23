<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facturenormalise;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Contrat;
use App\Models\Eleve;
use App\Models\Params2;


class DuplicataController extends Controller
{      
    // Afficher le formulaire avec les données nécessaires
    public function showForm()
    {
        // Récupérer les élèves depuis la table eleves
           $eleves = Eleve::all();
    //    $eleves = Facturenormalise::select('nom', 'nim', 'dateHeure', 'montant_total','idcontrat')->distinct()->get();

        // Récupérer toutes les factures de paiement et d'inscription
        $facturesPaiement = Facturenormalise::all();
        $facturesInscription = Contrat::all();

        return view('pages.duplicatafacture', [
            'eleves' => $eleves,
            'facturesPaiement' => $facturesPaiement,
            'facturesInscription' => $facturesInscription
        ]);
    }
    
public function filterduplicata(Request $request)
{
    // Récupère le type de facture et l'ID de la facture depuis la requête
    $idContrat = $request->input('eleve_id');
    $factureType = $request->input('facture_type');
    $facture = null;
    $contrat = null;

    // Filtrer la facture en fonction du type sélectionné
    if ($factureType) {
        if ($factureType === 'facturenormalises') {
            $facture = Facturenormalise::where('idcontrat', $idContrat)->get();
        } else {
            $contrat = Contrat::where('id_contrat', $idContrat)->get();
        }
    }

    // Récupère toutes les factures pour les afficher dans la vue
    $eleves = Eleve::all();
    $facturesPaiement = Facturenormalise::all();
    $facturesInscription = Contrat::all();

    // Passe les variables à la vue
    return view('pages.Etats.filterduplicata', [
        'eleves' => $eleves,
        'facturesPaiement' => $facturesPaiement,
        'facturesInscription' => $facturesInscription,
        'factures' => $facture, // Assurez-vous que la variable $facture est passée
        'contrats' => $contrat, // Assurez-vous que la variable $contrat est passée
    ]);
}

    public function pdfduplicatacontrat($idcontrat){

        $factureIns = Contrat::where('id_contrat', $idcontrat)->first();

        $factureIns->cout_contrat;
        $factureIns->id_usercontrat;
        $factureIns->statut_contrat;
        $factureIns->eleve_contrat;
        $factureIns->datecreation_contrat;

        // recuperation des information de l'eleve

        $infoeleves = Eleve::where('MATRICULE', $factureIns->eleve_contrat)->first();
        $nomcompeleve = $infoeleves->NOM .' '. $infoeleves->PRENOM;
        $classeeleve = $infoeleves->CODECLAS;
        $infoecole = Params2::first();
        $nomecole = $infoecole->NOMETAB;
        $ifuEcole = $infoecole->ifu;
        // dd($infoEcole);
        $logo = $infoecole->logoimage;
        // dd($classeeleve);

                Session::put('factureIns', $factureIns);


        return view('pages.Etats.pdfduplicatacontrat', compact('nomcompeleve', 'classeeleve', 'nomecole', 'ifuEcole', 'logo', 'factureIns'));
    }

    // public function pdfduplicatapaie($idfacture){

    //     $facturePaie = Facturenormalise::where('idcontrat', $idfacture)->first();
          
    //     $facturePaie->nom;
    //     $facturePaie->montant_total;
    //     $facturePaie->ifuEcole;
    //     $facturePaie->classe;
    //     $facturePaie->designation;
    //     $facturePaie->codemecef;
    //     $facturePaie->id;
    //     $facturePaie->qrcode;
    //     $facturePaie->nim;
    //     $facturePaie->datepaiementcontrat;
    //     $facturePaie->dateHeure;
    //     $facturePaie->counters;
    //     // dd($facturePaie);

    //     // recuperation des information de l'ecole
    //     $infoecole = Params2::first();
    //     $nomecole = $infoecole->NOMETAB;
    //     // dd($infoEcole);
    //     $logo = $infoecole->logoimage;
    //     // dd($logo);

    //     return view('pages.Etats.pdfduplicatapaie', compact( 'nomecole', 'logo', 'facturePaie'));
    // }

    public function pdfduplicatapaie($idfacture)
{
    // Utilisation du query builder pour récupérer les informations de la facture
    $facturePaie = DB::table('facturenormalises')
        ->where('idcontrat', $idfacture)
        ->first();

    // Récupération des informations de l'école
    $infoecole = DB::table('params2')->first();
    $nomecole = $infoecole->NOMETAB;
    $logo = $infoecole->logoimage;

    return view('pages.Etats.pdfduplicatapaie', compact('nomecole', 'logo', 'facturePaie'));
}

    public function duplicatainscription2() {
        $amount = Session::get('amount');
        $classe = Session::get('classe');
        $logoUrl = Session::get('logoUrl');
        $dateContrat = Session::get('dateContrat');
        $elevyo = Session::get('elevyo');
        $data = [
            'amount' => $amount,
            'classe' => $classe,
            'logoUrl' => $logoUrl,
            'dateContrat' => $dateContrat,
            'elevyo' => $elevyo,
        ];

        $factureIns = Session::get('factureIns');

    //    dd($factureIns);
    
        // Spécifiez le nom du fichier avec un timestamp pour garantir l'unicité
        $fileName = $elevyo . time() . '.pdf';
    
        // Spécifiez le chemin complet vers le sous-dossier pdfs dans public
        $filePaths = public_path('pdfs/' . $fileName);
    
        // Assurez-vous que le répertoire pdfs existe, sinon créez-le
        if (!file_exists(public_path('pdfs'))) {
            mkdir(public_path('pdfs'), 0755, true);
        }


    
        // Générer et enregistrer le PDF dans le sous-dossier pdfs
       // $pdf = PDF::loadView('pages.Etats.doubleinscriptionpdf', $data)->save($filePaths);
    

                        return view('pages.Etats.duplicatainscription2', [
                            'amount' => $amount,
                            'classe' => $classe,
                            'logoUrl' => $logoUrl,
                            'dateContrat' => $dateContrat,
                            'elevyo' => $elevyo,
                            'factureIns' => $factureIns,
                
                        ]);  
        
    }

}
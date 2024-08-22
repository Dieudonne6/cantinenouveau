<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facturenormalise;
use App\Models\Contrat;

class DuplicataController extends Controller
{      
    // Afficher le formulaire avec les données nécessaires
    public function showForm()
    {
        // Récupérer les élèves depuis la table facturenormalises
        
       $eleves = Facturenormalise::select('nom', 'nim', 'dateHeure', 'montant_total','idcontrat')->distinct()->get();

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
    $eleves = Facturenormalise::all();
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



}
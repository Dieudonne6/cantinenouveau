<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eleve;
use App\Models\Moiscontrat;
use App\Models\Paramcontrat;
use App\Models\Contrat;
use App\Models\Paiementcontrat;
use App\Models\Paiementglobalcontrat;
use App\Models\Usercontrat;
use App\Models\Paramsfacture;
use App\Models\User;
use App\Models\Params2;
use App\Models\Classes;
use App\Models\Duplicatafacture;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class PagesController extends Controller
{
 
    public function inscriptioncantine(){
        if(Session::has('account')){
        // Liste des mots à exclure
        $excludedWords = ["DELETE", 'NON'];
    
        // Construire la requête initiale
        $query = Classes::query();
    
        // Ajouter des conditions pour exclure les mots
        foreach ($excludedWords as $word) {
            $query->where('CODECLAS', 'not like', '%' . $word . '%');
        }
    
        // Récupérer les résultats
        $class = $query->get();
    
        // Retourner la vue avec les résultats
        return view('pages.inscriptioncantine')->with('class', $class);
       } 
       return redirect('/');
    }
    
    public function getEleves($codeClass)
    {
        $eleves = Eleve::where('CODECLAS', $codeClass)
        ->leftJoin('contrat', 'eleve.MATRICULE', '=', 'contrat.eleve_contrat')
        ->where(function ($query) {
            $query->whereNull('contrat.eleve_contrat') // Élèves sans contrat
                  ->orWhere('contrat.statut_contrat', 0); // Élèves avec contrat ayant statut 0
        })
        ->select('eleve.*')
        ->distinct()   // Assurez-vous de sélectionner uniquement les colonnes de la table eleves
        ->get();

        // $eleves = Eleve::where('CODECLAS', $codeClass)
        // ->whereHas('contrats', function($query) {
        //     $query->where('statut_contrat', 0);
        // })
        // ->get();
       return response()->json($eleves);
      // return mb_convert_encoding($eleves, 'UTF-8', 'UTF-8');

    }
    public function getMontant($codeClass)
    {
        // Suppose that the params table has one row
        $params = Paramcontrat::first();

        if (($codeClass === "MAT1") || ($codeClass === "MAT2")  || ($codeClass === "MAT2II")  || ($codeClass === "MAT3")  || ($codeClass === "MAT3II")  || ($codeClass === "PREMATER")) {
            $montant = $params->fraisinscription_mat;
        } else {
            $montant = $params->fraisinscription2_paramcontrat;
        }

        return response()->json(['montant' => $montant]);
    }
    public function paiement(){
        return view('pages.paiement');
    } 

    public function nouveaucontrat(){
        return view('pages.nouveaucontrat');
    }
    public function frais(){
        $param = Paramcontrat::first();
        return view('pages.frais', ['param' => $param]);
    }

    public function fraisnouveau(Request $request){
        $param = new Paramcontrat();
        $param->anneencours_paramcontrat = $request->input('anneencours_paramcontrat');
        $param->fraisinscription_paramcontrat = $request->input('fraisinscription_paramcontrat');
        $param->fraisinscription_mat = $request->input('fraisinscription_mat');
        $param->fraisinscription2_paramcontrat = $request->input('fraisinscription2_paramcontrat');
        $param->coutmensuel_paramcontrat = $request->input('coutmensuel_paramcontrat');
        $param->save();
        return back()->with('status','Enregistrer avec succes');
    }
    
    public function modifierfrais($id_paramcontrat, Request $request){
        // $test = $request->input('id_paramcontrat');
        // dd($test);
        $params = Paramcontrat::find($id_paramcontrat);
        $params->anneencours_paramcontrat = $request->input('anneencours_paramcontrat');
        $params->fraisinscription_paramcontrat = $request->input('fraisinscription_paramcontrat');
        $params->fraisinscription_mat = $request->input('fraisinscription_mat');

        $params->fraisinscription2_paramcontrat = $request->input('fraisinscription2_paramcontrat');
        $params->coutmensuel_paramcontrat = $request->input('coutmensuel_paramcontrat');
        $params->update();
        return back()->with('status','Modifier avec succes');
    }
  
    public function connexiondonnees(){
        return view('pages.connexiondonnees');

    }
  
    public function dashbord(){
        return view('pages.dashbord');

    }


    public function statistique(){
        return view('pages.tableaudebord.statistique');

    }

    public function recouvrementsM(){
        return view('pages.tableaudebord.recouvrementsM');

    }

    public function hsuppression(){
        return view('pages.tableaudebord.hsuppression');

    }

    public function changetrimestre(){
        return view('pages.parametre.changetrimestre');

    }

    public function confimpression(){
        return view('pages.parametre.confimpression');

    }

    public function Acceuil(){
        return view('pages.inscriptions.Acceuil');

    }
    public function profil(){
        return view('pages.inscriptions.profil');

    }
    public function connexion(){
        $login = User::get();
        return view('pages.connexion', ['login' => $login]); 

    }

    public function logins(Request $request){
        $account = User::where("login",$request->login_usercontrat)->first();

        if($account){
                if (Hash::check($request->password_usercontrat, $account->motdepasse)) {

                Session::put('account', $account);
                $id_usercontrat = $account->id_usercontrat;
                $image = $account->image;

                $nom_user = $account->nomuser;
                Session::put('image', $image);

                $prenom_user = $account->prenomuser;
                Session::put('id_usercontrat', $id_usercontrat);
                Session::put('nom_user', $nom_user);
                Session::put('prenom_user', $prenom_user);

                return redirect("vitrine");
            } else{
                return back()->with('status', 'Mot de passe ou email incorrecte');

            }
        } else {
            return back()->with('status', 'Mot de passe ou email incorrecte');

        }

    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function vitrine(){
        if(Session::has('account')){
        $totaleleve = Eleve::count();
        $totalcantineinscritactif = Contrat::where('statut_contrat', 1)->count();
        $totalcantineinscritinactif = Contrat::where('statut_contrat', 0)->count();

        // dd($totalcantineinscritactif);
        return view('pages.vitrine')->with('totalcantineinscritactif', $totalcantineinscritactif)->with('totalcantineinscritinactif', $totalcantineinscritinactif)->with('totaleleve', $totaleleve);
        }return redirect('/');
    }
    public function paramsfacture(){
        return view('pages.paramsfacture');
    }
    public function echeancier(){
        return view('pages.inscriptions.echeancier');
    }
    public function paramsemecef(Request $request){

        $emcef = Paramsfacture::first();
        $emcef->ifu = $request->input('ifu');
        $emcef->token = $request->input('token');
        $emcef->taxe = $request->input('taxe');
        $emcef->type = $request->input('type');
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagename = $request->file('logo');
        $imagecontent = file_get_contents($imagename->getRealPath());
        $emcef->logo = $imagecontent;

        $emcef->save();
        return back()->with('status','Enregistrer avec succes');
    }
    public function inscriptions(){
        return view('pages.etat.inscriptions');
    }
    public function enregistreruser(Request $request){
        $login = new User();
        $password_crypte = Hash::make($request->password);
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $login->nomgroupe = 1;
        $login->login = $request->input('login');
        $login->nomuser = $request->input('nom');
        $login->prenomuser = $request->input('prenom');
        $imagenam = $request->file('image');
        $imageconten = file_get_contents($imagenam->getRealPath());
        $login->image = $imageconten;
        $login->motdepasse = $password_crypte;
        $login->administrateur = 1;
        $login->user_actif = 1;
        $login->save();
        return back()->with('status','Enregistrer avec succes');

    }

    public function parametre(){
        if(Session::has('account')){
        $param = Paramcontrat::first();
        return view('pages.parametre.parametre', ['param' => $param]);
        }return redirect('/');
    } 

    public function duplicatafacture(Request $request){
        if(Session::has('account')){
        $duplicatafactures = Duplicatafacture::all();

        return view('pages.duplicatafacture')->with('duplicatafactures', $duplicatafactures);
        } 
        return redirect('/');
    } 

    public function dowloadduplfac($id){
        if(Session::has('account')){
        $duplicatafacture = Duplicatafacture::find($id);
        $contenupdf = $duplicatafacture->url;
        $namepdf = 'duplicatafactureC'.$duplicatafacture->nomeleve;




        return Response::make($contenupdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'. $namepdf .'".pdf'
        ]);
        } 
        return redirect('/');
    } 

    

    public function paiementeleve(){
        if(Session::has('account')){
        // $duplicatafactures = Duplicatafacture::all();

        return view('pages.inscriptions.Paiement');
        } 
        return redirect('/');
    } 

    public function majpaiementeleve(){
        if(Session::has('account')){
        // $duplicatafactures = Duplicatafacture::all();

        return view('pages.inscriptions.MajPaiement');
        } 
        return redirect('/');

    }
    public function inscrireeleve(){
        return view('pages.inscriptions.inscrireeleve');
    } 
}

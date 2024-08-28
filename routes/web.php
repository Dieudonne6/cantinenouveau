<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;

use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ConnexionDBController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\EtatController;
use App\Http\Controllers\DuplicataController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/inscriptioncantine', [PagesController::class, 'inscriptioncantine']);
Route::get('/get-eleves/{codeClass}', [PagesController::class, 'getEleves']);
Route::get('/get-montant/{codeClass}', [PagesController::class, 'getMontant']);

Route::get('/nouveaucontrat', [PagesController::class, 'nouveaucontrat']);
Route::get('/paiement', [PagesController::class, 'paiement']);

Route::get('/classes', [ClassesController::class, 'classe']);
Route::get('/listecontrat', [ClassesController::class, 'listecontrat'])->name('listecontrat');
Route::get('/connexiondonnees', [PagesController::class, 'connexiondonnees']);
Route::get('/', [PagesController::class, 'connexion']);

Route::get('/eleve/{CODECLAS}', [ClassesController::class, 'filterEleve'])->name('eleve');
// Route::get('/eleve/{CODECLAS}', [ClassesController::class, 'getElevesByClasse']);

// Route::get('/eleve/{CODECLAS}', 'EleveController@getElevesByClasse');
Route::post('/traiter', [ClassesController::class, 'traiter']);

Route::post('/creercontrat', [ClassesController::class, 'creercontrat']);

Route::get('/lettrederelance', [EtatController::class, 'lettrederelance']);
Route::post('/essairelance', [EtatController::class, 'essairelance']);

Route::get('/frais', [PagesController::class, 'frais']);
Route::post('/nouveaufrais', [PagesController::class, 'fraisnouveau']);
Route::post('/modifierfrais', [PagesController::class, 'modifierfrais']);

Route::get('/paiementcontrat/{CODECLAS}/{MATRICULE}', [ClassesController::class, 'paiementcontrat'])->name('paiementcontrat');
Route::post('/savepaiementcontrat', [ClassesController::class, 'savepaiementcontrat']);
Route::get('/telechargerfacture', [ClassesController::class, 'telechargerfacture']);


Route::get('/pdffacture',[ClassesController::class,'pdffacture'])->name('pdffacture');
Route::get('/facturenormalise/{nomcompleteleve}',[ClassesController::class,'facturenormalise'])->name('pdffactures');
Route::get('/create',[ClassesController::class,'create'])->name('qrcode.create');

Route::post('/modifierfrais', [PagesController::class, 'modifierfrais']);
Route::get('/dashbord', [PagesController::class, 'dashbord']);

Route::get('/statistique', [PagesController::class, 'statistique']);
Route::get('/recouvrementsM', [PagesController::class, 'recouvrementsM']);
Route::get('/hsuppression', [PagesController::class, 'hsuppression']);
Route::get('/changetrimestre', [PagesController::class, 'changetrimestre']);
Route::get('/confimpression', [PagesController::class, 'confimpression']);

Route::get('/Acceuil', [PagesController::class, 'Acceuil']);
Route::get('/inscrireeleve', [PagesController::class, 'inscrireeleve']);
Route::get('/profil', [PagesController::class, 'profil']);

Route::put('/modifierfrais/{id_paramcontrat}', [PagesController::class, 'modifierfrais']);
Route::get('/dashbord', [PagesController::class, 'dashbord']);
Route::post('/connexion', [ConnexionDBController::class, 'connexion']);
Route::post('/connexions', [PagesController::class, 'connexions']);
Route::post('/logins', [PagesController::class, 'logins']);

Route::get('/inscription', [EleveController::class, 'inscription']);
Route::get('/etat', [ClassesController::class, 'etat'])->name('etat');
Route::get('/etatpaiement', [ClassesController::class, 'etatpaiement'])->name('etatpaiement');
Route::post('/traitementetatpaiement', [ClassesController::class, 'traitementetatpaiement'])->name('traitementetatpaiement');
Route::delete('/supprimercontrat/{MATRICULE}', [ClassesController::class, 'supprimercontrat']);
Route::delete('/supprimerpaiement/{id_paiementcontrat}', [ClassesController::class, 'supprimerpaiement']);
Route::get('/etatpaiement1', [ClassesController::class, 'etatpaiement1']);
Route::get('/essaipdf', [ClassesController::class, 'essaipdf']);

Route::get('/vitrine', [PagesController::class, 'vitrine']);

Route::get('/modifparam', [PagesController::class, 'modifparam']);

Route::get('/relance', [PagesController::class, 'relance']);

Route::get('http://localhost:38917/info');


Route::get('/etatdroits', [EtatController::class, 'etatdroits']);
Route::post('/filteretat', [EtatController::class, 'filteretat'])->name('filteretat');
Route::post('/relance', [EtatController::class, 'relance']);

Route::get('/paramsfacture', [PagesController::class, 'paramsfacture']);
Route::post('/paramsemecef', [PagesController::class, 'paramsemecef']);
Route::get('/imprimerfiche/{id_paiementcontrat}', [ClassesController::class, 'imprimerfiche']);
Route::get('/inscriptions', [PagesController::class, 'inscriptions']);
Route::post('/enregistreruser', [PagesController::class, 'enregistreruser']);

Route::get('/parametre', [PagesController::class, 'parametre']);
Route::get('/echeancier', [PagesController::class, 'echeancier']);

Route::post('logout', [PagesController::class, 'logout'])->name('logout');

Route::get('/duplicatafacture', [PagesController::class, 'duplicatafacture']);
Route::get('/dowloadduplfac/{id}', [PagesController::class, 'dowloadduplfac']);
Route::get('/duplicatafacture', [DuplicataController::class, 'showForm'])->name('duplicata.showForm');
Route::post('/filterduplicata', [DuplicataController::class, 'filterduplicata'])->name('filterduplicata');
Route::get('/pdfduplicatacontrat/{idcontrat}', [DuplicataController::class, 'pdfduplicatacontrat']);
Route::get('/pdfduplicatapaie/{idfacture}', [DuplicataController::class, 'pdfduplicatapaie']);
Route::get('/duplicatainscription2/{idcontrat}',[DuplicataController::class,'duplicatainscription2']);





Route::get('/paiementeleve', [PagesController::class, 'paiementeleve']);


Route::get('/duplicatainscription/{elevyo}',[ClassesController::class,'duplicatainscription']);
Route::get('/majpaiementeleve', [PagesController::class, 'majpaiementeleve']);
Route::get('/generer-factures', [ClassesController::class, 'genererfacture']);



Route::get('/factures', [ClassesController::class, 'factures']);
Route::get('/factures/{id}', [ClassesController::class, 'show'])->name('factures.show');
Route::get('/listefacture', [ClassesController::class, 'listefacture']);
Route::get('/avoirfacture/{codemecef}', [ClassesController::class, 'avoirfacture']);
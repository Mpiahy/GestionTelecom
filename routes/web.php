<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\{
    LoginController, 
    IndexController, 
    UserController, 
    ChantierController, 
    OperateurController, 
    LigneController, 
    FibreController, 
    PhoneController, 
    BoxController,
    ForfaitController
};

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

// Routes d'authentification
Route::get('/', [LoginController::class, 'loginView'])->name('auth.login');
Route::get('/login', [LoginController::class, 'loginView'])->name('auth.login');
Route::get('/loginGuest', [LoginController::class, 'loginGuestView'])->name('auth.loginGuest');
Route::post('/loginCheck', [LoginController::class, 'loginCheck'])->name('auth.loginCheck');
Route::get('/logout', [LoginController::class, 'logout'])->name('auth.logout');

// Page d'accueil
Route::get('/index', [IndexController::class, 'indexView'])
    ->middleware('check.session')
    ->name('index');

// Routes de Référentiels avec middleware commun 'check.session'
Route::middleware('check.session')->group(function() {
    Route::get('/user', [UserController::class, 'userView'])->name('ref.user');
    Route::post('/utilisateur/ajouter', [UserController::class, 'ajouterUtilisateur'])->name('ajouter.utilisateur');
    Route::post('/utilisateur/modifier', [UserController::class, 'modifierUtilisateur'])->name('modifier.utilisateur');
    Route::get('/utilisateur/supprimer/{id}', [UserController::class, 'supprimerUtilisateur'])->name('utilisateur.supprimer');
    Route::get('/ligne/searchFonction', [UserController::class, 'searchFonction'])->name('ligne.searchFonction');
    Route::get('/ligne/searchChantier', [UserController::class, 'searchChantier'])->name('ligne.searchChantier');
    Route::get('/phones-inactifs', [UserController::class, 'showPhonesInactifs']);
    Route::get('/box-inactifs', [UserController::class, 'showBoxInactifs']);
    Route::get('/recherche-inactifs', [UserController::class, 'rechercherInactifs']);
    Route::post('/ligne/attrEquipement', [UserController::class, 'attrEquipement'])->name('ligne.attrEquipement');

    Route::get('/chantier', [ChantierController::class, 'chantierView'])->name('ref.chantier');
    Route::post('/addChantier', [ChantierController::class, 'ajouterChantier'])->name('ref.chantier.add');
    Route::post('/chantier/modifier/{id}', [ChantierController::class, 'modifierChantier'])->name('chantier.modifier');
    Route::get('/chantier/supprimer/{id}', [ChantierController::class, 'supprimerChantier'])->name('chantier.supprimer');

    Route::get('/operateur', [OperateurController::class, 'operateurView'])->name('ref.operateur');
    Route::post('/operateur/modifier', [OperateurController::class, 'modifierOperateur'])->name('operateur.modifier');

    Route::get('/ligne', [LigneController::class, 'ligneView'])->name('ref.ligne');
    Route::post('/ligne/save', [LigneController::class, 'saveLigne'])->name('ligne.save');
    Route::post('/ligne/enr', [LigneController::class, 'enrLigne'])->name('ligne.enr');
    Route::get('/ligne/searchUser', [LigneController::class, 'searchUser'])->name('ligne.searchUser');
    Route::get('/ligne/detailLigne/{id_ligne}', [LigneController::class, 'detailLigne'])->name('ligne.detailLigne');
    Route::get('/ligne/edt', [LigneController::class, 'edtLigne'])->name('ligne.edt');
    Route::post('/ligne/rsl', [LigneController::class, 'rslLigne'])->name('ligne.rsl');

    Route::get('/fibre', [FibreController::class, 'fibreView'])->name('ref.fibre');

    Route::get('/phone', [PhoneController::class, 'phoneView'])->name('ref.phone');
    Route::post('/phone/save', [PhoneController::class, 'savePhone'])->name('phone.enr');
    Route::get('/phones/{id_phone}', [PhoneController::class, 'updatePhone'])->name('phone.edt');
    Route::post('/phone/hs', [PhoneController::class, 'hsPhone'])->name('phone.hs');

    Route::get('/get-marques-by-type/{typeId}', [PhoneController::class, 'getMarquesByType']); //for phones
    Route::get('/get-modeles-by-marque/{marqueId}', [PhoneController::class, 'getModelesByMarque']); //for phones & box

    Route::get('/box', [BoxController::class, 'boxView'])->name('ref.box');
    Route::post('/box/save', [BoxController::class, 'saveBox'])->name('box.enr');
    Route::get('/box/{id_box}', [BoxController::class, 'updateBox'])->name('box.edt');
    Route::post('/box/hs', [BoxController::class, 'hsBox'])->name('box.hs');

    Route::get('/forfait', [ForfaitController::class, 'forfaitView'])->name('ref.forfait');
    Route::get('/forfaits/update-element/{id_forfait}/{id_element}', [ForfaitController::class, 'updateElement'])->name('forfait.update.element');
    Route::get('/forfaits/delete-element/{id_forfait}/{id_element}', [ForfaitController::class, 'deleteElement'])->name('forfait.delete.element');
});
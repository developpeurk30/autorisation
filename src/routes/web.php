<?php

use Chimak\Autorisation\Http\Controllers\AutorisationController;
use Illuminate\Support\Facades\Route;

$namespace = 'Chimak\Autorisation\Http\Controllers';

Route::group([
    'namespace' => $namespace,
    'middleware' => ['web'],
    'prefix' => 'admin',
], function(){
    Route::get('/',[AutorisationController::class,'administration'])->name('dashboard');
});

Route::group(
    [
        'namespace' => $namespace,
        'middleware' => ['web']
    ], function(){
    //Les routes en GETprofilUtilisateur
    Route::get('/',[AutorisationController::class,'login'])->name('login');
    Route::get('/logout',[AutorisationController::class,'logout'])->name('logout');

    Route::get('/listeUtilisateur',[AutorisationController::class,'listeUtilisateur'])->name('liste_utilisateur');
    Route::get('/listeProfile',[AutorisationController::class,'listeProfile'])->name('liste_profile');
    Route::get('/listeModule',[AutorisationController::class,'listeModule'])->name('liste_module');
    Route::get('/listePermission',[AutorisationController::class,'listePermission'])->name('liste_permission');
    Route::get('/creationUtilisateur',[AutorisationController::class,'creationUtilisateur'])->name('creation_utilisateur');
    Route::get('/creationProfil',[AutorisationController::class,'creationProfil'])->name('creation_profil');
    Route::get('/creationModule',[AutorisationController::class,'creationModule'])->name('creation_module');
    Route::get('/creationPermission',[AutorisationController::class,'creationPermission'])->name('creation_permission');
    Route::get('/profilUtilisateur', [AutorisationController::class,'profilUtilisateur'])->name('profil_utilisateur');
    Route::get('/menus', [AutorisationController::class,'multiProfiles'])->name('multi_profil');

    Route::get('/modificationUtilisateur/{userID}/admin', [AutorisationController::class,'modificationUtilisateurParAdministrateur'])->name('modification_utilisateur_par_admin');
    Route::get('/modificationProfil/{profileID}/admin', [AutorisationController::class,'modificationProfil'])->name('modification_profil_par_admin');
    Route::get('/modificationModule/{moduleID}/admin', [AutorisationController::class,'modificationModule'])->name('modification_module_par_admin');
    Route::get('/modificationPermission/{permissionID}/admin', [AutorisationController::class,'modificationPermission'])->name('modification_permission_par_admin');
    Route::get('/affectationPermissionAProfil/{profileID}/admin', [AutorisationController::class,'affectationPermissionAProfil'])->name('affectation_permission_a_profil');
    Route::get('/modificationMotDePasseFirstConnection',[AutorisationController::class,'FirstConnectionChangePassword'])->name('first_connection_change_password');
//    Route::get('/profilUtilisateurModification', [AutorisationController::class,'ProfilUtilisateurModificationParUtilisateur'])->name('modification_profil_par_utilisateur');
    Route::get('/redirectionVersListeProfileAvecMessage/{profileID}', [AutorisationController::class,'redirectionVersListeProfileAvecMessage'])->name('redirection_vers_liste_profile');


    //Les routes en POST
    Route::post('/creerUtilisateur', [AutorisationController::class,'creerUtilisateur'])->name('enregistrer_utilisateur');
    Route::post('/creerProfil', [AutorisationController::class,'creerProfil'])->name('enregistrer_profil');
    Route::post('/creerModule', [AutorisationController::class,'creerModule'])->name('enregistrer_module');
    Route::post('/creerPermission', [AutorisationController::class,'creerPermission'])->name('enregistrer_permission');
    Route::post('/authentification', [AutorisationController::class,'authentification'])->name('authentification');
    Route::post('/modifierMotDePasseFirstConnection', [AutorisationController::class,'FirstConnectionChangePasswordAction'])->name('first_connection_change_password_action');
    Route::post('/changerPhotoProfilUtilisateur', [AutorisationController::class,'changerPhotoProfilUtilisateur'])->name('changer_photo_profil_utilisateur');
    Route::post('/changerMotDePasseUtilisateur', [AutorisationController::class,'changerMotDePasseUtilisateur'])->name('utilisateur_change_mot_de_passe');
    Route::post('/modifierInformationsUtilisateur', [AutorisationController::class,'modifierInformationsUtilisateur'])->name('modifier_info_utilisateur');
    Route::post('/modifierUtilisateur/{userID}/admin', [AutorisationController::class,'modifierUtilisateurParAdministrateur'])->name('modifier_utilisateur_par_admin');
    Route::post('/modifierProfil/{profileID}/admin', [AutorisationController::class,'modifierProfil'])->name('modifier_profil_par_admin');
    Route::post('/modifierModule/{moduleID}/admin', [AutorisationController::class,'modifierModule'])->name('modifier_module_par_admin');
    Route::post('/modifierPermission/{permissionID}/admin', [AutorisationController::class,'modifierPermission'])->name('modifier_permission_par_admin');
    Route::post('/affecterPermissionAProfil/{profileID}/admin', [AutorisationController::class,'affecterPermissionAProfil'])->name('affecter_permission_a_profil');

});

//Routes tests ajouter pour vérifier la prise en compte des redirections. A supprimer
Route::group(['namespace' => $namespace], function () {

    Route::get('/facture', function(){
        return 'Gestionnaire de Factre';
    })->name('facture');

    Route::get('/consultation', function(){
        return 'La consultation';
    })->name('consultation');

    Route::get('/gestion_pec', function(){
        return 'Gestionnaire de PEC';
    })->name('gestionnaire_pec');

    Route::get('/gestion_stock', function(){
        return 'Gestionnaire de Stock';
    })->name('gestion_stock');
});



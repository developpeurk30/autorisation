<?php

namespace Chimak\Autorisation\Http\Controllers;

use App\Http\Controllers\Controller;


use App\Models\User;
use Chimak\Autorisation\Models\Module;
use Chimak\Autorisation\Models\Page;
use Chimak\Autorisation\Models\Profile;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AutorisationController extends Controller
{

    /**
     * AutorisationController constructor.
     * Constructeur spécifiant que les méthodes de ce controleur nécessitent le middleware auth à l'exception de celles contenues dans le tableau except
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login','authentification', 'FirstConnectionChangePasswordAction', 'FirstConnectionChangePassword']]);
    }


    /***
     * Méthode chargeant la vue d'authentification
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        return view('autorisation::login');
    }

    /***
     * Méthode permettant de déconnecter l'utilisateur connecté
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(){
        if(Auth::check()){
            Auth::logout();
            return redirect()->route('login');
        }

    }

    /***
     * Méthode permettant de charger l'interface permettant de changer le mot de passe lors de la première connexion
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function FirstConnectionChangePassword(){
        return view('autorisation::change-user-password');
    }

    /***
     * Méthode permettant de gérer l'authentification de l'utilisateur
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function authentification(Request $request){
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];
        $messages = [
            'username.required' => 'Veuillez renseigner le Nom Utilisateur.',
            'password.required' => 'Veuillez renseigner le Mot de Passe.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $parametersWithLogin = ['username' =>$request->username, 'password' => $request->password];
        $parametersWithEmail = ['email' =>$request->username, 'password' => $request->password];
        if (Auth::attempt($parametersWithLogin) or Auth::attempt($parametersWithEmail)) {
            if(Auth::user()->status === 0){ //L'utilisateur qui tente de se connecter est désactivé. Donc le déconnecter. Puis le ramener à l'interface de Connexion.
                return $this->logout();
            }

            if(Auth::user()->password_changed === 0){ //Il est à sa première connexion. L'obliger à changer de Mot de Passe
                return redirect()->route('first_connection_change_password')
                ->with('danger','Veuillez activer votre compte en modifiant votre mot de passe.')
                    ->withInput();
            }
            $adresseRedirectionUtilisateur = DB::table('users')
                ->join('profile_user', 'users.id', '=', 'profile_user.user_id')
                ->join('profiles', 'profiles.id', '=', 'profile_user.profile_id')
                ->where('users.id', Auth::user()->id)
                ->where('profile_user.profile_user_status',1)
                ->select('profiles.profile_address_redirection')
                ->groupBy('profiles.profile_address_redirection')
                ->get(); //Redirections distinctes de l'utilisateur connecté
            $profiles = Auth::user()->profiles()->wherePivot('profile_user_status',1)->get(); //Tous les profils de l'utilsateur connecté

            if($adresseRedirectionUtilisateur->count() === 1){ //Utilisateur Connecté n'a qu'une seule adresse de redirection
                foreach ($profiles as $profile){
                    return redirect()->route($profile->profile_address_redirection);
                }
            }
            if($adresseRedirectionUtilisateur->count() > 1){ //Utilisateur Connecté a plusieurs adresses de redirection
                return view('autorisation::autorisation-redirection-plusieurs-profils', compact('profiles'));
            }
        }
        return redirect()->route('login');
    }

    /**
     * Méthode permettant de charger l'interface d'administration
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function administration()
    {
        return view('autorisation::theme.dashboard');
    }

    /***
     * Méthode permettant de charger la liste des utilisateurs de l'application
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function listeUtilisateur()
    {
        $listeUtilisateurs = User::all();
        return view('autorisation::utilisateurs-liste', compact('listeUtilisateurs'));
    }

    /***
     * Méthode permettant de charger la liste des profils
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function listeProfile()
    {
        $listeProfile = Profile::all();
        return view('autorisation::profile-liste', compact('listeProfile'));
    }

    /***
     * Méthode permettant de charger la liste des modules de l'application
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function listeModule()
    {
        $listeModule= Module::all();
        return view('autorisation::module-liste', compact('listeModule'));
    }

    /***
     * Méthode permettant de charger la liste des permissions de l'application
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function listePermission()
    {
        $listePermission = Page::all();
        return view('autorisation::permission-liste', compact('listePermission'));
    }

    /***
     * Méthode permettant de charger l'interface de création d'utilisateurs
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function creationUtilisateur()
    {
        $listeProfile = Profile::all()->where('profile_status', 1);
        return view('autorisation::utilisateurs-creation', compact('listeProfile'));
    }

    /***
     * Méthode permettant de charger l'interface de création de profils
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function creationProfil()
    {
        return view('autorisation::profiles-creation');
    }

    /***
     * Méthode permettant de charger l'interface de création de modules
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function creationModule()
    {
        return view('autorisation::modules-creation');
    }

    /***
     * Méthode permettant de charger l'interface de création de permissions
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function creationPermission()
    {
        $listeModule = Module::all();
        return view('autorisation::permissions-creation', compact('listeModule'));
    }

    /***
     * Méthode permettant de créer, enregistrer un utilisateur
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function creerUtilisateur(Request $request)
    {
        $rules = [
            'username' => 'required|unique:users|max:255',
            'email' => 'required|unique:users|max:255',
            'name' => 'required|max:255',
            'birth_date' => 'required',
            'password'=> 'required|min:6',
            'password_confirmation' => 'required|same:password',
            'profiles' => 'required',
            'phone' => 'required',
//            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        $messages = [
            'username.required' => 'Le champ Nom Utilisateur est obligatoire.',
            'username.unique' => 'Le Nom Utilisateur renseigné existe déjà, veuillez en renseigner un autre.',
            'email.required' => 'Le champ Email est obligatoire.',
            'email.unique' => 'Le Email renseigné existe déjà, veuillez en renseigner un autre.',
            'name.required' => 'Le champ Nom et Prénoms est obligatoire.',
            'birth_date.required' => 'Le champ Date de Naissance est obligatoire.',
            'password.required' => 'Le champ Mot de Passe est obligatoire.',
            'password.min' => 'Le Mot de Passe doit être de 6 caractères minimum.',
            'password_confirmation.required' => 'Le champ Confirmation Mot de Passe est obligatoire.',
            'password_confirmation.same' => 'Les deux  Mot de Passe doivent être identiques.',
            'profiles.required' => 'Veuillez choisir le profil de l\'utilisateur.',
            'phone.required' => 'Le champ Téléphone est obligatoire.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::transaction(function () use ($request) {

            $imagePathStored = '';
            if(isset($request->photo)){
                $imagePathStored = uniqid().'.'.$request->photo->extension();
                $request->photo->move(public_path('images'), $imagePathStored);
            }
            $status = (isset($request->status) and !is_null($request->status)) ? 1 : 0;
            $date = Carbon::now();
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'birth_date' => Carbon::createFromFormat('d/m/Y', $request->birth_date)->format('Y-m-d'),
                'email' => $request->email,
                'photo' => $imagePathStored,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'status' => $status,
            ]);
            foreach ($request->profiles as $profile_id) {
                $profile = Profile::find($profile_id);
                $user->profiles()->save($profile, ['profile_opened_at' => $date, 'profile_user_status' => $status]);
            }

        });
        return redirect()->route('liste_utilisateur');
    }

    /***
     *  Méthode permettant de créer, enregistrer un profil
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function creerProfil(Request $request)
    {
        $rules = [
            'profile_name' => 'required|unique:profiles|max:255',
            'profile_address_redirection' => 'required|max:255',
            'profile_addr_redirect_link_name' => 'required|max:255',
            'profile_description' => 'required|max:255',
        ];
        $messages = [
            'profile_name.required' => 'Le Nom du Profil est obligatoire.',
            'profile_name.max' => 'Le Nom du Profil doit être de 255 Caractères Maximum.',
            'profile_name.unique' => 'Le Nom de Profil renseigné existe déjà, veuillez en renseigner un autre.',
            'profile_address_redirection.required' => 'Le Nom de la Route de Redirection est obligatoire.',
            'profile_address_redirection.max' => 'Le Nom de la Route de Redirection doit être de 255 Caractères Maximum.',
            'profile_addr_redirect_link_name.required' => 'Le Menu est obligatoire.',
            'profile_addr_redirect_link_name.max' => 'Le Menu doit être de 255 Caractères Maximum.',
            'profile_description.required' => 'La Description du Profil est obligatoire.',
            'profile_description.max' => 'La Description du Profil doit être de 255 Caractères Maximum.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $status = (isset($request->status) and !is_null($request->status)) ? 1 : 0;
        $profile = Profile::create([
            'profile_name' => $request->profile_name,
            'profile_address_redirection' => $request->profile_address_redirection,
            'profile_addr_redirect_link_name' => $request->profile_addr_redirect_link_name,
            'profile_description' => $request->profile_description,
            'profile_status' => $status,
        ]);
        return redirect()->route('liste_profile');
    }

    /***
     *  Méthode permettant de créer, enregistrer un module
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function creerModule(Request $request)
    {
        $rules = [
            'module_name' => 'required|unique:modules|max:255',
            'module_description' => 'required|max:255',
        ];
        $messages = [
            'module_name.required' => 'Le Nom du Module est obligatoire.',
            'module_name.max' => 'Le Nom du Module doit être de 255 Caractères Maximum.',
            'module_name.unique' => 'Le Nom de Module renseigné existe déjà, veuillez en renseigner un autre.',
            'module_description.required' => 'La Description du Module est obligatoire.',
            'module_description.max' => 'La Description du Module doit être de 255 Caractères Maximum.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $module = Module::create([
            'module_name' => $request->module_name,
            'module_description' => $request->module_description,
        ]);
        return redirect()->route('liste_module');
    }

    /***
     *  Méthode permettant de créer, enregistrer une permission
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function creerPermission(Request $request)
    {
        $rules = [
            'page_code' => 'required|unique:pages|max:255',
            'page_description' => 'required|max:255',
            'module_id' => 'required',
        ];
        $messages = [
            'page_code.required' => 'Le Champ Permission est obligatoire.',
            'page_code.max' => 'Le Champ Permission doit être de 255 Caractères Maximum.',
            'page_code.unique' => 'La Permission renseigné existe déjà, veuillez en renseigner une autre.',
            'page_description.required' => 'La Description de la Permission est obligatoire.',
            'page_description.max' => 'La Description de la Permission doit être de 255 Caractères Maximum.',
            'module_id.required' => 'Veuillez choisir le Module auquel la Permission est rattachée.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $permission = Page::create([
            'page_code' => $request->page_code,
            'page_description' => $request->page_description,
            'module_id' => $request->module_id,
        ]);

        return redirect()->route('liste_permission');
    }

    /***
     *  Méthode permettant de charger l'interface de modification des informations de l'utilisateur connecté
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function profilUtilisateur(){
        if(Auth::check()){
            $listeProfile = Auth::user()->profiles()->where('profile_status',1)->where('profile_user_status',1)->get();
            return view('autorisation::utilisateurs-profile', compact('listeProfile'));
        }
        return redirect()->back();
    }
/*
    public function ProfilUtilisateurModificationParUtilisateur(){

    }*/
    /***
     * Méthode permettant de charger l'interface de modification des profils
     * @param $idProfil : identifiant du profil concerné par la modification
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function modificationProfil($idProfil)
    {
        $profile = Profile::find($idProfil);
        return view('autorisation::profiles-modification',compact('profile'));
    }

    /***
     * Méthode permettant de charger l'interface de modification des modules
     * @param $idModule : identifiant du module concerné par la modification
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function modificationModule($idModule)
    {
        $module = Module::find($idModule);
        return view('autorisation::modules-modification',compact('module'));
    }

    /***
     * Méthode permettant de charger l'interface de modification des permissions
     * @param $idPermission : identifiant de la permission concernée par la modification
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function modificationPermission($idPermission)
    {
        $permission= Page::find($idPermission);
        $listeModule = Module::all();
        return view('autorisation::permissions-modification',compact('permission', 'listeModule'));
    }

    /***
     * Méthode permettant de charger l'interface d'attribution, d'affectation de permissions aux profils
     * @param $profileID : identifiant du profil concerné par l'action d'affectation de permissions
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function affectationPermissionAProfil($profileID){
        $profile = Profile::find($profileID);
        $profilePermissions = $profile->pages()->where('profile_page_status',1)->pluck('page_id')->toArray();
        $profile = Profile::find($profileID);
        $listePermission= Page::all();
        return view('autorisation::profiles-permissions',compact('profile', 'listePermission','profilePermissions'));
    }

    /***
     * Méthode permettant de modifier le mot de passe lors de la première connexion de l'utilisateur
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function FirstConnectionChangePasswordAction(Request $request){
        $rules = [
            'password'=> 'required|min:2',
            'password_confirmation' => 'required|same:password',
        ];
        $messages = [
            'password.required' => 'Le champ Mot de Passe est obligatoire.',
            'password.min' => 'Le Mot de Passe doit être de 6 caractères minimum.',
            'password_confirmation.required' => 'Le champ Confirmation Mot de Passe est obligatoire.',
            'password_confirmation.same' => 'Les deux  Mot de Passe doivent être identiques.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if(Hash::check($request->password, Auth::user()->password)){
            return redirect()->route('first_connection_change_password')
                ->with('danger','Veuillez renseigner un Mot de Passe différent de l\'ancien Mot de Passe.')
                ->withInput();
        }
        $user = User::find(Auth::user()->id);
        $user->password = bcrypt($request->password);
        $user->password_changed = 1;//Matérialiser le changement du Mot de Passe en mettant cette valeur à 1
        if($user->save()){
            if(Auth::user()->profiles()->count() === 1){ //Utilisateur Connecté n'a qu'un seul profil
                $profiles = Auth::user()->profiles()->get();
                foreach ($profiles as $profile){
                    return redirect()->route($profile->profile_address_redirection);
                }
            }
            if(Auth::user()->profiles()->count() > 1){ //Utilisateur Connecté n'a qu'un seul profil
                $profiles = Auth::user()->profiles()->get();
                return view('autorisation::autorisation-redirection-plusieurs-profils', compact('profiles'));
            }


        }
    }

    /***
     * Méthode permettant de charger la page de redirection des utilisateurs ayant plusieurs profils actifs
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function multiProfiles(){
        $profiles = Auth::user()->profiles()->get();
        $profiles = Auth::user()->profiles()->wherePivot('profile_user_status',1)->get();
        return view('autorisation::autorisation-redirection-plusieurs-profils', compact('profiles'));
    }

    /***
     * Méthode permettant à un utilisateur de changer sa photo de profil
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changerPhotoProfilUtilisateur(Request $request){

        if(Auth::check()) {
            if(isset($request->photo)){
                if(is_null(Auth::user()->photo)){
                    $imagePathStored = uniqid().'.'.$request->photo->extension();
                }else{
                    list($name, $extension) = explode('.', Auth::user()->photo);
                    $imagePathStored = $name.'.'.$request->photo->extension();
//                    unlink(public_path('images').'\\'.Auth::user()->photo); //Suppression de l'ancien photo de profil
                    //DIRECTORY_SEPARATOR pour gérer \ et / sous repectivement Windows et Linux
                    unlink(public_path('images').DIRECTORY_SEPARATOR.Auth::user()->photo); //Suppression de l'ancien photo de profil
                }

                $request->photo->move(public_path('images'), $imagePathStored);
                $user = User::find(Auth::user()->id);
                $user->photo = $imagePathStored;
                $user->save();
             }
        }
      return redirect()->route('profil_utilisateur');
    }

    /***
     * Méthode permettant à un utilisateur de changer son mot de passe
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changerMotDePasseUtilisateur(Request $request){
        $rules = [
            'old_password'=> 'required',
            'password'=> 'required|min:2',
            'password_confirmation' => 'required|same:password',
        ];
        $messages = [
            'old_password.required' => 'Le champ Mot de Passe Actuel est obligatoire.',
            'password.required' => 'Le champ Nouveau Mot de Passe est obligatoire.',
            'password.min' => 'Le Nouveau Mot de Passe doit être de 6 caractères minimum.',
            'password_confirmation.required' => 'Le champ Confirmation Mot de Passe est obligatoire.',
            'password_confirmation.same' => 'Le Nouveau Mot de Passe et La Confirmation de Mot de Passe doivent être identiques.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if(!Hash::check($request->old_password, Auth::user()->password)){
            return redirect()->route('profil_utilisateur')
                ->with('danger','Le Mot de Passe Actuel renseigné est invalide !')
                ->withInput();
        }
        if(Hash::check($request->password, Auth::user()->password)){
            return redirect()->route('profil_utilisateur')
                ->with('danger','Veuillez renseigner un Nouveau Mot de Passe différent du Mot de Passe Actuel.')
                ->withInput();
        }
        $user = User::find(Auth::user()->id);
        $user->password = bcrypt($request->password);
        if($user->save()){
            return redirect()->route('profil_utilisateur')
                ->with('success','Mot de Passe modifié avec succès !');
        }

    }

    /***
     * Méthode permettant à un utilisateur de modifier ses informations de bases, générales
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function modifierInformationsUtilisateur(Request $request){
        $rules = [
            'name' => 'required|max:255',
            'birth_date' => 'required',
            'phone' => 'required',
        ];
        $messages = [
            'name.required' => 'Le champ Nom et Prénoms est obligatoire.',
            'birth_date.required' => 'Le champ Date de Naissance est obligatoire.',
            'phone.required' => 'Le champ Téléphone est obligatoire.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->birth_date = Carbon::createFromFormat('d/m/Y', $request->birth_date)->format('Y-m-d');
        $user->phone = $request->phone;
        if($user->save()){
            return redirect()->route('profil_utilisateur')
                ->with('success','Informations générales modifiées avec succès !');
        }

    }

    /***
     * Méthode permettant de modifier les informations d'un profil
     * @param Request $request
     * @param $profilID : identifiant du profil concerné par la modification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function modifierProfil(Request $request, $profilID)
    {
        $rules = [
            'profile_name' => 'required|unique:profiles,profile_name,'.$profilID.',id'.'|max:255',
            'profile_address_redirection' => 'required|max:255',
            'profile_addr_redirect_link_name' => 'required|max:255',
            'profile_description' => 'required|max:255',
        ];
        $messages = [
            'profile_name.required' => 'Le Nom du Profil est obligatoire.',
            'profile_name.max' => 'Le Nom du Profil doit être de 255 Caractères Maximum.',
            'profile_name.unique' => 'Le Nom de Profil renseigné existe déjà, veuillez en renseigner un autre.',
            'profile_address_redirection.required' => 'Le Nom de la Route de Redirection est obligatoire.',
            'profile_address_redirection.max' => 'Le Nom de la Route de Redirection doit être de 255 Caractères Maximum.',
            'profile_addr_redirect_link_name.required' => 'Le Menu est obligatoire.',
            'profile_addr_redirect_link_name.max' => 'Le Menu doit être de 255 Caractères Maximum.',
            'profile_description.required' => 'La Description du Profil est obligatoire.',
            'profile_description.max' => 'La Description du Profil doit être de 255 Caractères Maximum.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $status = (isset($request->status) and !is_null($request->status)) ? 1 : 0;
        $profile = Profile::find($profilID);

        $profile->profile_name = $request->profile_name;
        $profile->profile_address_redirection = $request->profile_address_redirection;
        $profile->profile_addr_redirect_link_name = $request->profile_addr_redirect_link_name;
        $profile->profile_description = $request->profile_description;
        $profile->profile_status = $status;
        $profile->save();
        return redirect()->route('liste_profile');
    }

    /***
     * Méthode permettant de modifier les informations d'un module
     * @param Request $request
     * @param $moduleID : identifiant du module concerné par la modification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function modifierModule(Request $request, $moduleID)
    {
        $rules = [
            'module_name' => 'required|unique:modules,module_name,'.$moduleID.',id'.'|max:255',
            'module_description' => 'required|max:255',
        ];
        $messages = [
            'module_name.required' => 'Le Nom du Module est obligatoire.',
            'module_name.max' => 'Le Nom du Module doit être de 255 Caractères Maximum.',
            'module_name.unique' => 'Le Nom de Module renseigné existe déjà, veuillez en renseigner un autre.',
            'module_description.required' => 'La Description du Module est obligatoire.',
            'module_description.max' => 'La Description du Module doit être de 255 Caractères Maximum.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $module = Module::find($moduleID);

        $module->module_name = $request->module_name;
        $module->module_description = $request->module_description;
        $module->save();
        return redirect()->route('liste_module');
    }

    /***
     * Méthode permettant de modifier les informations d'une permission
     * @param Request $request
     * @param $permissionID : identifiant de la permission concernée par la modification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function modifierPermission(Request $request, $permissionID)
    {
        $rules = [
            'page_code' => 'required|unique:pages,page_code,'.$permissionID.',id'.'|max:255',
            'page_description' => 'required|max:255',
            'module_id' => 'required',
        ];
        $messages = [
            'page_code.required' => 'Le Champ Permission est obligatoire.',
            'page_code.max' => 'Le Champ Permission doit être de 255 Caractères Maximum.',
            'page_code.unique' => 'La Permission renseigné existe déjà, veuillez en renseigner une autre.',
            'page_description.required' => 'La Description de la Permission est obligatoire.',
            'page_description.max' => 'La Description de la Permission doit être de 255 Caractères Maximum.',
            'module_id.required' => 'Veuillez choisir le Module auquel la Permission est rattachée.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $permission = Page::find($permissionID);

        $permission->page_code = $request->page_code;
        $permission->page_description = $request->page_description;
        $permission->module_id = $request->module_id;
        $permission->save();
        return redirect()->route('liste_permission');
    }

    /***
     * Méthode permettant d'affecter des permissions à un profil
     * @param Request $request
     * @param $profileID : identifiant du profil concerné par l'affectation
     * @return false|string
     */
    public function affecterPermissionAProfil(Request $request, $profileID){

        $profile = Profile::find($profileID);
        $profilePermissionsInitial = $profile->pages()->where('profile_page_status',1)->pluck('page_id')->toArray();
        $profilePermissionsActuel = array();
        $profilePermissionsActuel = (isset($request->permissions)) ?$request->permissions:$profilePermissionsActuel;
        $date = Carbon::now();
        //Si Permission dans $profilePermissionsActuel est dans $profilePermissionsInitial, ne rien faire sinon insérer
        foreach ($profilePermissionsActuel as $permission_id) {
            if(!in_array($permission_id, $profilePermissionsInitial)){
                $permission = Page::find($permission_id);
                if($profile->pages()->where('page_id', $permission_id)->wherePivot('profile_page_status',1)->count() == 0){//Pour éviter les doublons
                    $profile->pages()->save($permission, ['page_allocate_to_profile_at' => $date, 'profile_page_status' => 1]);
                }

            }
        }

        //Si Permission dans $profilePermissionsInitial est absent dans $profilePermissionsActuel, alors désactiver
        foreach ($profilePermissionsInitial as $permission_id) {
            if(!in_array($permission_id, $profilePermissionsActuel)){
                //Rechercher puis désactiver le profile
                $profile->pages()->wherePivot('profile_page_status',1)->updateExistingPivot($permission_id, ['profile_page_status'=> 0, 'page_retire_from_profile_at' => $date]);
            }
        }

        return json_encode(['class' => 'success']);
    }

    /***
     * Méthode permettant de charger la vue permettant de modifier le mot de passe et le(s) profil(s) d'un utilisateur
     * @param $userID : identifiant de l'utilisateur concerné par la modification
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function modificationUtilisateurParAdministrateur($userID){
        $user = User::find($userID);
        $userProfiles = $user->profiles()->where('profile_status',1)->where('profile_user_status',1)->pluck('profile_id')->toArray();
        $listeProfile = Profile::where('profile_status',1)->orderBy('profile_name','asc')->get();
        return view('autorisation::modification-utilisateur-par-admin',compact('listeProfile','user','userProfiles'));
    }

    /***
     * Méthode permettant de modifier le mot de passe et le(s) profil(s) d'un utilisateur
     * @param Request $request
     * @param $userID : identifiant de l'utilisateur concerné par la modification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function modifierUtilisateurParAdministrateur(Request $request,$userID){

        $rules = [
            'password'=> '',
            'password_confirmation' => 'same:password',
            'profiles' => 'required',
        ];
        $messages = [
            'password.required' => 'Le champ Mot de Passe est obligatoire.',
            'password.min' => 'Le Mot de Passe doit être de 6 caractères minimum.',
            'password_confirmation.required' => 'Le champ Confirmation Mot de Passe est obligatoire.',
            'password_confirmation.same' => 'Les deux  Mot de Passe doivent être identiques.',
            'profiles.required' => 'Veuillez choisir le profil de l\'utilisateur.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::find($userID);
        $userProfilesInitial = $user->profiles()->where('profile_status',1)->where('profile_user_status',1)->pluck('profile_id')->toArray();
        $userProfilesActuel = $request->profiles;
        $date = Carbon::now();
        //Si profile dans $userProfilesActuel est dans $userProfilesInitial, ne rien faire sinon insérer
        foreach ($userProfilesActuel as $profile_id) {
            if(!in_array($profile_id, $userProfilesInitial)){
                $profile = Profile::find($profile_id);
                $user->profiles()->save($profile, ['profile_opened_at' => $date, 'profile_user_status' => 1]);
            }
        }
        //Si profile dans $userProfilesInitial est absent dans $userProfilesActuel, alors désactiver
        foreach ($userProfilesInitial as $profile_id) {
            if(!in_array($profile_id, $userProfilesActuel)){
                //Rechercher puis désactiver le profile
                $user->profiles()->wherePivot('profile_user_status',1)->updateExistingPivot($profile_id, ['profile_user_status'=> 0, 'profile_closed_at' => $date]);
            }
        }

        //Modification de Mot de Passe
        if(isset($request->password) and !is_null($request->password)){
            $user->password = bcrypt($request->password);
            $user->save();
        }

        return redirect()->route('modification_utilisateur_par_admin', $userID)->with('success','Modification d\'informations utilisateur générales effectuées avec succès !');
    }

    /***
     * Méthode permettant de rediriger l'utilisateur vers la liste des profils après affectation de droits à un profil avec affichage d'un message
     * @param $profileID : ientifiant du profil concerné par l'affectation de droits
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectionVersListeProfileAvecMessage($profileID){
        $profile = Profile::find($profileID);
        return redirect()->route('liste_profile')->with('success',strtoupper('Affectation de Droits au Profil '.$profile->profile_name.' effectuee avec succes !'));

    }


}

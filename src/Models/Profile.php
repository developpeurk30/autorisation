<?php

namespace  Chimak\Autorisation\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Cette Classe est la surcouche de l'ORM Eloquent de la laravel de la Table "profiles"
 *
 *
 * @copyright  Copyright (c) 2020 Fonds de Prévoyance Militaire. (http://www.fpmnet.ci)
 * @license     BSD License
 * @version    Version  1.0.0
 * @since      Cette Classe est disponible depuis la version 1.0.0
 * @author     KOUA A. Michel <michel.koua@fpmnet.ci>
 */
class Profile extends Model{

    public $timestamps = true;
    protected $guarded = [];
    protected $dates = ['created_at','updated_at','deleted_at'];

    /***
     * Association Entre les Modèles   Profile (1.n) et User (1,n)
     * Description longue de la classe, s'il y en a une
     * @return BelongsToMany
     * @since    Disponible depuis la version 1.0.0
     * @author   KOUA A. Michel <michel.koua@fpmnet.ci>
     * @version  1.0.0
     */
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('profile_opened_at', 'profile_closed_at','profile_user_status')
            ->withTimestamps();
    }

    /***
     * Association Entre les Modèles    Page (1,n) et Profile (1.n)
     * Description longue de la classe, s'il y en a une
     * @version  1.0.0
     * @since    Disponible depuis la version 1.0.0
     * @author   KOUA A. Michel <michel.koua@fpmnet.ci>
     * @return BelongsToMany
     */
    public function pages()
    {
        return $this->belongsToMany(Page::class)
            ->withPivot('page_allocate_to_profile_at', 'page_retire_from_profile_at','profile_page_status')
            ->withTimestamps();
    }


    /**
     *  Mets les premières lettres du profil en majuscule
     *
     * @copyright  Copyright (c) 2020 Fonds de Prévoyance Militaire. (http://www.fpmnet.ci)
     * @license     BSD License
     * @version    Version  1.0.0
     * @since      Cette Méthode est disponible depuis la version 1.0.0
     * @author     KOUA A. Michel <michel.koua@fpmnet.ci>
     *
     * @var
     * @return void
     */
    public function setProfileNameAttribute($valeur){
        $this->attributes['profile_name'] = ucwords($valeur);
    }

    /**
     *  Mets la valeur de l'addresse de redirection en miniscule
     *
     * @copyright  Copyright (c) 2020 Fonds de Prévoyance Militaire. (http://www.fpmnet.ci)
     * @license     BSD License
     * @version    Version  1.0.0
     * @since      Cette Méthode est disponible depuis la version 1.0.0
     * @author     KOUA A. Michel <michel.koua@fpmnet.ci>
     *
     * @var
     * @return void
     */
    public function setProfileAddressRedirectionAttribute($valeur){
        $this->attributes['profile_address_redirection'] = strtolower($valeur);
    }

    /**
     *  Mets les premières lettres de l'intitulé du Menu en Majuscule
     *
     * @copyright  Copyright (c) 2020 Fonds de Prévoyance Militaire. (http://www.fpmnet.ci)
     * @license     BSD License
     * @version    Version  1.0.0
     * @since      Cette Méthode est disponible depuis la version 1.0.0
     * @author     KOUA A. Michel <michel.koua@fpmnet.ci>
     *
     * @var
     * @return void
     */
    public function setProfileAddrRedirectLinkNameAttribute($valeur){
        $this->attributes['profile_addr_redirect_link_name'] = ucwords($valeur);
    }

    /**
     *  Mets la valeur de la description du profil en majuscule
     *
     * @copyright  Copyright (c) 2020 Fonds de Prévoyance Militaire. (http://www.fpmnet.ci)
     * @license     BSD License
     * @version    Version  1.0.0
     * @since      Cette Méthode est disponible depuis la version 1.0.0
     * @author     KOUA A. Michel <michel.koua@fpmnet.ci>
     *
     * @var
     * @return void
     */
    public function setProfileDescriptionAttribute($valeur){
        $this->attributes['profile_description'] = strtoupper($valeur);
    }

    /**
     * Cette méthode permet de rechercher des profils. Elle permet aussi de rechercher un profil
     *
     * @copyright  Copyright (c) 2020 Fonds de Prévoyance Militaire. (http://www.fpmnet.ci)
     * @license     BSD License
     * @version    Version  1.0.0
     * @since      Cette Méthode est disponible depuis la version 1.0.0
     * @author     KOUA A. Michel <michel.koua@fpmnet.ci>
     *
     * @param null $idProfil
     * @return
     */
    public static function rechercherProfils($idProfil = null){

        $listeProfils = Profil::all();
        if (isset($idProfil) and !empty($idProfil) and !is_null($idProfil)) {
            $listeProfils = Profil::findOrFail($idProfil);
        }

        return $listeProfils;
    }

    /**
     * Cette méthode permet de vérifier si un profil est assigné à un utilisateur ou pas
     * @copyright  Copyright (c) 2020 Fonds de Prévoyance Militaire. (http://www.fpmnet.ci)
     * @license     BSD License
     * @version    Version  1.0.0
     * @since      Cette Méthode est disponible depuis la version 1.0.0
     * @author     KOUA A. Michel <michel.koua@fpmnet.ci>
     * @var
     * @return
     */
    public function profilAssigne(){

        return $this->users()->count() > 0;
    }

    /**
     * Cette méthode permet de retourner la liste des pages d'un profil
     * @copyright  Copyright (c) 2020 Fonds de Prévoyance Militaire. (http://www.fpmnet.ci)
     * @license     BSD License
     * @version    Version  1.0.0
     * @since      Cette Méthode est disponible depuis la version 1.0.0
     * @author     KOUA A. Michel <michel.koua@fpmnet.ci>
     * @var
     * @return
     */

    public function listeProfilPages(){
        return $this->pages()->get();
    }

    /**
     * Cette méthode permet de vérifier que la page est assignée à un profil
     * @copyright  Copyright (c) 2020 Fonds de Prévoyance Militaire. (http://www.fpmnet.ci)
     * @license     BSD License
     * @version    Version  1.0.0
     * @since      Cette Méthode est disponible depuis la version 1.0.0
     * @author     KOUA A. Michel <michel.koua@fpmnet.ci>
     * @var
     * @return
     */
    public static function profilAPage($idProfil,$idPage){

        return  self::join('page_profile', 'profiles.id','=', 'page_profile.profile_id')
            ->where('page_profile.profile_id','=',$idProfil )
            ->where( 'page_profile.page_id','=',$idPage )
            ->get();
    }

}

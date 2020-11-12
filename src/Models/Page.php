<?php

namespace  Chimak\Autorisation\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Cette Classe est la surcouche de l'ORM Eloquent de la laravel de la Table "pages"
 *
 *
 * @copyright  Copyright (c) 2020 Fonds de Prévoyance Militaire. (http://www.fpmnet.ci)
 * @license     BSD License
 * @version    Version  1.0.0
 * @since      Cette Classe est disponible depuis la version 1.0.0
 * @author     KOUA A. Michel <michel.koua@fpmnet.ci>
 */
class Page extends Model
{
    public $timestamps = true;

    protected $guarded = [];
    protected $dates = ['created_at','updated_at'];//Permet de signifier que les éléments dans le tableau sont des dates

    /**
     *  Mets la valeur de la description de la page en majuscule
     *
     * @copyright  Copyright (c) 2020 Fonds de Prévoyance Militaire. (http://www.fpmnet.ci)
     * @license     BSD License
     * @version    Version  1.0.0
     * @since      Cette Méthode est disponible depuis la version 1.0.0
     * @author     KOUA A. Michel <michel.koua@fpmnet.ci>
     *
     * @var $page_description : Description de la page
     * @return void
     */
    public function setPageDescriptionAttribute($page_description){

        $this->attributes['page_description'] = strtoupper($page_description);
    }

    /**
     *  Mets le code de la page en majuscule
     *
     * @copyright  Copyright (c) 2020 Fonds de Prévoyance Militaire. (http://www.fpmnet.ci)
     * @license     BSD License
     * @version    Version  1.0.0
     * @since      Cette Méthode est disponible depuis la version 1.0.0
     * @author     KOUA A. Michel <michel.koua@fpmnet.ci>
     *
     * @var $page_code : Code de la page. Utilisé pour la gestion des droits.
     * @return void
     */
    public function setPageCodeAttribute($page_code){

        $this->attributes['page_code'] = strtoupper($page_code);
    }


    /***
     * Association Entre les Modèles    pages (1,n) et Profil (1.n)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @since    Disponible depuis la version 1.0.0
     * @author   KOUA A. Michel <michel.koua@fpmnet.ci>
     *
     * @version  1.0.0
     */
    public function profiles()
    {
        return $this->belongsToMany(Profile::class)
            ->withPivot('page_allocate_to_profile_at', 'page_retire_from_profile_at','profile_page_status')
            ->withTimestamps();
    }

    public function profilesActifs()
    {
        return $this->belongsToMany(Profile::class)
            ->withPivot('page_allocate_to_profile_at', 'page_retire_from_profile_at','profile_page_status')
            ->withTimestamps()
            ->wherePivot('profile_page_status',1);
    }

    /***
     * Association Entre les Modèles    pages (1,1) et Module (1,n)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @since    Disponible depuis la version 1.0.0
     * @author   KOUA A. Michel <michel.koua@fpmnet.ci>
     *
     * @version  1.0.0
     * @return
     */

    public function module(){
        return $this->belongsTo(Module::class);
    }

    /**
     * Cette méthode permet de rechercher des pages. Elle permet aussi de rechercher les pages d'un module
     *
     * @copyright  Copyright (c) 2020 Fonds de Prévoyance Militaire. (http://www.fpmnet.ci)
     * @license     BSD License
     * @version    Version  1.0.0
     * @since      Cette Méthode est disponible depuis la version 1.0.0
     * @author     KOUA A. Michel <michel.koua@fpmnet.ci>
     *
     * @param null $idPage
     * @param null $idModule
     * @return
     */
    public static function rechercherPages( $idPage = null, $idModule = null){

        $listePages = Page::join('modules','pages.module_id', '=','modules.id');
        if(isset($idPage) and !empty($idPage) and !is_null($idPage)){
            $listePages->where('pages.page_id', $idPage);
        }
        if(isset($idModule) and !empty($idModule) and !is_null($idModule)){
            $listePages->where('pages.module_id', $idModule);
        }

        return $listePages->select(['pages.*', 'modules.module_name']);
    }


    /**
     * Cette méthode permet de vérifier si une page est assignée à un profil ou pas
     * @copyright  Copyright (c) 2020 Fonds de Prévoyance Militaire. (http://www.fpmnet.ci)
     * @license     BSD License
     * @version    Version  1.0.0
     * @since      Cette Méthode est disponible depuis la version 1.0.0
     * @author     KOUA A. Michel <michel.koua@fpmnet.ci>
     *
     * @return bool
     */
    public function pageAssignee(){

        return $this->profiles()->count() > 0;
    }

}

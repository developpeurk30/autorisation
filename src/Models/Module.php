<?php
/**
 * Cette Classe est la surcouche de l'ORM Eloquent de la laravel de la Table "modules"
 *
 *
 * @copyright  Copyright (c) 2020 Fonds de Prévoyance Militaire. (http://www.fpmnet.ci)
 * @license     BSD License
 * @version    Version  1.0.0
 * @since      Cette Classe est disponible depuis la version 1.0.0
 * @author    KOUA A. Michel <michel.koua@fpmnet.ci>
 */
namespace Chimak\Autorisation\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    public $timestamps = true;
    protected $guarded = [];
    protected $dates = ['created_at','updated_at'];//Permet de signifier que les éléments dans le tableau sont des dates

    /***
     * Association Entre les Modèles    pages (1,1) et Module (1.n)
     * Description longue de la classe, s'il y en a une
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @since    Disponible depuis la version 1.0.0
     * @author   KOUA A. Michel <michel.koua@fpmnet.ci>
     *
     * @version  1.0.0
     */

    public function pages(){
        return $this->hasMany(Page::class);
    }

    /**
     *  Mets les premières lettres de chaque mot composant le nom du module en majuscule
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
    public function setModuleNameAttribute($valeur){


        $this->attributes['module_name'] = ucwords($valeur);
    }

    /**
     *  Mets la description du module en majuscule
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
    public function setModuleDescriptionAttribute($valeur){


        $this->attributes['module_description'] = strtoupper($valeur);
    }


    /**
     * Cette méthode permet de rechercher des modules. Elle permet aussi de rechercher un module
     *
     * @copyright  Copyright (c) 2020 Fonds de Prévoyance Militaire. (http://www.fpmnet.ci)
     * @license     BSD License
     * @version    Version  1.0.0
     * @since      Cette Méthode est disponible depuis la version 1.0.0
     * @author     KOUA A. Michel <michel.koua@fpmnet.ci>
     *
     * @param null $idModule
     * @return Module[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function rechercherModules( $idModule = null){


        $listeModules = Module::all();
        if(isset($idModule) and !empty($idModule) and !is_null($idModule)){
            $listeModules = Module::findOrFail($idModule);
        }

        return $listeModules;
    }

    /**
     * Cette méthode permet de vérifier si un module est assigné à une page ou pas
     * @copyright  Copyright (c) 2020 Fonds de Prévoyance Militaire. (http://www.fpmnet.ci)
     * @license     BSD License
     * @version    Version  1.0.0
     * @since      Cette Méthode est disponible depuis la version 1.0.0
     * @author     KOUA A. Michel <michel.koua@fpmnet.ci>
     *
     * @return bool
     */
    public function moduleAssigne(){

        return $this->pages()->count() > 0;
    }
}

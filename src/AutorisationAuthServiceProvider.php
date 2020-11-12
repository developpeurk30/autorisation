<?php
namespace Chimak\Autorisation;
use App\Models\User;
use Chimak\Autorisation\Models\Page;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AutorisationAuthServiceProvider extends ServiceProvider{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
//         'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @param GateContract $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
        
        foreach ($this->getPages() as $page){
            $gate->define($page->page_code, function(User $user) use($page){
                return $user->hasProfile($page->profilesActifs);
            });
        }

    }

    /**
     * Cette méthode toutes les pages et leurs profils
     *
     * @copyright  Copyright (c) 2020 Fonds de Prévoyance Militaire. (http://www.fpmnet.ci)
     * @license     BSD License
     * @version    Version  1.0.0
     * @since      Cette Méthode est disponible depuis la version 1.0.0
     * @author     KOUA A. Michel <michel.koua@fpmnet.ci>
     * @return Collection|\Autorisation\AutorisationAuthServiceProvider[]
     */

    protected function getPages(){
        return Page::with('profilesActifs')->get();
    }
}

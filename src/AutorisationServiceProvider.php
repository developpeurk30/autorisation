<?php
namespace Chimak\Autorisation;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AutorisationServiceProvider extends ServiceProvider{

    public function boot(){

        $basePath = dirname(__DIR__);
        Schema::defaultStringLength(191);
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'autorisation');
        $this->publishes([
            $basePath.'/publishables/assets' => public_path(),
        ], 'public');

        $this->publishes([ $basePath.'/publishables/database/seeders' => dirname(app_path()).'/database/seeders']);
        $this->publishes([ $basePath.'/publishables/models' => dirname(app_path()).'/app/Models']);
    }

    public function register()
    {
        parent::register(); // TODO: Change the autogenerated stub
    }
}
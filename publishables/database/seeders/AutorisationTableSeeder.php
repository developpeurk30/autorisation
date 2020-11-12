<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use \Chimak\Autorisation\Models\Module;
use App\Models\User;
use \Chimak\Autorisation\Models\Profile;
use \Chimak\Autorisation\Models\Page;

class AutorisationTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        //Création de module
        $module = Module::create(['module_name' => 'Administration','module_description' => 'Module de gestion de l\'administration']);

        //Création d'utilisateur Admin

        $admin = User::create([
            'name' => 'Administrateur',
            'username' => 'admin',
            'birth_date' => Carbon::createFromFormat('d/m/Y', '31/07/2019')->format('Y-m-d'),
            'email' => 'admin@admin.com',
            'photo' => null,
            'phone' => '00225 01080900',
            'password' => Hash::make('admin'),
            'password_changed' => 1,
            'status' => 1,
            'created_at' => Carbon::now(),
            ]);


        //Création de profil d'administration

        $profile = Profile::create([
            'profile_name'=> 'Administrateur',
            'profile_status' => 1,
            'profile_address_redirection'=> 'dashboard',
            'profile_addr_redirect_link_name' => 'Tableau de board',
            'profile_description'=> strtoupper('Tableau de bord de l\'application'),
            'created_at' => Carbon::now(),
        ]);


        //Attribution du profile Administration à l'utilisateur admin

        $admin->profiles()->save(
            $profile,
            [
                'profile_opened_at' => Carbon::now(),
                'profile_user_status' => 1
             ]
            );

        //Génération des permissions et affectation au profil Admin

        $entities = array('module', 'permission','profile', 'user');//Les entités ou tables pour lesquelles on génère les permissions
        $permissions = array('view', 'create', 'edit','manage_permission');
        $entities_permission_description = array(
            'module' => array(
                'access_to' => 'Donner acces au menu des gestion des modules',
                'view' => 'Lister les modules',
                'create' => 'Ajouter de nouveaux modules',
                'edit' => 'Modifier les modules'
            ),
            'permission' => array(
                'access_to' => 'Donner acces au menu des gestion des permissions',
                'view' => 'Lister les permissions',
                'create' => 'Ajouter de nouvelles permissions',
                'edit' => 'Modifier les permissions'
            ),
            'profile' => array(
                'access_to' => 'Donner acces au menu des gestion des profiles',
                'view' => 'Lister les profils',
                'create' => 'Ajouter de nouveaux profils',
                'edit' => 'Modifier les profils',
                'permission_to_manage' => 'Gerer les permissions liees aux profils',
            ),
            'user' => array(
                'access_to' => 'Donner acces au menu des gestion des utilisateurs',
                'view' => 'Lister les utilisateurs',
                'create' => 'Ajouter de nouveaux utilisateurs',
                'edit' => 'Modifier les iformations relatives aux utilisateurs'
            ),

        );

        //Créer les permissions pour chacune des entités tout en les affectant au profil admin

        foreach($entities_permission_description as $entity => $permissions){

            foreach($permissions as $permission => $permission_description){
                $privilege = Page::create([
                    'page_code' => $permission.'_'.$entity,
                    'page_description' =>$permission_description,
                    'module_id' => $module->id
                ]);

                $privilege->profiles()->save($profile, ['profile_page_status' => 1, 'page_allocate_to_profile_at' => Carbon::now()]);
            }
        }

        }
}

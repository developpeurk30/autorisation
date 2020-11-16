# PAQUET AUTORISATION
 ![](https://img.shields.io/badge/BUILT%20WITH-LARAVEL%208-red)  ![](https://img.shields.io/badge/VERSION-1.0.0-9cf) ![GitHub last commit (branch)](https://img.shields.io/github/last-commit/developpeurk30/autorisation/master?color=green&label=LAST%20UPDATE)
 
 Ce paquet vous permet d'administrer votre application et donc de gérer :  

* *L'authetification des utilisateurs*;
* *La gestion des permissions (accès aux modules et pages)*;

***NB : Il est préférable d'installer ce paquet sur une installation fraiche de Laravel dans la mésure où le paquet a pour rôle de gérer l'authentification des utilisateurs
et de gérer les permissions de ceux-ci.     
Lors de la publication, le modèle User.php sera écrasé***
  
 
## POUR COMMENCER

Pour commencer :  
   * Il vous faudra être à l'aise avec Laravel
   * Avoir Git installé
## PRE-REQUIS
* **Laravel >= 8.0**
* **PHP >= 7.3**  


## INSTALLATION
Dans cette phase, nous verrons comment installer notre paquet. Nous vous proposerons deux méthodes d'installation :
* Installation depuis le dépôt Github
* Installation local

Ces installations consisteront en la configuration du fichier **composer.json**.
 


1 - Dans la section **require** de votre fichier **composer.json**, ajoutez la ligne ***"chimak/autorisation"*** de sorte à avoir un fichier ressemblant à ceci :  

###### INSTALLATION DEPUIS LE DEPOT GITHUB
```
 "require": {  
    ...
	"chimak/autorisation" : "dev-master"  
}
```

###### INSTALLATION DEPUIS LE FICHIER COMPRESSE LOCAL

```
 "require": {  
    ...
	"chimak/autorisation" : "*"  
}
```

2 - Dans la section **repositories**, ajoutez les quatre lignes en partant du premier alcolade de sorte à avoir quelque chose dans le genre :   
###### INSTALLATION DEPUIS LE DEPOT GITHUB
```
"repositories":[  
	{  
	    "type": "git",  
	    "url": "https://github.com/developpeurk30/autorisation.git"  
	}  
]
```
###### INSTALLATION DEPUIS LE FICHIER COMPRESSE LOCAL

```
"repositories":[  
	{  
	    "type": "artifact",  
	    "url": "Chemin_d_acces_au_repertoire_local_contenant_l_archive"  
	}  
]
```

3 - Puis exécuter la commande ci-dessous et le tour est joué !

``` composer update ```

4 - Une fois l'installation terminée, exécutez la commande ci-dessous pour la publication des fichiers.

```php artisan vendor:publish --force ```

5 - Ajouter la ligne ci-dessous à votre fichier **database/seeders/DatabaseSeeder.php** dans sa méthode **run()**:

```$this->call(AutorisationTableSeeder::class);```

Le fichier devrait maintenant ressembler à ceci :

```
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(AutorisationTableSeeder::class);
    }
}
```

6 - Exécuter la commande ``` php artisan migrate --seed``` pour générer les migrations et les seeds associés.

7 - Ouvrir votre fichier vendor/chimak/autorisation/src/AutorisationAuthServiceProvider.php, vous trouverez une **méthode boot** ayant certaines lignes commentées :

 ```
 public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
        /*
        foreach ($this->getPages() as $page){
            $gate->define($page->page_code, function(User $user) use($page){
                return $user->hasProfile($page->profilesActifs);
            });
        }
        */

    }
```

Les décommenter de sorte à avoir :
```
 public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
        
        foreach ($this->getPages() as $page){
            $gate->define($page->page_code, function(User $user) use($page){
                return $user->hasProfile($page->profilesActifs);
            });
        }
        

    }
```

8 - Commenter la route / dans votre fichier routes/web.php et connectez-vous avec l'utilisateur **admin/admin**. Vous pourrez changer votre mot de passse sous le menu **Mon Profil**.


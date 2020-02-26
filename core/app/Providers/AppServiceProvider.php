<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        

        Gate::define('isAdmin', function($user) {
            return $user->cz1_id_rol == '1';
         });
     
         // define a author user role
         // returns true if user role is set to author
         Gate::define('isRRHH', function($user) {
             return $user->cz1_id_rol == '2';
         });
     
         // define a author user role
         // returns true if user role is set to author
         Gate::define('isSST', function($user) {
             return $user->cz1_id_rol == '3';
         });

          // returns true if user role is set to author
          Gate::define('isDefault', function($user) {
            return $user->cz1_id_rol == '4';
        });

        Gate::define('isAdministrativo', function($user) {
            return $user->cz1_id_rol == '5';
        });

        Gate::define('isJefe', function($user) {
            return $user->cz1_id_rol == '6';
        });
        
    }
}

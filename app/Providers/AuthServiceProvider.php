<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //Checa se for Admin
        //Retorna verdadeiro se o auth user type for  admin
        Gate::define('isAdmin', function($user){
            return $user->user_type == 'admin';
        });
        
        //Checa se for Funcionário
        //Retorna verdadeiro se o auth user type for funcionário
        Gate::define('isFuncionario', function($user){
            return $user->user_type == 'funcionario';
        });
    }
}

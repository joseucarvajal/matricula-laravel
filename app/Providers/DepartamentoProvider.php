<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Departamento;

class DepartamentoProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer("*", function($view){
            $view->with("departamentosArray", Departamento::all());
        });
    }
}

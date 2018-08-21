<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

use App\Ciudad;

class CiudadProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer("*", function($view){
            $ciudades = DB::select('select * from ciudads where idDepartamento = ?', [1]);
            $view->with("ciudadesArray", $ciudades);
        });
    }
}

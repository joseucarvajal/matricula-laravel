<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MatricularEstudianteTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_ir_a_matricular_estudiante_despliega_formulario_ok()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('matricula/matriculas/create')
                    ->assertSee('Información básica del estudiante')
                    ->type("nombre", "Jose Ubaldo Carvajal")
                    ->select("estrato", "2");
        });
    }

    public function test_el_nombre_del_estudiante_es_requerido_ok()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('matricula/matriculas/create')
                    ->select("estrato", "1")
                    ->press("Guardar")
                    ->AssertSeeIn(".help-block", "El campo nombre es requerido");
        });
    }

    public function test_la_edad_del_estudiante_debe_ser_mayor_a_cero_ok()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('matricula/matriculas/create')
                    ->type("edad", "-1")
                    ->press("Guardar")
                    ->AssertSee("El campo edad debe ser mínimo 1");
        });
    }

    public function test_se_filtran_las_ciudades_segun_departamento_seleccionado_ok()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('matricula/matriculas/create')
                    ->select("idDepartamento", "2")                    
                    ->AssertSeeIn("select[name=idCiudad]", "Bogotá")
                    ->AssertSeeIn("select[name=idCiudad]", "Zipaquirá")
                    ->AssertSeeIn("select[name=idCiudad]", "Chía");
        });
    }
    
    public function test_cambiar_estrato_a_3_produce_descuento_de_100000_ok()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('matricula/matriculas/create')
                    ->type("nombre", "Jose Ubaldo Carvajal")
                    ->select("estrato", "3")
                    ->assertSee('Descuento $100000');
        });
    }    

    public function test_registrar_una_matricula_redirecciona_a_listado_de_matriculas_ok()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('matricula/matriculas/create')
                    ->type("nombre", "Jose Ubaldo Carvajal")
                    ->type("documento", "1616")
                    ->type("edad", "36")                    
                    ->select("idDepartamento", "1")
                    ->select("idCiudad", "4")
                    ->select("estrato", "3")
                    ->press("Guardar")
                    ->assertPathIs('/matricula/matriculas');
        });
    }
}

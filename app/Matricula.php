<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'matriculas';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['idDepartamento', 'idCiudad', 'nombre', 'documento', 'edad', 'estrato', 'valor'];

    public function departamento()
    {
        return $this->belongsTo('App\Departamento');
    }
    public function ciudad()
    {
        return $this->belongsTo('App\Ciudad');
    }
    
}

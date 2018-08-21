<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ciudads';

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
    protected $fillable = ['idDepartamento', 'nombre'];

    public function departamento()
    {
        return $this->belongsTo('App\Departamento');
    }
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /** @var string $table Nombre de la tabla. */
    protected $table = 'cities';

    /** @var array $fillable Los atributos que son asignables. */
    protected $fillable = [
    	'name'
    ];

    /** @var array $fillable Los atributos excluidos en el JSON. */
    protected $hidden = [
        'state_id'
    ];

    /** @var bool $timestamps Los campos timestamp de la tabla. */
    public $timestamps = false;

    /**
     * Obtener las radios de una ciudad.
     */
    public function radios()
    {
        return $this->hasMany('App\Radio');
    }
}

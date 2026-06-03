<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Artista extends Model
{
    // Campos de la tabla que permitimos llenar desde formularios
    protected $fillable = [
        'nombres',
        'nacionalidad',
    ];

    /**
     * Relación: Un artista tiene muchas pinturas.
     */
    public function pinturas(): HasMany
    {
        return $this->hasMany(Pintura::class);
    }
}
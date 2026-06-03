<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pintura extends Model
{
    // Campos de la tabla que permitimos llenar desde formularios
    protected $fillable = [
        'artista_id',
        'titulo',
        'tecnica',
        'precio',
        'imagen',
    ];

    /**
     * Relación inversa: Una pintura pertenece a un artista.
     */
    public function artista(): BelongsTo
    {
        return $this->belongsTo(Artista::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marque extends Model
{
    use HasFactory;
    protected $table = 'marque';
    protected $primaryKey = 'id_marque';
    public $incrementing = true;  
    protected $fillable = [
        'marque',
    ];

    /**
     * Trouver ou créer une marque.
     *
     * @param  string $marqueId
     * @param  string|null $newMarque
     * @return Marque
     */
    public static function findOrCreate($marqueId, $newMarque = null)
    {
        if ($marqueId === 'new_marque') {
            return self::create([
                'marque' => $newMarque,
            ]);
        }

        return self::findOrFail($marqueId);
    }
}

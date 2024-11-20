<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modele extends Model
{
    use HasFactory;
    protected $table = 'modele';
    protected $primaryKey = 'id_modele';
    public $incrementing = true; 
    protected $fillable = [
        'nom_modele',
        'id_marque',
    ];

    public function marque()
    {
        return $this->belongsTo(Marque::class, 'id_marque');
    }

    /**
     * Trouver ou créer un modèle.
     *
     * @param  string $modeleId
     * @param  string|null $newModele
     * @param  int $marqueId
     * @return Modele
     */
    public static function findOrCreate($modeleId, $newModele = null, $marqueId)
    {
        if ($modeleId === 'new') {
            return self::create([
                'nom_modele' => $newModele,
                'id_marque' => $marqueId,
            ]);
        }

        return self::findOrFail($modeleId);
    }
}

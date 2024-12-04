<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ForfaitPrix;

class Forfait extends Model
{
    use HasFactory;

    protected $table = 'forfait';
    protected $primaryKey = 'id_forfait';
    public $timestamps = true;

    protected $fillable = [
        'nom_forfait',
    ];

    /**
     * Récupère les éléments associés au forfait via la vue 'elementPrix'.
     */
    public function elements()
    {
        return $this->hasMany(ElementPrix::class, 'id_forfait', 'id_forfait');
    }

    /**
     * Récupère les détails complets d'un forfait (données depuis 'forfaitPrix').
     *
     * @return ForfaitPrix|null
     */
    public function getDetails()
    {
        return ForfaitPrix::where('id_forfait', $this->id_forfait)->first();
    }

    /**
     * Méthode statique pour simplifier la récupération des éléments et des détails.
     *
     * @param int $id
     * @return array|null
     */
    public static function getForfaitWithDetails($id)
    {
        $forfait = self::find($id);

        if (!$forfait) {
            return null; // Si le forfait n'existe pas
        }

        return [
            'details' => $forfait->getDetails(),
            'elements' => $forfait->elements,
        ];
    }
}

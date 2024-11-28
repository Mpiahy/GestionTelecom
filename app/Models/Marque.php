<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Marque extends Model
{
    use HasFactory;
    protected $table = 'marque';
    protected $primaryKey = 'id_marque';
    public $incrementing = false;  
    protected $fillable = [
        'id_marque',
        'marque',
    ];

    public static function generateId($typeEquipementId)
    {
        // Démarrer une transaction pour éviter les conditions de course
        return DB::transaction(function () use ($typeEquipementId) {
            // Vérifie si un compteur existe déjà pour cette combinaison ('marque', $typeEquipementId)
            $counter = DB::table('id_counters')
                ->where('entity', 'marque')
                ->where('type_or_marque_id', $typeEquipementId)
                ->lockForUpdate() // Verrouille la ligne pour éviter les accès concurrents
                ->first();
    
            if (!$counter) {
                // Si aucun compteur n'existe, initialiser avec le premier ID pour ce type d'équipement
                $newId = $typeEquipementId * 1000 + 1;
    
                DB::table('id_counters')->insert([
                    'entity' => 'marque',
                    'type_or_marque_id' => $typeEquipementId,
                    'last_id' => $newId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
    
                return $newId;
            }
    
            // Incrémenter le dernier ID et mettre à jour le compteur
            $newId = $counter->last_id + 1;
    
            DB::table('id_counters')
                ->where('entity', 'marque')
                ->where('type_or_marque_id', $typeEquipementId)
                ->update([
                    'last_id' => $newId,
                    'updated_at' => now(),
                ]);
    
            return $newId;
        });
    }
        
    /**
     * Trouver ou créer une marque.
     *
     * @param  string $marqueId
     * @param  string|null $newMarque
     * @return Marque
     */
    public static function findOrCreate($marqueId, $newMarque = null, $typeEquipementId)
    {
        if ($marqueId === 'new_marque') {
            // Vérifiez si $typeEquipementId est défini
            if (!$typeEquipementId) {
                throw new \InvalidArgumentException('Le type d\'équipement est requis pour créer une nouvelle marque.');
            }
    
            // Générer un nouvel id_marque basé sur le type d'équipement
            $newId = self::generateId($typeEquipementId);
    
            // Créer une nouvelle marque
            return self::create([
                'id_marque' => $newId,
                'marque' => $newMarque,
            ]);
        }
    
        // Rechercher une marque existante
        return self::findOrFail($marqueId);
    }    
}

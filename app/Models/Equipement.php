<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipement extends Model
{
    use HasFactory;

    protected $table = 'equipement';
    protected $primaryKey = 'id_equipement';
    public $incrementing = true; 
    protected $fillable = [
        'imei',
        'serial_number',
        'enrole',
        'id_type_equipement',
        'id_modele',
        'id_statut_equipement',
    ];

    public function modele()
    {
        return $this->belongsTo(Modele::class, 'id_modele');
    }

    public function typeEquipement()
    {
        return $this->belongsTo(TypeEquipement::class, 'id_type_equipement');
    }

    public function statut()
    {
        return $this->belongsTo(StatutEquipement::class, 'id_statut_equipement');
    }


    /**
     * Créer un équipement à partir des données validées.
     *
     * @param  array $validatedData
     * @param  Modele $modele
     * @return Equipement
     */
    public static function createFromRequest(array $validatedData, Modele $modele)
    {
        return self::create([
            'imei' => $validatedData['enr_phone_imei'],
            'serial_number' => $validatedData['enr_phone_sn'],
            'enrole' => $validatedData['enr_phone_enroll'] == 1, // Convertir en booléen
            'id_type_equipement' => $validatedData['enr_phone_type'],
            'id_modele' => $modele->id_modele,
            'id_statut_equipement' => 1, // Par défaut : statut "Nouveau"
        ]);
    }

    /**
     * Scope pour appliquer les filtres dynamiques.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['filter_marque'] ?? null, function ($query, $filterMarque) {
                $query->whereHas('modele.marque', function ($q) use ($filterMarque) {
                    $q->where('id_marque', $filterMarque);
                });
            })
            ->when($filters['filter_statut'] ?? null, function ($query, $filterStatut) {
                $query->where('id_statut_equipement', $filterStatut);
            })
            ->when($filters['search_imei'] ?? null, function ($query, $searchIMEI) {
                $query->where('imei', 'like', "%$searchIMEI%");
            })
            ->when($filters['search_sn'] ?? null, function ($query, $searchSN) {
                $query->where('serial_number', 'like', "%$searchSN%");
            });
    }
}

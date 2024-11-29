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
     * Scope pour récupérer uniquement les téléphones (Smartphone et Téléphone à Touche).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePhones($query)
    {
        return $query->whereHas('typeEquipement', function ($q) {
            $q->whereIn('type_equipement', ['Smartphone', 'Téléphone à Touche']);
        });
    }

    /**
     * Scope pour récupérer uniquement les box.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBox($query)
    {
        return $query->whereHas('typeEquipement', function ($q) {
            $q->whereIn('type_equipement', ['Box']);
        });
    }

    /**
     * Créer un équipement à partir des données validées.
     *
     * @param  array $validatedData
     * @param  Modele $modele
     * @return Equipement
     * @throws \Exception
     */
    public static function createPhoneFromRequest(array $validatedData, Modele $modele)
    {
        // Vérifier que le type d'équipement est valide pour un téléphone
        $typeEquipement = TypeEquipement::find($validatedData['enr_phone_type']);
        if (!$typeEquipement || !in_array($typeEquipement->type_equipement, ['Smartphone', 'Téléphone à Touche'])) {
            throw new \Exception('Type d\'équipement invalide pour un téléphone.');
        }

        // Créer et retourner l'équipement
        return self::create([
            'imei' => $validatedData['enr_phone_imei'],
            'serial_number' => $validatedData['enr_phone_sn'],
            'enrole' => $validatedData['enr_phone_enroll'] == 1, // Convertir en booléen
            'id_type_equipement' => $validatedData['enr_phone_type'],
            'id_modele' => $modele->id_modele,
            'id_statut_equipement' => 1,
        ]);
    }

    public function updatePhoneFromRequest($validatedData, $modele)
    {
        $this->update([
            'id_type_equipement' => $validatedData['edt_phone_type'],
            'id_modele' => $modele->id_modele,
            'imei' => $validatedData['edt_phone_imei'],
            'serial_number' => $validatedData['edt_phone_sn'],
            'enrole' => $validatedData['edt_phone_enroll'] == '1', //bool
        ]);
    }

    /**
     * Scope pour appliquer des filtres dynamiques optimisés.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, array $filters)
    {
        // Préparez les filtres avant utilisation
        $filters = array_filter($filters); // Supprime les valeurs nulles ou vides

        return $query
            // Filtre par marque
            ->when(isset($filters['filter_marque']), function ($query) use ($filters) {
                $query->whereHas('modele.marque', function ($q) use ($filters) {
                    $q->where('id_marque', $filters['filter_marque']);
                });
            })

            // Filtre par statut
            ->when(isset($filters['filter_statut']), function ($query) use ($filters) {
                $query->where('id_statut_equipement', $filters['filter_statut']);
            })

            // Recherche par IMEI (LIKE avec wildcard optimisé)
            ->when(isset($filters['search_imei']), function ($query) use ($filters) {
                $query->where('imei', 'like', '%' . $filters['search_imei'] . '%');
            })

            // Recherche par numéro de série (SN)
            ->when(isset($filters['search_sn']), function ($query) use ($filters) {
                $query->where('serial_number', 'like', '%' . $filters['search_sn'] . '%');
            })

            // Tri conditionnel : met le statut HS (id_statut_equipement = 4) à la fin
            ->orderByRaw('CASE WHEN id_statut_equipement = 4 THEN 1 ELSE 0 END')
            ->orderBy('id_equipement'); // Optionnel : tri secondaire par ID pour un ordre cohérent.
    }
}

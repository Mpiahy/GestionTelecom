<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StatutEquipement;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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
            'id_statut_equipement' => StatutEquipement::STATUT_NOUVEAU,
        ]);
    }    
    
    /**
     * Créer un box à partir des données validées.
     *
     * @param  array $validatedData
     * @param  Modele $modele
     * @return Equipement
     * @throws \Exception
     */
    public static function createBoxFromRequest(array $validatedData, Modele $modele)
    {
        // Créer et retourner le box
        return self::create([
            'imei' => $validatedData['enr_box_imei'],
            'serial_number' => $validatedData['enr_box_sn'],
            'enrole' => false,
            'id_type_equipement' => TypeEquipement::BOX,
            'id_modele' => $modele->id_modele,
            'id_statut_equipement' => StatutEquipement::STATUT_NOUVEAU,
        ]);
    }

    public function updatePhoneFromRequest($validatedData)
    {
        $this->update([
            'imei' => $validatedData['edt_phone_imei'],
            'serial_number' => $validatedData['edt_phone_sn'],
            'enrole' => $validatedData['edt_phone_enroll'] == '1', //bool
        ]);
    }

    public function updateBoxFromRequest($validatedData)
    {
        $this->update([
            'imei' => $validatedData['edt_box_imei'],
            'serial_number' => $validatedData['edt_box_sn'],
        ]);
    }

    /**
     * Scope pour appliquer des filtres dynamiques optimisés.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function getPhonesWithDetails(array $filters = []): Collection
    {
        // Commence la requête avec Query Builder sur la vue SQL
        $query = DB::table('view_phones_details');

        // Appliquer les filtres
        $filters = array_filter($filters);

        $query = $query
            ->when(isset($filters['filter_marque']), function ($q) use ($filters) {
                $q->where('marque', $filters['filter_marque']);
            })
            ->when(isset($filters['filter_statut']), function ($q) use ($filters) {
                $q->where('statut_equipement', $filters['filter_statut']);
            })
            ->when(isset($filters['search_imei']), function ($q) use ($filters) {
                $q->where('imei', 'like', '%' . $filters['search_imei'] . '%');
            })
            ->when(isset($filters['search_sn']), function ($q) use ($filters) {
                $q->where('serial_number', 'like', '%' . $filters['search_sn'] . '%');
            })
            ->when(isset($filters['search_user']), function ($q) use ($filters) {
                $q->where('login', 'ilike', '%' . $filters['search_user'] . '%');
            })
            ->orderByRaw("CASE WHEN statut_equipement = 'HS' THEN 1 ELSE 0 END")
            ->orderBy('id_equipement');

        // Retourner les résultats sous forme de collection
        return $query->get();
    }
    public static function getBoxWithDetails(array $filters = []): Collection
    {
        // Commence la requête avec Query Builder sur la vue SQL
        $query = DB::table('view_box_details');

        // Appliquer les filtres
        $filters = array_filter($filters);

        $query = $query
            ->when(isset($filters['filter_marque']), function ($q) use ($filters) {
                $q->where('marque', $filters['filter_marque']);
            })
            ->when(isset($filters['filter_statut']), function ($q) use ($filters) {
                $q->where('statut_equipement', $filters['filter_statut']);
            })
            ->when(isset($filters['search_imei']), function ($q) use ($filters) {
                $q->where('imei', 'like', '%' . $filters['search_imei'] . '%');
            })
            ->when(isset($filters['search_sn']), function ($q) use ($filters) {
                $q->where('serial_number', 'like', '%' . $filters['search_sn'] . '%');
            })
            ->when(isset($filters['search_user']), function ($q) use ($filters) {
                $q->where('login', 'ilike', '%' . $filters['search_user'] . '%');
            })
            ->orderByRaw("CASE WHEN statut_equipement = 'HS' THEN 1 ELSE 0 END")
            ->orderBy('id_equipement');

        // Retourner les résultats sous forme de collection
        return $query->get();
    }

    // Compter les equipements Actifs
    public static function countActif()
    {
        return DB::select("SELECT COUNT(*) AS total FROM view_equipement_actif")[0]->total;
    }

    // Compter les equipements Inactifs
    public static function countInactif()
    {
        return DB::select("SELECT COUNT(*) AS total FROM view_equipement_inactif")[0]->total;
    }

    // Compter les equipements hs
    public static function countHs()
    {
        return DB::select("SELECT COUNT(*) AS total FROM view_equipement_hs")[0]->total;
    }

    // Fonction pour récupérer les téléphones inactifs
    public static function phonesInactif()
    {
        return DB::select('SELECT * FROM view_phones_inactif');
    }

    // Fonction pour récupérer les box inactifs
    public static function boxInactif()
    {
        return DB::select('SELECT * FROM view_box_inactif');
    }

    // Fonction pour récupérer les téléphones with affectation
    public static function phonesWithDetails()
    {
        return DB::select('SELECT * FROM view_phones_details');
    }

    // Fonction pour récupérer les box with affectation
    public static function boxWithDetails()
    {
        return DB::select('SELECT * FROM view_box_details');
    }

    // Recherche sur view_phones_inactif
    public static function recherchePhonesInactifs($searchTerm)
    {
        $searchTerm = "%{$searchTerm}%";

        return DB::table('view_phones_inactif')
            ->where('marque', 'ILIKE', $searchTerm)
            ->orWhere('modele', 'ILIKE', $searchTerm)
            ->orWhere('imei', 'ILIKE', $searchTerm)
            ->orWhere('serial_number', 'ILIKE', $searchTerm)
            ->get();
    }

    // Recherche sur view_box_inactif
    public static function rechercheBoxInactifs($searchTerm)
    {
        $searchTerm = "%{$searchTerm}%";

        return DB::table('view_box_inactif')
            ->where('marque', 'ILIKE', $searchTerm)
            ->orWhere('modele', 'ILIKE', $searchTerm)
            ->orWhere('imei', 'ILIKE', $searchTerm)
            ->orWhere('serial_number', 'ILIKE', $searchTerm)
            ->get();
    }

    public static function attrEquipement(int $idEquipement)
    {
        self::where('id_equipement', $idEquipement)->update([
            'id_statut_equipement' => StatutEquipement::STATUT_ATTRIBUE,
            'updated_at' => now(),
        ]);
    }

    public function retourEquipement()
    {
        $this->id_statut_equipement = StatutEquipement::STATUT_RETOURNE;
        $this->save();
    }

    public static function getPhonesWithBigDetails($id_phone)
    {
        $sql = "SELECT * FROM view_phones_details";
        
        // Ajout de la clause WHERE si $id_phone est fourni
        if (!empty($id_phone)) {
            $sql .= " WHERE id_equipement = :id_phone";
            return DB::select($sql, ['id_phone' => $id_phone]);
        }

        return DB::select($sql);
    }
    public static function getBoxWithBigDetails($id_box)
    {
        $sql = "SELECT * FROM view_box_details";
        
        // Ajout de la clause WHERE si $id_box est fourni
        if (!empty($id_box)) {
            $sql .= " WHERE id_equipement = :id_box";
            return DB::select($sql, ['id_box' => $id_box]);
        }

        return DB::select($sql);
    }
}

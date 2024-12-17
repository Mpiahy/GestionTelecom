<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localisation extends Model
{
    use HasFactory;
    protected $table = 'localisation';
    protected $primaryKey = 'id_localisation';
    protected $fillable = ['localisation', 'id_ue', 'id_service', 'id_imputation'];

    public function ue()
    {
        return $this->belongsTo(UE::class, 'id_ue');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service');
    }

    public function imputation()
    {
        return $this->belongsTo(Imputation::class, 'id_imputation');
    }

    // Méthode pour filtrer par UE
    public function scopeFilterByUE($query, $filterUE)
    {
        if ($filterUE) {
            $query->whereHas('ue', function ($q) use ($filterUE) {
                $q->where('libelle_ue', $filterUE);
            });
        }
        return $query;
    }

    // Méthode pour filtrer par numéro BU
    public function scopeFilterByBU($query, $searchBU)
    {
        if ($searchBU) {
            $query->whereHas('service', function ($q) use ($searchBU) {
                $q->where('numero_bu', 'like', "%{$searchBU}%");
            });
        }
        return $query;
    }

    // Méthode pour filtrer par libellé de service
    public function scopeFilterByService($query, $searchService)
    {
        if ($searchService) {
            $query->whereHas('service', function ($q) use ($searchService) {
                $q->where('libelle_service', 'like', "%{$searchService}%");
            });
        }
        return $query;
    }

    // Méthode pour filtrer par code imputation
    public function scopeFilterByImputation($query, $searchImputation)
    {
        if ($searchImputation) {
            $query->whereHas('imputation', function ($q) use ($searchImputation) {
                $q->where('code_imputation', 'like', "%{$searchImputation}%");
            });
        }
        return $query;
    }

    /**
     * Supprime une localisation avec son service et ses imputations associées.
     */
    public function deleteWithRelations()
    {
        try {
            if ($this->service) {
                $this->service->imputations()->delete();
                $this->service->delete();
            }
            
            $this->delete();
        } catch (\Exception $e) {
            throw new \Exception("Une erreur est survenue lors de la suppression de la localisation : " . $e->getMessage());
        }
    }

    // Recherche d'un Chantier
    public static function searchByTerm(string $term)
    {
        return self::where('localisation', 'ILIKE', "%{$term}%")
            ->get()
            ->map(function ($chantier) {
                return [
                    'id' => $chantier->id_localisation,
                    'label' => $chantier->localisation,
                ];
            });
    }
}

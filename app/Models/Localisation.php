<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localisation extends Model
{
    use HasFactory;
    protected $table = 'localisation';
    protected $primaryKey = 'id_localisation';
    protected $fillable = ['localisation', 'id_service', 'id_imputation'];

    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service');
    }

    public function imputation()
    {
        return $this->belongsTo(Imputation::class, 'id_imputation');
    }

    // Méthode pour filtrer par libellé de service
    public function scopeFilterByService($query, $filterService)
    {
        if ($filterService) {
            $query->whereHas('service', function ($q) use ($filterService) {
                $q->where('libelle_service', 'like', "%{$filterService}%");
            });
        }
        return $query;
    }

    // Méthode pour filtrer par libelle imputation
    public function scopeFilterByImputation($query, $searchImputation)
    {
        if ($searchImputation) {
            $query->whereHas('imputation', function ($q) use ($searchImputation) {
                $q->where('libelle_imputation', 'like', "%{$searchImputation}%");
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

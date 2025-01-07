<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = 'service';
    protected $primaryKey = 'id_service';
    protected $fillable = ['libelle_service'];

    public function imputations()
    {
        return $this->hasMany(Imputation::class, 'id_service');
    }

    public static function createServiceWithImputation($libelle_service, $libelle_imputation)
    {
        // Créer le service
        $service = self::create([
            'libelle_service' => $libelle_service,
        ]);

        // Créer l'imputation associée
        $imputation = Imputation::create([
            'libelle_imputation' => $libelle_imputation,
            'id_service' => $service->id_service,
        ]);

        // Construire le champ localisation en combinant les données
        $localisation_value = "{$libelle_service} - {$libelle_imputation}";

        // Créer une entrée dans la table `localisation`
        Localisation::create([
            'localisation' => $localisation_value,
            'id_service' => $service->id_service,
            'id_imputation' => $imputation->id_imputation,
        ]);

        return $service;
    }

    /**
     * Met à jour un service et son imputation associée.
     */
    public function updateWithImputation($data)
    {
        // Mettre à jour le service
        $this->update([
            'libelle_service' => $data['libelle_service'],
        ]);

        // Mettre à jour l'imputation associée
        $this->imputations()->first()->update([
            'libelle_imputation' => $data['libelle_imputation'],
        ]);
    }
}

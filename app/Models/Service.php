<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = 'service';
    protected $primaryKey = 'id_service';
    protected $fillable = ['libelle_service','numero_bu','id_ue'];

    public function ue()
    {
        return $this->belongsTo(UE::class, 'id_ue');
    }

    public function imputations()
    {
        return $this->hasMany(Imputation::class, 'id_service');
    }

    public static function createServiceWithImputation($libelle_service, $numero_bu, $id_ue, $code_imputation)
    {
        // Créer le service
        $service = self::create([
            'libelle_service' => $libelle_service,
            'numero_bu' => $numero_bu,
            'id_ue' => $id_ue,
        ]);

        // Créer l'imputation associée
        $imputation = Imputation::create([
            'code_imputation' => $code_imputation,
            'id_service' => $service->id_service,
        ]);

        // Récupérer les informations de l'UE
        $ue = UE::find($id_ue);

        // Construire le champ localisation en combinant les données
        $localisation_value = "{$ue->libelle_ue} - {$numero_bu} - {$libelle_service} - {$code_imputation}";

        // Créer une entrée dans la table `localisation`
        Localisation::create([
            'localisation' => $localisation_value,
            'id_ue' => $id_ue,
            'id_service' => $service->id_service,
            'id_imputation' => $imputation->id_imputation,
        ]);

        return $service;
    }
}

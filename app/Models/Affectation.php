<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;

class Affectation extends Model
{
    use HasFactory;
    protected $table = 'affectation';
    protected $primaryKey = 'id_affectation';
    public $timestamps = true;

    protected $fillable = [
        'debut_affectation',
        'fin_affectation',
        'id_ligne',
        'id_equipement',
        'id_utilisateur',
    ];

    public static function creerAffectation($dateDebut, $idLigne, $idUtilisateur)
    {
        self::create([
            'debut_affectation' => $dateDebut,
            'fin_affectation' => null,
            'id_ligne' => $idLigne,
            'id_equipement' => null,
            'id_utilisateur' => $idUtilisateur,
        ]);
    }

    public static function updateAffectation(int $idLigne, ?string $date)
    {
        if (!empty($date)) {
            return self::where('id_ligne', $idLigne)->update([
                'debut_affectation' => $date,
            ]);
        }

        return false;
    }

    public static function rslAffectation(int $idLigne, string $dateResil)
    {
        // Validation des paramètres
        if (empty($idLigne) || empty($dateResil)) {
            throw new InvalidArgumentException("Les paramètres 'idLigne' et 'dateResil' sont requis.");
        }

        // Mise à jour de l'affectation correspondant à id_ligne
        return self::where('id_ligne', $idLigne)->update([
            'fin_affectation' => $dateResil,
        ]);
    }

    public static function attrEquipement(int $idUtilisateur, int $idEquipement, string $dateDebutAffectation)
    {
        self::create([
            'debut_affectation' => $dateDebutAffectation,
            'id_utilisateur' => $idUtilisateur,
            'id_equipement' => $idEquipement,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function retourAffectationEquipement(string $retourDate)
    {
        if ($retourDate <= $this->debut_affectation) {
            throw ValidationException::withMessages([
                'retour_date' => 'La date de retour doit être strictement postérieure à la date d’affectation.',
            ]);
        }

        $this->fin_affectation = $retourDate;
        $this->save();
    }

    public static function hsEquipement(int $equipementId)
    {
        $affectation = self::where('id_equipement', $equipementId)
            ->whereNull('fin_affectation')
            ->first();

        if ($affectation) {
            $affectation->fin_affectation = Carbon::now();
            $affectation->save();
        }
    }
}

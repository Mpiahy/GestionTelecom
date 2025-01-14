<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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
        'commentaire',
        'id_ligne',
        'id_forfait',
        'id_equipement',
        'id_utilisateur',
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }
    
    public function ligne()
    {
        return $this->belongsTo(Ligne::class, 'id_ligne');
    }

    public static function creerAffectation($dateDebut, $idLigne, $idForfait, $idUtilisateur)
    {
        self::create([
            'debut_affectation' => $dateDebut,
            'fin_affectation' => null,
            'id_ligne' => $idLigne,
            'id_forfait' => $idForfait,
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
    public static function attrLigne(int $idUtilisateur, int $idLigne, string $dateDebutAffectation)
    {
        self::create([
            'debut_affectation' => $dateDebutAffectation,
            'id_utilisateur' => $idUtilisateur,
            'id_ligne' => $idLigne,
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

    public static function getMonthlyData($annee)
    {
        // Étape 1 : Définir la locale en français pour Carbon
        Carbon::setLocale('fr');

        // Étape 2 : Récupérer les données depuis la base de données
        $results = DB::table('affectation as a')
            ->join('ligne as l', 'a.id_ligne', '=', 'l.id_ligne')
            ->join('view_forfait_prix as vfp', 'l.id_forfait', '=', 'vfp.id_forfait')
            ->selectRaw("
                generate_series(
                    GREATEST(DATE_TRUNC('month', a.debut_affectation), make_date(?, 1, 1)),
                    LEAST(COALESCE(DATE_TRUNC('month', a.fin_affectation), make_date(?, 12, 31)), make_date(?, 12, 31)),
                    '1 month'::interval
                ) AS month,
                SUM(vfp.prix_forfait_ht) AS total_prix_forfait_ht
            ", [$annee, $annee, $annee])
            ->whereRaw("
                a.debut_affectation <= make_date(?, 12, 31)
                AND (a.fin_affectation IS NULL OR a.fin_affectation >= make_date(?, 1, 1))
            ", [$annee, $annee])
            ->groupByRaw('month')
            ->orderByRaw('month')
            ->get();

        // Étape 3 : Traduire les mois avec Carbon
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = [
                'mois' => Carbon::create($annee, $i, 1)->translatedFormat('F'), // Exemple : "Janvier"
                'total_prix_forfait_ht' => 0, // Valeur par défaut
            ];
        }

        // Associer les données SQL aux mois
        foreach ($results as $result) {
            $monthIndex = (int)date('n', strtotime($result->month)); // Numéro du mois
            $months[$monthIndex]['total_prix_forfait_ht'] = $result->total_prix_forfait_ht;
        }

        return $months;
    }

    public static function getTotalPrixForfaitHT($annee, $mois = null)
    {
        // Définir la plage de dates
        if ($mois) {
            $debutMois = "$annee-" . str_pad($mois, 2, '0', STR_PAD_LEFT) . "-01";
            $finMois = date('Y-m-t', strtotime($debutMois));
        } else {
            $debutMois = "$annee-01-01";
            $finMois = "$annee-12-31";
        }

        // Récupérer les données
        $result = DB::table('affectation as a')
            ->join('ligne as l', 'a.id_ligne', '=', 'l.id_ligne')
            ->join('view_forfait_prix as vfp', 'l.id_forfait', '=', 'vfp.id_forfait')
            ->selectRaw('SUM(vfp.prix_forfait_ht) as total_prix_forfait_ht')
            ->whereRaw("
                a.debut_affectation <= ?
                AND (a.fin_affectation IS NULL OR a.fin_affectation >= ?)
            ", [$finMois, $debutMois])
            ->first();

        return $result->total_prix_forfait_ht ?? 0;
    }

    public static function getYearlyData($annee)
    {
        // Récupérer les données
        $results = DB::table('affectation as a')
            ->join('ligne as l', 'a.id_ligne', '=', 'l.id_ligne')
            ->join('type_ligne as tl', 'l.id_type_ligne', '=', 'tl.id_type_ligne')
            ->join('view_forfait_prix as vfp', 'l.id_forfait', '=', 'vfp.id_forfait')
            ->selectRaw("
                tl.type_ligne,
                EXTRACT(MONTH FROM generate_series(
                    GREATEST(DATE_TRUNC('month', a.debut_affectation), make_date(?, 1, 1)),
                    LEAST(COALESCE(DATE_TRUNC('month', a.fin_affectation), make_date(?, 12, 31)), make_date(?, 12, 31)),
                    '1 month'::interval
                )) AS mois,
                SUM(vfp.prix_forfait_ht) AS total_prix_forfait_ht
            ", [$annee, $annee, $annee])
            ->whereRaw("
                a.debut_affectation <= make_date(?, 12, 31)
                AND (a.fin_affectation IS NULL OR a.fin_affectation >= make_date(?, 1, 1))
            ", [$annee, $annee])
            ->groupByRaw('tl.type_ligne, mois')
            ->orderByRaw('tl.type_ligne, mois')
            ->get();

        // Organiser les données
        $data = [];
        $typesLigne = DB::table('type_ligne')->pluck('type_ligne')->toArray();
        $totauxParMois = array_fill(1, 12, 0);
        $totalAnnuelTousTypes = 0;

        foreach ($typesLigne as $type) {
            $data[$type] = array_fill(1, 12, 0);
            $data[$type]['total_annuel'] = 0;
        }

        foreach ($results as $result) {
            $type = $result->type_ligne;
            $mois = (int)$result->mois;
            $total = $result->total_prix_forfait_ht;

            $data[$type][$mois] += $total;
            $data[$type]['total_annuel'] += $total;
            $totauxParMois[$mois] += $total;
            $totalAnnuelTousTypes += $total;
        }

        $data['Total'] = $totauxParMois;
        $data['Total']['total_annuel'] = $totalAnnuelTousTypes;

        return $data;
    }
    
    public static function cloturerAffectationsUtilisateur($idUtilisateur, $dateDepart, $commentaire = null)
    {
        self::where('id_utilisateur', $idUtilisateur)
            ->whereNull('fin_affectation')
            ->update([
                'fin_affectation' => $dateDepart,
                'commentaire' => $commentaire,
            ]);
    }

}

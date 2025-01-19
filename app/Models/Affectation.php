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

    public function retourAffectationEquipement(string $retourDate, string $commentaire)
    {
        if ($retourDate <= $this->debut_affectation) {
            throw ValidationException::withMessages([
                'retour_date' => 'La date de retour doit être strictement postérieure à la date d’affectation.',
            ]);
        }

        $this->fin_affectation = $retourDate;
        $this->commentaire = $commentaire;
        $this->updated_at = now();
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
        Carbon::setLocale('fr');
    
        // Récupération des affectations avec leurs périodes
        $results = DB::table('affectation as a')
            ->join('ligne as l', 'a.id_ligne', '=', 'l.id_ligne')
            ->join('view_forfait_prix as vfp', 'l.id_forfait', '=', 'vfp.id_forfait')
            ->selectRaw("
                a.debut_affectation,
                a.fin_affectation,
                vfp.prix_forfait_ht
            ")
            ->whereYear('a.debut_affectation', '<=', $annee)
            ->whereRaw("a.fin_affectation IS NULL OR EXTRACT(YEAR FROM a.fin_affectation) >= ?", [$annee])
            ->get();
    
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = [
                'mois' => Carbon::create($annee, $i, 1)->translatedFormat('F'),
                'total_prix_forfait_ht' => 0,
            ];
        }
    
        foreach ($results as $result) {
            $debut = Carbon::parse($result->debut_affectation);
            $fin = $result->fin_affectation ? Carbon::parse($result->fin_affectation) : Carbon::create($annee, 12, 31);
            $prixForfait = $result->prix_forfait_ht;
    
            for ($i = 1; $i <= 12; $i++) {
                $mois = Carbon::create($annee, $i, 1);
                $debutMois = $mois->copy()->startOfMonth();
                $finMois = $mois->copy()->endOfMonth();
    
                if ($debut->gt($finMois) || $fin->lt($debutMois)) {
                    continue; // Pas d'affectation durant ce mois
                }
    
                $debutFacture = max($debut, $debutMois);
                $finFacture = min($fin, $finMois);
                $joursFactures = $finFacture->diffInDays($debutFacture) + 1;
                $totalJoursMois = $mois->daysInMonth;
                $prorata = $joursFactures / $totalJoursMois;
    
                $months[$i]['total_prix_forfait_ht'] += $prixForfait * $prorata;
            }
        }
    
        return $months;
    }    

    public static function getTotalPrixForfaitHT($annee, $mois = null)
    {
        if ($mois) {
            $debutMois = Carbon::create($annee, $mois, 1)->startOfMonth();
            $finMois = $debutMois->copy()->endOfMonth();
        } else {
            $debutMois = Carbon::create($annee, 1, 1);
            $finMois = Carbon::create($annee, 12, 31);
        }
    
        $results = DB::table('affectation as a')
            ->join('ligne as l', 'a.id_ligne', '=', 'l.id_ligne')
            ->join('view_forfait_prix as vfp', 'l.id_forfait', '=', 'vfp.id_forfait')
            ->selectRaw("
                a.debut_affectation,
                a.fin_affectation,
                vfp.prix_forfait_ht
            ")
            ->whereRaw("
                a.debut_affectation <= ?
                AND (a.fin_affectation IS NULL OR a.fin_affectation >= ?)
            ", [$finMois, $debutMois])
            ->get();
    
        $totalPrixForfaitHT = 0;
    
        foreach ($results as $result) {
            $debut = Carbon::parse($result->debut_affectation);
            $fin = $result->fin_affectation ? Carbon::parse($result->fin_affectation) : $finMois;
            $prixForfait = $result->prix_forfait_ht;
    
            $debutFacture = max($debut, $debutMois);
            $finFacture = min($fin, $finMois);
            $joursFactures = $finFacture->diffInDays($debutFacture) + 1;
            $totalJoursPeriode = $debutMois->daysInMonth;
            $prorata = $joursFactures / $totalJoursPeriode;
    
            $totalPrixForfaitHT += $prixForfait * $prorata;
        }
    
        return $totalPrixForfaitHT;
    }    

    public static function getYearlyData($annee)
    {
        Carbon::setLocale('fr');
    
        // Récupération des affectations avec leurs périodes
        $results = DB::table('affectation as a')
            ->join('ligne as l', 'a.id_ligne', '=', 'l.id_ligne')
            ->join('type_ligne as tl', 'l.id_type_ligne', '=', 'tl.id_type_ligne')
            ->join('view_forfait_prix as vfp', 'l.id_forfait', '=', 'vfp.id_forfait')
            ->selectRaw("
                a.debut_affectation,
                a.fin_affectation,
                vfp.prix_forfait_ht,
                tl.type_ligne
            ")
            ->whereYear('a.debut_affectation', '<=', $annee)
            ->whereRaw("a.fin_affectation IS NULL OR EXTRACT(YEAR FROM a.fin_affectation) >= ?", [$annee])
            ->get();
    
        $data = [];
        $typesLigne = DB::table('type_ligne')->pluck('type_ligne')->toArray();
        $totauxParMois = array_fill(1, 12, 0);
        $totalAnnuelTousTypes = 0;
    
        // Initialiser les données par type de ligne
        foreach ($typesLigne as $type) {
            $data[$type] = array_fill(1, 12, 0);
            $data[$type]['total_annuel'] = 0;
        }
    
        foreach ($results as $result) {
            $debut = Carbon::parse($result->debut_affectation);
            $fin = $result->fin_affectation ? Carbon::parse($result->fin_affectation) : Carbon::create($annee, 12, 31);
            $prixForfait = $result->prix_forfait_ht;
            $type = $result->type_ligne;
    
            for ($mois = 1; $mois <= 12; $mois++) {
                $moisDate = Carbon::create($annee, $mois, 1);
                $debutMois = $moisDate->copy()->startOfMonth();
                $finMois = $moisDate->copy()->endOfMonth();
    
                if ($debut->gt($finMois) || $fin->lt($debutMois)) {
                    continue; // Pas de facturation pour ce mois
                }
    
                $debutFacture = max($debut, $debutMois);
                $finFacture = min($fin, $finMois);
                $joursFactures = $finFacture->diffInDays($debutFacture) + 1;
                $totalJoursMois = $moisDate->daysInMonth;
                $prorata = $joursFactures / $totalJoursMois;
    
                $montant = round($prixForfait * $prorata, 2);
    
                $data[$type][$mois] += $montant;
                $data[$type]['total_annuel'] += $montant;
                $totauxParMois[$mois] += $montant;
                $totalAnnuelTousTypes += $montant;
            }
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

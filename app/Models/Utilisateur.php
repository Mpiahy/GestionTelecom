<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Utilisateur extends Model
{
    use HasFactory;

    protected $table = 'utilisateur';
    protected $primaryKey = 'id_utilisateur';
    protected $fillable = ['matricule', 'nom', 'prenom', 'login', 'id_type_utilisateur', 'id_fonction', 'id_localisation'];

    // Relations avec les autres tables
    public function typeUtilisateur()
    {
        return $this->belongsTo(TypeUtilisateur::class, 'id_type_utilisateur');
    }

    public function fonction()
    {
        return $this->belongsTo(Fonction::class, 'id_fonction');
    }

    public function localisation()
    {
        return $this->belongsTo(Localisation::class, 'id_localisation');
    }

    // Fonction d'insertion d'utilisateur
    public static function ajouterUtilisateur($data)
    {
        return self::create([
            'matricule' => $data['matricule_add'] ?? null, 
            'nom' => $data['nom_add'],
            'prenom' => $data['prenom_add'],
            'login' => $data['login_add'],
            'id_type_utilisateur' => $data['id_type_utilisateur_add'],
            'id_fonction' => $data['id_fonction'],
            'id_localisation' => $data['id_localisation_add'],
        ]);
    }

    public static function modifierUtilisateur($id, $data)
    {
        // Récupération de l'utilisateur par ID
        $utilisateur = self::findOrFail($id);

        // Mise à jour des données
        $utilisateur->update([
            'matricule' => $data['matricule'] ?? $utilisateur->matricule, // Garde l'ancien matricule si non fourni
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'login' => $data['login'],
            'id_type_utilisateur' => $data['id_type_utilisateur'],
            'id_fonction' => $data['id_fonction'],
            'id_localisation' => $data['id_localisation'],
        ]);

        return $utilisateur;
    }

    public function scopeFilterByType($query, $type)
    {
        if ($type) {
            return $query->whereHas('typeUtilisateur', function ($q) use ($type) {
                $q->where('type_utilisateur', $type);
            });
        }
        return $query;
    }

    public function scopeFilterByChantier($query, $chantier)
    {
        if ($chantier) {
            return $query->whereHas('localisation', function ($q) use ($chantier) {
                $q->where('localisation', 'ILIKE', '%' . $chantier . '%');
            });
        }
        return $query;
    }

    public function scopeFilterByLogin($query, $login)
    {
        if ($login) {
            return $query->where('login', 'ILIKE', '%' . $login . '%');
        }
        return $query;
    }

    public function scopeFilterByName($query, $name)
    {
        if ($name) {
            return $query->where('nom', 'ILIKE', '%' . $name . '%')
                        ->orWhere('prenom', 'ILIKE', '%' . $name . '%');
        }
        return $query;
    }

    public static function searchUser($term)
    {
        return DB::table('utilisateur')
            ->where('nom', 'ILIKE', "%{$term}%")
            ->orWhere('prenom', 'ILIKE', "%{$term}%")
            ->orWhere('login', 'ILIKE', "%{$term}%")
            ->orWhere('matricule', 'ILIKE', "%{$term}%")
            ->get();
    }
}
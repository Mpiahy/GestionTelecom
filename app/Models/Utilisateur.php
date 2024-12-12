<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    use HasFactory;

    protected $table = 'utilisateur'; // Nom de la table
    protected $primaryKey = 'matricule'; // Clé primaire
    public $incrementing = false; // Car 'matricule' est un entier non auto-incrémenté
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
        return self::create($data); // Utilise les colonnes définies dans $fillable
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
}
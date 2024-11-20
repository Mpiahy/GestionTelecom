<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatutEquipement extends Model
{
    use HasFactory;

    protected $table = 'statut_equipement'; // Nom de la table dans la base de données
    public $timestamps = false; // Pas de champs created_at et updated_at
    protected $fillable = ['statut_equipement']; // Champs pouvant être massivement attribués
}
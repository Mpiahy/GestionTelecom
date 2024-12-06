<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatutLigne extends Model
{
    use HasFactory;
    protected $table = 'statut_ligne';
    public $timestamps = false;
    protected $primaryKey = 'id_statut_ligne';
    protected $fillable = ['statut_ligne'];
    const STATUT_INACTIF = 1;
    const STATUT_EN_ATTENTE = 2;
    const STATUT_ATTRIBUE = 3;
    const STATUT_RESILIE = 4;
}
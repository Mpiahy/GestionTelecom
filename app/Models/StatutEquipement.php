<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatutEquipement extends Model
{
    use HasFactory;
    protected $table = 'statut_equipement';
    public $timestamps = false;
    protected $primaryKey = 'id_statut_equipement';
    protected $fillable = ['statut_equipement'];
}
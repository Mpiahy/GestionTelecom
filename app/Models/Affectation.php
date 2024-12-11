<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'matricule',
    ];
}

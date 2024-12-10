<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ligne extends Model
{
    use HasFactory;

    protected $table = 'ligne';
    protected $primaryKey = 'id_ligne';
    public $timestamps = true;

    protected $fillable = [
        'num_ligne',
        'num_sim',
        'id_statut_ligne',
        'id_type_ligne',
        'id_operateur',
    ];

    public static function getLignesWithDetails()
    {
        return DB::table('view_ligne_details')->get(); // Utilise la vue SQL
    }

    public static function createLigneWithDetails($data)
    {
        $ligne = self::create([
            'num_ligne' => null,
            'num_sim' => $data['act_sim'],
            'id_statut_ligne' => StatutLigne::STATUT_EN_ATTENTE,
            'id_type_ligne' => $data['act_type'],
            'id_operateur' => $data['act_operateur'],
        ]);
        return $ligne;
    }
}

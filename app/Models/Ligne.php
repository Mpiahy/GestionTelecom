<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class Ligne extends Model
{
    use HasFactory;

    protected $table = 'ligne';
    protected $primaryKey = 'id_ligne';
    public $timestamps = true;

    protected $fillable = [
        'num_ligne',
        'num_sim',
        'id_forfait',
        'id_statut_ligne',
        'id_type_ligne',
        'id_operateur',
    ];

    public static function getLignesWithDetails($filters = [])
    {
        $query = DB::table('view_ligne_big_details');

        // Filtre par statut
        if (!empty($filters['statut'])) {
            $query->where('id_statut_ligne', $filters['statut']);
        }

        // Recherche par numéro de ligne
        if (!empty($filters['search_ligne_num'])) {
            $query->where('num_ligne', 'like', '%' . $filters['search_ligne_num'] . '%');
        }

        // Recherche par numéro de SIM
        if (!empty($filters['search_ligne_sim'])) {
            $query->where('num_sim', 'like', '%' . $filters['search_ligne_sim'] . '%');
        }

        return $query->get();
    }

    public static function getLignesWithBigDetails($id_ligne)
    {
        $sql = "SELECT * FROM view_ligne_big_details";
        
        // Ajout de la clause WHERE si $id_ligne est fourni
        if (!empty($id_ligne)) {
            $sql .= " WHERE id_ligne = :id_ligne";
            return DB::select($sql, ['id_ligne' => $id_ligne]);
        }

        return DB::select($sql);
    }
    

    public static function createLigneWithDetails($data)
    {
        $ligne = self::create([
            'num_ligne' => null,
            'num_sim' => $data['act_sim'],
            'id_forfait' => $data['act_forfait'],
            'id_statut_ligne' => StatutLigne::STATUT_EN_ATTENTE,
            'id_type_ligne' => $data['act_type'],
            'id_operateur' => $data['act_operateur'],
        ]);
        return $ligne;
    }

    public function enrLigne($numLigne)
    {
        $this->update([
            'num_ligne' => $numLigne,
            'id_statut_ligne' => StatutLigne::STATUT_ATTRIBUE,
        ]);
    }

    public static function updateLigne(int $idLigne, array $data)
    {
        $updateData = [
            'num_sim' => $data['edt_sim'],
            'id_operateur' => $data['edt_operateur'],
            'id_type_ligne' => $data['edt_type'],
            'id_forfait' => $data['edt_forfait'],
        ];

        // Inclure `num_ligne` uniquement s'il est présent
        if (!empty($data['edt_ligne'])) {
            $updateData['num_ligne'] = $data['edt_ligne'];
        }

        return self::where('id_ligne', $idLigne)->update($updateData);
    }

    public function rslLigne($idLigne)
    {
        // Vérifiez si l'ID est valide
        if (!$idLigne) {
            throw new InvalidArgumentException("L'identifiant de la ligne est requis.");
        }

        // Mettre à jour la ligne avec les conditions spécifiées
        $this->where('id_ligne', $idLigne)->update([
            'num_ligne' => null,
            'id_statut_ligne' => StatutLigne::STATUT_RESILIE,
        ]);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeUtilisateur extends Model
{
    use HasFactory;
    protected $table = 'type_utilisateur';
    protected $primaryKey = 'id_type_utilisateur';
    protected $fillable = ['type_utilisateur'];
}

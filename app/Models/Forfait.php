<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forfait extends Model
{
    use HasFactory;

    protected $table = 'forfait';
    protected $primaryKey = 'id_forfait';
    public $timestamps = true;

    protected $fillable = [
        'nom_forfait',
    ];
}

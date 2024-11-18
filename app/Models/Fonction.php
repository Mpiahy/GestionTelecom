<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fonction extends Model
{
    use HasFactory;

    protected $table = 'fonction';
    protected $primaryKey = 'id_fonction';
    public $timestamps = false;

    protected $fillable = ['fonction'];
}

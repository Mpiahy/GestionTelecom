<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeEquipement extends Model
{
    use HasFactory;
    protected $table = 'type_equipement';
    public $timestamps = false;
    protected $primaryKey = 'id_type_equipement';
    protected $fillable = ['type_equipement'];
}
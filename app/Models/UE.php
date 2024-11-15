<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UE extends Model
{
    use HasFactory;
    protected $table = 'ue';
    protected $primaryKey = 'id_ue';
    protected $fillable = ['libelle_ue'];
    public function services()
    {
        return $this->hasMany(Service::class, 'id_ue');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imputation extends Model
{
    use HasFactory;
    protected $table = 'imputation';
    protected $primaryKey = 'id_imputation';
    protected $fillable = ['code_imputation', 'id_service'];

    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service');
    }

    public function localisation()
    {
        return $this->hasOne(Localisation::class, 'id_imputation');
    }
}

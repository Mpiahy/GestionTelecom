<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForfaitElement extends Model
{
    use HasFactory;

    protected $table = 'forfait_element';
    public $timestamps = false;
    protected $primaryKey = null; // Pas de clé primaire auto-incrémentée (clé composite)
    public $incrementing = false;

    protected $fillable = [
        'id_element',
        'id_forfait',
        'quantite',
    ];

    public function element()
    {
        return $this->belongsTo(Element::class, 'id_element', 'id_element');
    }

    public function forfait()
    {
        return $this->belongsTo(Forfait::class, 'id_forfait', 'id_forfait');
    }
}

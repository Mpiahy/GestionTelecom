<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['login', 'email', 'password', 'nom_usr', 'prenom_usr'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed'];

    public static function createUser($login, $email, $password, $nom_usr, $prenom_usr)
    {
        // Créer un nouvel utilisateur
        return self::create([
            'login' => $login,
            'email' => $email,
            'password' => Hash::make($password),  // Sécuriser le mot de passe
            'nom_usr' => $nom_usr,
            'prenom_usr' => $prenom_usr,
        ]);
    }
}
<?php

namespace App\Http\Controllers;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Load Login View
    public function loginView()
    {
        return view("auth.login");
    }

    public function loginCheck(LoginRequest $request)
    {
        // Extraire les credentials après validation
        $credentials = $request->validated();
    
        // Identifier si l'input est un email ou un login
        $fieldType = filter_var($credentials['identifiant'], FILTER_VALIDATE_EMAIL) ? 'email' : 'login';
    
        // Construire les données de connexion
        $credentials = [
            $fieldType => $credentials['identifiant'],
            'password' => $credentials['password']
        ];
    
        // Tentative de connexion
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            return redirect()->route('index')->with('login', $user->login);
        }
    
        // Si l'authentification échoue
        return to_route('auth.login')->withErrors(['identifiant' => "Identifiant ou mot de passe invalide"])->onlyInput('identifiant');
    }
    
}

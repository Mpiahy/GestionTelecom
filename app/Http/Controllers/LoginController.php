<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
// use App\Models\User;

class LoginController extends Controller
{
    // Load Login View
    public function loginView()
    {
        return view("auth.login");
    }
    // Login validate
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
            $request->session()->put('login', $user->login);
            return redirect()->route('index');
        }
    
        // Si l'authentification échoue
        return to_route('auth.login')->withErrors(['identifiant' => "Identifiant ou mot de passe invalide"])->onlyInput('identifiant');
    }
    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return to_route("auth.login");
    }
    
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // REGISTER LOGIC
    public function register(Request $request) {
        // 1. Validation des données du formulaire
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' check password_confirmation
        ]);

        // 2. Création de l'utilisateur dans la base de données
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // 3. Connexion automatique après inscription
        Auth::login($user);

        // 4. Redirection vers le tableau de bord
        return redirect('/')->with('success', 'Welcome aboard, Trader!');
    }

    // LOGIN LOGIC
    public function login(Request $request) {
        // 1. Validation
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Tentative de connexion
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        // 3. Echec: Retour avec erreur
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // LOGOUT LOGIC
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // public function registerView(Request $request) {
    //     return view('auth.register');
    // }
}

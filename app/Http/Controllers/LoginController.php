<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Gère une tentative de connexion.
     */
    public function login(Request $request)
    {
        // 1. Validation
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required','string','min:8']
        ]);

        // 2. Tentative de connexion
        if (Auth::attempt($credentials, $request->filled('remember'))) { // 'remember' est optionnel
           $request->session()->regenerate(); // Sécurité: régénère l'ID de session
           $request->session()->regenerateToken(); 
            $user = Auth::user();
             Session::put('user_id',$user->id);
             Session::put('user_name',$user->name);
             Session::put('role',$user->role);
             Session::put('user_profile',$user->photo);
             
            // 3. Redirection basée sur le rôle
            //dd($user->role);
            switch ($user->role) {
                case 'directeur':
                    return redirect()->route('directeur.index');
                case 'gestionnaire':
                    return redirect()->route('gestionnaire.index');
                default:
                    // Fallback au cas où le rôle n'est pas défini ou inattendu
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return redirect()->route('login')->with('error', 'Rôle utilisateur non valide.');
            }
        }

        // 4. Échec de la connexion
        // throw ValidationException::withMessages([
        //     'error' => [trans('auth.failed')], // Message d'erreur générique
        // ]);

        // Alternative pour l'échec (si vous n'utilisez pas ValidationException)
        return back()->withErrors(['error'=> 'Invalid email or password.']);
    }

    /**
     * Déconnecte l'utilisateur.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate(); // Clears all session data and destroys session ID
        $request->session()->regenerateToken(); //	Creates a new CSRF token

        // Session::forget('user_id');
        // Session::forget('user_name');
        
        return redirect('/login'); // Redirige vers la page de login
    }

    /**
     * Redirige vers le dashboard approprié (utilisé par la route /dashboard).
     * Utile si vous avez besoin d'une route centrale après une action.
     */
    public function redirectToDashboard()
    {
        $user = Auth::user();
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'client':
                return redirect()->route('client.dashboard');
            case 'provider':
                return redirect()->route('provider.dashboard');
            default:
                 return redirect('/login'); // Sécurité
        }
    }
}
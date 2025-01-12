<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Sanctum\Sanctum;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
    }

    public function redirectToGoogle() {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function registerGoogle(Request $request) {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $pseudo = $this->generateRandomPseudo($googleUser->name);

        $user = User::firstOrCreate(
            ['email' => $googleUser->email],
            ['name' => $googleUser->name, 
            'auth_provider' => 'google',
            'pseudo' => $pseudo,
            'password' => Hash::make('password')]
        );
    }

    public function register(Request $request){
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'pseudo' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::firstOrCreate([
            'pseudo' => $request->pseudo,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ], 201);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    private function generateRandomPseudo($name)
{
    // Récupérer une partie du nom pour le rendre plus personnalisé
    $base = preg_replace('/\s+/', '', strtolower($name)); // Supprimer les espaces
    $randomNumber = rand(1000, 9999); // Ajouter un nombre aléatoire pour l'unicité

    return $base . $randomNumber;
}

}

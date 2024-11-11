<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Account;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        $credential = $request->only('email', 'password');
        
        $user = Account::where('email', $credential['email'])->first();

        if ($user && Hash::check($credential['password'], $user->password)) {
            session()->put('user_id', $user->id);
            session()->put('name', $user->name);
            return response()->json(['message' => 'Login effettuato con successo', 'data' => session()->all()], 200); 
        }
        return response()->json(['message' => 'Credenziali non valide'], 401); 
    }

    public function signup(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|alpha', 
            'surname' => 'required|alpha', 
            'email' => 'required|email|unique:accounts,email', 
            'password' => 'required|min:8', 
            'status' => 'required|in:student, worker, unemployed',
            'profile_picture' => 'nullable|string', 
            'tags' => 'nullable|array', 
        ], [
            'email.unique' => 'Questa email è già in uso da un altro utente.',
            'status.in' => 'Lo status deve essere uno dei seguenti: studente, lavoratore, disoccupato.',
        ]);
    
        Account::create([
            'name' => $validatedData['name'],
            'surname' => $validatedData['surname'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'status' => $validatedData['status'],
            'profile_picture' => $validatedData['profile_picture'] ?? null, 
            'tags' => json_encode($validatedData['tags'] ?? []), 
        ]);
    
        return response()->json(['message' => 'Registrazione effettuata con successo'], 201); 
    }

    public function logout()
    {
        session()->flush();
        return response()->json(['message' => 'Disconnessione effettuata con successo'], 200); 
    }

    public function checkSession()
    {

            Log::info('Controllo sessione iniziato.');
            if (session()->has('name') && session()->has('user_id')) {
                Log::info('Sessione trovata', [
                    'user_id' => session('user_id'),
                ]);
                return response()->json([
                    'logged_in' => true,
                    'user_id' => session('user_id'),
                    'name' => session('name')
                ], 200);
            }
        
            Log::info('Sessione non trovata');
            return response()->json(['logged_in' => false], 200);
        }
        
}
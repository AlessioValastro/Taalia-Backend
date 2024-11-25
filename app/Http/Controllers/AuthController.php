<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Organizer;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash; 

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        $credential = $request->only('email', 'password');
    
        $user = User::where('email', $credential['email'])->first();
    
        if ($user && Hash::check($credential['password'], $user->password)) {
            session()->put('user_id', $user->id);
            session()->put('name', $user->name);
            session()->put('user_type', 'u');
            return response()->json(['message' => 'Login effettuato con successo', 'data' => session()->all()], 200);
        }
    
        $organizer = Organizer::where('email', $credential['email'])->first();
    
        if ($organizer && Hash::check($credential['password'], $organizer->password)) {
            session()->put('user_id', $organizer->id);
            session()->put('name', $organizer->name);
            session()->put('user_type', 'o');
            return response()->json(['message' => 'Login effettuato con successo (Organizer)', 'data' => session()->all()], 200);
        }
    
        return response()->json(['message' => 'Credenziali non valide'], 401);
    }
    

    public function signup(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|alpha', 
            'surname' => 'required|alpha', 
            'email' => 'required|email|unique:users,email', 
            'password' => 'required|min:8', 
            'status' => 'required|in:student, worker, unemployed',
            'profile_picture' => 'nullable|string', 
            'tags' => 'nullable|array', 
        ], [
            'email.unique' => 'Questa email è già in uso da un altro utente.',
            'status.in' => 'Lo status deve essere uno dei seguenti: studente, lavoratore, disoccupato.',
        ]);
    
        User::create([
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

    public function signupOrganizer(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string', 
            'address' => 'required|string', 
            'email' => 'required|email|unique:organizers,email', 
            'password' => 'required|min:8',
            'profile_picture' => 'nullable|string', 
        ], [
            'email.unique' => 'Questa email è già in uso da un altro utente.',
            ]);
    
        Organizer::create([
            'name' => $validatedData['name'],
            'address' => $validatedData['address'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'profile_picture' => $validatedData['profile_picture'] ?? null,
        ]);
    
        return response()->json(['message' => 'Registrazione effettuata con successo'], 201); 
    }

    public function logout()
    {
        session()->flush();
        Cookie::queue(Cookie::forget('laravel_session'));
        
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
                    'name' => session('name'),
                    'user_type' => session('user_type'),
                ], 200);
            }
        
            Log::info('Sessione non trovata');
            return response()->json(['logged_in' => false], 200);
        }
        
}
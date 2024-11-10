<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Ticket;

class EventsController extends Controller
{
    public function getEventsList($user_id){
        // Recupera tutti i biglietti dell'utente corrente
        $tickets = Ticket::where('user_id', $user_id)->get();
    
        // Estrae tutti gli ID degli eventi dai biglietti
        $eventIds = $tickets->pluck('event_id');
    
        // Recupera gli eventi corrispondenti agli ID trovati
        $events = Event::whereIn('id', $eventIds)->get();
    
        return response()->json($events, 200);
    }
    
}

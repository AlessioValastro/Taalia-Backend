<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Ticket;

class EventsController extends Controller
{
    public function getEventsList($user_id, $user_type){
    
        if($user_type == 'u'){
            $tickets = Ticket::where('account_id', $user_id)->get();
    
            $eventIds = $tickets->pluck('event_id');
    
            $events = Event::whereIn('id', $eventIds)->get();

            $events->load('organizer');
        } else{
            $events = Event::where('organizer', $user_id)->get();
        }
    
    
        return response()->json($events, 200);
    }

    public function getAllEventsList(){
        $events = Event::all();
        $events->load('organizer');

        return response()->json($events, 200);
    }

    public function newEvent(Request $request){
        
            // Validazione dei dati in ingresso
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'date' => 'required|date|after_or_equal:today',
                'address' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
            ]);
    
            
                // Creazione del nuovo evento
                $event = Event::create([
                    'title' => $validated['title'],
                    'date' => $validated['date'],
                    'address' => $validated['address'],
                    'description' => $validated['description'],
                    'price' => $validated['price'],
                    'img' => 'events/default.jpg',
                    'organizer' => session('user_id'),
                    'tags' => null,
                ]);

                return response()->json([
                    'message' => 'Evento creato con successo!',
                    'event' => $event,
                ], 201);
    }

    public function getEvent($event_id)
{
    $event = Event::where('id', $event_id)->first();

    if (!$event) {
        return response()->json(['error' => 'Event not found'], 404);
    }

    $event->load('organizer');
    return response()->json($event);
}

}

